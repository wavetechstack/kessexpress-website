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

// Helmet configuration with less restrictive settings for development
app.use(helmet({
  contentSecurityPolicy: false,
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

// Error handling middleware
app.use((err: Error, req: Request, res: Response, next: NextFunction) => {
  enhancedLog(`Error occurred: ${err.message}`, 'error');
  res.status(500).json({ error: 'Internal Server Error' });
});

// Server startup function with improved retry mechanism
const startServer = async (retryCount = 0, maxRetries = 5) => {
  try {
    enhancedLog("Registering routes...");
    const server = registerRoutes(app);

    if (isDevelopment) {
      enhancedLog("Setting up Vite in development mode...");
      await setupVite(app, server);
    } else {
      enhancedLog("Setting up static serving for production...");
      serveStatic(app);
    }

    const PORT = process.env.PORT || 5000;

    // Handle server startup errors
    server.on('error', (error: any) => {
      if (error.code === 'EADDRINUSE') {
        enhancedLog(`Port ${PORT} is already in use`, 'error');
        if (retryCount < maxRetries) {
          const nextPort = parseInt(PORT.toString()) + 1;
          enhancedLog(`Retrying with port ${nextPort}... (Attempt ${retryCount + 1}/${maxRetries})`, 'warn');
          process.env.PORT = nextPort.toString();
          setTimeout(() => startServer(retryCount + 1, maxRetries), 1000);
        } else {
          enhancedLog('Max retry attempts reached. Exiting...', 'error');
          process.exit(1);
        }
      } else {
        enhancedLog(`Server error: ${error.message}`, 'error');
        process.exit(1);
      }
    });

    // Graceful shutdown handler
    const cleanup = () => {
      enhancedLog('Shutting down gracefully...', 'info');
      server.close(() => {
        enhancedLog('Server closed successfully', 'info');
        process.exit(0);
      });

      // Force close if graceful shutdown takes too long
      setTimeout(() => {
        enhancedLog('Force closing server after timeout', 'warn');
        process.exit(1);
      }, 10000);
    };

    process.on('SIGTERM', cleanup);
    process.on('SIGINT', cleanup);

    // Optimized keep-alive settings for Replit
    server.keepAliveTimeout = 30000; // 30 seconds
    server.headersTimeout = 31000; // Slightly higher than keepAliveTimeout

    // Start listening on all interfaces
    server.listen(PORT, "0.0.0.0", () => {
      enhancedLog(`Server is running on http://0.0.0.0:${PORT}`);
      enhancedLog(`Server is ready to accept connections`);
    });

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