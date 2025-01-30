import { motion } from "framer-motion";

export default function About() {
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
        <div className="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
          <motion.div
            initial={{ opacity: 0, x: -50 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8 }}
            className="relative"
          >
            <motion.h2
              className="text-3xl font-extrabold text-gray-900 sm:text-4xl bg-gradient-to-r from-primary to-blue-600 bg-clip-text text-transparent"
            >
              Our Journey
            </motion.h2>
            <motion.p
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: 0.2 }}
              className="mt-3 text-lg text-gray-500"
            >
              Founded in 2018 as an e-commerce retailer, KessExpress has evolved into a comprehensive IT services provider. Our journey from e-commerce to technology solutions has given us unique insights into the challenges businesses face in the digital age.
            </motion.p>

            <motion.dl
              variants={containerVariants}
              initial="hidden"
              animate="visible"
              className="mt-10 space-y-10"
            >
              <motion.div variants={itemVariants} whileHover={{ scale: 1.02 }}>
                <dt className="text-lg leading-6 font-medium text-gray-900 bg-gradient-to-r from-primary to-blue-600 bg-clip-text text-transparent">
                  Our Mission
                </dt>
                <dd className="mt-2 text-base text-gray-500">
                  To empower businesses with innovative technology solutions that drive growth and success in the digital era.
                </dd>
              </motion.div>
              <motion.div variants={itemVariants} whileHover={{ scale: 1.02 }}>
                <dt className="text-lg leading-6 font-medium text-gray-900 bg-gradient-to-r from-primary to-blue-600 bg-clip-text text-transparent">
                  Our Vision
                </dt>
                <dd className="mt-2 text-base text-gray-500">
                  To be the leading technology partner for businesses, providing cutting-edge solutions that transform operations and drive digital excellence.
                </dd>
              </motion.div>
            </motion.dl>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, x: 50 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8 }}
            className="mt-10 lg:mt-0"
          >
            <motion.div
              whileHover={{ scale: 1.02 }}
              className="relative rounded-lg overflow-hidden shadow-xl"
            >
              <img
                className="rounded-lg shadow-lg"
                src="https://images.unsplash.com/photo-1527192491265-7e15c55b1ed2"
                alt="KessExpress office"
              />
              <motion.div
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                transition={{ duration: 0.5 }}
                className="absolute inset-0 bg-gradient-to-r from-primary/20 to-blue-600/20 rounded-lg"
              />
            </motion.div>
          </motion.div>
        </div>

        <motion.div
          initial={{ opacity: 0, y: 50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="mt-24"
        >
          <h3 className="text-2xl font-bold text-gray-900 mb-8 bg-gradient-to-r from-primary to-blue-600 bg-clip-text text-transparent">
            Our Values
          </h3>
          <motion.div
            variants={containerVariants}
            initial="hidden"
            animate="visible"
            className="grid grid-cols-1 md:grid-cols-3 gap-8"
          >
            {[
              {
                title: "Innovation",
                description: "Constantly evolving and adopting new technologies to serve our clients better."
              },
              {
                title: "Excellence",
                description: "Delivering the highest quality solutions and service in everything we do."
              },
              {
                title: "Partnership",
                description: "Building long-term relationships with our clients based on trust and mutual success."
              }
            ].map((value, index) => (
              <motion.div
                key={index}
                variants={itemVariants}
                whileHover={{
                  scale: 1.05,
                  boxShadow: "0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)"
                }}
                className="bg-white p-6 rounded-lg shadow-lg transform transition-all duration-300"
              >
                <h4 className="text-lg font-semibold text-gray-900 mb-2 bg-gradient-to-r from-primary to-blue-600 bg-clip-text text-transparent">
                  {value.title}
                </h4>
                <p className="text-gray-500">{value.description}</p>
              </motion.div>
            ))}
          </motion.div>
        </motion.div>
      </div>
    </div>
  );
}