@foreach($items as $item)
    @php
        $itemUrl = $item->resolvedUrl();
        $path = trim((string) parse_url($itemUrl, PHP_URL_PATH), '/');
        $isActive = $path !== '' && request()->is($path.'*');
    @endphp
    <a href="{{ $itemUrl }}" target="{{ $item->target ?: '_self' }}" class="learning-nav__link {{ $level > 0 ? 'learning-nav__link--sub' : '' }} {{ $isActive ? 'is-active' : '' }}">
        @if($item->icon)
            <i class="{{ $item->icon }}" aria-hidden="true"></i>
        @endif
        <span>{{ $item->translatedTitle() }}</span>
    </a>

    @if($item->childrenRecursive->count())
        @include('frontend.partials.navigation-mobile-items', ['items' => $item->childrenRecursive, 'level' => $level + 1])
    @endif
@endforeach
