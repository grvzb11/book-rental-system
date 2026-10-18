@if ($paginator->hasPages())
    <nav class="pagination" aria-label="Pagination">
        <span class="pagination-meta">Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }}</span>
        <div class="pagination-controls">
            @if ($paginator->onFirstPage())
                <span class="page-btn disabled">Previous</span>
            @else
                <a class="page-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
            @endif

            <span class="page-current">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>

            @if ($paginator->hasMorePages())
                <a class="page-btn" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
            @else
                <span class="page-btn disabled">Next</span>
            @endif
        </div>
    </nav>
@endif
