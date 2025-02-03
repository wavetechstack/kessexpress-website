import express, { type Request, Response, NextFunction } from "express";
import { registerRoutes } from "./routes";
import { setupVite, serveStatic, log } from "./vite";
import helmet from "helmet";

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

// Domain redirection middleware with enhanced logging
app.use((req, res, next) => {
  const host = req.header("host");
  enhancedLog(`Incoming request from host: ${host}, path: ${req.path}, protocol: ${req.protocol}`);

  if (!isDevelopment && host && !ALLOWED_DOMAINS.some(domain => {
    if (domain.startsWith("*.")) {
      const suffix = domain.slice(1);
      return host.endsWith(suffix);
    }
    return host.includes(domain);
  })) {
    enhancedLog(`Redirecting ${host} to kessexpress.com`, 'info');
    return res.redirect(301, `https://kessexpress.com${req.url}`);
  }
  next();
});

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

    // Error handling middleware
    app.use((err: any, _req: Request, res: Response, _next: NextFunction) => {
      const status = err.status || err.statusCode || 500;
      const message = err.message || "Internal Server Error";
      enhancedLog(`Error: ${message}`, 'error');
      res.status(status).json({ message });
    });

    if (app.get("env") === "development") {
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
          enhancedLog(`Retrying in 5 seconds... (Attempt ${retryCount + 1}/${maxRetries})`, 'warn');
          setTimeout(() => startServer(retryCount + 1, maxRetries), 5000);
        } else {
          enhancedLog('Max retry attempts reached. Exiting...', 'error');
          process.exit(1);
        }
      } else {
        enhancedLog(`Server error: ${error.message}`, 'error');
        process.exit(1);
      }
    });

    // Handle process termination
    const cleanup = () => {
      enhancedLog('Shutting down gracefully...', 'info');
      server.close(() => {
        enhancedLog('Server closed successfully', 'info');
        process.exit(0);
      });
    };

    process.on('SIGTERM', cleanup);
    process.on('SIGINT', cleanup);

    // Keep-alive configuration
    server.keepAliveTimeout = 65000; // Slightly higher than ALB's idle timeout
    server.headersTimeout = 66000; // Slightly higher than keepAliveTimeout

    // Start listening
    server.listen(PORT, "0.0.0.0", () => {
      enhancedLog(`Server is running on port ${PORT}`);
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