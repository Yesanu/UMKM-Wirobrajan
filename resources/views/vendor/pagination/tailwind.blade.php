@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-center">

        {{-- Mobile view --}}
        <div class="flex gap-2 items-center justify-between sm:hidden w-full">

            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-[var(--text-muted)] bg-[var(--surface-2)] border border-[var(--border)] cursor-not-allowed rounded-[var(--radius-sm)]">
                    &lsaquo; Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-[var(--text-secondary)] bg-[var(--surface)] border border-[var(--border)] rounded-[var(--radius-sm)] hover:bg-[var(--primary-light)] hover:border-[var(--primary)] hover:text-[var(--primary)] transition duration-150 ease-in-out">
                    &lsaquo; Sebelumnya
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-[var(--text-secondary)] bg-[var(--surface)] border border-[var(--border)] rounded-[var(--radius-sm)] hover:bg-[var(--primary-light)] hover:border-[var(--primary)] hover:text-[var(--primary)] transition duration-150 ease-in-out">
                    Berikutnya &rsaquo;
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-[var(--text-muted)] bg-[var(--surface-2)] border border-[var(--border)] cursor-not-allowed rounded-[var(--radius-sm)]">
                    Berikutnya &rsaquo;
                </span>
            @endif

        </div>

        {{-- Desktop view --}}
        <div class="hidden sm:flex sm:items-center sm:gap-1">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[var(--text-muted)] bg-[var(--surface-2)] border border-[var(--border)] cursor-not-allowed rounded-[var(--radius-sm)] opacity-60" aria-hidden="true">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[var(--text-secondary)] bg-[var(--surface)] border border-[var(--border)] rounded-[var(--radius-sm)] hover:bg-[var(--primary-light)] hover:border-[var(--primary)] hover:text-[var(--primary)] transition duration-150 ease-in-out"
                   aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span aria-disabled="true">
                        <span class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[var(--text-muted)] bg-[var(--surface)] border border-[var(--border)] cursor-default rounded-[var(--radius-sm)]">{{ $element }}</span>
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page">
                                <span class="inline-flex items-center justify-center w-9 h-9 text-sm font-bold text-white bg-[var(--primary)] border border-[var(--primary)] cursor-default rounded-[var(--radius-sm)] shadow-sm">{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[var(--text-secondary)] bg-[var(--surface)] border border-[var(--border)] rounded-[var(--radius-sm)] hover:bg-[var(--primary-light)] hover:border-[var(--primary)] hover:text-[var(--primary)] transition duration-150 ease-in-out"
                               aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[var(--text-secondary)] bg-[var(--surface)] border border-[var(--border)] rounded-[var(--radius-sm)] hover:bg-[var(--primary-light)] hover:border-[var(--primary)] hover:text-[var(--primary)] transition duration-150 ease-in-out"
                   aria-label="{{ __('pagination.next') }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-[var(--text-muted)] bg-[var(--surface-2)] border border-[var(--border)] cursor-not-allowed rounded-[var(--radius-sm)] opacity-60" aria-hidden="true">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
            @endif

        </div>

    </nav>
@endif
