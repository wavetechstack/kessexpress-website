import { Button } from "@/components/ui/button";
import { Link } from "wouter";
import { motion } from "framer-motion";

export default function Hero() {
  return (
    <div className="relative overflow-hidden">
      {/* Animated gradient background */}
      <div className="absolute inset-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 animate-gradient-x">
        {/* Circuit Pattern Overlay */}
        <svg className="absolute inset-0 w-full h-full opacity-20" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <pattern id="circuit-pattern" x="0" y="0" width="50" height="50" patternUnits="userSpaceOnUse">
              {/* Circuit lines */}
              <path d="M10 10h30v30h-30z" fill="none" stroke="rgba(255,255,255,0.5)" strokeWidth="0.5" className="animate-pulse"/>
              <circle cx="10" cy="10" r="2" fill="rgba(255,255,255,0.5)" className="animate-ping"/>
              <circle cx="40" cy="40" r="2" fill="rgba(255,255,255,0.5)" className="animate-ping"/>
              <path d="M10 10l30 30M40 10l-30 30" stroke="rgba(255,255,255,0.3)" strokeWidth="0.5" className="animate-pulse"/>
              {/* Connection nodes */}
              <circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.8)" className="animate-ping"/>
            </pattern>
          </defs>
          <rect x="0" y="0" width="100%" height="100%" fill="url(#circuit-pattern)"/>
        </svg>
      </div>

      <div className="max-w-7xl mx-auto relative z-20">
        <div className="relative pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
          <main className="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 lg:mt-16 lg:px-8 xl:mt-28">
            <div className="sm:text-center lg:text-left">
              <motion.div
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.8 }}
              >
                <h1 className="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                  <span className="block">Transform Your</span>
                  <span className="block text-blue-200">Digital Future</span>
                </h1>
                <p className="mt-3 text-base text-gray-100 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                  From e-commerce excellence to comprehensive IT solutions, KessExpress delivers cutting-edge technology services to power your business growth.
                </p>
              </motion.div>

              <motion.div 
                className="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start"
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.8, delay: 0.2 }}
              >
                <div className="rounded-md shadow">
                  <Link href="/consultation">
                    <Button size="lg" className="w-full bg-white text-blue-600 hover:bg-blue-50">
                      Book a Consultation
                    </Button>
                  </Link>
                </div>
                <div className="mt-3 sm:mt-0 sm:ml-3">
                  <Link href="/services">
                    <Button 
                      variant="outline" 
                      size="lg" 
                      className="w-full text-white border-white bg-transparent hover:bg-white/10"
                    >
                      Learn More
                    </Button>
                  </Link>
                </div>
              </motion.div>
            </div>
          </main>
        </div>
      </div>
      <div className="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <div className="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full bg-gradient-to-l from-blue-900/50 to-transparent"></div>
      </div>
    </div>
  );
}