<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Admin - PUSDATIN UNIGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        secondary: '#10b981',
                        dark: {
                            900: '#121212',
                            800: '#1e1e1e',
                            700: '#2d2d2d',
                            600: '#3e3e3a',
                        },
                        light: {
                            100: '#f8fafc',
                            200: '#f1f5f9',
                            300: '#e2e8f0',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            scrollbar-width: thin;
            scrollbar-color: #2563eb #121212;
        }
        body::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        body::-webkit-scrollbar-track {
            background: #121212;
        }
        body::-webkit-scrollbar-thumb {
            background-color: #2563eb;
            border-radius: 10px;
            border: 2px solid #1e1e1e;
        }
    </style>
</head>
<body class="bg-light-100 dark:bg-dark-900 text-gray-800 dark:text-gray-200 min-h-screen flex items-center justify-center transition-colors duration-300">
    <div class="w-full max-w-md bg-white dark:bg-dark-800 rounded-lg shadow-xl p-8 transition-transform transform hover:scale-[1.01]">
        <div class="flex flex-col items-center mb-8">
            <div class="bg-primary w-14 h-14 rounded-full flex items-center justify-center mb-4 shadow-md">
                <i class="fas fa-key text-white text-2xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-primary dark:text-white">Atur Ulang Password</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-2 text-center">
                Masukkan password baru Anda di bawah ini.
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}"> {{-- Ini adalah route Laravel default --}}
            @csrf

            {{-- Password Reset Token --}}
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                       class="w-full px-4 py-2 rounded-md bg-gray-50 dark:bg-dark-700 border border-gray-300 dark:border-dark-600 focus:ring-primary focus:border-primary transition duration-200 text-gray-800 dark:text-gray-200 @error('email') border-red-500 @enderror">
                @error('email')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-5">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password Baru</label>
                <input type="password" id="password" name="password" required autocomplete="new-password"
                       class="w-full px-4 py-2 rounded-md bg-gray-50 dark:bg-dark-700 border border-gray-300 dark:border-dark-600 focus:ring-primary focus:border-primary transition duration-200 text-gray-800 dark:text-gray-200 @error('password') border-red-500 @enderror">
                @error('password')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                       class="w-full px-4 py-2 rounded-md bg-gray-50 dark:bg-dark-700 border border-gray-300 dark:border-dark-600 focus:ring-primary focus:border-primary transition duration-200 text-gray-800 dark:text-gray-200 @error('password_confirmation') border-red-500 @enderror">
                @error('password_confirmation')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-primary text-white py-2.5 rounded-md font-semibold text-lg hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-dark-800 transition duration-300 transform hover:-translate-y-0.5">
                Atur Ulang Password
            </button>
        </form>
    </div>

    <script>
        // Set initial theme (relevant if accessed directly)
        if (localStorage.getItem('theme') === 'dark' || 
            (!localStorage.getItem('theme') && 
            window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>