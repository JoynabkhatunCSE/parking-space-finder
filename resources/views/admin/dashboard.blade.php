@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Enhanced Header --}}
        <div class="mb-10">
            <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <a href="#" class="hover:text-slate-900 font-medium">Dashboard</a>
            </nav>
            
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 via-indigo-900 to-slate-900 bg-clip-text text-transparent">
                        Admin Dashboard
                    </h1>
                    <p class="mt-2 text-xl text-slate-600 font-medium">Parking Space Management System</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-white/80 backdrop-blur-sm px-6 py-3 rounded-2xl shadow-xl border border-slate-200">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-sm font-semibold text-slate-700">Live Data</span>
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm px-6 py-3 rounded-2xl shadow-xl border border-slate-200">
                        <span class="text-sm font-semibold text-slate-700">{{ now()->format('M j, Y - g:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
            @php
                $kpis = [
                    [
                        'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                        'title' => 'Total Locations',
                        'value' => $parkingLotsCount,
                        'color' => 'from-indigo-500 to-purple-600',
                        'bg' => 'bg-gradient-to-br from-indigo-50 to-purple-50'
                    ],
                    [
                        'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z',
                        'title' => 'Total Spaces',
                        'value' => $parkingSpacesCount,
                        'color' => 'from-emerald-500 to-teal-600',
                        'bg' => 'bg-gradient-to-br from-emerald-50 to-teal-50'
                    ],
                    [
                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                        'title' => 'Available Slots',
                        'value' => $availableSpaces,
                        'color' => 'from-green-500 to-emerald-600',
                        'bg' => 'bg-gradient-to-br from-green-50 to-emerald-50'
                    ],
                    [
                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                        'title' => 'Currently Booked',
                        'value' => $bookedSpaces,
                        'color' => 'from-rose-500 to-pink-600',
                        'bg' => 'bg-gradient-to-br from-rose-50 to-pink-50'
                    ]
                ];
            @endphp
            
            @foreach($kpis as $kpi)
            <div class="group bg-white/70 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 hover:border-{{ explode(' ', $kpi['color'])[0] }}-200/50 p-8 transform hover:-translate-y-2 transition-all duration-500 hover:shadow-3xl">
                <div class="flex items-center justify-between mb-6">
                    <div class="p-4 {{ $kpi['bg'] }} rounded-2xl group-hover:scale-110 transition-transform duration-300 border border-white/30">
                        <svg class="w-8 h-8 text-{{ $kpi['color'] }} drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $kpi['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-r {{ $kpi['color'] }} rounded-2xl flex items-center justify-center opacity-20 group-hover:opacity-30 transition-opacity"></div>
                </div>
                <div>
                    <p class="text-slate-600 font-semibold text-lg mb-2 tracking-wide uppercase">{{ $kpi['title'] }}</p>
                    <p class="text-4xl font-black text-slate-900 drop-shadow-lg leading-tight">{{ number_format($kpi['value']) }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Main Analytics Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            {{-- Revenue Chart Card --}}
            <div class="lg:col-span-2 bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 p-10 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/5"></div>
                <div class="absolute top-0 right-0 w-72 h-72 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-full opacity-10 blur-3xl -translate-y-20 translate-x-20"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900 mb-2">Monthly Revenue</h3>
                            <p class="text-slate-600">Total earnings from paid transactions</p>
                        </div>
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-2xl shadow-lg font-semibold">
                            ৳ {{ number_format($monthlyRevenue, 2) }}
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-slate-50 to-indigo-50 p-8 rounded-2xl border border-slate-200/50">
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Payment Success Rate</span>
                            <div class="flex items-center gap-2">
                                @if($totalBookings > 0)
                                    <span class="text-3xl font-black text-emerald-600">{{ round(($paidBookings / $totalBookings) * 100) }}%</span>
                                @else
                                    <span class="text-3xl font-black text-slate-500">0%</span>
                                @endif
                                <div class="w-3 h-3 bg-emerald-400 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                        
                        <div class="h-80 bg-white rounded-2xl p-6 border-2 border-dashed border-indigo-200/50 flex items-center justify-center">
                            <div class="text-center text-slate-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <p class="text-lg font-semibold mb-1">Revenue Analytics Chart</p>
                                <p class="text-sm">Enhanced charts coming soon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Booking Status --}}
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 p-8">
                <h3 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Booking Status
                </h3>
                
                <div class="space-y-8">
                    <div class="group">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-slate-700 font-semibold">Total Bookings</span>
                            <span class="text-2xl font-black text-slate-900">{{ $totalBookings }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden shadow-inner">
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full shadow-lg transition-all duration-1000" style="width: 100%"></div>
                        </div>
                    </div>
                    
                    <div class="group">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-slate-700 font-semibold">Paid & Confirmed</span>
                            <span class="text-2xl font-black text-emerald-600">{{ $paidBookings }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden shadow-inner">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 h-3 rounded-full shadow-lg transition-all duration-1000" style="width: {{ $totalBookings > 0 ? ($paidBookings / $totalBookings) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FIXED Action Buttons - Correct Routes --}}
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 p-10">
            <div class="flex items-center gap-3 mb-10">
                <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <div>
                    <h2 class="text-3xl font-bold text-slate-900">Quick Actions</h2>
                    <p class="text-slate-600">Manage your parking system efficiently</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- ✅ Parking Lots - CORRECT --}}
                <a href="{{ route('admin.parking-lots.index') }}" 
                   class="group bg-gradient-to-b from-slate-50 to-white p-10 rounded-3xl border-2 border-slate-200/50 hover:border-indigo-300 hover:shadow-2xl hover:-translate-y-3 transition-all duration-500 shadow-xl hover:shadow-indigo-100/50">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-2xl group-hover:scale-110 transition-all duration-300 mb-6 mx-auto">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-black text-slate-900 mb-3 text-center group-hover:text-indigo-600 transition-colors">Parking Lots</h4>
                    <p class="text-slate-600 text-center font-medium mb-6">Manage locations & facilities</p>
                    <div class="flex items-center justify-center gap-2 text-indigo-600 group-hover:text-indigo-700">
                        <span class="font-semibold">Manage</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </a>

                {{-- ✅ Parking Spaces - FIXED: Direct to lots index (spaces require parkingLot parameter) --}}
                <a href="{{ route('admin.parking-lots.index') }}" 
                   class="group bg-gradient-to-b from-slate-50 to-white p-10 rounded-3xl border-2 border-slate-200/50 hover:border-emerald-300 hover:shadow-2xl hover:-translate-y-3 transition-all duration-500 shadow-xl hover:shadow-emerald-100/50">
                    <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center text-white shadow-2xl group-hover:scale-110 transition-all duration-300 mb-6 mx-auto">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-black text-slate-900 mb-3 text-center group-hover:text-emerald-600 transition-colors">Parking Spaces</h4>
                    <p class="text-slate-600 text-center font-medium mb-6">Manage capacities via lots</p>
                    <div class="flex items-center justify-center gap-2 text-emerald-600 group-hover:text-emerald-700">
                        <span class="font-semibold">Manage Lots</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </a>

                {{-- ✅ Booking History - Generic link (update with your actual route) --}}
                <a href="#" onclick="alert('Add your bookings route here')" 
                   class="group bg-gradient-to-b from-slate-50 to-white p-10 rounded-3xl border-2 border-slate-200/50 hover:border-orange-300 hover:shadow-2xl hover:-translate-y-3 transition-all duration-500 shadow-xl hover:shadow-orange-100/50 cursor-pointer">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-amber-600 rounded-2xl flex items-center justify-center text-white shadow-2xl group-hover:scale-110 transition-all duration-300 mb-6 mx-auto">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-black text-slate-900 mb-3 text-center group-hover:text-orange-600 transition-colors">Booking History</h4>
                    <p class="text-slate-600 text-center font-medium mb-6">View all reservations</p>
                    <div class="flex items-center justify-center gap-2 text-orange-600 group-hover:text-orange-700">
                        <span class="font-semibold">Coming Soon</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </a>

                {{-- ✅ Payments - Generic link (update with your actual route) --}}
                <a href="#" onclick="alert('Add your payments route here')" 
                   class="group bg-gradient-to-b from-slate-50 to-white p-10 rounded-3xl border-2 border-slate-200/50 hover:border-sky-300 hover:shadow-2xl hover:-translate-y-3 transition-all duration-500 shadow-xl hover:shadow-sky-100/50 cursor-pointer">
                    <div class="w-20 h-20 bg-gradient-to-br from-sky-500 to-blue-600 rounded-2xl flex items-center justify-center text-white shadow-2xl group-hover:scale-110 transition-all duration-300 mb-6 mx-auto">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-black text-slate-900 mb-3 text-center group-hover:text-sky-600 transition-colors">Payments</h4>
                    <p class="text-slate-600 text-center font-medium mb-6">Transaction logs & reports</p>
                    <div class="flex items-center justify-center gap-2 text-sky-600 group-hover:text-sky-700">
                        <span class="font-semibold">Coming Soon</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </a>
            </div>

            {{-- 🚀 Quick Fix Instructions --}}
            <div class="mt-12 p-8 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-3xl border-2 border-yellow-200">
                <h3 class="text-xl font-bold text-yellow-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Quick Setup Guide
                </h3>
                <div class="space-y-3 text-sm text-yellow-900">
                    <p><strong>✅ Parking Lots:</strong> Working! → <code>route('admin.parking-lots.index')</code></p>
                    <p><strong>🔧 Parking Spaces:</strong> Fixed! Uses parking lots index (spaces need parkingLot ID)</p>
                    <p><strong>⚠️ Bookings & Payments:</strong> Add these routes to your <code>web.php</code>:</p>
                    <div class="bg-white p-4 rounded-xl border-l-4 border-yellow-400 font-mono text-xs">
<pre>Route::resource('admin/bookings', BookingController::class)->names('admin.bookings');
Route::resource('admin/payments', PaymentController::class)->names('admin.payments');</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
