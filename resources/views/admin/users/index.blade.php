<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen User') }}
            </h2>
        </div>
    </x-slot>

    <!-- Inisialisasi Alpine.js state di kontainer utama: showModal dan deleteUrl -->
    <div class="py-12" x-data="{ showModal: false, deleteUrl: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded">
                    + Tambah User
                </a>
            </div>
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="border-b py-4 px-6 font-semibold text-sm">Nama</th>
                                <th class="border-b py-4 px-6 font-semibold text-sm">Email</th>
                                <th class="border-b py-4 px-6 font-semibold text-sm">Role</th>
                                <th class="border-b py-4 px-6 font-semibold text-sm text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="border-b py-4 px-6">{{ $user->name }}</td>
                                    <td class="border-b py-4 px-6">{{ $user->email }}</td>
                                    <td class="border-b py-4 px-6">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="border-b py-4 px-6 text-right">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                        
                                        <!-- Tombol Hapus: Mengubah url target dan menampilkan modal -->
                                        <button type="button" 
                                                @click="deleteUrl = '{{ route('admin.users.destroy', $user) }}'; showModal = true" 
                                                class="text-red-600 hover:text-red-900">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

            <!-- Modal Card Konfirmasi Hapus -->
            <div x-show="showModal" 
                style="display: none;" 
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm transition-opacity"
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                
                <!-- Box Modal -->
                <div @click.away="showModal = false" 
                    class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-6 sm:p-7 transform transition-all border border-gray-100"
                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100">
                    
                    <!-- Header: Icon & Judul -->
                    <div class="flex items-center space-x-4 mb-4">
                        <!-- Container Icon Peringatan (Soft Red background + rounded) -->
                        <div class="flex-shrink-0 w-12 h-12 bg-red-100/70 text-red-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-800">
                            Konfirmasi Hapus User
                        </h3>
                    </div>

                    <!-- Body / Pesan Konfirmasi -->
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">
                        Apakah kamu yakin ingin menghapus user ini? Seluruh data yang terhubung dengan user ini juga akan <strong class="text-slate-800 font-semibold">dihapus secara permanen</strong>.
                    </p>

                    <!-- Divider Line -->
                    <hr class="border-gray-100 mb-5" />

                    <!-- Footer / Action Buttons -->
                    <div class="flex justify-end items-center space-x-3">
                        <button type="button" 
                                @click="showModal = false" 
                                class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2.5 px-6 rounded-xl text-sm transition-colors duration-150">
                            Batal
                        </button>
                        
                        <form :action="deleteUrl" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-6 rounded-xl text-sm shadow-sm hover:shadow-md transition-all duration-150">
                                Ya, Hapus Sekarang
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>