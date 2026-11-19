@props(['eyebrow' => null, 'id' => null, 'as' => 'h2'])

<div {{ $attributes->merge(['class' => 'reveal']) }}>
    @if($eyebrow)
        <p class="eyebrow">{{ $eyebrow }}</p>
    @endif
    <{{ $as }} @if($id) id="{{ $id }}" @endif class="display-sm mt-4">
        {{ $slot }}
    </{{ $as }}>
    @isset($text)
        <p class="mt-4 text-muted-foreground text-base md:text-lg leading-relaxed max-w-2xl">{{ $text }}</p>
    @endisset
</div>
