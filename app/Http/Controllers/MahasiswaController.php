<?php

namespace App\Http\Controllers;
use Illuminate\Http\validated;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Prestasi;
class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function _construct()
    {
        $this->middleware('auth')->only('create','edit');
    }


    public function index()
    {
        return view('mahasiswa.index',[
            'mahasiswas'=>Mahasiswa::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswa.create',[
            'jurusans'=>Jurusan::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData=$request->validate([
            'nim' =>'required|unique:mahasiswas|size:10',
            'nama' =>'required',
            'jenis_kelamin'=>'required|in:P,L',
            'jurusan_id'=>'required',
            'prestasi_id'=>'required',
            'angkatan'=>'required',
            'alamat'=>'required'
        ]);
        Mahasiswa::create($validatedData);
        return redirect('/mahasiswa')->with('pesan','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit',[
            'mahasiswas' => Mahasiswa::find($mahasiswa->id),
            'jurusans' => Jurusan::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validatedData=$request->validate([
            'nim' =>'required',
            'nama' =>'required',
            'jenis_kelamin'=>'required|in:P,L',
            'jurusan_id'=>'required',
            'alamat'=>'required'
        ]);
        Mahasiswa::WHERE('id',$mahasiswa->id)->update($validatedData);
        return redirect('/mahasiswa')->with('pesan','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        Mahasiswa::destroy($mahasiswa->id);
        return redirect('/mahasiswa')->with('Pesan','Data berhasil dihapus');
    }
}
