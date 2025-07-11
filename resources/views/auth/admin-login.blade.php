@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6">Login Admin PUSDATIN</h1>
        
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="email">Email Admin</label>
                <input type="email" name="email" required 
                       class="w-full px-3 py-2 border rounded-lg">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 mb-2" for="password">Password</label>
                <input type="password" name="password" required 
                       class="w-full px-3 py-2 border rounded-lg">
            </div>
            
            <button type="submit" 
                    class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-primary-dark transition">
                Masuk
            </button>
        </form>
    </div>
</div>
@endsection