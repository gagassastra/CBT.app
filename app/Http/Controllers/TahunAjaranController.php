<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TahunAjaran;

class TahunAjaranController extends Controller {
    public function index() {
        $data = TahunAjaran::all();
        return view('admin.tahun_ajaran.index', compact('data'));
    }
    public function create() {
        return view('admin.tahun_ajaran.create');
    }
    public function store(Request $request) {
        TahunAjaran::create($request->all());
        return redirect()->route('admin.tahun_ajaran.index')->with('success', 'Data saved');
    }
    public function edit($id) {
        $data = TahunAjaran::findOrFail($id);
        return view('admin.tahun_ajaran.edit', compact('data'));
    }
    public function update(Request $request, $id) {
        $data = TahunAjaran::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('admin.tahun_ajaran.index')->with('success', 'Data updated');
    }
    public function destroy($id) {
        TahunAjaran::destroy($id);
        return redirect()->route('admin.tahun_ajaran.index')->with('success', 'Data deleted');
    }
}