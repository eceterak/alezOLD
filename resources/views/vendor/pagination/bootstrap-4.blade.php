@if ($paginator->hasPages())
    <ul class="custom-pagination justify-content-center" role="navigation">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <li class="custom-page-item control">
                <a class="custom-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="fas fa-angle-left"></i></a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="custom-page-item disabled" aria-disabled="true"><span class="custom-page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="custom-page-item active" aria-current="page"><span class="custom-page-link">{{ $page }}</span></li>
                    @else
                        <li class="custom-page-item"><a class="custom-page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if($paginator->hasMorePages())
            <li class="custom-page-item control">
                <a class="custom-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="fas fa-angle-right"></i></a>
            </li>
        @endif
    </ul>
@endif
