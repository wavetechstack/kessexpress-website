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
  "6f1cb0f1-e92a-4fd6-82b6-44193563fefe-00-3rw15b1v8ntjv.riker.replit.dev"
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
  crossOriginResourcePolicy: { policy: isDevelopment ? "cross-origin" : "same-origin" }
}));

// Domain redirection middleware
app.use((req, res, next) => {
  const host = req.header("host");
  // Only redirect in production and if the host doesn't match allowed domains
  if (!isDevelopment && host && !ALLOWED_DOMAINS.some(domain => host.includes(domain))) {
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
  let capturedJsonResponse: Record<string, any> | undefined = undefined;

  const originalResJson = res.json;
  res.json = function (bodyJson, ...args) {
    capturedJsonResponse = bodyJson;
    return originalResJson.apply(res, [bodyJson, ...args]);
  };

  res.on("finish", () => {
    const duration = Date.now() - start;
    if (path.startsWith("/api")) {
      let logLine = `${req.method} ${path} ${res.statusCode} in ${duration}ms`;
      if (capturedJsonResponse) {
        logLine += ` :: ${JSON.stringify(capturedJsonResponse)}`;
      }

      if (logLine.length > 80) {
        logLine = logLine.slice(0, 79) + "…";
      }

      log(logLine);
    }
  });

  next();
});

(async () => {
  const server = registerRoutes(app);

  // Error handling middleware
  app.use((err: any, _req: Request, res: Response, _next: NextFunction) => {
    const status = err.status || err.statusCode || 500;
    const message = err.message || "Internal Server Error";

    res.status(status).json({ message });
    throw err;
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