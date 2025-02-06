<x-app-layout>
    <div class="pt-16">
        <x-sections.hero />
        <x-sections.stats />

        <section class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        Our Services
                    </h2>
                    <p class="mt-4 text-lg text-gray-500">
                        Comprehensive IT solutions for your business needs
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($services as $service)
                        <x-sections.service-card 
                            :title="$service->title"
                            :description="$service->description"
                            :icon="$service->icon"
                        />
                    @endforeach
                </div>
            </div>
        </section>

        <x-sections.partners />
    </div>
</x-app-layout>
