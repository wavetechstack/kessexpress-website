import { motion } from "framer-motion";
import { ChartBar, Shield, Database, Cloud, Cog, Lock, Network, ShoppingCart } from "lucide-react";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Link } from "wouter";

const services = [
  {
    icon: <ChartBar className="w-6 h-6" />,
    title: "Analytics & Business Intelligence",
    description: "Transform raw data into actionable insights with our advanced analytics solutions. We help you make data-driven decisions that drive business growth.",
    features: ["Data Visualization", "Predictive Analytics", "Custom Dashboards", "Real-time Reporting"]
  },
  {
    icon: <Shield className="w-6 h-6" />,
    title: "Cybersecurity",
    description: "Protect your business with enterprise-grade security solutions. We provide comprehensive protection against modern cyber threats.",
    features: ["Threat Detection", "Incident Response", "Security Audits", "Compliance Management"]
  },
  {
    icon: <Database className="w-6 h-6" />,
    title: "Data Platform Services",
    description: "Build scalable data platforms that power your analytics and AI initiatives. Modern solutions for modern data challenges.",
    features: ["Data Warehousing", "ETL Services", "Data Lakes", "Machine Learning Ops"]
  },
  {
    icon: <Cloud className="w-6 h-6" />,
    title: "Data Center Solutions",
    description: "Flexible infrastructure solutions that grow with your business. Choose from on-premises, cloud, or hybrid options.",
    features: ["Cloud Migration", "Hybrid Infrastructure", "Disaster Recovery", "Performance Optimization"]
  },
  {
    icon: <Cog className="w-6 h-6" />,
    title: "Managed Services",
    description: "24/7 IT support and management services to keep your business running smoothly. Let us handle your IT while you focus on growth.",
    features: ["Help Desk Support", "System Monitoring", "Patch Management", "Asset Management"]
  },
  {
    icon: <Lock className="w-6 h-6" />,
    title: "Managed Security Services",
    description: "Round-the-clock security monitoring and threat response. Keep your business protected with our expert security team.",
    features: ["24/7 Monitoring", "Threat Hunting", "Vulnerability Management", "Security Training"]
  },
  {
    icon: <Network className="w-6 h-6" />,
    title: "Networking",
    description: "Build robust network infrastructure that scales with your needs. From LANs to WANs, we've got you covered.",
    features: ["Network Design", "Implementation", "Optimization", "Security"]
  },
  {
    icon: <ShoppingCart className="w-6 h-6" />,
    title: "E-Commerce Solutions",
    description: "Scale your e-commerce operations across major platforms. Comprehensive solutions for online retail success.",
    features: ["Platform Integration", "Inventory Management", "Order Fulfillment", "Analytics"]
  }
];

export default function Services() {
  const containerVariants = {
    hidden: { opacity: 0 },
    visible: {
      opacity: 1,
      transition: {
        staggerChildren: 0.2
      }
    }
  };

  const itemVariants = {
    hidden: { opacity: 0, y: 20 },
    visible: {
      opacity: 1,
      y: 0,
      transition: {
        duration: 0.5
      }
    }
  };

  return (
    <div className="pt-16 bg-gradient-to-b from-gray-50 to-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <motion.div
          initial={{ opacity: 0, y: -20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="text-center mb-16"
        >
          <h1 className="text-4xl font-extrabold text-gray-900 sm:text-5xl bg-clip-text text-transparent bg-gradient-to-r from-primary to-blue-600">
            Our Services
          </h1>
          <p className="mt-4 text-xl text-gray-500">
            Comprehensive IT solutions tailored to your business needs
          </p>
        </motion.div>

        <motion.div
          variants={containerVariants}
          initial="hidden"
          animate="visible"
          className="grid grid-cols-1 md:grid-cols-2 gap-8"
        >
          {services.map((service, index) => (
            <motion.div
              key={index}
              variants={itemVariants}
              whileHover={{ scale: 1.02 }}
              className="h-full"
            >
              <Card className="h-full transform transition-all duration-300 hover:shadow-xl">
                <CardHeader>
                  <motion.div
                    whileHover={{ rotate: 360, scale: 1.2 }}
                    transition={{ duration: 0.5 }}
                    className="w-12 h-12 flex items-center justify-center rounded-lg bg-primary/10 text-primary mb-4"
                  >
                    {service.icon}
                  </motion.div>
                  <CardTitle className="bg-gradient-to-r from-primary to-blue-600 bg-clip-text text-transparent">
                    {service.title}
                  </CardTitle>
                  <CardDescription>{service.description}</CardDescription>
                </CardHeader>
                <CardContent>
                  <ul className="mt-4 space-y-2">
                    {service.features.map((feature, i) => (
                      <motion.li
                        key={i}
                        initial={{ opacity: 0, x: -20 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        transition={{ delay: i * 0.1 }}
                        className="flex items-center text-sm text-gray-500"
                      >
                        <motion.div
                          whileHover={{ scale: 1.5 }}
                          className="w-1.5 h-1.5 rounded-full bg-primary mr-2"
                        />
                        {feature}
                      </motion.li>
                    ))}
                  </ul>
                  <Link href="/consultation">
                    <motion.div
                      whileHover={{ scale: 1.05 }}
                      whileTap={{ scale: 0.95 }}
                    >
                      <Button className="w-full mt-6 bg-gradient-to-r from-primary to-blue-600 hover:from-blue-600 hover:to-primary transition-all duration-300">
                        Get Started
                      </Button>
                    </motion.div>
                  </Link>
                </CardContent>
              </Card>
            </motion.div>
          ))}
        </motion.div>
      </div>
    </div>
  );
}