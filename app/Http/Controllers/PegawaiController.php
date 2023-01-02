<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    public function index(){

        //mengambil data dari table pegawaiController
        $pegawai = DB::table('pegawai')->paginate(5);

        return view('pegawai',['pegawai' => $pegawai]);
    }

    public function cariPegawai(Request $request){

        $cari = $request->cari;
        $pegawai = DB::table('pegawai')
        ->where('nama','like',"%".$cari."%")
        ->paginate();

        return view('pegawai.index',['pegawai' => $pegawai]);

    }
}
