<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Permintaan Data Baru - PUSDATIN</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Flatpickr CSS for the date picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script>
        // Tailwind CSS configuration for custom colors and dark mode
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb', // Primary blue color
                        secondary: '#10b981', // Secondary green color
                        dark: {
                            900: '#121212', // Darkest background
                            800: '#1e1e1e', // Darker background
                            700: '#2d2d2d', // Medium dark background
                            600: '#3e3e3a', // Lighter dark background
                        },
                        light: {
                            100: '#f8fafc', // Lightest background
                            200: '#f1f5f9', // Lighter background
                            300: '#e2e8f0', // Medium light background
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
                    <!-- Navigation link to home page for general users -->
                    <a href="{{ route('home') }}" class="hover:text-primary dark:hover:text-secondary transition-colors">Beranda</a>
                    <!-- Theme toggle button -->
                    <button id="theme-toggle" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-dark-700">
                        <i class="fas fa-moon dark:hidden"></i> <!-- Moon icon for light mode -->
                        <i class="fas fa-sun hidden dark:block"></i> <!-- Sun icon for dark mode -->
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content Section - Data Request Form -->
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="max-w-xl mx-auto bg-white dark:bg-dark-800 rounded-lg shadow-xl p-8">
            <h2 class="text-2xl font-bold text-center text-primary dark:text-white mb-6">PERMINTAAN DATA BARU</h2>

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

            <!-- Data Request Form -->
            <form action="{{ route('data_requests.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf <!-- CSRF token for security -->

                <!-- Requester Name Input -->
                <div>
                    <label for="requester_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap:</label>
                    <input type="text" id="requester_name" name="requester_name" value="{{ old('requester_name') }}" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200">
                    @error('requester_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Requester Email Input -->
                <div>
                    <label for="requester_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email:</label>
                    <input type="email" id="requester_email" name="requester_email" value="{{ old('requester_email') }}" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200">
                    @error('requester_email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- WhatsApp Number Input (REQUIRED) -->
                <div>
                    <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor WhatsApp Pribadi:</label>
                    <input type="text" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number') }}" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200"
                           placeholder="Contoh: 6281234567890">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Pastikan nomor aktif dan diawali dengan kode negara (misal: 62 untuk Indonesia).</p>
                    @error('whatsapp_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title Input -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Permintaan:</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description Textarea -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi Data:</label>
                    <textarea id="description" name="description" rows="4" required
                                 class="w-full px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Purpose Input -->
                <div>
                    <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tujuan Penggunaan:</label>
                    <input type="text" id="purpose" name="purpose" value="{{ old('purpose') }}" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200">
                    @error('purpose')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Needed Date Input with Flatpickr -->
                <div>
                    <label for="needed_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Dibutuhkan:</label>
                    <input type="text" id="needed_date" name="needed_date" value="{{ old('needed_date') }}" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-dark-600 rounded-md focus:ring-primary focus:border-primary dark:bg-dark-700 dark:text-gray-200 flatpickr">
                    @error('needed_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Attachment Upload Input -->
                <div>
                    <label for="attachment_path" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Surat Permohonan (PDF/DOC/DOCX/ZIP, maks 2MB):</label>
                    <input type="file" id="attachment_path" name="attachment_path" accept=".pdf,.doc,.docx,.zip"
                           class="w-full text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-indigo-600">
                    @error('attachment_path')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Action Buttons -->
                <div class="flex justify-end space-x-4 pt-4">
                    <!-- Cancel Button -->
                    <a href="{{ route('home') }}" class="px-6 py-2 border border-gray-300 dark:border-dark-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors">
                        Batal
                    </a>
                    <!-- Submit Button -->
                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-md font-semibold hover:bg-indigo-600 transition-colors">
                        Ajukan Permintaan
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

    <!-- Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize Flatpickr for date input
        flatpickr(".flatpickr", {
            dateFormat: "Y-m-d", // Date format YYYY-MM-DD
            minDate: "today",    // Only allow today or future dates
        });

        // Theme toggle functionality
        const themeToggleBtn = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;

        // Function to set initial theme based on localStorage or system preference
        function setInitialTheme() {
            if (localStorage.getItem('theme') === 'dark' ||
                (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                htmlElement.classList.add('dark');
            } else {
                htmlElement.classList.remove('dark');
            }
        }

        // Event listener for theme toggle button click
        themeToggleBtn.addEventListener('click', function() {
            htmlElement.classList.toggle('dark'); // Toggle 'dark' class on <html>
            localStorage.setItem('theme', htmlElement.classList.contains('dark') ? 'dark' : 'light'); // Save preference
        });

        // Apply initial theme when the page loads
        setInitialTheme();
    </script>
</body>
</html>
