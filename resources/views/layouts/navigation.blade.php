<!-- Overlay Gelap untuk Tampilan Mobile (Menutup sidebar saat diklik) -->
<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-20 bg-black/50 sm:hidden" 
     @click="sidebarOpen = false" 
     style="display: none;"></div>

<!-- Sidebar Container -->
<!-- Perubahan pada :class untuk mengatur width (w-64 vs w-20) di layar besar -->
<aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full sm:translate-x-0 sm:w-20 w-64'" 
       class="fixed inset-y-0 left-0 z-30 bg-white border-r border-gray-200 transition-all duration-300 ease-in-out sm:static sm:inset-0 flex flex-col shrink-0 overflow-hidden">
    
    <!-- Header Sidebar (Logo & Brand) -->
    <div class="flex items-center h-16 border-b border-gray-100 transition-all duration-300" :class="sidebarOpen ? 'justify-between px-4' : 'justify-center px-0'">
        
        <!-- Logo (Berfungsi sbg link dashboard saat buka, dan tombol toggle saat tutup) -->
        <a :href="sidebarOpen ? '{{ route('dashboard') }}' : '#'" 
           @click="if(!sidebarOpen) { $event.preventDefault(); sidebarOpen = true; }"
           class="flex items-center gap-3 cursor-pointer group outline-none">
            
            <x-application-logo class="block h-8 w-auto fill-current text-blue-600 shrink-0 group-hover:opacity-80 transition-opacity" />
            
            <span x-show="sidebarOpen" class="font-bold text-lg text-gray-800 tracking-tight whitespace-nowrap">
                Admin Dashboard
            </span>
        </a>
        
        <!-- Tombol Close/Hamburger di dalam Sidebar -->
        <button x-show="sidebarOpen" @click="sidebarOpen = false" class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
            <!-- Ikon Double Chevron Left untuk Desktop (Menyusutkan Sidebar ke Kiri) -->
            <svg class="w-5 h-5 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
            
            <!-- Ikon X untuk Mobile (Menutup Sidebar Overlay) -->
            <svg class="w-6 h-6 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Group Navigasi -->
    <div class="flex-1 overflow-y-auto px-3 py-6 space-y-6">
        
        <!-- BAGIAN 1: MENU UTAMA -->
        <div>
            <p x-show="sidebarOpen" class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Menu</p>
            <!-- Garis pemisah kecil saat ditutup -->
            <div x-show="!sidebarOpen" class="w-8 h-px bg-gray-200 mx-auto mb-4"></div>
            
            <nav class="space-y-1">
                
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center py-2.5 text-sm font-semibold rounded-lg transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}"
                   :class="sidebarOpen ? 'px-3' : 'justify-center'" title="Dashboard">
                    <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Dashboard</span>
                </a>

                @if (Auth::user()->role === 'admin')
                    <!-- Kelola User -->
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center py-2.5 text-sm font-semibold rounded-lg transition-all duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}"
                       :class="sidebarOpen ? 'px-3' : 'justify-center'" title="Kelola User">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Kelola User</span>
                    </a>

                    <!-- Kelola Modul -->
                    <a href="{{ route('admin.modules.index') }}" 
                       class="flex items-center py-2.5 text-sm font-semibold rounded-lg transition-all duration-150 {{ request()->routeIs('admin.modules.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}"
                       :class="sidebarOpen ? 'px-3' : 'justify-center'" title="Kelola Modul">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.modules.*') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Kelola Modul</span>
                    </a>

                    <!-- Template Sertifikat -->
                    <a href="{{ route('admin.certificate-templates.index') }}" 
                       class="flex items-center py-2.5 text-sm font-semibold rounded-lg transition-all duration-150 {{ request()->routeIs('admin.certificate-templates.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}"
                       :class="sidebarOpen ? 'px-3' : 'justify-center'" title="Template Sertifikat">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.certificate-templates.*') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Template Sertifikat</span>
                    </a>
                @endif

            </nav>
        </div>

        <!-- BAGIAN 2: PROFILE & AKUN -->
        <div>
            <p x-show="sidebarOpen" class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Profile</p>
            <div x-show="!sidebarOpen" class="w-8 h-px bg-gray-200 mx-auto mb-4"></div>
            
            <nav class="space-y-1">
                
                <!-- Pengaturan / Edit Profile & Password -->
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center py-2.5 text-sm font-semibold rounded-lg transition-all duration-150 {{ request()->routeIs('profile.edit') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}"
                   :class="sidebarOpen ? 'px-3' : 'justify-center'" title="Pengaturan">
                    <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('profile.edit') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Pengaturan</span>
                </a>

                <!-- Log Out Form -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center py-2.5 text-sm font-semibold rounded-lg text-gray-600 hover:bg-red-50 hover:text-red-600 transition-all duration-150"
                            :class="sidebarOpen ? 'px-3' : 'justify-center'" title="Log Out">
                        <svg class="w-5 h-5 shrink-0 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Log Out</span>
                    </button>
                </form>

            </nav>
        </div>

    </div>

    <!-- Profile Footer Card (Bagian Bawah Sidebar) -->
    <div class="p-4 border-t border-gray-100 bg-gray-50/50 flex" :class="sidebarOpen ? 'items-center gap-3' : 'justify-center'">
        <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div x-show="sidebarOpen" class="overflow-hidden">
            <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
        </div>
    </div>
</aside>