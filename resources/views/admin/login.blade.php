<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - PUSDATIN UNIGA</title>
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
        /* Optional: Custom scrollbar for better aesthetics in dark mode */
        body {
            scrollbar-width: thin;
            scrollbar-color: #2563eb #121212; /* thumb color track color */
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
                <i class="fas fa-lock text-white text-2xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-primary dark:text-white">Login Admin</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Masuk untuk mengelola sistem PUSDATIN</p>
        </div>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800 p-3 rounded-md">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}"> {{-- Sesuaikan route ini --}}
            @csrf

            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-2 rounded-md bg-gray-50 dark:bg-dark-700 border border-gray-300 dark:border-dark-600 focus:ring-primary focus:border-primary transition duration-200 text-gray-800 dark:text-gray-200 @error('email') border-red-500 @enderror">
                @error('email')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                <input type="password" id="password" name="password" required autocomplete="current-password"
                       class="w-full px-4 py-2 rounded-md bg-gray-50 dark:bg-dark-700 border border-gray-300 dark:border-dark-600 focus:ring-primary focus:border-primary transition duration-200 text-gray-800 dark:text-gray-200 @error('password') border-red-500 @enderror">
                @error('password')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember_me" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary dark:border-dark-600 dark:bg-dark-700 dark:checked:bg-primary">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Ingat Saya</label>
                </div>

                {{-- Link to forgot password, if you want to implement it --}}
                @if (Route::has('password.request'))
                    <a class="text-sm text-primary hover:text-secondary dark:text-secondary dark:hover:text-primary transition-colors" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <button type="submit"
                    class="w-full bg-primary text-white py-2.5 rounded-md font-semibold text-lg hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-dark-800 transition duration-300 transform hover:-translate-y-0.5">
                Login
            </button>

            <div class="mt-6 text-center text-gray-600 dark:text-gray-400 text-sm">
                Kembali ke <a href="{{ url('/') }}" class="text-primary hover:text-secondary dark:text-secondary dark:hover:text-primary transition-colors font-medium">Halaman Utama</a>
            </div>
        </form>
    </div>

    <script>
        // Dark mode toggle (optional, for demo purposes if this page is standalone)
        document.getElementById('theme-toggle')?.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        });

        // Set initial theme
        if (localStorage.getItem('theme') === 'dark' || 
            (!localStorage.getItem('theme') && 
            window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>