<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->has('cari')){
            $data_mahasiswa = \App\models\Mahasiswa::where('nama', 'LIKE', '%'. $request->cari . '%')-> paginate(5);
        }else{
            //$data_mahasiswa = \App\models\Mahasiswa::all();
            $data_mahasiswa = \App\models\Mahasiswa::paginate(5);
            //$data_mahasiswa = DB::table('data_mahasiswa')->paginate(5);
        }
        return view('mahasiswa.index',['data_mahasiswa' => $data_mahasiswa]);

    }

    public function cari(Request $request){

        $cari = $request->cari;
        $data_mahasiswa = DB::table('mahasiswa')
        ->where('nama','like',"%".$cari."%")
        ->paginate();

        return view('mahasiswa.index',['mahasiswa' => $data_mahasiswa]);

    }

    public function create(Request $request){

        Mahasiswa::create($request->all());
        return redirect('/mahasiswa')->with('Sukses','Data berhasil di input!');
    }

    public function edit($id){

        $data_mahasiswa = \App\models\Mahasiswa::find($id);
        return view('mahasiswa.edit',['mahasiswa'=> $data_mahasiswa]);
    }

    public function update(Request $request, $id){

        $data_mahasiswa = \App\models\Mahasiswa::find($id);
        $data_mahasiswa->update($request->all());
        return redirect('/mahasiswa')->with('Sukses','Data berhasil diupdate');
    }

    public function delete($id){

        $data_mahasiswa = \App\models\Mahasiswa::find($id);
        $data_mahasiswa->delete();
        return redirect('/mahasiswa')->with('Sukses','Data berhasil dihapus');
    }

    public function exportPdf(){

        $data_mahasiswa = \App\Models\Mahasiswa::all();
        $pdf = PDF::loadView('export.mahasiswapdf',['mahasiswa' => $data_mahasiswa]);
        return $pdf->download('mahasiswa.pdf');
    }
}
