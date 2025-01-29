import { useEffect, useRef } from "react";
import { motion, useInView, useAnimation } from "framer-motion";

const stats = [
  { id: 1, name: 'Clients Served', value: '500+' },
  { id: 2, name: 'Projects Completed', value: '1000+' },
  { id: 3, name: 'Team Members', value: '50+' },
  { id: 4, name: 'Years of Experience', value: '5+' },
];

export default function Stats() {
  const controls = useAnimation();
  const ref = useRef(null);
  const isInView = useInView(ref);

  useEffect(() => {
    if (isInView) {
      controls.start("visible");
    }
  }, [controls, isInView]);

  return (
    <div className="bg-white py-24">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="max-w-4xl mx-auto text-center">
          <h2 className="text-3xl font-extrabold text-gray-900 sm:text-4xl">
            Trusted by Businesses Worldwide
          </h2>
          <p className="mt-3 text-xl text-gray-500 sm:mt-4">
            Our numbers speak for themselves
          </p>
        </div>
        <dl ref={ref} className="mt-10 text-center grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
          {stats.map((stat) => (
            <motion.div
              key={stat.id}
              initial="hidden"
              animate={controls}
              variants={{
                hidden: { opacity: 0, y: 20 },
                visible: { opacity: 1, y: 0 }
              }}
              transition={{ duration: 0.5, delay: stat.id * 0.1 }}
              className="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6"
            >
              <dt className="text-sm font-medium text-gray-500 truncate">
                {stat.name}
              </dt>
              <dd className="mt-1 text-3xl font-semibold text-primary">
                {stat.value}
              </dd>
            </motion.div>
          ))}
        </dl>
      </div>
    </div>
  );
}
