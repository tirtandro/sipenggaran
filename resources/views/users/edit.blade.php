@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
    <p class="text-gray-500">{{ $user->name }}</p>
</div>
<div class="bg-white rounded-xl shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2 border rounded-lg @error('email') border-red-500 @enderror">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru (kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" required class="w-full px-4 py-2 border rounded-lg">
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru_bk" {{ old('role', $user->role) == 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
                    <option value="guru_piket" {{ old('role', $user->role) == 'guru_piket' ? 'selected' : '' }}>Guru Piket</option>
                    <option value="wali_kelas" {{ old('role', $user->role) == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas (untuk Wali Kelas)</label>
                <select name="kelas_id" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">-</option>
                    @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('kelas_id', $user->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
            <a href="{{ route('users.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection