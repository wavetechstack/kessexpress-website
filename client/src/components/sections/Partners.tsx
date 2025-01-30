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
    <section className="py-24 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <h2 className="text-3xl font-extrabold text-gray-900 sm:text-4xl">
            Our Partners
          </h2>
          <p className="mt-4 text-lg text-gray-500">
            Working with industry leaders to deliver excellence
          </p>
        </div>
        <Carousel
          opts={{
            align: "start",
            loop: true,
          }}
          className="w-full max-w-4xl mx-auto"
        >
          <CarouselContent className="-ml-4">
            {partners.map((partner) => (
              <CarouselItem key={partner.name} className="pl-4 md:basis-1/2 lg:basis-1/4">
                <div className="h-32 flex items-center justify-center p-6 bg-white">
                  <img
                    src={partner.logo}
                    alt={`${partner.name} logo`}
                    className="max-h-12 w-auto filter grayscale hover:grayscale-0 transition-all duration-300"
                  />
                </div>
              </CarouselItem>
            ))}
          </CarouselContent>
          <div className="flex items-center justify-center gap-2 mt-4">
            <CarouselPrevious />
            <CarouselNext />
          </div>
        </Carousel>
      </div>
    </section>
  );
}