<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Parking Space Finder') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            900: '#0f172a', // Dark Blue
                            800: '#1e293b',
                            accent: '#f59e0b', // Amber/Yellow for Parking
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased bg-gray-50 text-slate-800">

    <nav class="absolute w-full z-20 top-0 start-0 border-b border-white/10 bg-brand-900/50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <div class="bg-brand-accent p-1.5 rounded-md">
                    <svg class="w-6 h-6 text-brand-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                </div>
                <span class="self-center text-xl font-bold whitespace-nowrap text-white">Park<span class="text-brand-accent">Finder</span></span>
            </a>
            
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                @if (Route::has('login'))
                    <div class="flex gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-white bg-brand-accent hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-brand-accent font-medium text-sm px-4 py-2.5 transition-colors">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-brand-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center transition-all">
                                    Sign Up
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <section class="relative bg-brand-900 min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1506521781263-d8422e82f27a?q=80&w=2070&auto=format&fit=crop" alt="Parking Garage" class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-b from-brand-900/90 via-brand-900/70 to-brand-900"></div>
        </div>

        <div class="relative z-10 py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
            <div class="inline-flex justify-between items-center py-1 px-1 pr-4 mb-7 text-sm text-brand-accent bg-brand-800 rounded-full hover:bg-brand-700 transition-colors" role="alert">
                <span class="text-xs bg-brand-accent text-brand-900 rounded-full px-4 py-1.5 mr-3 font-bold">New</span> <span class="text-sm font-medium">Real-time availability is now live!</span> 
            </div>
            
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">
                Find Your Perfect <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-accent to-yellow-200">Parking Spot</span>
            </h1>
            
            <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">
                Stop circling the block. Reserve secure, convenient, and affordable parking spaces in seconds.
            </p>

            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex justify-center items-center py-3 px-6 text-base font-medium text-center text-brand-900 rounded-lg bg-brand-accent hover:bg-yellow-500 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900 transition-all">
                        Find a Spot Now
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center py-3 px-6 text-base font-medium text-center text-brand-900 rounded-lg bg-brand-accent hover:bg-yellow-500 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900 transition-all">
                        Get Started
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                    <a href="#features" class="inline-flex justify-center items-center py-3 px-6 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white/20 hover:bg-white/10 focus:ring-4 focus:ring-gray-400 transition-all">
                        Learn More
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <section id="features" class="bg-white py-16 lg:py-24">
        <div class="px-4 mx-auto max-w-screen-xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Why use ParkFinder?</h2>
                <p class="mt-4 text-lg text-gray-500">We make parking hassle-free with smart technology.</p>
            </div>
            
            <div class="grid gap-8 md:grid-cols-3">
                <div class="p-8 border border-gray-100 rounded-2xl bg-gray-50 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-gray-900">Real-Time Availability</h3>
                    <p class="text-gray-500">See exactly which spots are open right now. No more guessing games or driving in circles.</p>
                </div>

                <div class="p-8 border border-gray-100 rounded-2xl bg-gray-50 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-gray-900">Secure Booking</h3>
                    <p class="text-gray-500">Book your spot in advance and pay securely through the app. Your space is guaranteed.</p>
                </div>

                <div class="p-8 border border-gray-100 rounded-2xl bg-gray-50 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-gray-900">Best Locations</h3>
                    <p class="text-gray-500">Find the closest parking to your destination. We cover garages, lots, and private driveways.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-brand-900 border-t border-white/10">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-gray-400 sm:text-center">© {{ date('Y') }} <a href="#" class="hover:underline hover:text-white">ParkFinder™</a>. All Rights Reserved.
            </span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-400 sm:mt-0">
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6 hover:text-white">About</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6 hover:text-white">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="hover:underline hover:text-white">Contact</a>
                </li>
            </ul>
        </div>
    </footer>

</body>
</html>