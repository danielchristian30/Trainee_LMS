<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Admin Dashboard') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Default sidebarOpen diubah ke true untuk desktop -->
        <div x-data="{ sidebarOpen: true }" class="flex h-screen bg-gray-100 overflow-hidden">
            
            <!-- Sidebar Component -->
            @include('layouts.navigation')

            <!-- Area Konten Utama -->
            <div class="flex-1 flex flex-col overflow-hidden">
                
                <!-- Topbar / Header -->
                <header class="bg-white border-b border-gray-100 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 shrink-0">
                    <div class="flex items-center">
                        <!-- Tombol Toggle (Sekarang aktif untuk Mobile & Desktop) -->
                        <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 focus:outline-none sm:hidden mr-4">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Slot Judul Halaman (Page Heading) -->
                        @isset($header)
                            {{ $header }}
                        @endisset
                    </div>

                    <!-- Info User Singkat di Kanan Atas -->
                    <div class="hidden sm:flex items-center text-sm font-medium text-gray-700">
                        <span class="ml-2 px-2 py-1 bg-slate-800 text-white rounded text-[10px] uppercase font-bold tracking-wider">
                            {{ Auth::user()->name }}
                        </span>
                    </div>
                </header>

                <!-- Slot Konten Dashboard / Halaman -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                    {{ $slot }}
                </main>
            </div>
            
        </div>
    </body>
</html>