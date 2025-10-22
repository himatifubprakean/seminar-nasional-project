@extends('layout.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-6">
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold text-indigo-700 mb-6 text-center">📋 Daftar Hadir Peserta</h1>

        {{-- Notifikasi sukses/error --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tabel daftar hadir --}}
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg text-sm text-left">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama Peserta</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Waktu Absen</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($presensi as $index => $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $p->peserta->nama ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $p->peserta->email ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $p->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $p->status == 'hadir' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data presensi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
