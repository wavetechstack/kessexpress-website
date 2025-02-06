import express, { type Request, Response, NextFunction } from "express";
import { registerRoutes } from "./routes";
import { setupVite, serveStatic, log } from "./vite";
import helmet from "helmet";
import cors from "cors";
import { startPingService } from './ping-service';

const app = express();

// Configure security headers based on environment
const isDevelopment = process.env.NODE_ENV !== 'production';

// CORS configuration - More permissive for development
app.use(cors({
  origin: "*", // Allow all origins in development
  methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'PATCH'],
  allowedHeaders: ['Content-Type', 'Authorization', 'X-Requested-With', 'Accept'],
  credentials: true,
  maxAge: 86400 // Cache preflight requests for 24 hours
}));

// Minimal helmet configuration for development
app.use(helmet({
  contentSecurityPolicy: false,
  crossOriginEmbedderPolicy: false,
  crossOriginResourcePolicy: { policy: "cross-origin" },
  xssFilter: true
}));

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Health check endpoint
app.get('/health', (req, res) => {
  res.status(200).json({ status: 'healthy', timestamp: new Date().toISOString() });
});

// Request logging middleware
app.use((req, res, next) => {
  const start = Date.now();
  res.on("finish", () => {
    const duration = Date.now() - start;
    enhancedLog(`${req.method} ${req.originalUrl} ${res.statusCode} in ${duration}ms`);
  });
  next();
});

// Error handling middleware
app.use((err: Error, req: Request, res: Response, next: NextFunction) => {
  enhancedLog(`Error occurred: ${err.message}`, 'error');
  console.error(err);
  res.status(500).json({ error: 'Internal Server Error' });
});

// Enhanced logging function with timestamp
const enhancedLog = (message: string, type: 'info' | 'error' | 'warn' = 'info') => {
  const timestamp = new Date().toISOString();
  log(`[${timestamp}] [${type.toUpperCase()}] ${message}`);
};

// Server startup function
const startServer = async (retryCount = 0, maxRetries = 5) => {
  try {
    enhancedLog("Starting server...");
    const server = registerRoutes(app);

    if (isDevelopment) {
      enhancedLog("Setting up Vite in development mode...");
      await setupVite(app, server);
    } else {
      enhancedLog("Setting up static serving for production...");
      serveStatic(app);
    }

    const PORT = process.env.PORT || 3000;

    server.listen(PORT, () => {
      enhancedLog(`Server running on port ${PORT}`);
      startPingService();
    });

    return server;
  } catch (error) {
    enhancedLog(`Error starting server: ${error}`, 'error');
    if (retryCount < maxRetries) {
      setTimeout(() => startServer(retryCount + 1, maxRetries), 5000);
    } else {
      process.exit(1);
    }
  }
};

// Start the server
enhancedLog("Initializing server...");
startServer();