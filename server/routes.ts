import type { Express } from "express";
import { createServer, type Server } from "http";
import { z } from "zod";

const consultationSchema = z.object({
  name: z.string().min(2),
  email: z.string().email(),
  company: z.string().min(1),
  phone: z.string().min(10),
  service: z.string().min(1),
  message: z.string().min(10),
});

const contactSchema = z.object({
  name: z.string().min(2),
  email: z.string().email(),
  subject: z.string().min(1),
  message: z.string().min(10),
});

export function registerRoutes(app: Express): Server {
  // Consultation booking endpoint
  app.post("/api/consultation", async (req, res) => {
    try {
      const data = consultationSchema.parse(req.body);
      
      // Here you would typically:
      // 1. Save to database
      // 2. Send notification email
      // 3. Schedule follow-up

      res.json({
        success: true,
        message: "Consultation request received",
      });
    } catch (error) {
      res.status(400).json({
        success: false,
        message: "Invalid consultation request",
      });
    }
  });

  // Contact form endpoint
  app.post("/api/contact", async (req, res) => {
    try {
      const data = contactSchema.parse(req.body);
      
      // Here you would typically:
      // 1. Save to database
      // 2. Send notification email
      // 3. Send auto-response

      res.json({
        success: true,
        message: "Message received",
      });
    } catch (error) {
      res.status(400).json({
        success: false,
        message: "Invalid contact request",
      });
    }
  });

  const httpServer = createServer(app);
  return httpServer;
}
