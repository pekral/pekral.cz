<section id="skills" class="animate-fade-in-delay-2">
    <h2 class="text-xl font-semibold text-foreground mb-6 font-mono">
        <span class="text-primary">#</span> Skills
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach(['languages' => 'Languages', 'frameworks' => 'Frameworks', 'tools' => 'Tools', 'practices' => 'Practices'] as $key => $title)
            <div>
                <h3 class="text-sm text-muted-foreground mb-3 font-mono">{{ $title }}</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($skills[$key] as $skill)
                        <span class="skill-tag">
                            @if(isset($skill['logo']))
                                <img src="{{ $skill['logo'] }}" alt="{{ $skill['name'] }}" class="w-4 h-4 mr-2" loading="lazy">
                            @elseif(isset($skill['icon']))
                                <span class="mr-2">{{ $skill['icon'] }}</span>
                            @endif
                            {{ $skill['name'] }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
