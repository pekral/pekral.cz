@props(['title'])

<div class="terminal-window glow-border">
    <div class="terminal-header">
        <div class="flex gap-2">
            <div class="terminal-dot terminal-dot-red"></div>
            <div class="terminal-dot terminal-dot-yellow"></div>
            <div class="terminal-dot terminal-dot-green"></div>
        </div>
        <span class="text-xs text-[#9ca3af] font-mono ml-2">{{ $title }}</span>
    </div>
    <div class="terminal-content">
        {{ $slot }}
    </div>
</div>

