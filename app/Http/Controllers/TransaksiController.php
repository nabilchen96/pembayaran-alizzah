<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use DB;
use DataTables;
use App\JenisPembayaran;
use App\SetPembayaranKelas;
use App\Kelas;
use App\Rombel;
use App\TahunAjaran;
use App\RekapTransaksi;

class TransaksiController extends Controller
{

    public function json(){
        $transaksi = DB::table('transaksis')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->select(
                            'transaksis.kd_nota', 
                            DB::raw('sum(jumlah_bayar) as total_pembayaran'),
                            DB::raw('MAX(tgl_transaksi) as tgl_transaksi'),
                            DB::raw('MAX(keterangan) as keterangan'),
                            DB::raw('MAX(nama_pembayar) as nama_pembayar')
                        )
                        ->groupBy('kd_nota')
                        ->orderBy('transaksis.tgl_transaksi', 'DESC')
                        ->get();

        return Datatables::of($transaksi)->make(true);
    }

    public function index(){

        $harian     = DB::table('transaksis')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                        ->where('tgl_transaksi', date('Y-m-d'))
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->sum('jumlah_bayar');

        $bulanan    = DB::table('transaksis')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                        ->whereMonth('tgl_transaksi', '=', date('m'))
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->sum('jumlah_bayar');

        $tahunan    = DB::table('transaksis')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->sum('jumlah_bayar');

        $totals    = DB::table('transaksis')
                                ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                                ->where('tahun_ajarans.status_aktif', 1)
                                ->distinct('kd_nota')
                                ->count();

        return view('transaksi.index')
                    ->with('totals', $totals)
                    ->with('bulanan', $bulanan)
                    ->with('tahunan', $tahunan)
                    ->with('harian', $harian);
    }

    public function create(Request $request){
    
        $kelas      = Kelas::all();

        $siswa      = $request->id_kelas ? DB::table('rombels')
                        ->join('siswas', 'siswas.id_siswa', '=', 'rombels.id_siswa')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rombels.id_tahun')
                        ->where('id_kelas', $request->id_kelas)
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->get() : [];

        $pembayaran  = $request->id_kelas ? DB::table('set_pembayaran_kelas')
                        ->join('kelas', 'kelas.id_kelas', '=', 'set_pembayaran_kelas.id_kelas')
                        ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'set_pembayaran_kelas.id_jenis_pembayaran')
                        ->where('set_pembayaran_kelas.id_kelas', $request->id_kelas)
                        ->get() : [];

        return view('transaksi.create')
            ->with('kelas', $kelas)
            ->with('siswa', $siswa)
            ->with('pembayaran', $pembayaran);
    }

    public function store(Request $request){
        $request->validate([
            'nama_pembayar'         => 'required',
            'tgl_transaksi'         => 'required',
            'id_kelas'              => 'required',
        ]);
        

        $jumlah_bayar   = $request->input('jumlah_bayar');
        $kosong_bayar   = 0;
        $tahun          = TahunAjaran::where('status_aktif', 1)->first();
        
        $transaksi                  = DB::table('transaksis')->select('kd_nota')
                                        ->where('id_tahun', $tahun->id_tahun)
                                        ->latest('created_at')->first();
                                        
        if(empty($transaksi->kd_nota)){
            $int_kd_transaksi           = 1;
        }else{
            $kd_transaksi_potong_awal   = substr($transaksi->kd_nota, 3);
            $kd_transaksi_potong_akhir  = substr($kd_transaksi_potong_awal, 8);
            $int_kd_transaksi           = (int)$kd_transaksi_potong_akhir+1;
        }


        $krr    = explode('-', $request->input('tgl_transaksi'));
        $result = implode("", $krr);

        $kode_nota = 'TRM'.$result.$int_kd_transaksi;

        for($i=0; $i<count($jumlah_bayar); $i++){
            if($jumlah_bayar[$i] !== null){
                Transaksi::create([
                    'tgl_transaksi'         => $request->input('tgl_transaksi'),
                    'id_kelas'              => $request->input('id_kelas'),
                    'id_jenis_pembayaran'   => $request->input('id_jenis_pembayaran')[$i],
                    'jumlah_bayar'          => str_replace(",", "", $request->jumlah_bayar[$i]),
                    'keterangan'            => $request->input('keterangan'),
                    'nama_pembayar'         => $request->input('nama_pembayar'),
                    'id_tahun'              => $tahun->id_tahun,
                    'kd_nota'               => $kode_nota,
                    'id_siswa'              => $request->input('id_siswa')
                ]);
            }else{
                $kosong_bayar = $kosong_bayar+1;
            }
        }

        if($kosong_bayar == count($jumlah_bayar)){
            return back()->with(['gagal' => 'Data Tidak Berhasil Disimpan, Isi Data Jumlah Bayar Terlebih Dahulu']);
        }else{
            $data_trx = DB::table('transaksis')
                        ->groupBy('kd_nota')
                        ->select(
                            'kd_nota',
                            DB::raw('max(nama_pembayar) as nama_pembayar'),
                            DB::raw('max(keterangan) as keterangan'),
                            DB::raw('sum(jumlah_bayar) as total_bayar')
                        )
                        ->where('kd_nota', $kode_nota)
                        ->first();

            RekapTransaksi::create([
                'tgl_transaksi'     => $request->input('tgl_transaksi'),
                'jenis_transaksi'   => 'pemasukan',
                'jumlah_transaksi'  => $data_trx->total_bayar,
                'keterangan'        => $data_trx->keterangan.' atas nama '.$data_trx->nama_pembayar.' Kode Nota '.$kode_nota,
                'kd_nota'           => $kode_nota,
                'id_tahun'          => $tahun->id_tahun
            ]);

            return redirect('transaksi')->with(['sukses' => 'Data Berhasil Disimpan']);
        }
    }

    public function edit($id, Request $request){

        $transaksi   = DB::table('transaksis')
                    ->Leftjoin('siswas', 'siswas.id_siswa', '=', 'transaksis.id_siswa')
                    ->join('kelas', 'kelas.id_kelas', '=', 'transaksis.id_kelas')
                    ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'transaksis.id_jenis_pembayaran')
                    ->where('transaksis.kd_nota', $id)
                    ->get();

        $data       = DB::table('transaksis')
                    ->Leftjoin('siswas', 'siswas.id_siswa', '=', 'transaksis.id_siswa')
                    ->join('kelas', 'kelas.id_kelas', '=', 'transaksis.id_kelas')
                    ->where('transaksis.kd_nota', $id)
                    ->select(
                        'siswas.nama_siswa', 
                        'transaksis.tgl_transaksi', 
                        'transaksis.nama_pembayar', 
                        'kelas.kelas', 
                        'siswas.nama_siswa', 
                        'keterangan',
                        'kelas.id_kelas',
                        'kelas.jenjang',
                        'siswas.nama_siswa',
                        'siswas.id_siswa',
                        'transaksis.kd_nota'
                    )
                    ->distinct('transaksis.kd_nota')
                    ->first();

        return view('transaksi.edit')->with('data', $data)->with('transaksi', $transaksi);
    }

    public function update(Request $request){
        // //query2
        // $transaksi = DB::table('rekap_transaksis')->where('kd_nota', $request->kode_nota)->first();
        
        // //query3
        // $rekap = RekapTransaksi::find($transaksi->id_rekap_transaksi);

        // for($i=0; $i < count($request->id_transaksi); $i++){
        //     if($request->jumlah_bayar[$i] == null){
        //         //query1
        //         $data = Transaksi::find($request->id_transaksi[$i]);

        //         $rekap->update([
        //             'jumlah_transaksi' => $transaksi->jumlah_transaksi - $data->jumlah_bayar
        //         ]);


        //         if($rekap->jumlah_transaksi == 0){
        //             //query4
        //             $rekap->delete();
        //         }

        //         //query5
        //         $data->delete();
        //     }else{
        //         Transaksi::find($request->id_transaksi[$i])->update([
        //             'jumlah_bayar'  => $request->jumlah_bayar[$i],
        //             'keterangan'    => $request->keterangan,
        //             'nama_pembayar' => $request->nama_pembayar,
        //         ]);

        //         $rekap->update([
        //             'jumlah_transaksi'
        //         ]);

        //     }
        // }

        // return redirect('transaksi')->with(['sukses' => 'Data Berhasil Disimpan!']);
    }

    public function nota($id){

        $nota = DB::table('transaksis')
                    ->where('kd_nota', $id)
                    ->Leftjoin('siswas', 'siswas.id_siswa', '=', 'transaksis.id_siswa')
                    ->select('kd_nota', 'tgl_transaksi', 'nama_pembayar', 'keterangan', 'siswas.nama_siswa', 'siswas.nis')
                    ->distinct('kd_nota')
                    ->first();

        $pembayaran = DB::table('transaksis')
                        ->where('kd_nota', $id)
                        ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'transaksis.id_jenis_pembayaran')
                        ->join('kelas', 'kelas.id_kelas', '=', 'transaksis.id_kelas')
                        ->select('jenis_pembayarans.nama_pembayaran', 'transaksis.jumlah_bayar', 'kelas.kelas', 'kelas.jenjang')
                        ->get();

        return view('transaksi.nota')
            ->with('pembayaran', $pembayaran)
            ->with('nota', $nota);
    }

    public function destroy($id){

        Transaksi::where('kd_nota', $id)->delete();
        RekapTransaksi::where('kd_nota', $id)->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus']);

    }
}
