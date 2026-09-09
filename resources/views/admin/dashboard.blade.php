<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Monitoring Admin') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-6 bg-slate-900 text-white rounded-xl shadow-sm border border-amber-500/20">
                <span class="text-xs font-bold text-amber-400 uppercase tracking-widest block mb-1">Administrator Control Panel</span>
                <h1 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}</h1>
                <p class="text-sm text-slate-300 mt-1">Sistem Manajemen Training & Evaluasi Intern.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-amber-600 uppercase tracking-wider">Total Intern Active</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalInterns }}</h3>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-lg text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-amber-600 uppercase tracking-wider">Total Modul Materi</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalModules }}</h3>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-lg text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-amber-600 uppercase tracking-wider">Total Kuis Diterbitkan</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalQuizzes }}</h3>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-lg text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-gray-800">Aktivitas Pengerjaan Kuis Terbaru</h3>
                    <a href="{{ route('admin.modules.index') }}" class="text-xs text-amber-600 hover:underline font-bold">Kelola Modul &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-900 text-slate-300 font-semibold uppercase">
                            <tr>
                                <th class="p-4">Peserta Intern</th>
                                <th class="p-4">Nama Kuis</th>
                                <th class="p-4">Nilai Skor</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentResults as $res)
                                <tr>
                                    <td class="p-4 font-bold">{{ $res->user->name ?? 'User Unknown' }}</td>
                                    <td class="p-4">{{ $res->quiz->title ?? 'Kuis' }}</td>
                                    <td class="p-4 font-bold">{{ $res->score }}%</td>
                                    <td class="p-4">
                                        <span class="px-2.5 py-1 rounded text-[10px] font-bold tracking-wide {{ $res->passed ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $res->passed ? 'LULUS' : 'GAGAL' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-400">{{ $res->created_at ? $res->created_at->diffForHumans() : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-gray-400">Belum ada riwayat pengerjaan kuis.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>