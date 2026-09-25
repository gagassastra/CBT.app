<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller {
    public function index() {
        $data = MataPelajaran::all();
        return view('admin.mapel.index', compact('data'));
    }
    public function create() {
        return view('admin.mapel.create');
    }
    public function store(Request $request) {
        MataPelajaran::create($request->all());
        return redirect()->route('admin.mapel.index')->with('success', 'Data saved');
    }
    public function edit($id) {
        $data = MataPelajaran::findOrFail($id);
        return view('admin.mapel.edit', compact('data'));
    }
    public function update(Request $request, $id) {
        $data = MataPelajaran::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('admin.mapel.index')->with('success', 'Data updated');
    }
    public function destroy($id) {
        MataPelajaran::destroy($id);
        return redirect()->route('admin.mapel.index')->with('success', 'Data deleted');
    }
}