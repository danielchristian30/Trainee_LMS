<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Modul Pelatihan') }}
            </h2>
            <a href="{{ route('admin.modules.create') }}" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-lg text-xs transition">
                + Tambah Modul Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ showDeleteModal: false, deleteUrl: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-xs font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-900 text-slate-300 font-semibold uppercase">
                            <tr>
                                <th class="p-4">Urutan</th>
                                <th class="p-4">Modul</th>
                                <th class="p-4">Passing Score</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Soal Kuis</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($modules as $module)
                                @php $quiz = $module->quizzes->first(); @endphp
                                <tr>
                                    <td class="p-4 font-bold text-gray-500">#{{ $module->order }}</td>
                                    <td class="p-4">
                                        <p class="font-bold text-gray-800 text-sm">{{ $module->title }}</p>
                                        <p class="text-gray-400 text-[11px] mt-0.5">{{ Str::limit($module->description, 50) }}</p>
                                    </td>
                                    <td class="p-4 font-bold text-amber-600">{{ $quiz ? $quiz->passing_score : 0 }}%</td>
                                    <td class="p-4">
                                        <span class="px-2.5 py-1 rounded text-[10px] font-bold tracking-wide {{ $module->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $module->is_published ? 'PUBLISHED' : 'DRAFT' }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        @if($quiz)
                                            <a href="{{ route('admin.quizzes.questions.index', $quiz->id) }}" class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold px-3 py-1.5 rounded text-[11px] transition">
                                                <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                Kelola Soal ({{ $quiz->questions->count() ?? 0 }})
                                            </a>
                                        @else
                                            <span class="text-gray-400">Belum ada kuis</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center space-x-2">
                                        <a href="{{ route('admin.modules.edit', $module->id) }}" class="text-blue-600 hover:underline font-bold">Edit</a>
                                        
                                        <button type="button" 
                                                @click="showDeleteModal = true; deleteUrl = '{{ route('admin.modules.destroy', $module->id) }}'"
                                                class="text-red-600 hover:underline font-bold">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400">Belum ada modul yang dibuat. Klik tombol "+ Tambah Modul Baru" di atas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div x-show="showDeleteModal" 
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
            
            <div @click.away="showDeleteModal = false" 
                 class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4 border border-slate-100">
                
                <div class="flex items-center gap-3 text-red-600">
                    <div class="p-2 bg-red-100 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Konfirmasi Hapus Modul</h3>
                </div>

                <p class="text-xs text-slate-600 leading-relaxed">
                    Apakah kamu yakin ingin menghapus modul ini? Seluruh kuis dan soal yang terhubung dengan modul ini juga akan <strong>dihapus secara permanen</strong>.
                </p>

                <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                    <button type="button" 
                            @click="showDeleteModal = false" 
                            class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-200 transition">
                        Batal
                    </button>

                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white text-xs font-bold rounded-xl hover:bg-red-700 transition shadow-sm">
                            Ya, Hapus Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>