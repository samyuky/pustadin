    <!DOCTYPE html>
    <html lang="id" class="scroll-smooth">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporkan Error - PUSDATIN</title>
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

                    <div class="flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="hover:text-primary dark:hover:text-secondary transition-colors">Beranda</a>
                        <button id="theme-toggle" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-dark-700">
                            <i class="fas fa-moon dark:hidden"></i>
                            <i class="fas fa-sun hidden dark:block"></i>
                        </button>
                    </div>
                </nav>
            </div>
        </header>

        <!-- Main Content Section - Error Report Form -->
        <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="max-w-xl mx-auto bg-white dark:bg-dark-800 rounded-lg shadow-xl p-8">
                <h2 class="text-2xl font-bold text-center text-primary dark:text-white mb-6">LAPORAN ERROR</h2>

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

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('error_reports.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Laporan Error:</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi Detail Error:</label>
                        <textarea id="description" name="description" rows="6" required
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label for="reported_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Pelapor (Opsional):</label>
                        <input type="text" id="reported_by" name="reported_by" value="{{ old('reported_by') }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Pelapor (Opsional):</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200">
                    </div>

                    <div class="flex justify-end space-x-4 pt-4">
                        <a href="{{ route('home') }}" class="px-6 py-2 border border-gray-300 dark:border-dark-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-md font-semibold hover:bg-indigo-600 transition-colors">
                            Kirim Laporan
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
    