@extends('layout.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gray-50 px-6 py-12">
    <div class="bg-white shadow-xl rounded-2xl p-10 w-full max-w-3xl border border-gray-100">

        {{-- Judul --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-700 mb-2 flex items-center justify-center gap-2">
                📤 Upload File Excel
            </h1>
            <p class="text-gray-600 text-sm leading-relaxed">
                Silakan unggah file Excel dengan format 
                <span class="font-medium text-gray-800">.xlsx, .xls, atau .csv</span> 
                untuk dimasukkan ke dalam sistem.
            </p>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                <p class="font-semibold">✅ {{ session('success') }}</p>
                <p class="text-sm mt-1 text-gray-600"></p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <p class="font-semibold">❌ {{ session('error') }}</p>
            </div>
        @endif

        {{-- Form Upload --}}
        <form action="{{ route('upload.excel.submit') }}" method="POST" enctype="multipart/form-data" class=" flex justify-center mb-8"  >
            @csrf
            <div class="w-full max-w-md text-center" >
                <label for="excel_file" class="block text-gray-700 font-medium text-left mb-2">
                    Pilih File Excel:
                </label>
                <input 
                    id="excel_file"
                    type="file" 
                    name="excel_file"
                    class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                    required
                >
                @error('excel_file')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                {{-- Tombol Upload --}}
                <button 
                    type="submit"
                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-black font-semibold py-2.5 rounded-lg shadow-md transition duration-200 text-center"
                >
                    🚀 Upload Sekarang
                </button>
            </div>

        </form>

        <br>

    
        
        <div class="d-flex justify-content-evenly ">
            {{-- Tombol Aksi (dalam satu baris) --}}
                
                
                {{-- Tombol Kirim QR --}}
                <form   action="{{ route('send.qrcode.email') }}" method="POST" >
                    @csrf
                    <button 
                        type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-black font-semibold py-2.5 rounded-lg shadow-md transition duration-200"
                    >
                        📧 Kirim QR Code ke Email Peserta
                    </button>
                </form>
        
                {{-- Tombol Hapus Semua Peserta --}}
                <a 
                    href="{{ route('delete-all-participants.delete') }}" 
                    onclick="return confirm('Apakah kamu yakin ingin menghapus semua peserta? Tindakan ini tidak dapat dibatalkan!')"
                    class="flex-1 bg-blue-600 text-decoration-none hover:bg-red-700 text-black font-semibold py-2.5 rounded-lg shadow-md transition duration-200 text-center "
                >
                    🗑️ Hapus Semua Peserta
                </a>
         
        </div>
    </div>

    
    
    
</div>





@endsection
