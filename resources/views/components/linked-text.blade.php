@props(['text', 'links' => []])

@php
    $html = e($text);
    foreach ($links as $label => $url) {
        if ($url === '') {
            continue;
        }
        $html = str_replace(
            e($label),
            '<a href="' . e($url) . '" target="_blank" rel="noopener noreferrer" class="text-primary hover:underline">' . e($label) . '</a>',
            $html,
        );
    }
@endphp

{!! $html !!}
