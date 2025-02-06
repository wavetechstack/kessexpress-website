<nav class="border-b bg-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="text-xl font-bold">KessExpress</span>
                </a>
            </div>

            <div class="hidden md:flex md:items-center md:space-x-6">
                <a href="{{ route('home') }}" 
                   class="text-sm font-medium transition-colors hover:text-primary 
                          {{ request()->routeIs('home') ? 'text-primary' : 'text-foreground/60' }}">
                    Home
                </a>
                <a href="{{ route('about') }}" 
                   class="text-sm font-medium transition-colors hover:text-primary 
                          {{ request()->routeIs('about') ? 'text-primary' : 'text-foreground/60' }}">
                    About
                </a>
                <a href="{{ route('services') }}" 
                   class="text-sm font-medium transition-colors hover:text-primary 
                          {{ request()->routeIs('services') ? 'text-primary' : 'text-foreground/60' }}">
                    Services
                </a>
                <a href="{{ route('contact') }}" 
                   class="text-sm font-medium transition-colors hover:text-primary 
                          {{ request()->routeIs('contact') ? 'text-primary' : 'text-foreground/60' }}">
                    Contact
                </a>
            </div>
        </div>
    </div>
</nav>
