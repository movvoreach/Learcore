@foreach($items as $item)
    @php
        $itemUrl = $item->resolvedUrl();
        $path = trim((string) parse_url($itemUrl, PHP_URL_PATH), '/');
        $isActive = $path !== '' && request()->is($path.'*');
    @endphp
    <a class="dropdown-item {{ $isActive ? 'active' : '' }}" href="{{ $itemUrl }}" target="{{ $item->target ?: '_self' }}">
        @if($item->icon)
            <i class="{{ $item->icon }} me-2" aria-hidden="true"></i>
        @endif
        <span>{{ $item->translatedTitle() }}</span>
    </a>

    @if($item->childrenRecursive->count())
        <div class="learning-dropdown-children">
            @include('frontend.partials.navigation-dropdown-items', ['items' => $item->childrenRecursive])
        </div>
    @endif
@endforeach
