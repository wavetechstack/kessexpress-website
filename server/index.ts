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
  "*.replit.dev" // Allow all Replit subdomains
];

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
  crossOriginResourcePolicy: { policy: isDevelopment ? "cross-origin" : "same-site" }
}));

// Domain redirection middleware with enhanced logging
app.use((req, res, next) => {
  const host = req.header("host");
  // Log incoming requests for debugging
  log(`Incoming request from host: ${host}, path: ${req.path}`);

  // Only redirect in production and if the host doesn't match allowed domains
  if (!isDevelopment && host && !ALLOWED_DOMAINS.some(domain => {
    if (domain.startsWith("*.")) {
      const suffix = domain.slice(1); // Remove *
      return host.endsWith(suffix);
    }
    return host.includes(domain);
  })) {
    log(`Redirecting ${host} to kessexpress.com`);
    return res.redirect(301, `https://kessexpress.com${req.url}`);
  }
  next();
});

app.use(express.json());
app.use(express.urlencoded({ extended: false }));

// Request logging middleware
app.use((req, res, next) => {
  const start = Date.now();
  const path = req.path;

  res.on("finish", () => {
    const duration = Date.now() - start;
    const logLine = `${req.method} ${path} ${res.statusCode} in ${duration}ms`;
    log(logLine);
  });

  next();
});

(async () => {
  const server = registerRoutes(app);

  // Error handling middleware
  app.use((err: any, _req: Request, res: Response, _next: NextFunction) => {
    const status = err.status || err.statusCode || 500;
    const message = err.message || "Internal Server Error";

    log(`Error: ${message}`);
    res.status(status).json({ message });
  });

  if (app.get("env") === "development") {
    await setupVite(app, server);
  } else {
    serveStatic(app);
  }

  const PORT = process.env.PORT || 5000;
  server.listen(PORT, "0.0.0.0", () => {
    log(`Server is running on port ${PORT}`);
  });
})();