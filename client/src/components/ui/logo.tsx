import { Link } from "wouter";
import { motion } from "framer-motion";

export function Logo() {
  return (
    <Link href="/">
      <motion.div
        whileHover={{ scale: 1.05 }}
        className="flex items-center cursor-pointer"
      >
        <svg
          width="40"
          height="40"
          viewBox="0 0 40 40"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
          className="text-primary"
        >
          {/* Circuit K */}
          <motion.path
            d="M10 5 L10 35 M10 20 L30 5 M10 20 L30 35"
            stroke="currentColor"
            strokeWidth="3"
            strokeLinecap="round"
            strokeLinejoin="round"
            initial={{ pathLength: 0 }}
            animate={{ pathLength: 1 }}
            transition={{ duration: 1, ease: "easeInOut" }}
          />
          {/* Circuit nodes */}
          <motion.circle
            cx="10"
            cy="5"
            r="3"
            fill="currentColor"
            className="animate-pulse"
          />
          <motion.circle
            cx="10"
            cy="20"
            r="3"
            fill="currentColor"
            className="animate-pulse"
          />
          <motion.circle
            cx="10"
            cy="35"
            r="3"
            fill="currentColor"
            className="animate-pulse"
          />
          <motion.circle
            cx="30"
            cy="5"
            r="3"
            fill="currentColor"
            className="animate-pulse"
          />
          <motion.circle
            cx="30"
            cy="35"
            r="3"
            fill="currentColor"
            className="animate-pulse"
          />
        </svg>
        <motion.span
          className="ml-2 text-xl font-bold bg-gradient-to-r from-primary to-blue-400 bg-clip-text text-transparent"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ duration: 0.5 }}
        >
          KessExpress
        </motion.span>
      </motion.div>
    </Link>
  );
}
