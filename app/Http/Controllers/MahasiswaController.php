<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Kelas;

class MahasiswaController extends Controller
{
    public function destroy($id) {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus');
    }
    public function index() {
        // $data = Mahasiswa::all();
        // return view('mahasiswa.index', compact('data'));
        $data = Mahasiswa ::with('kelas')->get();
        $kelas = Kelas::all();
        return view('mahasiswa.index', compact('data', 'kelas'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|max:20',
            'kelas_id' => 'required|integer|exists:kelas,id',
        ]);

        Mahasiswa::create($request->only('nama', 'nim', 'kelas_id'));
        return redirect()->back();
    }

    public function edit($nim) {
        $data = Mahasiswa::where('nim', $nim)->firstOrFail();
        return view('mahasiswa.edit', compact('data'));
    }

    public function update(Request $request, $id) {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|max:20',
            'kelas_id' => 'required|integer|exists:kelas,id',
        ]);
        $mahasiswa->update($request->only('nim', 'nama', 'kelas_id'));
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diupdate');
    }
}
