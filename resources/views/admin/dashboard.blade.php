<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PUSDATIN UNIGA</title>
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
        /* Custom scrollbar for better aesthetics if needed */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .dark ::-webkit-scrollbar-track {
            background: #2d2d2d;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #555;
        }
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #777;
        }
    </style>
</head>
<body class="bg-light-100 dark:bg-dark-900 text-gray-800 dark:text-gray-200 min-h-screen transition-colors duration-300 flex flex-col">
    <!-- Header Section -->
    <header class="sticky top-0 z-50 bg-white/90 dark:bg-dark-800/90 backdrop-blur-sm border-b border-gray-200 dark:border-dark-600">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                        <img src="https://images.seeklogo.com/logo-png/33/2/universitas-garut-logo-png_seeklogo-339889.png" alt="Logo PUSDATIN UNIGA" class="h-10">
                    </div>
                    <span class="text-xl font-bold text-primary dark:text-white">PUSDATIN<span class="text-secondary">UNIGA</span></span>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary dark:hover:text-secondary transition-colors">Dashboard</a>
                    
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">Logout</button>
                    </form>
                    
                    <div class="flex items-center space-x-3">
                        <button id="theme-toggle" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-dark-700">
                            <i class="fas fa-moon dark:hidden"></i>
                            <i class="fas fa-sun hidden dark:block"></i>
                        </button>
                    </div>
                </div>

                <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-gray-700 dark:text-gray-300">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </nav>
        </div>

        <div id="mobile-menu" class="md:hidden hidden px-4 pb-4 bg-white dark:bg-dark-800 border-t border-gray-200 dark:border-dark-600">
            <div class="flex flex-col space-y-3 pt-3">
                <a href="{{ route('admin.dashboard') }}" class="py-2 hover:text-primary dark:hover:text-secondary">Dashboard</a>
                <a href="{{ route('admin.announcements.index') }}" class="py-2 hover:text-primary dark:hover:text-secondary">Pengumuman</a>
                <a href="{{ route('admin.data-requests.index') }}" class="py-2 hover:text-primary dark:hover:text-secondary">Permintaan Data</a>
                <a href="{{ route('admin.error-reports.index') }}" class="py-2 hover:text-primary dark:hover:text-secondary">Laporan Error</a>
                <a href="{{ route('admin.complaints.index') }}" class="py-2 hover:text-primary dark:hover:text-secondary">Keluhan</a>
                <a href="{{ route('admin.simak-feature-requests.index') }}" class="py-2 hover:text-primary dark:hover:text-secondary">Fitur SIMAK</a>
                <a href="{{ route('admin.feeder-sync-requests.index') }}" class="py-2 hover:text-primary dark:hover:text-secondary">Sinkronisasi Feeder</a>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 hover:text-primary dark:hover:text-secondary">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card for Data Requests -->
            <a href="{{ route('admin.data-requests.index') }}" class="block bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 transition-transform hover:scale-[1.02] hover:shadow-xl group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-primary dark:text-white group-hover:text-indigo-600 dark:group-hover:text-secondary transition-colors">Permintaan Data</h2>
                    <i class="fas fa-database text-3xl text-primary/70 dark:text-white/70 group-hover:text-primary dark:group-hover:text-secondary transition-colors"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Lihat dan kelola semua permintaan data.</p>
            </a>

            <!-- Card for Error Reports -->
            <a href="{{ route('admin.error-reports.index') }}" class="block bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 transition-transform hover:scale-[1.02] hover:shadow-xl group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-secondary dark:text-white group-hover:text-green-600 dark:group-hover:text-primary transition-colors">Laporan Error</h2>
                    <i class="fas fa-bug text-3xl text-secondary/70 dark:text-white/70 group-hover:text-secondary dark:group-hover:text-primary transition-colors"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Tinjau dan tangani laporan bug sistem.</p>
            </a>

            <!-- Card for Complaints -->
            <a href="{{ route('admin.complaints.index') }}" class="block bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 transition-transform hover:scale-[1.02] hover:shadow-xl group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-amber-500 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-300 transition-colors">Keluhan</h2>
                    <i class="fas fa-exclamation-triangle text-3xl text-amber-500/70 dark:text-white/70 group-hover:text-amber-500 dark:group-hover:text-amber-300 transition-colors"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Kelola keluhan dan masukan pengguna.</p>
            </a>

            <!-- Card for SIMAK Feature Requests -->
            <a href="{{ route('admin.simak-feature-requests.index') }}" class="block bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 transition-transform hover:scale-[1.02] hover:shadow-xl group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-purple-500 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-300 transition-colors">Permintaan Fitur SIMAK</h2>
                    <i class="fas fa-lightbulb text-3xl text-purple-500/70 dark:text-white/70 group-hover:text-purple-500 dark:group-hover:text-purple-300 transition-colors"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Tinjau dan proses permintaan fitur baru untuk SIMAK.</p>
            </a>

            <!-- Card for Feeder Sync Requests -->
            <a href="{{ route('admin.feeder-sync-requests.index') }}" class="block bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 transition-transform hover:scale-[1.02] hover:shadow-xl group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-teal-500 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-300 transition-colors">Permintaan Sinkronisasi Feeder</h2>
                    <i class="fas fa-sync-alt text-3xl text-teal-500/70 dark:text-white/70 group-hover:text-teal-500 dark:group-hover:text-teal-300 transition-colors"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Kelola permintaan sinkronisasi data feeder.</p>
            </a>

            <!-- Card for Announcements -->
            <a href="{{ route('admin.announcements.index') }}" class="block bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 transition-transform hover:scale-[1.02] hover:shadow-xl group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-blue-500 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-300 transition-colors">Pengumuman</h2>
                    <i class="fas fa-bullhorn text-3xl text-blue-500/70 dark:text-white/70 group-hover:text-blue-500 dark:group-hover:text-blue-300 transition-colors"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Buat dan kelola pengumuman papan buletin.</p>
            </a>
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="bg-dark-900 text-white py-8 px-6 mt-auto">
        <div class="container mx-auto text-center text-sm text-gray-400">
            &copy; 2023 PUSDATIN Universitas Garut. Hak Cipta Dilindungi.
        </div>
    </footer>

    <script>
        // Theme toggle functionality
        document.getElementById('theme-toggle').addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        });

        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Apply initial theme when the page loads
        if (localStorage.getItem('theme') === 'dark' || 
            (!localStorage.getItem('theme') && 
            window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>
