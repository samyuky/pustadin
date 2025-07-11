<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengumuman - Admin PUSDATIN</title>
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

    <!-- Main Content Section - Daftar Pengumuman -->
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Kelola Pengumuman</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex justify-end mb-6">
            <a href="{{ route('admin.announcements.create') }}" class="px-6 py-2 bg-primary text-white rounded-md font-semibold hover:bg-indigo-600 transition-colors">
                <i class="fas fa-plus mr-2"></i> Tambah Pengumuman Baru
            </a>
        </div>

        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 overflow-x-auto mb-10">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Daftar Pengumuman</h2>
            @if($announcements->isEmpty())
                <p class="text-center text-gray-600 dark:text-gray-400">Belum ada pengumuman.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                    <thead class="bg-gray-50 dark:bg-dark-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Judul</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Konten Singkat</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Diterbitkan Pada</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-dark-800 divide-y divide-gray-200 dark:divide-dark-700">
                        @foreach ($announcements as $announcement)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $announcement->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $announcement->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($announcement->content, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $announcement->published_at ? $announcement->published_at->format('d M Y H:i') : 'Draft' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center space-x-2">
                                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="text-primary hover:text-indigo-900 dark:text-blue-400 dark:hover:text-blue-600">Edit</a>
                                    <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600 ml-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $announcements->links() }}
                </div>
            @endif
        </div>

        {{-- Bagian baru untuk Permintaan Data --}}
        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 overflow-x-auto mb-10">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Daftar Permintaan Data</h2>
            @if($dataRequests->isEmpty())
                <p class="text-center text-gray-600 dark:text-gray-400">Belum ada permintaan data.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                    <thead class="bg-gray-50 dark:bg-dark-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subjek</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Diajukan Pada</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-dark-800 divide-y divide-gray-200 dark:divide-dark-700">
                        @foreach ($dataRequests as $dataRequest)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $dataRequest->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $dataRequest->subject }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = '';
                                        switch ($dataRequest->status) {
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
                                        {{ ucfirst(str_replace('_', ' ', $dataRequest->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $dataRequest->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.data-requests.show', $dataRequest->id) }}" class="text-primary hover:text-indigo-600 dark:text-secondary dark:hover:text-green-400">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $dataRequests->links('pagination::tailwind', ['pageName' => 'dataRequestPage']) }}
                </div>
            @endif
        </div>

        {{-- Bagian baru untuk Laporan Error --}}
        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 overflow-x-auto mb-10">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Daftar Laporan Error</h2>
            @if($errorReports->isEmpty())
                <p class="text-center text-gray-600 dark:text-gray-400">Belum ada laporan error.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                    <thead class="bg-gray-50 dark:bg-dark-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subjek</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Dilaporkan Pada</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-dark-800 divide-y divide-gray-200 dark:divide-dark-700">
                        @foreach ($errorReports as $errorReport)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $errorReport->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $errorReport->subject }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = '';
                                        switch ($errorReport->status) {
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
                                        {{ ucfirst(str_replace('_', ' ', $errorReport->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $errorReport->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.error-reports.show', $errorReport->id) }}" class="text-primary hover:text-indigo-600 dark:text-secondary dark:hover:text-green-400">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $errorReports->links('pagination::tailwind', ['pageName' => 'errorReportPage']) }}
                </div>
            @endif
        </div>

        {{-- Bagian baru untuk Keluhan --}}
        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 overflow-x-auto mb-10">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Daftar Keluhan yang Telah Ditanggapi</h2>
            @if($complaints->isEmpty())
                <p class="text-center text-gray-600 dark:text-gray-400">Tidak ada keluhan yang telah ditanggapi.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                    <thead class="bg-gray-50 dark:bg-dark-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID Keluhan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subjek</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pelapor</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Terakhir Diperbarui</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-dark-800 divide-y divide-gray-200 dark:divide-dark-700">
                        @foreach ($complaints as $complaint)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $complaint->id }}</td>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $complaint->updated_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="text-primary hover:text-indigo-600 dark:text-secondary dark:hover:text-green-400">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $complaints->links('pagination::tailwind', ['pageName' => 'complaintPage']) }}
                </div>
            @endif
        </div>

        {{-- Bagian baru untuk Permintaan Fitur SIMAK --}}
        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 overflow-x-auto mb-10">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Daftar Permintaan Fitur SIMAK</h2>
            @if($simakFeatureRequests->isEmpty())
                <p class="text-center text-gray-600 dark:text-gray-400">Belum ada permintaan fitur SIMAK.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                    <thead class="bg-gray-50 dark:bg-dark-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subjek</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Diajukan Pada</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-dark-800 divide-y divide-gray-200 dark:divide-dark-700">
                        @foreach ($simakFeatureRequests as $simakFeatureRequest)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $simakFeatureRequest->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $simakFeatureRequest->subject }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = '';
                                        switch ($simakFeatureRequest->status) {
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
                                        {{ ucfirst(str_replace('_', ' ', $simakFeatureRequest->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $simakFeatureRequest->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.simak-feature-requests.show', $simakFeatureRequest->id) }}" class="text-primary hover:text-indigo-600 dark:text-secondary dark:hover:text-green-400">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $simakFeatureRequests->links('pagination::tailwind', ['pageName' => 'simakFeaturePage']) }}
                </div>
            @endif
        </div>

        {{-- Bagian baru untuk Permintaan Sinkronisasi Feeder --}}
        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 overflow-x-auto mb-10">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Daftar Permintaan Sinkronisasi Feeder</h2>
            @if($feederSyncRequests->isEmpty())
                <p class="text-center text-gray-600 dark:text-gray-400">Belum ada permintaan sinkronisasi feeder.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                    <thead class="bg-gray-50 dark:bg-dark-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subjek</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Diajukan Pada</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-dark-800 divide-y divide-gray-200 dark:divide-dark-700">
                        @foreach ($feederSyncRequests as $feederSyncRequest)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $feederSyncRequest->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $feederSyncRequest->subject }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = '';
                                        switch ($feederSyncRequest->status) {
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
                                        {{ ucfirst(str_replace('_', ' ', $feederSyncRequest->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $feederSyncRequest->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.feeder-sync-requests.show', $feederSyncRequest->id) }}" class="text-primary hover:text-indigo-600 dark:text-secondary dark:hover:text-green-400">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $feederSyncRequests->links('pagination::tailwind', ['pageName' => 'feederSyncPage']) }}
                </div>
            @endif
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
