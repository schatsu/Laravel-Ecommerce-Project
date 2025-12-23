@if ($paginator->hasPages())
    <ul class="wg-pagination tf-pagination-list justify-content-start">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link animate-hover-btn" rel="prev">
                    <span class="icon icon-arrow-left"></span>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span class="pagination-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active">
                            <a href="#" class="pagination-link">{{ $page }}</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}" class="pagination-link animate-hover-btn">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link animate-hover-btn" rel="next">
                    <span class="icon icon-arrow-right"></span>
                </a>
            </li>
        @endif
    </ul>
@endif
