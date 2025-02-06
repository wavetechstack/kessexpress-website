@props(['title', 'description', 'icon'])

<div class="rounded-lg border bg-card text-card-foreground shadow-sm">
    <div class="p-6">
        <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10">
            <i class="text-primary" data-feather="{{ $icon }}"></i>
        </div>
        <h3 class="mb-2 text-lg font-semibold">{{ $title }}</h3>
        <p class="text-sm text-muted-foreground">{{ $description }}</p>
    </div>
</div>
