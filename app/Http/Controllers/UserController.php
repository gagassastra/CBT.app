<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller {
    public function index() {
        $data = User::whereIn('role', ['admin', 'guru'])->get();
        return view('admin.pengguna.index', compact('data'));
    }
    public function create() { return view('admin.pengguna.create'); }
    public function store(Request $request) {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        User::create($data);
        return redirect()->route('admin.pengguna.index');
    }
    public function edit($id) {
        $data = User::findOrFail($id);
        return view('admin.pengguna.edit', compact('data'));
    }
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $data = $request->all();
        if(!empty($data['password'])) { $data['password'] = bcrypt($data['password']); }
        else { unset($data['password']); }
        $user->update($data);
        return redirect()->route('admin.pengguna.index');
    }
    public function destroy($id) { User::destroy($id); return redirect()->route('admin.pengguna.index'); }
}