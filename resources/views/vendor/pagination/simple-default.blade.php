@if ($paginator->hasPages())
    <nav class="pagination-nav">
        <ul class="pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled">
                    <span class="pagination-link">← Poprzednia</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link" rel="prev">← Poprzednia</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled"><span class="pagination-dots">...</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active">
                                <span class="pagination-link current">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link" rel="next">Następna →</a>
                </li>
            @else
                <li class="disabled">
                    <span class="pagination-link">Następna →</span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
        .pagination-nav {
            display: flex;
            justify-content: center;
            margin: 2rem 0;
        }

        .pagination-list {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            min-width: 44px;
            height: 44px;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background-color: #ffffff;
            color: #374151;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.15s ease-in-out;
        }

        .pagination-link:hover {
            background-color: #f9fafb;
            color: #6b7280;
            border-color: #9ca3af;
        }

        .pagination-link.current {
            background-color: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
        }

        .pagination-link.current:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .disabled .pagination-link {
            background-color: #f9fafb;
            color: #d1d5db;
            cursor: not-allowed;
            opacity: 0.5;
        }

        .pagination-dots {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            min-width: 44px;
            height: 44px;
            color: #6b7280;
            font-weight: 500;
        }

        @media (max-width: 640px) {
            .pagination-list {
                gap: 0.25rem;
            }

            .pagination-link {
                padding: 0.375rem 0.5rem;
                min-width: 40px;
                height: 40px;
                font-size: 0.75rem;
            }

            .pagination-dots {
                padding: 0.375rem 0.5rem;
                min-width: 40px;
                height: 40px;
                font-size: 0.75rem;
            }
        }
    </style>
@endif