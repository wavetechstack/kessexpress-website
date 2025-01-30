import { motion } from "framer-motion";
import { ChevronLeft, ChevronRight } from "lucide-react";
import { Button } from "@/components/ui/button";
import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious,
} from "@/components/ui/carousel";

const partners = [
  {
    name: "Cisco",
    logo: "https://www.cisco.com/web/fw/i/logo-open-graph.gif"
  },
  {
    name: "Amazon",
    logo: "https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg"
  },
  {
    name: "IBM",
    logo: "https://www.ibm.com/brand/experience-guides/developer/b1db1ae501d522a1a4b49613fe07c9f1/01_8-bar-positive.svg"
  },
  {
    name: "Dell",
    logo: "https://upload.wikimedia.org/wikipedia/commons/8/82/Dell_Logo.png"
  }
];

export default function Partners() {
  return (
    <section className="py-24 bg-white relative overflow-hidden">
      {/* Circuit pattern background */}
      <div className="absolute inset-0 opacity-5">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
          <pattern id="partnerCircuit" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
            <path 
              d="M20 0v20h60v60h20V0H20zm0 40v20h20V40H20zm60 0v20h20V40H80z" 
              fill="none" 
              stroke="currentColor" 
              strokeWidth="0.5"
              className="text-primary animate-circuit" 
            />
          </pattern>
          <rect x="0" y="0" width="100%" height="100%" fill="url(#partnerCircuit)" />
        </svg>
      </div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <motion.div 
          className="text-center mb-16"
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8 }}
        >
          <h2 className="text-3xl font-extrabold sm:text-4xl bg-gradient-to-r from-primary to-blue-600 bg-clip-text text-transparent">
            Our Partners
          </h2>
          <p className="mt-4 text-lg text-gray-500">
            Working with industry leaders to deliver excellence
          </p>
        </motion.div>

        <Carousel
          opts={{
            align: "start",
            loop: true,
          }}
          className="w-full max-w-4xl mx-auto"
        >
          <CarouselContent className="-ml-4">
            {partners.map((partner, index) => (
              <CarouselItem key={partner.name} className="pl-4 md:basis-1/2 lg:basis-1/4">
                <motion.div 
                  className="h-32 flex items-center justify-center p-6 bg-white rounded-lg hover:shadow-lg transition-all duration-300"
                  initial={{ opacity: 0, scale: 0.9 }}
                  whileInView={{ opacity: 1, scale: 1 }}
                  whileHover={{ y: -5 }}
                  viewport={{ once: true }}
                  transition={{ delay: index * 0.1 }}
                >
                  <motion.img
                    src={partner.logo}
                    alt={`${partner.name} logo`}
                    className="max-h-12 w-auto filter grayscale hover:grayscale-0 transition-all duration-300 animate-glow"
                    whileHover={{ scale: 1.1 }}
                  />
                </motion.div>
              </CarouselItem>
            ))}
          </CarouselContent>
          <div className="flex items-center justify-center gap-2 mt-4">
            <CarouselPrevious className="relative hover:bg-primary/10" />
            <CarouselNext className="relative hover:bg-primary/10" />
          </div>
        </Carousel>
      </div>
    </section>
  );
}