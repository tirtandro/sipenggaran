<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPENGGARAN') - Sistem Pencatatan Pelanggaran Murid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ sidebarOpen: true }">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-blue-900 text-white transition-all duration-300 fixed h-full z-30 flex flex-col">
            <div class="p-4 border-b border-blue-800">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                        <div x-show="sidebarOpen" x-cloak class="ml-2">
                            <h1 class="text-sm font-bold leading-none">SIPENGGARAN</h1>
                            <p class="text-[10px] text-blue-300">SMAN 2 Wates</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white hover:bg-blue-800 p-1 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
            <nav class="flex-1 py-4 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 transition {{ request()->routeIs('dashboard') ? 'bg-blue-800 border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                    <span x-show="sidebarOpen" class="ml-3" x-cloak>Dashboard</span>
                </a>
                <a href="{{ route('murid.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 transition {{ request()->routeIs('murid.*') ? 'bg-blue-800 border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                    <span x-show="sidebarOpen" class="ml-3" x-cloak>Data Murid</span>
                </a>
                @if(auth()->user()->canCatatPelanggaran())
                <a href="{{ route('pelanggaran.create') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 transition {{ request()->routeIs('pelanggaran.create') ? 'bg-blue-800 border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span x-show="sidebarOpen" class="ml-3" x-cloak>Catat Pelanggaran</span>
                </a>
                @endif
                <a href="{{ route('pelanggaran.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 transition {{ request()->routeIs('pelanggaran.index') || request()->routeIs('pelanggaran.show') || request()->routeIs('pelanggaran.edit') ? 'bg-blue-800 border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span x-show="sidebarOpen" class="ml-3" x-cloak>Riwayat Pelanggaran</span>
                </a>
                @if(auth()->user()->canManageSanksi())
                <a href="{{ route('sanksi.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 transition {{ request()->routeIs('sanksi.*') ? 'bg-blue-800 border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span x-show="sidebarOpen" class="ml-3" x-cloak>Manajemen Sanksi</span>
                </a>
                @endif
                @if(auth()->user()->canCetakSurat())
                <a href="{{ route('surat.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 transition {{ request()->routeIs('surat.*') ? 'bg-blue-800 border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span x-show="sidebarOpen" class="ml-3" x-cloak>Surat Peringatan</span>
                </a>
                @endif
                <a href="{{ route('laporan.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 transition {{ request()->routeIs('laporan.*') ? 'bg-blue-800 border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span x-show="sidebarOpen" class="ml-3" x-cloak>Laporan</span>
                </a>
                @if(auth()->user()->canManageReferensi())
                <a href="{{ route('referensi.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 transition {{ request()->routeIs('referensi.*') ? 'bg-blue-800 border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span x-show="sidebarOpen" class="ml-3" x-cloak>Referensi Tata Tertib</span>
                </a>
                @endif
                @if(auth()->user()->canManageUsers())
                <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 transition {{ request()->routeIs('users.*') ? 'bg-blue-800 border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span x-show="sidebarOpen" class="ml-3" x-cloak>Manajemen User</span>
                </a>
                <a href="{{ route('tahun-ajaran.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-800 transition {{ request()->routeIs('tahun-ajaran.*') ? 'bg-blue-800 border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span x-show="sidebarOpen" class="ml-3" x-cloak>Tahun Ajaran</span>
                </a>
                @endif
            </nav>
            <div class="p-4 border-t border-blue-800">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-700 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <div x-show="sidebarOpen" class="ml-3" x-cloak>
                        <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-blue-300">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-red-300 hover:bg-blue-800 rounded transition">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span x-show="sidebarOpen" class="ml-2" x-cloak>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main :class="sidebarOpen ? 'ml-64' : 'ml-20'" class="flex-1 transition-all duration-300">
            <div class="p-6">
                @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg" x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false, 5000)">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg" x-data="{show:true}" x-show="show">
                    {{ session('error') }}
                </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
