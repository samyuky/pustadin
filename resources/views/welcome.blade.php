<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem PUSDATIN - Universitas Garut</title>
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
<body class="bg-light-100 dark:bg-dark-900 text-gray-800 dark:text-gray-200 min-h-screen transition-colors duration-300">
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
                    <a href="#layanan" class="hover:text-primary dark:hover:text-secondary transition-colors">Layanan</a>
                    <a href="#alur" class="hover:text-primary dark:hover:text-secondary transition-colors">Alur Pengajuan</a>
                    <a href="#faq" class="hover:text-primary dark:hover:text-secondary transition-colors">FAQ</a>
                    <a href="#kontak" class="hover:text-primary dark:hover:text-secondary transition-colors">Kontak</a>
                    
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
                <a href="#layanan" class="py-2 hover:text-primary dark:hover:text-secondary">Layanan</a>
                <a href="#alur" class="py-2 hover:text-primary dark:hover:text-secondary">Alur Pengajuan</a>
                <a href="#faq" class="py-2 hover:text-primary dark:hover:text-secondary">FAQ</a>
                <a href="#kontak" class="py-2 hover:text-primary dark:hover:text-secondary">Kontak</a>
            </div>
        </div>
    </header>

    <section class="py-16 md:py-24 bg-gradient-to-br from-primary to-indigo-700 dark:from-dark-800 dark:to-dark-900 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Pusat Data dan Informasi Universitas Garut</h1>
                <p class="text-xl mb-10 opacity-90">Layanan terpadu untuk permintaan data, laporan sistem, dan pengembangan aplikasi SIMAK</p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#layanan" class="px-8 py-3 bg-transparent border-2 border-white font-medium rounded-lg hover:bg-white/10 transition-colors">
                        Lihat Layanan
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Papan Pengumuman untuk User -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white dark:bg-dark-800 rounded-lg shadow-xl p-8 mb-10">
            <h2 class="text-2xl font-bold text-center text-primary dark:text-white mb-6 flex items-center justify-center">
                <i class="fas fa-bullhorn mr-3"></i> Papan Pengumuman
            </h2>
            @if($latestAnnouncements->isEmpty())
                <p class="text-center text-gray-600 dark:text-gray-400">Tidak ada pengumuman terbaru saat ini.</p>
            @else
                <ul class="divide-y divide-gray-200 dark:divide-dark-700">
                    @foreach($latestAnnouncements as $announcement)
                        <li class="py-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $announcement->title }}</h3>
                            <p class="text-gray-700 dark:text-gray-300 mb-2">{{ $announcement->content }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Diterbitkan: {{ $announcement->published_at->format('d M Y H:i') }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <section id="layanan" class="py-16 bg-light-200 dark:bg-dark-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Layanan Kami</h2>
                <p class="max-w-2xl mx-auto text-gray-600 dark:text-gray-400">PUSDATIN menyediakan berbagai layanan untuk mendukung kebutuhan data dan sistem informasi di lingkungan Universitas Garut</p>
            </div>

            <!-- Kontainer untuk layanan -->
            <div class="relative">
                <div id="servicesContainer" class="flex flex-wrap justify-center gap-8 pb-4">
                    <!-- Permintaan Data -->
                    <a href="{{ route('data_requests.create') }}" class="block flex-none w-full sm:w-[calc(50%-16px)] md:w-[calc(33.33%-22px)] lg:w-[calc(20%-26px)] xl:w-[calc(20%-26px)] bg-white dark:bg-dark-700 rounded-xl shadow-lg overflow-hidden transition-transform hover:scale-[1.02] hover:shadow-xl group">
                        <div class="h-2 bg-primary"></div>
                        <div class="p-6">
                            <div class="w-12 h-12 rounded-lg bg-primary/10 text-primary flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                                <i class="fas fa-database text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2 group-hover:text-primary dark:group-hover:text-secondary transition-colors duration-300">Permintaan Data</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Ajukan permintaan data resmi untuk kebutuhan akademik, penelitian, atau administrasi</p>
                            <!-- Tombol dihapus -->
                        </div>
                    </a>

                    <!-- Laporan Error -->
                    <a href="{{ route('error_reports.create') }}" class="block flex-none w-full sm:w-[calc(50%-16px)] md:w-[calc(33.33%-22px)] lg:w-[calc(20%-26px)] xl:w-[calc(20%-26px)] bg-white dark:bg-dark-700 rounded-xl shadow-lg overflow-hidden transition-transform hover:scale-[1.02] hover:shadow-xl group">
                        <div class="h-2 bg-secondary"></div>
                        <div class="p-6">
                            <div class="w-12 h-12 rounded-lg bg-secondary/10 text-secondary flex items-center justify-center mb-4 group-hover:bg-secondary group-hover:text-white transition-colors duration-300">
                                <i class="fas fa-bug text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2 group-hover:text-secondary dark:group-hover:text-secondary transition-colors duration-300">Laporan Error</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Laporkan masalah teknis atau kendala yang Anda temui dalam penggunaan sistem informasi</p>
                            <!-- Tombol dihapus -->
                        </div>
                    </a>

                    <!-- Keluhan -->
                    <a href="{{ route('complaints.create') }}" class="block flex-none w-full sm:w-[calc(50%-16px)] md:w-[calc(33.33%-22px)] lg:w-[calc(20%-26px)] xl:w-[calc(20%-26px)] bg-white dark:bg-dark-700 rounded-xl shadow-lg overflow-hidden transition-transform hover:scale-[1.02] hover:shadow-xl group">
                        <div class="h-2 bg-amber-500"></div>
                        <div class="p-6">
                            <div class="w-12 h-12 rounded-lg bg-amber-500/10 text-amber-500 flex items-center justify-center mb-4 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                                <i class="fas fa-exclamation-triangle text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2 group-hover:text-amber-500 dark:group-hover:text-amber-300 transition-colors duration-300">Ajukan Keluhan</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Berikan masukan, saran, atau keluhan terkait layanan PUSDATIN</p>
                            <!-- Tombol dihapus -->
                        </div>
                    </a>

                    <!-- Permintaan Fitur SIMAK -->
                    <a href="{{ route('simak_feature_requests.create') }}" class="block flex-none w-full sm:w-[calc(50%-16px)] md:w-[calc(33.33%-22px)] lg:w-[calc(20%-26px)] xl:w-[calc(20%-26px)] bg-white dark:bg-dark-700 rounded-xl shadow-lg overflow-hidden transition-transform hover:scale-[1.02] hover:shadow-xl group">
                        <div class="h-2 bg-purple-500"></div>
                        <div class="p-6">
                            <div class="w-12 h-12 rounded-lg bg-purple-500/10 text-purple-500 flex items-center justify-center mb-4 group-hover:bg-purple-500 group-hover:text-white transition-colors duration-300">
                                <i class="fas fa-lightbulb text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2 group-hover:text-purple-500 dark:group-hover:text-purple-300 transition-colors duration-300">Permintaan Fitur SIMAK</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Ajukan permintaan penambahan atau pengubahan fitur pada sistem SIMAK</p>
                            <!-- Tombol dihapus -->
                        </div>
                    </a>

                    <!-- Permintaan Sinkronisasi Feeder -->
                    <a href="{{ route('feeder_sync_requests.create') }}" class="block flex-none w-full sm:w-[calc(50%-16px)] md:w-[calc(33.33%-22px)] lg:w-[calc(20%-26px)] xl:w-[calc(20%-26px)] bg-white dark:bg-dark-700 rounded-xl shadow-lg overflow-hidden transition-transform hover:scale-[1.02] hover:shadow-xl group">
                        <div class="h-2 bg-teal-500"></div>
                        <div class="p-6">
                            <div class="w-12 h-12 rounded-lg bg-teal-500/10 text-teal-500 flex items-center justify-center mb-4 group-hover:bg-teal-500 group-hover:text-white transition-colors duration-300">
                                <i class="fas fa-sync-alt text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2 group-hover:text-teal-500 dark:group-hover:text-teal-300 transition-colors duration-300">Permintaan Sinkronisasi Feeder</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Ajukan permintaan sinkronisasi data dengan sistem feeder eksternal</p>
                            <!-- Tombol dihapus -->
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="alur" class="py-16 bg-white dark:bg-dark-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Alur Pengajuan Layanan</h2>
                <p class="max-w-2xl mx-auto text-gray-600 dark:text-gray-400">Proses sederhana untuk mengajukan permintaan layanan di PUSDATIN</p>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="flex flex-col items-center text-center mb-10 md:mb-0">
                        <div class="w-16 h-16 rounded-full bg-primary text-white flex items-center justify-center text-xl font-bold mb-4">
                            1
                        </div>
                        <h3 class="font-bold text-lg mb-2">Isi Formulir</h3>
                        <p class="text-gray-600 dark:text-gray-400 max-w-xs">Pilih layanan dan isi detail permintaan Anda.</p>
                    </div>

                    <div class="hidden md:block text-gray-300 dark:text-dark-600">
                        <i class="fas fa-arrow-right text-3xl"></i>
                    </div>

                    <div class="flex flex-col items-center text-center mb-10 md:mb-0">
                        <div class="w-16 h-16 rounded-full bg-primary text-white flex items-center justify-center text-xl font-bold mb-4">
                            2
                        </div>
                        <h3 class="font-bold text-lg mb-2">Verifikasi & Proses</h3>
                        <p class="text-gray-600 dark:text-gray-400 max-w-xs">Permintaan Anda akan diverifikasi dan diproses oleh tim PUSDATIN.</p>
                    </div>

                    <div class="hidden md:block text-gray-300 dark:text-dark-600">
                        <i class="fas fa-arrow-right text-3xl"></i>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-primary text-white flex items-center justify-center text-xl font-bold mb-4">
                            3
                        </div>
                        <h3 class="font-bold text-lg mb-2">Notifikasi</h3>
                        <p class="text-gray-600 dark:text-gray-400 max-w-xs">Anda akan menerima notifikasi setelah permintaan selesai.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
            <!-- Section for Data Requests -->
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="bg-white dark:bg-dark-800 rounded-lg shadow-xl p-8 mb-10">
                    <h2 class="text-2xl font-bold text-center text-primary dark:text-white mb-6 flex items-center justify-center">
                        <i class="fas fa-database mr-3"></i> Permintaan Data Terbaru
                    </h2>
                    @if($latestDataRequests->isEmpty())
                        <p class="text-center text-gray-600 dark:text-gray-400">Tidak ada permintaan data terbaru saat ini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                                <thead class="bg-gray-50 dark:bg-dark-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Judul</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Diajukan Pada</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-dark-800 divide-y divide-gray-200 dark:divide-dark-700">
                                    @foreach($latestDataRequests as $request)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                {{ $request->title }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusClass = '';
                                                    switch ($request->status) {
                                                        case 'pending':
                                                            $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100';
                                                            break;
                                                        case 'approved':
                                                            $statusClass = 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100';
                                                            break;
                                                        case 'rejected':
                                                            $statusClass = 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100';
                                                            break;
                                                        case 'completed':
                                                            $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100';
                                                            break;
                                                        default:
                                                            $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';
                                                            break;
                                                    }
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $request->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section for Error Reports -->
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="bg-white dark:bg-dark-800 rounded-lg shadow-xl p-8 mb-10">
                    <h2 class="text-2xl font-bold text-center text-primary dark:text-white mb-6 flex items-center justify-center">
                        <i class="fas fa-bug mr-3"></i> Laporan Error Terbaru
                    </h2>
                    @if($latestErrorReports->isEmpty())
                        <p class="text-center text-gray-600 dark:text-gray-400">Tidak ada laporan error terbaru saat ini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                                <thead class="bg-gray-50 dark:bg-dark-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subjek</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Dilaporkan Pada</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-dark-800 divide-y divide-gray-200 dark:divide-dark-700">
                                    @foreach($latestErrorReports as $report)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                {{ $report->title }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusClass = '';
                                                    switch ($report->status) {
                                                        case 'new':
                                                            $statusClass = 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100';
                                                            break;
                                                        case 'investigating':
                                                            $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100';
                                                            break;
                                                        case 'resolved':
                                                            $statusClass = 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100';
                                                            break;
                                                        default:
                                                            $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';
                                                            break;
                                                    }
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $report->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section for Complaints -->
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="bg-white dark:bg-dark-800 rounded-lg shadow-xl p-8 mb-10">
                    <h2 class="text-2xl font-bold text-center text-primary dark:text-white mb-6 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle mr-3"></i> Keluhan Terbaru
                    </h2>
                    @if($latestComplaints->isEmpty())
                        <p class="text-center text-gray-600 dark:text-gray-400">Tidak ada keluhan terbaru saat ini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                                <thead class="bg-gray-50 dark:bg-dark-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subjek</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pelapor</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Diajukan Pada</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-dark-800 divide-y divide-gray-200 dark:divide-dark-700">
                                    @foreach($latestComplaints as $complaint)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $complaint->subject }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $complaint->complainant_name ?? 'Anonim' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusClass = '';
                                                    switch ($complaint->status) {
                                                        case 'pending':
                                                            $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100';
                                                            break;
                                                        case 'approved':
                                                            $statusClass = 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100';
                                                            break;
                                                        case 'rejected':
                                                            $statusClass = 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100';
                                                            break;
                                                        case 'completed':
                                                            $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100';
                                                            break;
                                                        default:
                                                            $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';
                                                            break;
                                                    }
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $complaint->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section for SIMAK Feature Requests -->
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="bg-white dark:bg-dark-800 rounded-lg shadow-xl p-8 mb-10">
                    <h2 class="text-2xl font-bold text-center text-primary dark:text-white mb-6 flex items-center justify-center">
                        <i class="fas fa-lightbulb mr-3"></i> Permintaan Fitur SIMAK Terbaru
                    </h2>
                    @if($latestSimakFeatureRequests->isEmpty())
                        <p class="text-center text-gray-600 dark:text-gray-400">Tidak ada permintaan fitur SIMAK terbaru saat ini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                                <thead class="bg-gray-50 dark:bg-dark-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subjek</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Diajukan Pada</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-dark-800 divide-y divide-gray-200 dark:divide-dark-700">
                                    @foreach($latestSimakFeatureRequests as $request)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $request->subject }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusClass = '';
                                                    switch ($request->status) {
                                                        case 'new':
                                                            $statusClass = 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100';
                                                            break;
                                                        case 'in_progress':
                                                            $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100';
                                                            break;
                                                        case 'completed':
                                                            $statusClass = 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100';
                                                            break;
                                                        default:
                                                            $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';
                                                            break;
                                                    }
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $request->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section for Feeder Sync Requests -->
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="bg-white dark:bg-dark-800 rounded-lg shadow-xl p-8 mb-10">
                    <h2 class="text-2xl font-bold text-center text-primary dark:text-white mb-6 flex items-center justify-center">
                        <i class="fas fa-sync-alt mr-3"></i> Permintaan Sinkronisasi Feeder Terbaru
                    </h2>
                    @if($latestFeederSyncRequests->isEmpty())
                        <p class="text-center text-gray-600 dark:text-gray-400">Tidak ada permintaan sinkronisasi feeder terbaru saat ini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                                <thead class="bg-gray-50 dark:bg-dark-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subjek</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Diajukan Pada</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-dark-800 divide-y divide-gray-200 dark:divide-dark-700">
                                    @foreach($latestFeederSyncRequests as $request)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $request->subject }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusClass = '';
                                                    switch ($request->status) {
                                                        case 'pending':
                                                            $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100';
                                                            break;
                                                        case 'processing':
                                                            $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100';
                                                            break;
                                                        case 'completed':
                                                            $statusClass = 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100';
                                                            break;
                                                        case 'failed':
                                                            $statusClass = 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100';
                                                            break;
                                                        default:
                                                            $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';
                                                            break;
                                                    }
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $request->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

<!-- FAQ Section -->
    <section id="faq" class="py-16 bg-light-200 dark:bg-dark-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Pertanyaan Umum</h2>
                <p class="max-w-2xl mx-auto text-gray-600 dark:text-gray-400">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
            </div>

            <div class="max-w-3xl mx-auto">
                <div class="space-y-4">
                    <div class="bg-white dark:bg-dark-700 rounded-lg shadow-md overflow-hidden">
                        <button class="faq-question w-full flex justify-between items-center p-6 text-left">
                            <span class="font-medium">Bagaimana cara mengajukan permintaan data?</span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </button>
                        <div class="faq-answer px-6 pb-6 hidden">
                            <p class="text-gray-600 dark:text-gray-400">
                                Anda dapat mengajukan permintaan data melalui formulir "Permintaan Data" yang tersedia di halaman layanan kami.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-dark-700 rounded-lg shadow-md overflow-hidden">
                        <button class="faq-question w-full flex justify-between items-center p-6 text-left">
                            <span class="font-medium">Berapa lama waktu yang dibutuhkan untuk memproses permintaan?</span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </button>
                        <div class="faq-answer px-6 pb-6 hidden">
                            <p class="text-gray-600 dark:text-gray-400">
                                Waktu pemrosesan bervariasi tergantung jenis permintaan. Anda akan menerima notifikasi setelah permintaan Anda selesai.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-dark-700 rounded-lg shadow-md overflow-hidden">
                        <button class="faq-question w-full flex justify-between items-center p-6 text-left">
                            <span class="font-medium">Apakah saya akan mendapatkan notifikasi tentang status permintaan saya?</span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </button>
                        <div class="faq-answer px-6 pb-6 hidden">
                            <p class="text-gray-600 dark:text-gray-400">
                                Ya, Anda akan menerima notifikasi melalui email mengenai setiap pembaruan status permintaan Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-primary dark:bg-dark-800 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6">Siap Mengajukan Permintaan?</h2>
            <p class="max-w-2xl mx-auto mb-10 opacity-90">Mulai ajukan permintaan Anda sekarang dan dapatkan dukungan dari PUSDATIN</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#layanan" class="px-8 py-3 bg-transparent border-2 border-white font-medium rounded-lg hover:bg-white/10 transition-colors">
                    Ajukan Permintaan
                </a>
            </div>
        </div>
    </section>

    <footer id="kontak" class="bg-dark-900 text-white py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                            <img src="https://images.seeklogo.com/logo-png/33/2/universitas-garut-logo-png_seeklogo-339889.png" alt="Logo PUSDATIN UNIGA" class="h-10">
                        </div>
                        <span class="text-xl font-bold text-white">PUSDATIN<span class="text-secondary">UNIGA</span></span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Pusat Data dan Informasi Universitas Garut
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/pusdatinkemdikdasmen/" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/pusdatin_kemendikdasmen/?hl=en" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@Pusdatin.Kemendikdasmen" class="text-gray-400 hover:text-white">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak Kami</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-gray-400"></i>
                            <span class="text-gray-400">Jl. Hampor</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-gray-400"></i>
                            <span class="text-gray-400">(0341) 1234567</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-gray-400"></i>
                            <span class="text-gray-400">pusdatin@uniga.ac.id</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Jam Operasional</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex justify-between">
                            <span>Senin - Kamis</span>
                            <span>08:00 - 16:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Jumat</span>
                            <span>08:00 - 16:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Sabtu - Minggu</span>
                            <span>Tutup</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Tautan Cepat</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white">Portal Mahasiswa</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Portal Dosen</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Website Universitas</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">SIM Akademik</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-dark-700 mt-12 pt-8 text-center text-gray-500">
                <p>&copy; 2023 PUSDATIN Universitas Garut. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Dark mode toggle
        document.getElementById('theme-toggle').addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        });

        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // FAQ accordion
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', () => {
                const answer = button.nextElementSibling;
                const icon = button.querySelector('i');
                
                // Toggle answer visibility
                answer.classList.toggle('hidden');
                
                // Toggle icon
                if (answer.classList.contains('hidden')) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                } else {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            });
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
