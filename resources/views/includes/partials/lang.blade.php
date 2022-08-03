<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownLanguageLink">
    <div class="dropdown-body">
    @foreach(collect(config('boilerplate.locale.languages'))->sortBy('name') as $code => $details)
        @if($code !== app()->getLocale())
            <x-utils.link class="list-group-item list-group-item-action" :href="route('locale.change', $code)" >
                <img src="/img/lang/{{ $code }}.svg"
                     class="nav-lang rounded-circle me-2"
                     alt="{{ __(getLocaleName( htmlLang() )) }}"
                />
                <span> {{ __(getLocaleName($code)) }}</span>
            </x-utils.link>
        @endif
    @endforeach
    </div>
</div>
