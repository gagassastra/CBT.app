<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller {
    public function index() {
        $data = Kelas::all();
        return view('admin.kelas.index', compact('data'));
    }
    public function create() {
        return view('admin.kelas.create');
    }
    public function store(Request $request) {
        Kelas::create($request->all());
        return redirect()->route('admin.kelas.index')->with('success', 'Data saved');
    }
    public function edit($id) {
        $data = Kelas::findOrFail($id);
        return view('admin.kelas.edit', compact('data'));
    }
    public function update(Request $request, $id) {
        $data = Kelas::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('admin.kelas.index')->with('success', 'Data updated');
    }
    public function destroy($id) {
        Kelas::destroy($id);
        return redirect()->route('admin.kelas.index')->with('success', 'Data deleted');
    }
}