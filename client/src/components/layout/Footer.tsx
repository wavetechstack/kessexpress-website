import { Link } from "wouter";
import { Separator } from "../ui/separator";

export default function Footer() {
  return (
    <footer className="bg-background">
      <div className="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
        <div className="flex justify-center space-x-6 md:order-2">
          <nav>
            <ul className="flex space-x-6">
              <li>
                <div className="text-sm text-muted-foreground hover:text-foreground transition-colors">
                  <Link href="/about">About</Link>
                </div>
              </li>
              <li>
                <div className="text-sm text-muted-foreground hover:text-foreground transition-colors">
                  <Link href="/services">Services</Link>
                </div>
              </li>
              <li>
                <div className="text-sm text-muted-foreground hover:text-foreground transition-colors">
                  <Link href="/contact">Contact</Link>
                </div>
              </li>
              <li>
                <div className="text-sm text-muted-foreground hover:text-foreground transition-colors">
                  <Link href="/consultation">Consultation</Link>
                </div>
              </li>
            </ul>
          </nav>
        </div>
        <div className="mt-8 md:order-1 md:mt-0">
          <p className="text-center text-xs leading-5 text-muted-foreground">
            &copy; {new Date().getFullYear()} KessExpress. All rights reserved.
          </p>
        </div>
      </div>
    </footer>
  );
}