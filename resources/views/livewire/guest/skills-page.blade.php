<div>
    <x-page-header :eyebrow="__('guest.skills.eyebrow')" :back="route('home')" :back-label="__('guest.common.back_to_home')">
        {{ __('guest.skills.hero_title') }}
        <x-slot:lead>
            <p>{!! __('guest.skills.hero_description', ['php_developer' => '<strong class="text-foreground">' . __('guest.skills.php_developer') . '</strong>', 'laravel_programmer' => '<strong class="text-foreground">' . __('guest.skills.laravel_programmer') . '</strong>', 'php_ecosystem' => '<strong class="text-foreground">' . __('guest.skills.php_ecosystem') . '</strong>', 'open_source' => '<strong class="text-foreground">' . __('guest.skills.open_source') . '</strong>']) !!}</p>
        </x-slot:lead>
    </x-page-header>

    <div class="grid gap-5 md:grid-cols-2">
        @foreach($this->getSkillsByCategory() as $categoryKey => $categorySkills)
            <section class="project-card reveal {{ $categoryKey === 'tools' ? 'md:col-span-2' : '' }}" aria-labelledby="skills-{{ $categoryKey }}">
                <div class="flex items-center justify-between gap-3 mb-5">
                    <h2 id="skills-{{ $categoryKey }}" class="font-mono text-lg font-semibold text-foreground">
                        <span class="text-primary">#</span> {{ __('guest.skills.' . $categoryKey) }}
                    </h2>
                    <span class="hud-label">{{ sprintf('%02d', $loop->iteration) }}</span>
                </div>
                <div class="flex flex-wrap gap-2.5">
                    @foreach($categorySkills as $skill)
                        <span class="skill-tag">
                            @if(isset($skill['logo']))
                                <img src="{{ $skill['logo'] }}" alt="" class="w-4 h-4 mr-2" loading="lazy" width="16" height="16">
                            @elseif(isset($skill['icon']))
                                <span class="mr-2" aria-hidden="true">{{ $skill['icon'] }}</span>
                            @endif
                            {{ $skill['name'] }}
                        </span>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
</div>
