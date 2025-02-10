import { motion } from "framer-motion";
import { Card, CardHeader, CardContent } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Mail } from "lucide-react";

const jobs = [
  {
    title: "Software Engineer",
    location: "Houston, TX",
    type: "Full-time",
    description: "We are seeking a talented Software Engineer to join our growing team. The ideal candidate will have experience in full-stack development and a passion for creating innovative solutions.",
    responsibilities: [
      "Design and implement scalable software solutions",
      "Write clean, maintainable, and efficient code",
      "Collaborate with cross-functional teams to define and implement new features",
      "Troubleshoot, debug and upgrade existing systems",
      "Create technical documentation for reference and reporting"
    ],
    requirements: [
      "Bachelor's degree in Computer Science or related field",
      "3+ years of experience in software development",
      "Proficiency in modern programming languages and frameworks",
      "Strong problem-solving abilities and attention to detail",
      "Excellent communication and teamwork skills"
    ]
  },
  {
    title: "IT Support Specialist",
    location: "Houston, TX",
    type: "Full-time",
    description: "Join our IT support team to help maintain and improve our technology infrastructure while providing excellent service to our clients.",
    responsibilities: [
      "Provide technical support to clients and internal teams",
      "Install, configure, and maintain computer systems and networks",
      "Respond to service requests and resolve technical issues",
      "Document technical solutions and maintain knowledge base",
      "Assist in implementing IT security measures"
    ],
    requirements: [
      "Associate's degree in IT or related field",
      "2+ years of IT support experience",
      "Knowledge of computer hardware, software, and networks",
      "Strong customer service and problem-solving skills",
      "Relevant IT certifications are a plus"
    ]
  }
];

export default function Careers() {
  return (
    <div className="pt-16">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
          className="max-w-2xl mx-auto text-center mb-16"
        >
          <h1 className="text-4xl font-extrabold text-gray-900">
            Join Our Team
          </h1>
          <p className="mt-4 text-lg text-gray-500">
            Build your career with KessExpress and help shape the future of technology services
          </p>
        </motion.div>

        <div className="grid gap-8 mt-12">
          {jobs.map((job, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: index * 0.1 }}
            >
              <Card>
                <CardHeader>
                  <div className="flex justify-between items-start">
                    <div>
                      <h3 className="text-2xl font-bold text-gray-900">{job.title}</h3>
                      <div className="mt-2 flex items-center gap-4">
                        <span className="text-sm text-gray-500">{job.location}</span>
                        <span className="text-sm text-gray-500">{job.type}</span>
                      </div>
                    </div>
                    <Button className="flex items-center gap-2">
                      <Mail className="h-4 w-4" />
                      Apply Now
                    </Button>
                  </div>
                </CardHeader>
                <CardContent>
                  <p className="text-gray-600 mb-6">{job.description}</p>
                  
                  <div className="space-y-6">
                    <div>
                      <h4 className="text-lg font-semibold text-gray-900 mb-3">Responsibilities</h4>
                      <ul className="list-disc list-inside space-y-2 text-gray-600">
                        {job.responsibilities.map((item, i) => (
                          <li key={i}>{item}</li>
                        ))}
                      </ul>
                    </div>

                    <div>
                      <h4 className="text-lg font-semibold text-gray-900 mb-3">Requirements</h4>
                      <ul className="list-disc list-inside space-y-2 text-gray-600">
                        {job.requirements.map((item, i) => (
                          <li key={i}>{item}</li>
                        ))}
                      </ul>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </motion.div>
          ))}
        </div>

        <motion.div
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ duration: 0.5, delay: 0.5 }}
          className="mt-16 text-center"
        >
          <h3 className="text-2xl font-bold text-gray-900 mb-4">Don't see a position that fits?</h3>
          <p className="text-gray-600 mb-6">
            We're always looking for talented individuals to join our team. Send us your resume and we'll keep it on file for future opportunities.
          </p>
          <Button className="flex items-center gap-2 mx-auto">
            <Mail className="h-4 w-4" />
            Send Your Resume
          </Button>
        </motion.div>
      </div>
    </div>
  );
}
