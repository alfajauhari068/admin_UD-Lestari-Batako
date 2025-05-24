<?php

namespace App\Http\Controllers;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    // public function index()
    // {
    //     $pengiriman = Pengiriman::all();
    //     return view('admin.pengiriman.index', compact('pengiriman'));
    // }

    // public function create()
    // {
    //     return view('admin.pengiriman.create');
    // }

    // public function store(Request $request)
    // {
    //     Pengiriman::create($request->all());
    //     return redirect()->route('pengiriman.index')->with('success', 'Pengiriman berhasil ditambahkan');
    // }

    // public function edit($id)
    // {
    //     $pengiriman = Pengiriman::findOrFail($id);
    //     return view('admin.pengiriman.edit', compact('pengiriman'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $pengiriman = Pengiriman::findOrFail($id);
    //     $pengiriman->update($request->all());
    //     return redirect()->route('pengiriman.index')->with('success', 'Pengiriman berhasil diupdate');
    // }

    // public function destroy($id)
    // {
    //     $pengiriman = Pengiriman::findOrFail($id);
    //     $pengiriman->delete();
    //     return redirect()->route('pengiriman.index')->with('success', 'Pengiriman berhasil dihapus');
    // }
}
