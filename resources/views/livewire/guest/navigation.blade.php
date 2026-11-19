@php
    $currentUrl = url()->current();
    $currentLocale = app()->getLocale();
@endphp

<nav
    class="site-nav"
    role="navigation"
    aria-label="{{ __('guest.nav.main_label') }}"
    x-data="{ open: false }"
    @keydown.escape.window="open = false"
>
    <div class="flex items-center justify-between gap-3 px-4 py-2.5 md:px-5">
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-foreground hover:text-primary transition-colors" wire:navigate>
            <svg class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m18 16 4-4-4-4"></path>
                <path d="m6 8-4 4 4 4"></path>
                <path d="m14.5 4-5 16"></path>
            </svg>
            <span class="font-mono font-semibold tracking-tight">pekral</span>
        </a>

        <div class="hidden md:flex items-center gap-1">
            @foreach($links as $link)
                @if($link['is_anchor'])
                    <a href="{{ $link['route'] }}" class="btn btn-primary btn-nav ml-2">
                        {{ __('guest.nav.' . $link['name']) }}
                    </a>
                @else
                    @php
                        $isActive = str_starts_with($currentUrl, $link['route']);
                    @endphp
                    <a
                        href="{{ $link['route'] }}"
                        class="site-nav-link"
                        @if($isActive) aria-current="page" @endif
                        wire:navigate
                    >
                        @if($isActive)
                            <span class="status-dot" aria-hidden="true"></span>
                        @endif
                        {{ __('guest.nav.' . $link['name']) }}
                    </a>
                @endif
            @endforeach
        </div>

        <div class="flex items-center gap-2">
            <div class="locale-switch" role="group" aria-label="{{ __('guest.locale.language') }}">
                <a href="{{ route('locale.switch', 'cs') }}" aria-label="{{ __('guest.locale.switch_to_cz') }}" @if($currentLocale === 'cs') aria-current="true" @endif>cs</a>
                <a href="{{ route('locale.switch', 'en') }}" aria-label="{{ __('guest.locale.switch_to_en') }}" @if($currentLocale === 'en') aria-current="true" @endif>en</a>
            </div>

            <button
                type="button"
                class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-full border border-border bg-secondary/60 text-foreground hover:text-primary transition-colors"
                @click="open = !open"
                :aria-expanded="open"
                :aria-label="open ? @js(__('guest.nav.close_menu')) : @js(__('guest.nav.open_menu'))"
                aria-controls="mobile-menu"
            >
                <svg x-show="!open" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M4 7h16"></path>
                    <path d="M4 12h16"></path>
                    <path d="M4 17h16"></path>
                </svg>
                <svg x-show="open" x-cloak class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <div
        id="mobile-menu"
        class="md:hidden flex flex-col gap-1 border-t border-border px-4 py-4"
        x-show="open"
        x-cloak
        x-transition.opacity.duration.200ms
    >
        @foreach($links as $link)
            @if($link['is_anchor'])
                <a href="{{ $link['route'] }}" class="btn btn-primary btn-nav mt-2 self-start" @click="open = false">
                    {{ __('guest.nav.' . $link['name']) }}
                </a>
            @else
                @php
                    $isActive = str_starts_with($currentUrl, $link['route']);
                @endphp
                <a
                    href="{{ $link['route'] }}"
                    class="site-nav-link"
                    @if($isActive) aria-current="page" @endif
                    @click="open = false"
                    wire:navigate
                >
                    @if($isActive)
                        <span class="status-dot" aria-hidden="true"></span>
                    @endif
                    {{ __('guest.nav.' . $link['name']) }}
                </a>
            @endif
        @endforeach
    </div>
</nav>
