@if ($paginator->hasPages())
<nav class="pagination-wrapper">
    <ul class="pagination">

        {{-- Previous --}}
        <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}">‹</a>
        </li>

        {{-- Page Numbers --}}
        @php
            $range = 5;
            $current = $paginator->currentPage();
            $last = $paginator->lastPage();

            $start = max(1, $current - floor($range / 2));
            $end = min($last, $start + $range - 1);

            if ($end - $start < $range - 1) {
                $start = max(1, $end - $range + 1);
            }
        @endphp

        {{-- Show first if far --}}
        @if ($start > 1)
            <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
            <li class="page-item disabled"><span class="page-link">...</span></li>
        @endif

        {{-- Main pages --}}
        @for ($page = $start; $page <= $end; $page++)
            <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
            </li>
        @endfor

        {{-- Show last if far --}}
        @if ($end < $paginator->lastPage())
            <li class="page-item disabled"><span class="page-link">...</span></li>
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">
                    {{ $paginator->lastPage() }}
                </a>
            </li>
        @endif

        {{-- Next --}}
        <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">›</a>
        </li>

    </ul>
</nav>
@endif
