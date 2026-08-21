@props(['title'])

<div class="terminal-window glow-border">
    <div class="terminal-header">
        <div class="flex gap-2">
            <div class="terminal-dot terminal-dot-red"></div>
            <div class="terminal-dot terminal-dot-yellow"></div>
            <div class="terminal-dot terminal-dot-green"></div>
        </div>
        <span class="text-xs text-muted-foreground font-mono ml-2 truncate">{{ $title }}</span>
        <span class="hud-label ml-auto hidden sm:flex items-center gap-2 text-functional-green shrink-0" aria-hidden="true">
            <span class="status-dot"></span>
            <span class="text-muted-foreground">active</span>
        </span>
    </div>
    <div class="terminal-content">
        {{ $slot }}
    </div>
</div>
