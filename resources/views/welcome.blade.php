<!-- resources/views/welcome.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-1/2 lg:w-1/3">
            <h1 class="text-2xl font-bold mb-6">Selamat Datang di Sistem Penerimaan Barang</h1>
            <a href="{{ route('penerimaan') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                ke Menu Penerimaan Barang
            </a>
        </div>
    </div>
</div>
@endsection
