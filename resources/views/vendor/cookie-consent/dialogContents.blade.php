<div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-4 z-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="p-6 rounded-2xl bg-card border border-border shadow-2xl backdrop-blur-md">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="max-w-full flex-1 items-center md:w-0 md:inline">
                    <p class="md:ml-3 text-foreground cookie-consent__message text-sm leading-relaxed">
                        {!! trans('cookie-consent::texts.message') !!}
                    </p>
                </div>
                <div class="mt-2 flex-shrink-0 w-full sm:mt-0 sm:w-auto">
                    <button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 bg-primary hover:bg-primary/90 text-background px-6 py-3 text-sm font-semibold shadow-lg transition-all duration-200">
                        {{ trans('cookie-consent::texts.agree') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>