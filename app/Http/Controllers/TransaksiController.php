<?php

namespace App\Http\Controllers;

use App\Models\Transaksi; 
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::where('user_id', auth()->id()) ->orderBy('tanggal', 'desc') ->get(); 
        return view('transaksi.index', compact('transaksis')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('transaksi.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([ 'jenis' => 'required|in:pemasukan,pengeluaran', 'kategori' => 'required|string|max:255', 'jumlah' => 'required|numeric|min:0', 'catatan' => 'nullable|string', 'tanggal' => 'required|date', ]); $validated['user_id'] = auth()->id(); Transaksi::create($validated);
         return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
         if ($transaksi->user_id !== auth()->id()) { abort(403); } 
         return view('transaksi.edit', compact('transaksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        if ($transaksi->user_id !== auth()->id()) { abort(403); } $validated = $request->validate([ 'jenis' => 'required|in:pemasukan,pengeluaran', 'kategori' => 'required|string|max:255', 'jumlah' => 'required|numeric|min:0', 'catatan' => 'nullable|string', 'tanggal' => 'required|date', ]); $transaksi->update($validated);
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui!'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        if ($transaksi->user_id !== auth()->id()) { abort(403); } $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
