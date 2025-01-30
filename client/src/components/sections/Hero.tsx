import { Button } from "@/components/ui/button";
import { Link } from "wouter";
import { motion } from "framer-motion";

export default function Hero() {
  return (
    <div className="relative overflow-hidden min-h-[calc(100vh-4rem)]">
      {/* Enhanced gradient background with circuit pattern */}
      <div className="absolute inset-0 bg-gradient-to-r from-blue-900 via-primary to-blue-600 animate-gradient-x opacity-90">
        {/* Circuit board pattern overlay */}
        <div className="absolute inset-0 opacity-10">
          <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <pattern id="circuit" x="0" y="0" width="50" height="50" patternUnits="userSpaceOnUse">
              <path d="M10 0v10h30v30h10V0H10zm0 20v10h10V20H10zm30 0v10h10V20H40z" 
                    fill="none" 
                    stroke="currentColor" 
                    strokeWidth="0.5"
                    className="text-white animate-pulse" />
            </pattern>
            <rect x="0" y="0" width="100%" height="100%" fill="url(#circuit)" />
          </svg>
        </div>
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
                  <motion.span 
                    className="block text-blue-200"
                    initial={{ opacity: 0, x: -20 }}
                    animate={{ opacity: 1, x: 0 }}
                    transition={{ delay: 0.3, duration: 0.8 }}
                  >
                    Digital Future
                  </motion.span>
                </h1>
                <motion.p 
                  className="mt-3 text-base text-gray-100 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0"
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ delay: 0.5, duration: 0.8 }}
                >
                  With nearly a decade of excellence in both e-commerce and IT solutions, KessExpress delivers cutting-edge technology services that power your business growth.
                </motion.p>
              </motion.div>

              <motion.div 
                className="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start"
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.8, delay: 0.2 }}
              >
                <div className="rounded-md shadow">
                  <Link href="/consultation">
                    <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
                      <Button size="lg" className="w-full bg-white text-blue-600 hover:bg-blue-50">
                        Book a Consultation
                      </Button>
                    </motion.div>
                  </Link>
                </div>
                <div className="mt-3 sm:mt-0 sm:ml-3">
                  <Link href="/services">
                    <motion.div whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }}>
                      <Button 
                        variant="outline" 
                        size="lg" 
                        className="w-full text-white border-white bg-transparent hover:bg-white/10"
                      >
                        Learn More
                      </Button>
                    </motion.div>
                  </Link>
                </div>
              </motion.div>
            </div>
          </main>
        </div>
      </div>

      {/* Animated tech elements */}
      <motion.div 
        className="absolute bottom-0 right-0 w-1/2 h-full opacity-20"
        initial={{ opacity: 0 }}
        animate={{ opacity: 0.2 }}
        transition={{ duration: 1 }}
      >
        <svg className="w-full h-full" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="techGrad" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" style={{ stopColor: 'white', stopOpacity: 0.3 }} />
              <stop offset="100%" style={{ stopColor: 'white', stopOpacity: 0.1 }} />
            </linearGradient>
          </defs>
          <motion.path
            d="M10,10 L190,10 L190,190 L10,190 Z"
            stroke="url(#techGrad)"
            strokeWidth="0.5"
            fill="none"
            initial={{ pathLength: 0 }}
            animate={{ pathLength: 1 }}
            transition={{ duration: 2, repeat: Infinity, repeatType: "reverse" }}
          />
          <motion.circle
            cx="100"
            cy="100"
            r="50"
            stroke="url(#techGrad)"
            strokeWidth="0.5"
            fill="none"
            initial={{ scale: 0.8, opacity: 0.3 }}
            animate={{ scale: 1.2, opacity: 0.7 }}
            transition={{ duration: 3, repeat: Infinity, repeatType: "reverse" }}
          />
        </svg>
      </motion.div>
      <div className="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <div className="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full bg-gradient-to-l from-blue-900/50 to-transparent"></div>
      </div>
    </div>
  );
}