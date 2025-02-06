import type { Express } from "express";
import { createServer, type Server } from "http";
import { z } from "zod";

// Schema definitions
const contactSchema = z.object({
  name: z.string().min(2, "Name must be at least 2 characters"),
  email: z.string().email("Invalid email address"),
  subject: z.string().min(1, "Subject is required"),
  message: z.string().min(10, "Message must be at least 10 characters")
});

const consultationSchema = z.object({
  name: z.string().min(2, "Name must be at least 2 characters"),
  email: z.string().email("Invalid email address"),
  company: z.string().min(1, "Company name is required"),
  service: z.string().min(1, "Service selection is required"),
  message: z.string().min(10, "Message must be at least 10 characters")
});

export function registerRoutes(app: Express): Server {
  // API Routes
  app.post("/api/contact", async (req, res) => {
    try {
      const data = contactSchema.parse(req.body);
      // TODO: Implement contact form handling
      res.json({ success: true, message: "Message received" });
    } catch (error) {
      if (error instanceof z.ZodError) {
        res.status(400).json({ 
          success: false, 
          errors: error.errors.map(e => ({
            field: e.path.join('.'),
            message: e.message
          }))
        });
      } else {
        res.status(500).json({ 
          success: false, 
          message: "Failed to process contact request" 
        });
      }
    }
  });

  app.post("/api/consultation", async (req, res) => {
    try {
      const data = consultationSchema.parse(req.body);
      // TODO: Implement consultation booking
      res.json({ success: true, message: "Consultation request received" });
    } catch (error) {
      if (error instanceof z.ZodError) {
        res.status(400).json({ 
          success: false, 
          errors: error.errors.map(e => ({
            field: e.path.join('.'),
            message: e.message
          }))
        });
      } else {
        res.status(500).json({ 
          success: false, 
          message: "Failed to process consultation request" 
        });
      }
    }
  });

  return createServer(app);
}