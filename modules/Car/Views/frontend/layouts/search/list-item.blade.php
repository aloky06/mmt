<style>
/* ============================================================
   RESULTS PAGE LAYOUT
============================================================ */
.cr-results-page {
    font-family: 'Inter', sans-serif;
    padding: 28px 0 60px;
    background: #f7f9fc;
    min-height: 60vh;
}

/* ── ROUTE SUMMARY BAR ─────────────────────────── */
.cr-route-bar {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    border-radius: 14px;
    padding: 16px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 22px;
}
.cr-route-info {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
}
.cr-route-city {
    font-size: 18px;
    font-weight: 800;
    color: #fff;
}
.cr-route-arrow {
    color: #ff5f1f;
    font-size: 22px;
}
.cr-route-meta {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
}
.cr-route-pill {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.85);
    font-size: 12px;
    font-weight: 600;
    padding: 5px 13px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.cr-route-pill i { color: #ff5f1f; font-size: 11px; }
.cr-trip-badge {
    background: linear-gradient(90deg, #ff5f1f, #ff8c00);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    padding: 6px 16px;
    border-radius: 20px;
    text-transform: capitalize;
    letter-spacing: 0.3px;
}

/* ── RESULTS TOPBAR ────────────────────────────── */
.cr-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    flex-wrap: wrap;
    gap: 10px;
}
.cr-count-text {
    font-size: 17px;
    font-weight: 700;
    color: #1a1a2e;
}
.cr-count-text span { color: #ff5f1f; }

/* ── LIST CARDS ────────────────────────────────── */
.cr-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* ── PAGINATION ────────────────────────────────── */
.cr-pagination {
    margin-top: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}
.cr-count-showing {
    font-size: 13px;
    color: #999;
    font-weight: 500;
}

/* ── FILTER PANEL ──────────────────────────────── */
.cr-filter-col {
    position: sticky;
    top: 80px;
}
.goibibo-filters {
    background: #fff !important;
    border-radius: 14px !important;
    border: 1.5px solid #f0f0f0 !important;
    overflow: hidden;
}
.goibibo-filters .filter-title {
    background: linear-gradient(135deg, #1a1a2e, #16213e) !important;
    color: #fff !important;
    padding: 16px 20px !important;
    font-size: 15px !important;
    font-weight: 700 !important;
}
.goibibo-filters .filter-title a.clear-all {
    color: rgba(255,255,255,0.6) !important;
    font-size: 11px !important;
}
.goibibo-filters .g-filter-item {
    padding: 16px 20px !important;
}
.goibibo-filters .item-title h3 {
    font-size: 13px !important;
    font-weight: 700 !important;
    color: #1a1a2e !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.bravo-checkbox input:checked ~ .checkmark {
    background-color: #ff5f1f !important;
    border-color: #ff5f1f !important;
}

/* ── NO RESULT ─────────────────────────────────── */
.cr-no-result {
    text-align: center;
    padding: 80px 30px;
    background: #fff;
    border-radius: 16px;
    border: 1.5px dashed #e0e0e0;
}
.cr-no-result i { font-size: 64px; color: #ff5f1f; opacity: 0.25; margin-bottom: 20px; display: block; }
.cr-no-result h4 { font-size: 20px; font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
.cr-no-result p { color: #aaa; font-size: 14px; }
</style>

<div class="cr-results-page">
    <div class="container-fluid px-3 px-md-4" style="max-width:1280px;margin:0 auto;">
        <div class="row g-4">

            {{-- ── FILTERS ────────────────────────────────────── --}}
            <div class="col-lg-3 col-md-12 cr-filter-col">
                @include('Car::frontend.layouts.search.filter-search')
            </div>

            {{-- ── RESULTS ─────────────────────────────────────── --}}
            <div class="col-lg-9 col-md-12">

                {{-- Route summary bar --}}
                @if(Request::query('pickup_name') || Request::query('dropoff_name'))
                <div class="cr-route-bar">
                    <div class="cr-route-info">
                        @if(Request::query('pickup_name'))
                            <span class="cr-route-city">{{ Request::query('pickup_name') }}</span>
                        @endif
                        @if(Request::query('dropoff_name'))
                            <i class="fa fa-long-arrow-right cr-route-arrow"></i>
                            <span class="cr-route-city">{{ Request::query('dropoff_name') }}</span>
                        @endif
                        <div class="cr-route-meta">
                            @if(Request::query('pickup_date'))
                                <span class="cr-route-pill">
                                    <i class="fa fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse(Request::query('pickup_date'))->format('d M, Y') }}
                                </span>
                            @endif
                            @if(isset($distance_km) && $distance_km > 0)
                                <span class="cr-route-pill">
                                    <i class="fa fa-road"></i>
                                    {{ $distance_km }} km
                                </span>
                            @endif
                        </div>
                    </div>
                    @if(Request::query('trip_type'))
                        <span class="cr-trip-badge">{{ ucwords(str_replace('_', ' ', Request::query('trip_type'))) }}</span>
                    @endif
                </div>
                @endif

                {{-- Topbar --}}
                <div class="cr-topbar">
                    <div class="cr-count-text">
                        <span>{{ $rows->total() }}</span>
                        {{ $rows->total() == 1 ? 'cab' : 'cabs' }} found
                    </div>
                    <div>
                        @include('Car::frontend.layouts.search.orderby')
                    </div>
                </div>

                {{-- Car Cards --}}
                <div class="cr-list">
                    @if($rows->total() > 0)
                        @foreach($rows as $row)
                            @include('Car::frontend.layouts.search.loop-gird')
                        @endforeach
                    @else
                        <div class="cr-no-result">
                            <i class="fa fa-car"></i>
                            <h4>No Cabs Found</h4>
                            <p>Try adjusting your filters or search for a different route.</p>
                        </div>
                    @endif
                </div>

                {{-- Pagination --}}
                <div class="cr-pagination">
                    <div>{{ $rows->appends(request()->query())->links() }}</div>
                    @if($rows->total() > 0)
                        <span class="cr-count-showing">
                            Showing {{ $rows->firstItem() }}–{{ $rows->lastItem() }} of {{ $rows->total() }} cabs
                        </span>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
