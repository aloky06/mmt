<div class="bg-[#f2f4f7] min-h-screen py-8 font-sans">
    <div class="container mx-auto px-4" style="max-width:1200px;">
        <div class="flex flex-col lg:flex-row gap-6">

            {{-- ── FILTERS ────────────────────────────────────── --}}
            <div class="w-full lg:w-1/4">
                @include('Boat::frontend.layouts.search.filter-search')
            </div>

            {{-- ── RESULTS ─────────────────────────────────────── --}}
            <div class="w-full lg:w-3/4 flex flex-col">

                {{-- Sort Bar --}}
                @include('Boat::frontend.layouts.search.orderby')

                {{-- Hotel Cards --}}
                <div class="flex flex-col">
                    @if($rows->total() > 0)
                        @foreach($rows as $row)
                            <div class="mb-4">
                                @include('Boat::frontend.layouts.search.loop-gird')
                            </div>
                        @endforeach
                    @else
                        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center shadow-sm">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-400 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">No Boats Found</h4>
                            <p class="text-gray-500">We couldn't find any boats matching your current filters. Try adjusting them or searching a different area.</p>
                            <button onclick="window.location.href='{{ route('boat.search') }}'" class="mt-6 bg-brand hover:bg-brand-dark text-white font-bold py-2.5 px-6 rounded-lg transition-colors">
                                Clear All Filters
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Pagination --}}
                @if($rows->total() > 0)
                    <div class="mt-8 flex flex-col md:flex-row items-center justify-between gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                        <div class="text-sm font-medium text-gray-500">
                            Showing <span class="font-bold text-gray-900">{{ $rows->firstItem() }}</span> to <span class="font-bold text-gray-900">{{ $rows->lastItem() }}</span> of <span class="font-bold text-gray-900">{{ $rows->total() }}</span> boats
                        </div>
                        <div class="bravo-pagination">
                            {{ $rows->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
                
                <style>
                    /* Style the default Laravel pagination to fit the theme */
                    .bravo-pagination .pagination { display: flex; gap: 4px; margin: 0; padding: 0; list-style: none; }
                    .bravo-pagination .page-item .page-link { 
                        display: flex; align-items: center; justify-content: center;
                        min-width: 36px; height: 36px; padding: 0 10px;
                        border-radius: 8px; border: 1px solid #e5e7eb;
                        background: #fff; color: #4b5563; font-weight: 600; font-size: 14px;
                        transition: all 0.2s;
                    }
                    .bravo-pagination .page-item.active .page-link { background: #e6521f; border-color: #e6521f; color: #fff; }
                    .bravo-pagination .page-item.disabled .page-link { opacity: 0.5; cursor: not-allowed; }
                    .bravo-pagination .page-item:not(.active):not(.disabled) .page-link:hover { background: #f3f4f6; border-color: #d1d5db; color: #111827; }
                </style>

            </div>
        </div>
    </div>
</div>