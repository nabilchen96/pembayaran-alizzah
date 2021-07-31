<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UangSaku;
use App\TransaksiUangSaku;
use DB;
// use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class UangSakuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(request()->ajax()){
            $data = DB::table('siswas')
                    ->leftjoin('uang_sakus','uang_sakus.id_siswa', '=', 'siswas.id_siswa')
                    ->select(
                        'siswas.id_siswa',
                        'siswas.nama_siswa',
                        'siswas.nis',
                        'uang_sakus.saldo'
                    )
                    ->get();

            return DataTables::of($data)->toJson();
        }
        return view('uangsaku.index');
    }

    public function detailtransaksiuangsaku($id){

        if(request()->ajax()){
            $rekap_trx = [];
            $pemasukan = null;
            $pengeluaran = null;

            $data = DB::table('transaksi_uang_sakus')
                        ->join('siswas', 'siswas.id_siswa', '=', 'transaksi_uang_sakus.id_siswa')
                        ->where('siswas.id_siswa', $id)
                        ->select(
                            'siswas.id_siswa',
                            'siswas.nama_siswa',
                            'siswas.nis',
                            'transaksi_uang_sakus.*'
                        )
                        ->orderBy('transaksi_uang_sakus.created_at', 'ASC')
                        ->get();

            foreach($data as $k => $d){
                $d->jenis_transaksi == 'masuk' ? $pemasukan = $d->jumlah + $pemasukan : $pengeluaran = $d->jumlah + $pengeluaran;
    
                $saldo = $pemasukan - $pengeluaran;
    
                $rekap_trx[] = array(
                    'id_transaksi_uang_saku'=> $d->id_transaksi_uang_saku,
                    'created_at'            => $d->created_at,
                    'jenis_transaksi'       => $d->jenis_transaksi,
                    'jumlah'                => $d->jumlah,
                    'keterangan'            => $d->keterangan,
                    'saldo'                 => $saldo
                );
            }

            return DataTables::of($rekap_trx)->make(true);
        }

        return view('uangsaku.transaksiuangsaku');
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
    public function tambahtransaksiuangsaku(Request $request)
    {
        // dd($request);
        
        TransaksiUangSaku::create([
            'id_siswa'          => $request->id_siswa,
            'keterangan'        => $request->keterangan,
            'jenis_transaksi'   => $request->jenis_transaksi, 
            'jumlah'            => $request->jumlah
        ]);

        $data = UangSaku::where('id_siswa', $request->id_siswa)->first();
        
        if($data){
            $uangsaku = UangSaku::find($data->id_uang_saku);

            // dd($uangsaku->saldo);

            if($request->jenis_transaksi == 'masuk'){
                $uangsaku->update([
                    'saldo' => $uangsaku->saldo + $request->jumlah
                ]);
            }else{
                $uangsaku->update([
                    'saldo' => $uangsaku->saldo - $request->jumlah
                ]);
            }
        }else{
            UangSaku::create([
                'id_siswa'    => $request->id_siswa,
                'saldo' => $request->jumlah
            ]);
        }

        return back()->with(['sukses' => 'Data berhasil disimpan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
