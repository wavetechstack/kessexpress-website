import { motion } from "framer-motion";

export default function About() {
  return (
    <div className="pt-16">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div className="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
          <div className="relative">
            <motion.h2
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5 }}
              className="text-3xl font-extrabold text-gray-900 sm:text-4xl"
            >
              Our Journey
            </motion.h2>
            <motion.p
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: 0.1 }}
              className="mt-3 text-lg text-gray-500"
            >
              Founded in 2018 as an e-commerce retailer, KessExpress has evolved into a comprehensive IT services provider. Our journey from e-commerce to technology solutions has given us unique insights into the challenges businesses face in the digital age.
            </motion.p>

            <motion.dl
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: 0.2 }}
              className="mt-10 space-y-10"
            >
              <div>
                <dt className="text-lg leading-6 font-medium text-gray-900">Our Mission</dt>
                <dd className="mt-2 text-base text-gray-500">
                  To empower businesses with innovative technology solutions that drive growth and success in the digital era.
                </dd>
              </div>
              <div>
                <dt className="text-lg leading-6 font-medium text-gray-900">Our Vision</dt>
                <dd className="mt-2 text-base text-gray-500">
                  To be the leading technology partner for businesses, providing cutting-edge solutions that transform operations and drive digital excellence.
                </dd>
              </div>
            </motion.dl>
          </div>

          <div className="mt-10 lg:mt-0">
            <div className="relative">
              <img
                className="rounded-lg shadow-lg"
                src="https://images.unsplash.com/photo-1527192491265-7e15c55b1ed2"
                alt="KessExpress office"
              />
              <div className="absolute inset-0 bg-primary/10 rounded-lg"></div>
            </div>
          </div>
        </div>

        <div className="mt-24">
          <h3 className="text-2xl font-bold text-gray-900 mb-8">Our Values</h3>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
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
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.5, delay: 0.3 + index * 0.1 }}
                className="bg-white p-6 rounded-lg shadow"
              >
                <h4 className="text-lg font-semibold text-gray-900 mb-2">{value.title}</h4>
                <p className="text-gray-500">{value.description}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
}
