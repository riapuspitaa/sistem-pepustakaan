<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Kategoribukurelasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        $kategori = Kategoribukurelasi::all();
        return view('buku.buku', compact('buku', 'kategori'));
    }

    public function create()
    {
        
        $kategori = Kategori::distinct()->get();
        return view('buku.buku_create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'foto' => 'required|mimes:jpeg,png,jpg,gifsvg|max:2048',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'sinopsis' => 'required',
            'kategori_id' => 'required',
        ]);
         $fotoPath = $request->file('foto')->store('buku_images', 'public');


        // Cari kategori berdasarkan ID
        $kategori = Kategori::find($request->kategori_id);

        //Tambah buku baru beserta kategori
        $buku = Buku::create([
            'judul' => $request->judul,
            'foto' => $fotoPath,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'sinopsis' => $request->sinopsis,
        ]);

        $buku->kategori()->attach($kategori);

        return redirect('/buku')->with('success', 'Buku berhasil ditambahkan!');
    }

     public function welcome(){
        $buku = Buku::all();
        return view('welcome', ['buku' => $buku]);
    }
    public function show($id){
        $buku = Buku::findOrFail($id);
        return view ('buku.detail_buku', ['buku' => $buku]);
    }
    public function hapus ($id)
    {
        $buku = Buku::find($id);
        $buku->delete();
        return redirect ('/buku');
    }
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::distinct()->get();
        return view('buku.edit', compact('buku', 'kategori'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'sinopsis' => 'required',
            'kategori_id' => 'required',
        ]);
        $buku = Buku::findOrFail($id);
        if ($request->hasFile('foto')) {
            $request->validate([
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:12048',
            ]);
            // Hapus foto lama
            Storage::disk('public')->delete($buku->foto);
            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('buku_images', 'public');
            $buku->foto = $fotoPath;
        }
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->penerbit = $request->penerbit;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->sinopsis = $request->sinopsis;
        $buku->save();
        // Update kategori
        $kategori = Kategori::find($request->kategori_id);
        $buku->kategori()->sync([$kategori->id]);
        return redirect('/buku')->with('success', 'Buku berhasil diperbarui!');
    }
}

