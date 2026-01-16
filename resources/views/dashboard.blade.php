@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Enhanced Header --}}
        <div class="mb-12">
            <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <a href="#" class="hover:text-slate-900 font-medium">Dashboard</a>
            </nav>
            
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 via-indigo-900 to-slate-900 bg-clip-text text-transparent mb-2">
                        Welcome Back!
                    </h1>
                    <p class="text-xl text-slate-600 font-semibold">Manage your parking bookings, {{ auth()->user()->name }}</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm px-8 py-4 rounded-2xl shadow-xl border border-slate-200 flex items-center gap-4">
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-lg font-bold text-slate-800">Active Account</span>
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- KPI Cards - Professional Design --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            @php
                $stats = [
                    [
                        'title' => 'Total Bookings',
                        'value' => $bookings->count(),
                        'color' => 'from-indigo-500 to-purple-600',
                        'bg' => 'bg-gradient-to-br from-indigo-50 to-purple-50',
                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    [
                        'title' => 'Active / Paid',
                        'value' => $bookings->where('status', 'paid')->count(),
                        'color' => 'from-emerald-500 to-teal-600',
                        'bg' => 'bg-gradient-to-br from-emerald-50 to-teal-50',
                        'icon' => 'M9 12l2 2 4-4'
                    ],
                    [
                        'title' => 'Pending Payment',
                        'value' => $bookings->where('status', 'pending')->count(),
                        'color' => 'from-rose-500 to-pink-600',
                        'bg' => 'bg-gradient-to-br from-rose-50 to-pink-50',
                        'icon' => 'M12 8v4l3 3'
                    ]
                ];
            @endphp

            @foreach($stats as $stat)
            <div class="group bg-white/70 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 p-8 hover:shadow-3xl hover:-translate-y-2 transition-all duration-500 transform">
                <div class="flex items-center justify-between mb-6">
                    <div class="p-4 {{ $stat['bg'] }} rounded-2xl shadow-lg border border-white/30 group-hover:scale-105 transition-all duration-300">
                        <svg class="w-8 h-8 text-{{ $stat['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-r {{ $stat['color'] }} rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                </div>
                <p class="text-slate-600 font-semibold text-lg mb-3 tracking-wide uppercase">{{ $stat['title'] }}</p>
                <p class="text-4xl font-black bg-gradient-to-r {{ $stat['color'] }} bg-clip-text text-transparent drop-shadow-lg">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Primary Action Button --}}
        <div class="mb-12 text-center">
            <a href="{{ route('parking-lots.index') }}"
               class="group inline-flex items-center gap-4 px-10 py-6 bg-gradient-to-r from-indigo-500 via-indigo-600 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-black text-xl rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all duration-500 transform shadow-indigo-500/50 hover:shadow-indigo-600/60 border-2 border-transparent hover:border-indigo-400/50">
                <svg class="w-8 h-8 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>Browse Parking Lots</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        {{-- Enhanced Booking History --}}
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-10 py-8">
                <div class="flex items-center gap-4">
                    <svg class="w-12 h-12 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <h2 class="text-3xl font-black text-white drop-shadow-lg">Booking History</h2>
                        <p class="text-indigo-100 font-medium">Track all your parking reservations</p>
                    </div>
                </div>
            </div>

            <div class="p-10">
                @forelse($bookings as $booking)
                    {{-- Enhanced Booking Card --}}
                    <div class="group bg-gradient-to-br from-white to-slate-50 rounded-3xl border-2 border-slate-100/50 p-8 mb-8 hover:shadow-2xl hover:border-indigo-200/50 hover:-translate-y-2 transition-all duration-500 shadow-xl overflow-hidden relative">
                        <div class="absolute top-4 right-4">
                            @php $statusColor = match($booking->status) {
                                'paid' => ['bg-emerald-500/90', 'text-emerald-50', 'border-emerald-400/50', 'Paid'],
                                'pending' => ['bg-amber-500/90', 'text-amber-50', 'border-amber-400/50', 'Pending'],
                                default => ['bg-slate-500/90', 'text-slate-50', 'border-slate-400/50', 'Completed']
                            }; @endphp
                            <span class="px-6 py-3 {{ $statusColor[0] }} font-bold text-lg rounded-2xl shadow-lg border {{ $statusColor[2] }} tracking-wide">
                                {{ $statusColor[3] }}
                            </span>
                        </div>

                        <div class="flex flex-col lg:flex-row lg:items-start lg:gap-8">
                            <div class="flex-1 mb-6 lg:mb-0">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center shadow-xl">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-2xl font-black text-slate-900 mb-1 group-hover:text-indigo-700 transition-colors">
                                            {{ $booking->parkingSpace->parkingLot->name }}
                                        </h4>
                                        <p class="text-slate-600 font-semibold">{{ $booking->parkingSpace->parkingLot->address }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-50/50 p-6 rounded-2xl border border-slate-200/50">
                                    <div class="text-center p-4">
                                        <div class="text-3xl font-black text-indigo-600 mb-1">#{{ $booking->parkingSpace->space_number }}</div>
                                        <p class="text-sm text-slate-600 font-medium uppercase tracking-wide">Space Number</p>
                                    </div>
                                    <div class="text-center p-4 border-l border-slate-200/30">
                                        <div class="text-xl font-bold text-emerald-600 mb-1">{{ $booking->start_time }}</div>
                                        <p class="text-sm text-slate-600 font-medium uppercase tracking-wide">Start Time</p>
                                    </div>
                                    <div class="text-center p-4 border-l border-slate-200/30">
                                        <div class="text-xl font-bold text-rose-600 mb-1">{{ $booking->end_time }}</div>
                                        <p class="text-sm text-slate-600 font-medium uppercase tracking-wide">End Time</p>
                                    </div>
                                </div>
                            </div>

                            @if($booking->status === 'pending')
                            <div class="lg:text-right mt-6 lg:mt-0 lg:self-center">
                                <a href="{{ route('payment.sslcommerz', $booking) }}"
                                   class="group/btn inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-black text-lg rounded-2xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all duration-300 transform shadow-amber-500/50 border border-amber-400/50">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                    Complete Payment
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 px-8">
                        <div class="w-32 h-32 bg-gradient-to-br from-slate-100 to-slate-200 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-xl">
                            <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-4">No Bookings Yet</h3>
                        <p class="text-xl text-slate-600 mb-8 max-w-md mx-auto">You haven't booked any parking spaces. Start by browsing available lots!</p>
                        <a href="{{ route('parking-lots.index') }}"
                           class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-black text-lg rounded-2xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Find Parking Now
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
