<div class="relative min-h-[600px] overflow-hidden bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900">
    {{-- Gradient overlay --}}
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(0,0,0,0)_0%,rgba(0,0,0,0.3)_100%)]"></div>

    {{-- Circuit board pattern overlay with animation--}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik0xMCAxMGgyME0xMCAzMGgyME0xMCAxMHYyME0zMCAxMHYyMCIgc3Ryb2tlPSJjdXJyZW50Q29sb3IiIHN0cm9rZS13aWR0aD0iLjUiIGNsYXNzPSJ0ZXh0LWJsdWUtMjAwIi8+PC9zdmc+')] animate-pulse"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto">
        <div class="relative pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 lg:mt-16 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl leading-[1.3]">
                        <span class="block mb-4">Transform Your</span>
                        <span class="inline-block bg-clip-text text-transparent bg-gradient-to-r from-blue-200 to-indigo-200 animate-pulse pb-4">
                            Digital Future
                        </span>
                    </h1>
                    <p class="mt-6 text-base text-gray-100 sm:mt-8 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-8 md:text-xl lg:mx-0">
                        With nearly a decade of excellence in both e-commerce and IT solutions, KessExpress delivers cutting-edge technology services that power your business growth.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start space-x-4">
                        <a href="{{ route('consultation') }}" 
                           class="inline-flex justify-center rounded-md bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm transition-all duration-200">
                            Book a Consultation
                        </a>
                        <a href="{{ route('services') }}" 
                           class="inline-flex justify-center rounded-md border border-white bg-transparent px-4 py-2 text-base font-medium text-white hover:bg-white/10 transition-all duration-200">
                            Learn More
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>