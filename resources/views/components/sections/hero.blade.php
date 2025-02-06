<div class="relative min-h-[600px] overflow-hidden bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900">
    {{-- Circuit board pattern overlay with scanning effect --}}
    <div class="absolute inset-0 opacity-10">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <pattern id="circuit" x="0" y="0" width="50" height="50" patternUnits="userSpaceOnUse">
                <path d="M10 10h30 M10 40h30" fill="none" stroke="currentColor" stroke-width="0.5" class="text-blue-200" />
                <path d="M10 10v30 M40 10v30" fill="none" stroke="currentColor" stroke-width="0.5" class="text-blue-200" />
                <path d="M15 15l20 20 M35 15l-20 20" fill="none" stroke="currentColor" stroke-width="0.5" class="text-blue-200" />
                <circle cx="10" cy="10" r="1.5" class="fill-blue-200" />
                <circle cx="40" cy="10" r="1.5" class="fill-blue-200" />
                <circle cx="10" cy="40" r="1.5" class="fill-blue-200" />
                <circle cx="40" cy="40" r="1.5" class="fill-blue-200" />
                <circle cx="25" cy="25" r="2" class="fill-blue-200" />
            </pattern>
            <rect width="100%" height="100%" fill="url(#circuit)" />
        </svg>
    </div>

    <div class="relative z-30 max-w-7xl mx-auto">
        <div class="relative pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 lg:mt-16 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl leading-[1.3] mb-4">
                        <span class="block mb-4">Transform Your</span>
                        <span class="inline-block bg-clip-text text-transparent bg-gradient-to-r from-blue-200 to-indigo-200 animate-pulse pb-4">
                            Digital Future
                        </span>
                    </h1>
                    <p class="mt-6 text-base text-gray-100 sm:mt-8 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-8 md:text-xl lg:mx-0">
                        With nearly a decade of excellence in both e-commerce and IT solutions, KessExpress delivers cutting-edge technology services that power your business growth.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="{{ route('consultation') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 md:py-4 md:text-lg md:px-10">
                                Book a Consultation
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="{{ route('services') }}" class="w-full flex items-center justify-center px-8 py-3 border border-white text-base font-medium rounded-md text-white bg-transparent hover:bg-white/10 md:py-4 md:text-lg md:px-10">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>