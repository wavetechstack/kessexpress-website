import { Button } from "@/components/ui/button";
import { Link } from "wouter";
import { motion } from "framer-motion";
import { useCallback, useEffect, useRef } from "react";
import type { Engine } from "@tsparticles/engine";
import Particles from "@tsparticles/react";
import { loadSlim } from "@tsparticles/slim";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

export default function Hero() {
  const particlesInit = useCallback(async (engine: Engine) => {
    try {
      await loadSlim(engine);
    } catch (error) {
      console.error("Failed to initialize particles:", error);
    }
  }, []);

  return (
    <div className="relative min-h-[600px] overflow-hidden">
      {/* Circuit board pattern overlay */}
      <div className="absolute inset-0 z-10 opacity-10">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
          <pattern id="circuit" x="0" y="0" width="50" height="50" patternUnits="userSpaceOnUse">
            {/* Horizontal lines */}
            <path
              d="M10 10h30 M10 40h30"
              fill="none"
              stroke="currentColor"
              strokeWidth="0.5"
              className="text-blue-200 animate-circuit-line"
            />
            {/* Vertical lines */}
            <path
              d="M10 10v30 M40 10v30"
              fill="none"
              stroke="currentColor"
              strokeWidth="0.5"
              className="text-blue-200 animate-circuit-line"
            />
            {/* Diagonal connections */}
            <path
              d="M15 15l20 20 M35 15l-20 20"
              fill="none"
              stroke="currentColor"
              strokeWidth="0.5"
              className="text-blue-200 animate-circuit-line"
            />
            {/* Circuit nodes */}
            <circle cx="10" cy="10" r="1.5" className="fill-blue-200 animate-circuit-pulse" />
            <circle cx="40" cy="10" r="1.5" className="fill-blue-200 animate-circuit-pulse" />
            <circle cx="10" cy="40" r="1.5" className="fill-blue-200 animate-circuit-pulse" />
            <circle cx="40" cy="40" r="1.5" className="fill-blue-200 animate-circuit-pulse" />
            <circle cx="25" cy="25" r="2" className="fill-blue-200 animate-circuit-pulse" />
          </pattern>
          <rect width="100%" height="100%" fill="url(#circuit)" />
        </svg>
        {/* Scanning effect overlay */}
        <div className="absolute inset-0 bg-gradient-to-b from-transparent via-blue-200/20 to-transparent animate-circuit-scan" />
      </div>

      {/* Animated gradient background */}
      <div className="absolute inset-0 bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 animate-gradient-x">
        <div className="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(0,0,0,0)_0%,rgba(0,0,0,0.3)_100%)]" />
      </div>

      {/* Particles overlay */}
      <Particles
        id="tsparticles"
        init={particlesInit}
        className="absolute inset-0 z-20"
        options={{
          fullScreen: false,
          background: {
            color: {
              value: "transparent",
            },
          },
          fpsLimit: 120,
          particles: {
            color: {
              value: "#ffffff",
            },
            links: {
              color: "#ffffff",
              distance: 150,
              enable: true,
              opacity: 0.2,
              width: 1,
            },
            move: {
              enable: true,
              outModes: {
                default: "bounce",
              },
              random: false,
              speed: 1,
              straight: false,
            },
            number: {
              density: {
                enable: true,
                area: 800,
              },
              value: 60,
            },
            opacity: {
              value: 0.3,
            },
            shape: {
              type: "circle",
            },
            size: {
              value: { min: 1, max: 2 },
            },
          },
          detectRetina: true,
        }}
      />

      <div className="relative z-30 max-w-7xl mx-auto">
        <div className="relative pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
          <main className="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 lg:mt-16 lg:px-8 xl:mt-28">
            <div className="sm:text-center lg:text-left">
              <motion.div
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ 
                  duration: 1.2,
                  ease: [0.6, -0.05, 0.01, 0.99]
                }}
              >
                <h1 className="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl leading-[1.3] mb-4">
                  <span className="block mb-4">Transform Your</span>
                  <span className="inline-block bg-clip-text text-transparent bg-gradient-to-r from-blue-200 to-indigo-200 animate-pulse pb-4">
                    Digital Future
                  </span>
                </h1>
                <p className="mt-6 text-base text-gray-100 sm:mt-8 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-8 md:text-xl lg:mx-0">
                  With nearly a decade of excellence in both e-commerce and IT solutions, KessExpress delivers cutting-edge technology services that power your business growth.
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
                    <Button
                      size="lg"
                      className="w-full bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white"
                    >
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
    </div>
  );
}