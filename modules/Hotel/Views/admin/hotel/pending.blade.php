@extends('admin.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="font-size:22px;font-weight:700;color:#1e293b;">🔔 Pending Hotel Verification</h2>
            <p class="text-muted mb-0" style="font-size:13px;">Review and approve or reject hotel submissions from property owners.</p>
        </div>
        <a href="{{ url('admin/module/hotel') }}" class="btn btn-outline-secondary btn-sm">← Back to All Hotels</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ❌ {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($rows->count() > 0)
    <div class="row g-3">
        @foreach($rows as $hotel)
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius:14px;overflow:hidden;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center p-4 gap-4">
                        <!-- Hotel Image -->
                        <div style="width:72px;height:72px;border-radius:10px;overflow:hidden;background:#f1f5f9;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:28px;">
                            @if($hotel->image_id)
                                <img src="{{ \Modules\Media\Helpers\FileHelper::url($hotel->image_id,'thumb') }}" style="width:100%;height:100%;object-fit:cover;" alt="{{ $hotel->title }}">
                            @else
                                🏨
                            @endif
                        </div>

                        <!-- Hotel Info -->
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h5 class="mb-0" style="font-size:16px;font-weight:700;color:#1e293b;">{{ $hotel->title }}</h5>
                                <span class="badge" style="background:#fff8e1;color:#92400e;border:1px solid #fbbf24;font-size:11px;">⏳ Pending</span>
                            </div>
                            <div class="d-flex flex-wrap gap-3" style="font-size:12px;color:#64748b;">
                                @if($hotel->address)
                                <span>📍 {{ Str::limit($hotel->address, 60) }}</span>
                                @endif
                                @if($hotel->star_rate)
                                <span>
                                    @for($i=0;$i<$hotel->star_rate;$i++)⭐@endfor {{ $hotel->star_rate }}-Star
                                </span>
                                @endif
                                @if($hotel->author)
                                <span>👤 {{ $hotel->author->name ?? 'Unknown' }} ({{ $hotel->author->email ?? '' }})</span>
                                @endif
                                <span>📅 Submitted: {{ $hotel->created_at ? $hotel->created_at->format('d M Y, h:i A') : '—' }}</span>
                            </div>
                            @if($hotel->price)
                            <div class="mt-1" style="font-size:12px;color:#475569;">
                                💰 Base Price: <strong>{{ format_money($hotel->price) }}/night</strong>
                            </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2 flex-shrink-0">
                            <a href="{{ route('hotel.vendor.edit', ['id' => $hotel->id]) }}" target="_blank"
                               class="btn btn-sm btn-outline-secondary" style="font-size:12px;">
                               👁️ Preview
                            </a>

                            <!-- Approve -->
                            <form method="POST" action="{{ route('hotel.admin.approve', $hotel->id) }}" style="display:inline;" onsubmit="return confirm('Approve this hotel and make it live?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" style="font-size:12px;font-weight:600;">
                                    ✅ Approve
                                </button>
                            </form>

                            <!-- Reject -->
                            <button type="button" class="btn btn-sm btn-danger" style="font-size:12px;font-weight:600;"
                                onclick="openRejectModal({{ $hotel->id }}, '{{ addslashes($hotel->title) }}')">
                                ❌ Reject
                            </button>
                        </div>
                    </div>

                    @php
                        $policy = is_array($hotel->policy) ? $hotel->policy : (json_decode($hotel->policy, true) ?? []);
                    @endphp
                    @if(!empty($policy))
                    <div class="px-4 pb-3">
                        <div style="background:#f8fafc;border-radius:8px;padding:12px 16px;border:1px solid #e2e8f0;">
                            <div class="d-flex flex-wrap gap-3" style="font-size:12px;color:#475569;">
                                @if(!empty($policy['property_type']))
                                <span><strong>Type:</strong> {{ ucfirst($policy['property_type']) }}</span>
                                @endif
                                @if(!empty($policy['breakfast']))
                                <span><strong>Breakfast:</strong> {{ ucfirst($policy['breakfast']) }}</span>
                                @endif
                                @if(!empty($policy['parking']))
                                <span><strong>Parking:</strong> {{ ucfirst($policy['parking']) }}</span>
                                @endif
                                @if(!empty($policy['gst_registered']))
                                <span><strong>GST:</strong> {{ $policy['gst_registered'] == 'yes' ? '✓ Registered' : 'Not Registered' }}</span>
                                @endif
                                @if(!empty($policy['owner_name']))
                                <span><strong>Owner:</strong> {{ $policy['owner_name'] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $rows->links() }}
    </div>

    @else
    <div class="text-center py-5">
        <div style="font-size:64px;margin-bottom:16px;">🎉</div>
        <h4 style="color:#1e293b;font-weight:700;">No Pending Hotels</h4>
        <p class="text-muted">All hotel submissions have been reviewed. Check back later.</p>
        <a href="{{ url('admin/module/hotel') }}" class="btn btn-primary mt-2">View All Hotels</a>
    </div>
    @endif
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:14px;border:none;">
            <div class="modal-header" style="background:#fef2f2;border-bottom:1px solid #fecaca;">
                <h5 class="modal-title" style="color:#dc2626;font-weight:700;">❌ Reject Hotel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p style="font-size:14px;color:#475569;">You are rejecting: <strong id="rejectHotelName"></strong></p>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;font-size:13px;">Rejection Reason (optional)</label>
                        <textarea name="rejection_reason" class="form-control" rows="3"
                            placeholder="Explain why this property is being rejected..."
                            style="font-size:13px;border-radius:8px;"></textarea>
                        <small class="text-muted">This will be stored for record. The hotel will be moved to Draft status.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" style="font-weight:600;">❌ Confirm Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRejectModal(hotelId, hotelName) {
    document.getElementById('rejectHotelName').textContent = hotelName;
    document.getElementById('rejectForm').action = '/admin/module/hotel/reject/' + hotelId;
    var modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}
</script>
@endsection
