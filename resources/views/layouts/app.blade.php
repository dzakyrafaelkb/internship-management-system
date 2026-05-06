<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Magang') - Sistem Manajemen Magang Profesional</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased">
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="text-2xl font-bold text-blue-600">SistemMagang</div>
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <span class="text-gray-600">{{ auth()->user()->name }}</span>
                        <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded">{{ ucfirst(auth()->user()->role) }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white mt-12">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">Tentang Kami</h3>
                    <p class="text-gray-400">Sistem manajemen magang profesional untuk perusahaan modern.</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Menu Utama</h3>
                    <ul class="text-gray-400 space-y-2">
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="hover:text-white">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-white">Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-white">Daftar</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <p class="text-gray-400">Email: info@sistemamagang.com</p>
                    <p class="text-gray-400">Phone: +62-xxx-xxxx-xxxx</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Ikuti Kami</h3>
                    <div class="flex gap-4 text-gray-400">
                        <a href="#" class="hover:text-white">Facebook</a>
                        <a href="#" class="hover:text-white">Instagram</a>
                        <a href="#" class="hover:text-white">Twitter</a>
                    </div>
                </div>
            </div>
            <hr class="border-gray-800 my-8">
            <div class="text-center text-gray-400">
                <p>&copy; 2026 Sistem Manajemen Magang. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
