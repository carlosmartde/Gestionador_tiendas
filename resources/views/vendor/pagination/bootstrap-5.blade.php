@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center mt-4">
        <ul class="pagination">
            {{-- Previous Page --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
            @endif

            @php
                $totalPages = $paginator->lastPage();
                $currentPage = $paginator->currentPage();
                $sidePages = 2; // Páginas a mostrar a la izquierda y derecha
                $start = max(2, $currentPage - $sidePages);
                $end = min($totalPages - 1, $currentPage + $sidePages);
            @endphp

            {{-- Página 1 siempre visible --}}
            <li class="page-item {{ $currentPage == 1 ? 'active' : '' }}">
                @if ($currentPage == 1)
                    <span class="page-link">1</span>
                @else
                    <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                @endif
            </li>

            {{-- Puntos suspensivos si el inicio es mayor que 2 --}}
            @if ($start > 2)
                <li class="page-item disabled"><span class="page-link">…</span></li>
            @endif

            {{-- Rango dinámico de páginas del medio --}}
            @for ($i = $start; $i <= $end; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    @if ($i == $currentPage)
                        <span class="page-link">{{ $i }}</span>
                    @else
                        <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    @endif
                </li>
            @endfor

            {{-- Puntos suspensivos si el final es menor que la penúltima página --}}
            @if ($end < $totalPages - 1)
                <li class="page-item disabled"><span class="page-link">…</span></li>
            @endif

            {{-- Última página siempre visible --}}
            @if ($totalPages > 1)
                <li class="page-item {{ $currentPage == $totalPages ? 'active' : '' }}">
                    @if ($currentPage == $totalPages)
                        <span class="page-link">{{ $totalPages }}</span>
                    @else
                        <a class="page-link" href="{{ $paginator->url($totalPages) }}">{{ $totalPages }}</a>
                    @endif
                </li>
            @endif

            {{-- Next Page --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
