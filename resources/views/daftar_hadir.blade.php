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

        <livewire:table-kehadiran/>
    </div>
</div>
@endsection
