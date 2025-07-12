<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Permintaan Sinkronisasi Feeder - Admin PUSDATIN</title>
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
        /* Custom scrollbar for better aesthetics */
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
                <a href="{{ route('admin.data-requests.index') }}" class="py-2 hover:text-primary dark:hover:text-secondary">Permintaan Data</a>
                <a href="{{ route('admin.announcements.index') }}" class="py-2 hover:text-primary dark:hover:text-secondary">Pengumuman</a>
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

    <!-- Main Content Area Wrapper -->
    <div id="content-area" class="flex-grow p-4 transition-all duration-300">
        <!-- Main Header (adapts for mobile/desktop) -->
        <header class="flex justify-between items-center py-4 px-4 bg-white dark:bg-dark-800 rounded-lg shadow-md mb-6">
            <div class="flex items-center space-x-4">
                <!-- Mobile sidebar toggle -->
                <button id="mobile-sidebar-open-button" class="md:hidden p-2 rounded-md text-gray-700 dark:text-gray-300">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <!-- Desktop sidebar toggle -->
                <button id="desktop-sidebar-toggle" class="hidden md:block p-2 rounded-md text-gray-700 dark:text-gray-300">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Riwayat Layanan</h1>
            </div>
        </header>

        <!-- Main Content for Service History -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 hidden md:block">Detail Riwayat Layanan</h1>

        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0 md:space-x-4">
                <input type="text" placeholder="Cari layanan..." class="w-full md:w-1/3 px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200">
                <select class="w-full md:w-1/4 px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200">
                    <option value="">Filter Status</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">Dalam Proses</option>
                    <option value="completed">Selesai</option>
                    <option value="rejected">Ditolak</option>
                </select>
                <button class="w-full md:w-auto px-6 py-2 bg-primary text-white rounded-md font-semibold hover:bg-indigo-600 transition-colors">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
            </div>
        </div>

        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-primary dark:text-white mb-6">Daftar Lengkap Riwayat Layanan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-600">
                    <thead class="bg-gray-50 dark:bg-dark-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tl-lg">
                                ID Layanan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Jenis Layanan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Deskripsi
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Pelapor
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tanggal Dibuat
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tanggal Selesai
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tr-lg">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody id="service-history-table-body" class="bg-white dark:bg-dark-800 divide-y divide-gray-200 dark:divide-dark-600">
                        <!-- Data will be loaded here from a MySQL-backed API -->
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Memuat riwayat layanan dari database...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Controls (dummy) -->
            <nav class="flex items-center justify-between pt-4" aria-label="Pagination">
                <div class="hidden sm:block">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan
                        <span class="font-medium">1</span> sampai
                        <span class="font-medium">10</span> dari
                        <span class="font-medium">Total 50</span> hasil
                    </p>
                </div>
                <div class="flex-1 flex justify-between sm:justify-end">
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-dark-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-dark-700 hover:bg-gray-50 dark:hover:bg-dark-600">
                        Previous
                    </a>
                    <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-dark-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-dark-700 hover:bg-gray-50 dark:hover:bg-dark-600">
                        Next
                    </a>
                </div>
            </nav>
        </div>

        <!-- Back to Dashboard Button -->
        <div class="mt-8 text-center">
            <a href="/admin/dashboard" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-secondary hover:bg-emerald-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

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
