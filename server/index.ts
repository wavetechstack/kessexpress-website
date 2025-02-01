import express, { type Request, Response, NextFunction } from "express";
import { registerRoutes } from "./routes";
import { setupVite, serveStatic, log } from "./vite";
import helmet from "helmet";

const app = express();

// Configure security headers based on environment
const isDevelopment = process.env.NODE_ENV !== 'production';
app.use(helmet({
  contentSecurityPolicy: {
    directives: {
      defaultSrc: ["'self'", ...(isDevelopment ? ["*"] : ["https://kessexpress.com"])],
      scriptSrc: ["'self'", "'unsafe-inline'", "'unsafe-eval'", ...(isDevelopment ? ["*"] : ["https://kessexpress.com"])],
      styleSrc: ["'self'", "'unsafe-inline'", ...(isDevelopment ? ["*"] : ["https://kessexpress.com"])],
      imgSrc: ["'self'", "data:", ...(isDevelopment ? ["*"] : ["https://kessexpress.com"])],
      connectSrc: ["'self'", ...(isDevelopment ? ["*", "ws:", "wss:"] : ["https://kessexpress.com", "wss://kessexpress.com"])],
      fontSrc: ["'self'", "data:", ...(isDevelopment ? ["*"] : ["https://kessexpress.com"])],
      objectSrc: ["'none'"],
      mediaSrc: ["'self'", ...(isDevelopment ? ["*"] : ["https://kessexpress.com"])],
      frameSrc: ["'self'", ...(isDevelopment ? ["*"] : ["https://kessexpress.com"])],
    },
  },
  crossOriginEmbedderPolicy: false,
  crossOriginResourcePolicy: { policy: isDevelopment ? "cross-origin" : "same-origin" }
}));

// Force domain redirection only in production
if (!isDevelopment) {
  app.use((req, res, next) => {
    const host = req.header("host");
    if (host && !host.includes("kessexpress.com")) {
      return res.redirect(301, `https://kessexpress.com${req.url}`);
    }
    next();
  });
}

app.use(express.json());
app.use(express.urlencoded({ extended: false }));

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
  server.listen(PORT, () => {
    log(`serving on port ${PORT}`);
  });
})();