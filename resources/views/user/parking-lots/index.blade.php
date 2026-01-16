@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Enhanced Header --}}
        <div class="mb-12">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-4xl font-black bg-gradient-to-r from-slate-900 via-indigo-900 to-slate-900 bg-clip-text text-transparent mb-3">
                        Parking Lots
                    </h1>
                    <p class="text-xl text-slate-600 font-semibold max-w-2xl">Discover available parking locations near you</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm px-8 py-4 rounded-2xl shadow-xl border border-slate-200 flex items-center gap-3">
                    <div class="w-3 h-3 bg-emerald-400 rounded-full animate-pulse"></div>
                    <span class="text-lg font-bold text-slate-800">Live Availability</span>
                </div>
            </div>
        </div>

        {{-- Parking Lots Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($parkingLots as $lot)
                {{-- Fixed Icon Size Parking Lot Card --}}
                <div class="group bg-white/70 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 p-8 hover:shadow-3xl hover:-translate-y-3 hover:border-indigo-200/50 transition-all duration-700 transform overflow-hidden h-full">
                    
                    {{-- Decorative Background --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 via-indigo-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    
                    {{-- Fixed Header with Smaller Icon --}}
                    <div class="relative mb-6">
                        <div class="w-full h-40 bg-gradient-to-br from-indigo-500 via-purple-600 to-emerald-500 rounded-2xl flex items-center justify-center shadow-2xl group-hover:scale-[1.02] transition-all duration-500 overflow-hidden">
                            <svg class="w-16 h-16 text-white/90 drop-shadow-2xl group-hover:scale-105 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="px-4 py-2 bg-white/95 backdrop-blur-sm text-indigo-700 font-bold text-sm rounded-xl shadow-lg border border-indigo-200/50">
                                {{ $lot->total_spaces }} Spaces
                            </span>
                        </div>
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-2xl font-black bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent mb-2 group-hover:text-indigo-700 transition-colors">
                                    {{ $lot->name }}
                                </h3>
                                <p class="text-slate-600 font-semibold text-base mb-1">{{ Str::limit($lot->address, 60) }}</p>
                            </div>
                        </div>

                        {{-- Stats Grid with Smaller Numbers --}}
                        <div class="grid grid-cols-2 gap-4 mb-8 p-6 bg-gradient-to-r from-slate-50/50 to-indigo-50/50 backdrop-blur-sm rounded-2xl border border-slate-200/50">
                            <div class="text-center p-4 group-hover:bg-emerald-50/50 rounded-xl transition-all">
                                <div class="text-2xl font-black text-emerald-600 mb-1 drop-shadow-lg">{{ $lot->total_spaces }}</div>
                                <p class="text-xs font-semibold text-slate-600 uppercase tracking-wide">Total Spaces</p>
                            </div>
                            <div class="text-center p-4 group-hover:bg-indigo-50/50 rounded-xl transition-all">
                                <div class="text-2xl font-black text-indigo-600 mb-1 drop-shadow-lg">৳{{ number_format($lot->hourly_rate, 0) }}/hr</div>
                                <p class="text-xs font-semibold text-slate-600 uppercase tracking-wide">Hourly Rate</p>
                            </div>
                        </div>

                        {{-- Fixed Button Icon Size --}}
                        <a href="{{ route('parking-lots.show', $lot->id) }}"
                           class="group/btn w-full bg-gradient-to-r from-indigo-500 via-indigo-600 to-purple-600 hover:from-indigo-600 hover:via-indigo-700 hover:to-purple-700 text-white font-black text-lg py-4 px-6 rounded-2xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all duration-500 flex items-center justify-center gap-2 border-2 border-indigo-400/50">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span>View Spaces</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="col-span-full bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 p-20 text-center group hover:shadow-3xl transition-all">
                    <div class="w-24 h-24 mx-auto mb-8 bg-gradient-to-br from-slate-200 to-gray-300 rounded-3xl flex items-center justify-center shadow-2xl group-hover:scale-105 transition-transform">
                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-black text-slate-900 mb-4 bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                        No Parking Lots Available
                    </h2>
                    <p class="text-xl text-slate-600 mb-8 max-w-2xl mx-auto font-semibold">
                        We're working hard to bring more parking locations to your area.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
