import express, { type Request, Response, NextFunction } from "express";
import { registerRoutes } from "./routes";
import { setupVite, serveStatic, log } from "./vite";
import helmet from "helmet";
import cors from "cors";

const app = express();

// Configure security headers based on environment
const isDevelopment = process.env.NODE_ENV !== 'production';
const ALLOWED_DOMAINS = [
  "kessexpress.com",
  "www.kessexpress.com",
  "hello-world-wavetechstack.replit.app",
  "6f1cb0f1-e92a-4fd6-82b6-44193563fefe-00-3rw15b1v8ntjv.riker.replit.dev",
  "*.replit.dev", // Allow all Replit subdomains
  "*.riker.replit.dev", // Specifically allow riker subdomains
  "35.186.242.242" // Allow Replit's IP
];

// Enhanced logging function
const enhancedLog = (message: string, type: 'info' | 'error' | 'warn' = 'info') => {
  const timestamp = new Date().toISOString();
  log(`[${timestamp}] [${type.toUpperCase()}] ${message}`);
};

// Basic startup logging
enhancedLog("Starting server...");
enhancedLog(`Environment: ${process.env.NODE_ENV}`);

// CORS configuration
app.use(cors({
  origin: isDevelopment ? "*" : ALLOWED_DOMAINS,
  credentials: true
}));

// Helmet configuration
app.use(helmet({
  contentSecurityPolicy: {
    directives: {
      defaultSrc: ["'self'", ...(isDevelopment ? ["*"] : ALLOWED_DOMAINS)],
      scriptSrc: ["'self'", "'unsafe-inline'", "'unsafe-eval'", ...(isDevelopment ? ["*"] : ALLOWED_DOMAINS)],
      styleSrc: ["'self'", "'unsafe-inline'", ...(isDevelopment ? ["*"] : ALLOWED_DOMAINS)],
      imgSrc: ["'self'", "data:", ...(isDevelopment ? ["*"] : ALLOWED_DOMAINS)],
      connectSrc: ["'self'", ...(isDevelopment ? ["*", "ws:", "wss:"] : [...ALLOWED_DOMAINS, "wss://kessexpress.com", "wss://www.kessexpress.com"])],
      fontSrc: ["'self'", "data:", ...(isDevelopment ? ["*"] : ALLOWED_DOMAINS)],
      objectSrc: ["'none'"],
      mediaSrc: ["'self'", ...(isDevelopment ? ["*"] : ALLOWED_DOMAINS)],
      frameSrc: ["'self'", ...(isDevelopment ? ["*"] : ALLOWED_DOMAINS)],
    },
  },
  crossOriginEmbedderPolicy: false,
  crossOriginResourcePolicy: { policy: "cross-origin" }
}));

app.use(express.json());
app.use(express.urlencoded({ extended: false }));

// Health check endpoint
app.get('/health', (req, res) => {
  res.status(200).json({ status: 'healthy', timestamp: new Date().toISOString() });
});

// Request logging middleware
app.use((req, res, next) => {
  const start = Date.now();
  res.on("finish", () => {
    const duration = Date.now() - start;
    enhancedLog(`${req.method} ${req.path} ${res.statusCode} in ${duration}ms`);
  });
  next();
});

// Server startup function with retry mechanism
const startServer = async (retryCount = 0, maxRetries = 3) => {
  try {
    enhancedLog("Registering routes...");
    const server = registerRoutes(app);

    if (app.get("env") === "development") {
      enhancedLog("Setting up Vite in development mode...");
      await setupVite(app, server);
    } else {
      enhancedLog("Setting up static serving for production...");
      serveStatic(app);
    }

    const PORT = process.env.PORT || 5000;

    // Start listening on all interfaces
    server.listen(PORT, "0.0.0.0", () => {
      enhancedLog(`Server is running on http://0.0.0.0:${PORT}`);
      enhancedLog(`Server is ready to accept connections`);
    });

    // Keep-alive configuration
    server.keepAliveTimeout = 65000;
    server.headersTimeout = 66000;

    return server;
  } catch (error) {
    enhancedLog(`Fatal error starting server: ${error}`, 'error');
    if (retryCount < maxRetries) {
      enhancedLog(`Retrying server startup... (Attempt ${retryCount + 1}/${maxRetries})`, 'warn');
      setTimeout(() => startServer(retryCount + 1, maxRetries), 5000);
    } else {
      enhancedLog('Max retry attempts reached. Exiting...', 'error');
      process.exit(1);
    }
  }
};

// Start the server
startServer();