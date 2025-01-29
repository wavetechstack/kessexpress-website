import Hero from "@/components/sections/Hero";
import Stats from "@/components/sections/Stats";
import ServiceCard from "@/components/sections/ServiceCard";
import Partners from "@/components/sections/Partners";
import { ChartBar, Shield, Database, Cloud, Cog, Lock, Network, ShoppingCart } from "lucide-react";

const services = [
  {
    title: "Analytics & BI",
    description: "Unlock the power of your data with advanced analytics and business intelligence solutions.",
    icon: <ChartBar className="w-6 h-6" />
  },
  {
    title: "Cybersecurity",
    description: "Protect your business with advanced security solutions against modern threats.",
    icon: <Shield className="w-6 h-6" />
  },
  {
    title: "Data Platform Services",
    description: "Scalable solutions for analytics and AI implementation.",
    icon: <Database className="w-6 h-6" />
  },
  {
    title: "Data Center Solutions",
    description: "Flexible on-premises, cloud & hybrid infrastructure options.",
    icon: <Cloud className="w-6 h-6" />
  },
  {
    title: "Managed Services",
    description: "24/7 IT support for your business operations.",
    icon: <Cog className="w-6 h-6" />
  },
  {
    title: "Managed Security",
    description: "Round-the-clock cybersecurity monitoring and threat response.",
    icon: <Lock className="w-6 h-6" />
  },
  {
    title: "Networking",
    description: "Build robust and scalable network infrastructure.",
    icon: <Network className="w-6 h-6" />
  },
  {
    title: "E-Commerce Solutions",
    description: "Complete e-commerce scaling solutions across major platforms.",
    icon: <ShoppingCart className="w-6 h-6" />
  }
];

export default function Home() {
  return (
    <div className="pt-16">
      <Hero />
      <Stats />

      <section className="py-24 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-3xl font-extrabold text-gray-900 sm:text-4xl">
              Our Services
            </h2>
            <p className="mt-4 text-lg text-gray-500">
              Comprehensive IT solutions for your business needs
            </p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {services.map((service, index) => (
              <ServiceCard
                key={index}
                title={service.title}
                description={service.description}
                icon={service.icon}
              />
            ))}
          </div>
        </div>
      </section>

      <Partners />
    </div>
  );
}