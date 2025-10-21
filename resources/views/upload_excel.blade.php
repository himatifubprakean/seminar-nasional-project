@extends('layout.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gray-50 px-6">
    <div class="bg-white shadow-xl rounded-2xl p-10 w-full max-w-xl text-center">
        <h1 class="text-3xl font-bold mb-6 text-indigo-700 flex items-center justify-center gap-2">
            📤 Upload File Excel
        </h1>

        <p class="text-gray-600 mb-8 text-sm">
            Silakan pilih file Excel dengan format <span class="font-medium text-gray-800">.xlsx, .xls, atau .csv</span> untuk diunggah ke sistem.
        </p>

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-left">
                <p class="font-medium">{{ session('success') }}</p>
                <p class="text-sm mt-1 text-gray-500">Path: {{ session('file_path') }}</p>
            </div>
        @endif

        {{-- Form Upload --}}
<form action="{{ route('upload.excel.post') }}" method="POST" enctype="multipart/form-data"
      class="space-y-6">

            @csrf
            <div class="flex flex-col items-center justify-center space-y-3">
                <label class="block text-gray-700 font-medium">Pilih File Excel</label>

                <input type="file" name="excel_file"
                    class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                    required>

                @error('excel_file')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

                <button type="submit"
                    class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-black font-semibold py-2.5 px-4 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                    🚀 Upload Sekarang
                </button>
            </div>
        </form>

        {{-- Preview Data --}}
        @if (session('preview_data'))
            <div class="mt-10 text-left">
                <h2 class="text-lg font-semibold mb-3 text-gray-700">📋 Data (5 baris pertama)</h2>
                <div class="overflow-x-auto border rounded-lg shadow-sm">
                    <table class="min-w-full text-sm text-left border-collapse">
                        @foreach (session('preview_data') as $row)
                            <tr class="border-b hover:bg-gray-50 transition">
                                @foreach ($row as $cell)
                                    <td class="px-3 py-2">{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
