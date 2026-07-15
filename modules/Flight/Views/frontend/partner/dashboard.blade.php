@extends('layouts.user')
@section('content')
<div class="container mx-auto px-4 py-8">
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Affiliate Dashboard</h2>
            <p class="text-gray-500 mt-1">Welcome back, {{ $partner->name }}!</p>
        </div>
        <span class="px-4 py-2 rounded-full {{ $partner->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} font-semibold">
            Status: {{ ucfirst($partner->status) }}
        </span>
    </div>

    <!-- Referral Link Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8" x-data="{ link: '{{ url('/') }}?ref={{ $partner->referral_code }}', copied: false }">
        <h3 class="text-lg font-bold text-gray-800 mb-3">Your Unique Referral Link</h3>
        <p class="text-gray-600 mb-4 text-sm">Share this link to earn a {{ $partner->commission_type == 'percentage' ? $partner->commission_value.'%' : '₹'.$partner->commission_value }} commission on successful bookings.</p>
        
        <div class="flex items-center">
            <input type="text" readonly x-model="link" class="w-full bg-gray-50 border border-gray-300 text-gray-700 py-3 px-4 rounded-l-lg focus:outline-none">
            <button @click="navigator.clipboard.writeText(link); copied = true; setTimeout(() => copied = false, 2000)" 
                    class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-r-lg transition duration-200 min-w-[120px]">
                <span x-show="!copied">Copy Link</span>
                <span x-show="copied"><i class="bi bi-check-circle"></i> Copied!</span>
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="text-gray-500 text-sm font-semibold uppercase mb-1">Total Clicks</div>
            <div class="text-3xl font-bold text-gray-800">{{ $totalClicks }}</div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="text-gray-500 text-sm font-semibold uppercase mb-1">Total Bookings</div>
            <div class="text-3xl font-bold text-gray-800">{{ $totalBookings }}</div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="text-gray-500 text-sm font-semibold uppercase mb-1">Pending Commission</div>
            <div class="text-3xl font-bold text-orange-500">₹{{ number_format($pendingCommission, 2) }}</div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 bg-gradient-to-br from-green-50 to-white">
            <div class="text-gray-500 text-sm font-semibold uppercase mb-1">Confirmed Balance</div>
            <div class="text-3xl font-bold text-green-600">₹{{ number_format($confirmedCommission, 2) }}</div>
        </div>
    </div>

    <!-- Payout Request & History -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Payout Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Request Payout</h3>
                <p class="text-gray-600 text-sm mb-6">Minimum payout threshold is ₹500.</p>
                
                <form action="{{ route('flight.partner.payout.request') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2 text-sm">Amount (₹)</label>
                        <input type="number" name="amount" min="500" max="{{ $confirmedCommission }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required {{ $confirmedCommission < 500 ? 'disabled' : '' }}>
                    </div>
                    
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition duration-300 {{ $confirmedCommission < 500 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $confirmedCommission < 500 ? 'disabled' : '' }}>
                        Request Transfer
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Payout History -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Payout History</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-sm uppercase">
                                <th class="px-6 py-4 font-semibold">Date</th>
                                <th class="px-6 py-4 font-semibold">Amount</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm text-gray-800">
                            @forelse($payouts as $payout)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $payout->created_at->format('d M, Y H:i') }}</td>
                                <td class="px-6 py-4 font-semibold">₹{{ number_format($payout->amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $payout->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $payout->status == 'requested' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $payout->status == 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                                    ">
                                        {{ ucfirst($payout->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">No payout requests found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</div>

<!-- Add Alpine.js for copy functionality -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js" defer></script>
@endsection
