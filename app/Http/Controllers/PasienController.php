<?php

namespace App\Http\Controllers;

use DB;
use App\Pasien;
use App\Kabupaten;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class PasienController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pasien = Pasien::select('tb_pasien.id','id_kabupaten','kabupaten','positif','rawat','sembuh','meninggal')
                ->join('tb_kabupaten','tb_pasien.id_kabupaten','=','tb_kabupaten.id')
                ->get();
        $test = Pasien::select('tb_pasien.id','id_kabupaten','kabupaten','positif','rawat','sembuh','meninggal')
                ->join('tb_kabupaten','tb_pasien.id_kabupaten','=','tb_kabupaten.id')
                ->where('tgl_data', Pasien::max('tgl_data'))->orderBy('tgl_data','desc')
                ->get();
        $sembuh = Pasien::where('tgl_data', Pasien::max('tgl_data'))->orderBy('tgl_data','desc')
                ->sum('sembuh');
        $positif = Pasien::where('tgl_data', Pasien::max('tgl_data'))->orderBy('tgl_data','desc')
                ->sum('positif');
        $meninggal = Pasien::where('tgl_data', Pasien::max('tgl_data'))->orderBy('tgl_data','desc')
                ->sum('meninggal');
        $rawat = Pasien::where('tgl_data', Pasien::max('tgl_data'))->orderBy('tgl_data','desc')
                ->sum('rawat');
        $kabupaten = Kabupaten::all();

        $date   = \Carbon\Carbon::now()->format('d F Y');
        return view('pasien.index',compact('kabupaten','positif','rawat','sembuh','meninggal','date'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $cek = Pasien::where('id_kabupaten',$request->kabupaten)->where('tgl_data',$request->tgl_data)->count();
        if($cek == 0){
            $Pasien = new Pasien();
        }else{
            $Pasien = Pasien::where('id_kabupaten',$request->kabupaten)->where('tgl_data',$request->tgl_data)->first();
            $Pasien->status = 1;
        }

        $Pasien->id_kabupaten = $request->kabupaten;
        $Pasien->meninggal = $request->meninggal;
        $Pasien->sembuh = $request->sembuh;
        $Pasien->rawat = $request->rawat;
        $Pasien->tgl_data = $request->tgl_data;
        $Pasien->positif = $request->sembuh + $request->rawat + $request->meninggal;
        if($cek == 0){
            $Pasien->save();
        }else{
            $Pasien->update();
        }

        return redirect('/pasien');
        return $request;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */
    public function show(Pasien $pasien)
    {
        $pasien = Pasien::select('tb_pasien.id','kabupaten','positif','rawat','sembuh','meninggal')
                ->join('tb_kabupaten','tb_Pasien.id_kabupaten','=','tb_kabupaten.id')
                ->where('tb_Pasien.id_kabupaten','=',$pasien)
                ->get();

        return view('detail',compact('pasien'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */
    public function edit(Pasien $pasien)
    {
        return view('edit',compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pasien $pasien)
    {
        // $pasien->update($request->all());
        // $test = $request->id;
        $rawat= $request->rawat;
        $sembuh= $request->sembuh;
        $meninggal= $request->meninggal;
        $positif = $rawat+$sembuh+$meninggal;

        $pasien->sembuh = $request->sembuh;
        $pasien->rawat= $request->rawat;
        $pasien->positif= $positif;
        $pasien->meninggal= $request->meninggal;
        $pasien->save();

        return redirect('/pasien');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect('/pasien')->with('alert-success','Pasien berhasil dihapus!');
    }
}
