<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Permintaan Data - Admin PUSDATIN</title>
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
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 hover:text-primary dark:hover:text-secondary">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Detail Permintaan Data</h1>

        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ID Permintaan:</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $dataRequest->id }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Pemohon:</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $dataRequest->requester_name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Pemohon:</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $dataRequest->requester_email }}</p>
                </div>
                @if($dataRequest->requester_phone)
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Telepon:</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $dataRequest->requester_phone }}</p>
                </div>
                @endif
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Judul Permintaan:</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $dataRequest->title }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tujuan Penggunaan:</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $dataRequest->purpose }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Dibutuhkan:</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($dataRequest->needed_date)->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Diajukan:</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $dataRequest->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Saat Ini:</p>
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
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClass }}">
                        {{ ucfirst($dataRequest->status) }}
                    </span>
                </div>
            </div>
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi Data:</p>
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $dataRequest->description }}</p>
            </div>
            @if($dataRequest->attachment_path)
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Lampiran:</p>
                <a href="{{ Storage::url($dataRequest->attachment_path) }}" target="_blank" class="text-primary hover:underline dark:text-secondary">
                    <i class="fas fa-file-alt mr-2"></i>Lihat Lampiran
                </a>
            </div>
            @endif
        </div>

        <!-- Form untuk Mengubah Status -->
        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Ubah Status Permintaan</h2>
            <form action="{{ route('admin.data-requests.update_status', $dataRequest->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Baru:</label>
                    <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200" required>
                        <option value="pending" {{ $dataRequest->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $dataRequest->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ $dataRequest->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="completed" {{ $dataRequest->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-md font-semibold hover:bg-indigo-600 transition-colors">
                    Perbarui Status
                </button>
            </form>
        </div>

        <!-- Tombol Hapus dan Kembali -->
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.data-requests.index') }}" class="px-6 py-2 border-2 border-gray-300 dark:border-dark-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors">
                Kembali ke Daftar
            </a>
            <form action="{{ route('admin.data-requests.destroy', $dataRequest->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permintaan ini secara permanen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-md font-semibold hover:bg-red-700 transition-colors">
                    Hapus Permintaan
                </button>
            </form>
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
