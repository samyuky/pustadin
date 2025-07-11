<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Permintaan Sinkronisasi Feeder - PUSDATIN UNIGA</title>
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
</head>
<body class="bg-light-100 dark:bg-dark-900 text-gray-800 dark:text-gray-200 min-h-screen transition-colors duration-300">
    <!-- Header Section (Disalin dari welcome.blade.php) -->
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
                        <a href="{{ route('home') }}" class="hover:text-primary dark:hover:text-secondary transition-colors">Beranda</a>
                    
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
                <a href="{{ route('home') }}#layanan" class="py-2 hover:text-primary dark:hover:text-secondary">Layanan</a>
                <a href="{{ route('home') }}#alur" class="py-2 hover:text-primary dark:hover:text-secondary">Alur Pengajuan</a>
                <a href="{{ route('home') }}#faq" class="py-2 hover:text-primary dark:hover:text-secondary">FAQ</a>
                <a href="{{ route('home') }}#kontak" class="py-2 hover:text-primary dark:hover:text-secondary">Kontak</a>
            </div>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-dark-800 p-8 rounded-xl shadow-xl w-full max-w-md border border-gray-200 dark:border-dark-700">
            <h1 class="text-2xl md:text-3xl font-bold mb-6 text-center text-primary dark:text-white">Ajukan Permintaan Sinkronisasi Feeder</h1>

            <!-- Display validation errors if any -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success message after submission -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            <form action="{{ route('feeder_sync_requests.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Nama Anda:</label>
                    <input type="text" id="name" name="name" class="form-input w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-dark-600 bg-gray-50 dark:bg-dark-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="Masukkan nama Anda" required>
                </div>
                <div>
                    <label for="email" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Email Anda:</label>
                    <input type="email" id="email" name="email" class="form-input w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-dark-600 bg-gray-50 dark:bg-dark-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="Masukkan email Anda" required>
                </div>
                <div>
                    <label for="request_type" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Jenis Permintaan Sinkronisasi:</label>
                    <select id="request_type" name="request_type" class="form-select w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-dark-600 bg-gray-50 dark:bg-dark-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" required>
                        <option value="">Pilih Jenis Sinkronisasi</option>
                        <option value="data_mahasiswa">Data Mahasiswa</option>
                        <option value="data_dosen">Data Dosen</option>
                        <option value="data_matakuliah">Data Mata Kuliah</option>
                        <option value="data_nilai">Data Nilai</option>
                        <option value="lain_lain">Lain-lain</option>
                    </select>
                </div>
                <div>
                    <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Deskripsi Detail Permintaan:</label>
                    <textarea id="description" name="description" rows="5" class="form-textarea w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-dark-600 bg-gray-50 dark:bg-dark-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" placeholder="Jelaskan kebutuhan sinkronisasi Anda secara detail" required></textarea>
                </div>
                
                <div class="flex justify-end space-x-4 pt-4">
                        <a href="{{ route('home') }}" class="px-6 py-2 border border-gray-300 dark:border-dark-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-md font-semibold hover:bg-indigo-600 transition-colors">
                            Ajukan Permintaan Fitur
                        </button>
                    </div>
            </form>
        </div>
    </main>

    <!-- Footer Section -->
        <footer class="bg-dark-900 text-white py-8 px-6 mt-auto">
            <div class="container mx-auto text-center text-sm text-gray-400">
                &copy; 2023 PUSDATIN Universitas Garut. Hak Cipta Dilindungi.
            </div>
        </footer>

        <!-- Theme Toggle Script -->
        <script>
            const themeToggleBtn = document.getElementById('theme-toggle');
            const htmlElement = document.documentElement;

            function setInitialTheme() {
                if (localStorage.getItem('theme') === 'dark' ||
                    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    htmlElement.classList.add('dark');
                } else {
                    htmlElement.classList.remove('dark');
                }
            }

            themeToggleBtn.addEventListener('click', function() {
                htmlElement.classList.toggle('dark');
                localStorage.setItem('theme', htmlElement.classList.contains('dark') ? 'dark' : 'light');
            });

            setInitialTheme();
        </script>
    </body>
    </html>
    