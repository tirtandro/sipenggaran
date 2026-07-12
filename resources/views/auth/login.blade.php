<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPENGGARAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <div class="w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SMAN 2 Wates" class="w-full h-full object-contain">
                </div>
                <h1 class="text-2xl font-bold text-gray-800">SIPENGGARAN</h1>
                <p class="text-gray-500 text-sm mt-1">Sistem Pencatatan Pelanggaran Murid</p>
                <p class="text-gray-400 text-xs">SMAN 2 Wates - Kulon Progo</p>
            </div>

            @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded-lg text-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="email@sman2wates.sch.id">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Masukkan password">
                </div>
                <div class="mb-6 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>
                <button type="submit" class="w-full bg-blue-900 text-white py-3 rounded-lg hover:bg-blue-800 transition font-medium">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</body>
</html>
