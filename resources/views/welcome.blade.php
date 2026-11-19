<x-layouts.guest.layout>
    <livewire:guest.hero-section />

    <div class="container max-w-5xl mx-auto px-6 pb-24 space-y-28">
        @include('partials.guest.how-i-work')
        <livewire:guest.open-source-section />
        <livewire:guest.blog-latest-section />
        @include('partials.guest.contact')
    </div>
</x-layouts.guest.layout>
