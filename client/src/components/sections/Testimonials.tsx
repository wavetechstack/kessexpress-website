import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious,
} from "@/components/ui/carousel";
import { Card, CardContent } from "@/components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";

const testimonials = [
  {
    id: 1,
    content: "KessExpress transformed our e-commerce operations with their expertise. Highly recommended!",
    author: "Sarah Johnson",
    role: "CEO, TechRetail",
    avatar: "SJ"
  },
  {
    id: 2,
    content: "Their cybersecurity solutions gave us peace of mind. Professional team and excellent service.",
    author: "Michael Chen",
    role: "CTO, DataFlow",
    avatar: "MC"
  },
  {
    id: 3,
    content: "Outstanding managed IT services. They're always there when we need them.",
    author: "Emma Williams",
    role: "Operations Director, CloudTech",
    avatar: "EW"
  }
];

export default function Testimonials() {
  return (
    <div className="bg-gray-50 py-24">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <h2 className="text-3xl font-extrabold text-gray-900 sm:text-4xl">
            What Our Clients Say
          </h2>
          <p className="mt-4 text-lg text-gray-500">
            Don't just take our word for it
          </p>
        </div>

        <Carousel
          opts={{
            align: "start",
            loop: true,
          }}
          className="w-full max-w-4xl mx-auto"
        >
          <CarouselContent>
            {testimonials.map((testimonial) => (
              <CarouselItem key={testimonial.id} className="md:basis-1/2 lg:basis-1/3">
                <Card className="h-full">
                  <CardContent className="p-6">
                    <div className="flex flex-col h-full">
                      <p className="text-gray-600 flex-grow">"{testimonial.content}"</p>
                      <div className="flex items-center mt-6">
                        <Avatar>
                          <AvatarFallback>{testimonial.avatar}</AvatarFallback>
                        </Avatar>
                        <div className="ml-3">
                          <p className="text-sm font-medium text-gray-900">{testimonial.author}</p>
                          <p className="text-sm text-gray-500">{testimonial.role}</p>
                        </div>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              </CarouselItem>
            ))}
          </CarouselContent>
          <CarouselPrevious />
          <CarouselNext />
        </Carousel>
      </div>
    </div>
  );
}
