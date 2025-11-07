@if ($paginator->hasPages())
    <ul class="wg-pagination tf-pagination-list justify-content-start">

        {{-- Geri --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <a href="#" class="pagination-link animate-hover-btn" aria-disabled="true">
                    <span class="icon icon-arrow-left"></span>
                </a>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link animate-hover-btn" rel="prev">
                    <span class="icon icon-arrow-left"></span>
                </a>
            </li>
        @endif

        {{-- Sayfa Numaraları --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled">
                    <a href="#" class="pagination-link">{{ $element }}</a>
                </li>
            @endif

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

        {{-- İleri --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link animate-hover-btn" rel="next">
                    <span class="icon icon-arrow-right"></span>
                </a>
            </li>
        @else
            <li class="disabled">
                <a href="#" class="pagination-link animate-hover-btn" aria-disabled="true">
                    <span class="icon icon-arrow-right"></span>
                </a>
            </li>
        @endif
    </ul>
@endif
