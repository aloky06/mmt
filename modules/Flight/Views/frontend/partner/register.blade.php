@extends('layouts.user')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-orange-500 to-orange-400 p-6 text-white text-center">
            <h2 class="text-2xl font-bold">Become an Affiliate Partner</h2>
            <p class="mt-2 text-orange-50">Join the Make My Travels affiliate program and earn commissions on every booking.</p>
        </div>
        
        <div class="p-8">
            <form action="{{ route('flight.partner.register') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                    <input type="text" name="name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" value="{{ auth()->user()->display_name ?? '' }}" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Email Address</label>
                    <input type="email" name="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" value="{{ auth()->user()->email ?? '' }}" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-8">
                    <label class="block text-gray-700 font-semibold mb-2">PAN Number <span class="text-gray-400 font-normal">(Optional, required for payouts over ₹500)</span></label>
                    <input type="text" name="pan_number" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 uppercase" placeholder="ABCDE1234F">
                </div>
                
                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-300">
                    Register as Partner
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
