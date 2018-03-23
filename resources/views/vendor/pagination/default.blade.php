@if ($paginator->hasPages())

    <ul class="uk-pagination uk-flex-center" uk-margin>
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled previous"><a>Prev</a></li>
        @else
            <li class="previous"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">Prev</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="uk-disabled"><span>...</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="uk-active"><a><span>{{ $page }}</span></a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="next"><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a></li>
        @else
            <li class="disabled next"><a>Next</a></li>
        @endif
    </ul>

@endif
