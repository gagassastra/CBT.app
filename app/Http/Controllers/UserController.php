<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $data = User::whereIn('role', ['admin', 'guru'])->get();
        return view('admin.pengguna.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pengguna.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:admin,guru'],
            'password' => ['required', 'string', 'min:6'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['password'] = bcrypt($validated['password']);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto_profil', 'public');
        }

        User::create($validated);

        return redirect()->route('admin.pengguna.index')->with('success', 'Data pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('admin.pengguna.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', 'in:admin,guru'],
            'password' => ['nullable', 'string', 'min:6'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hapus_foto' => ['nullable', 'boolean'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        unset($validated['hapus_foto']);

        if ($request->boolean('hapus_foto') && $user->foto) {
            Storage::disk('public')->delete($user->foto);
            $validated['foto'] = null;
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto_profil', 'public');
        }

        $user->update($validated);

        return redirect()->route('admin.pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }
        $user->delete();

        return redirect()->route('admin.pengguna.index')->with('success', 'Data pengguna berhasil dihapus.');
    }
}
