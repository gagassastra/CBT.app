<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - PKBM AL-QUDWAH</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex items-center justify-center relative overflow-hidden p-4 sm:p-6 lg:p-8">
            
            <!-- Beautiful Background Gradient/Shapes -->
            <div class="absolute inset-0 z-0 bg-gradient-to-br from-blue-600 via-indigo-700 to-indigo-900"></div>
            
            <div class="relative z-10 w-full max-w-5xl flex rounded-2xl shadow-2xl overflow-hidden bg-white">
                
                <!-- Left Side: Branding and Welcome -->
                <div class="hidden md:flex md:w-1/2 bg-blue-50 flex-col items-center justify-center p-12 text-center border-r border-gray-100 relative">
                    <!-- Logo Image -->
                    <div class="mb-6 bg-transparent">
                        <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM AL-QUDWAH" class="w-32 h-auto object-contain drop-shadow-md">
                    </div>
                    
                    <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight mb-4">
                        PKBM AL-QUDWAH
                    </h1>
                    <p class="text-blue-700 leading-relaxed font-medium">
                        Sistem Ujian Sekolah Berbasis Web (Computer Based Test). Silakan masuk untuk mengakses panel Anda.
                    </p>
                    
                    <div class="absolute bottom-6 left-0 right-0 text-sm text-blue-400 font-semibold">
                        &copy; {{ date('Y') }} PKBM AL-QUDWAH
                    </div>
                </div>

                <!-- Right Side: The Form Slot -->
                <div class="w-full md:w-1/2 p-8 sm:p-10 lg:p-12 flex flex-col justify-center bg-white">
                    <!-- Mobile Logo (only shows on small screens) -->
                    <div class="md:hidden flex flex-col items-center mb-8">
                        <div class="mb-3 bg-transparent">
                            <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM AL-QUDWAH" class="w-20 h-auto object-contain">
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">PKBM AL-QUDWAH</h2>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang &#x1F44B;</h2>
                        <p class="text-gray-500 mt-2">Masukkan kredensial Anda untuk mengakses sistem.</p>
                    </div>

                    {{ $slot }}
                </div>
                
            </div>
        </div>
    </body>
</html>
