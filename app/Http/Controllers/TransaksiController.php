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

class TransaksiController extends Controller
{

    public function json(){
        $transaksi = DB::table('transaksis')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->select(
                            'transaksis.tgl_transaksi',
                            'transaksis.kd_nota', 
                            'transaksis.id_transaksi', 
                            'transaksis.keterangan', 
                            'transaksis.nama_pembayar', 
                            DB::raw('sum(jumlah_bayar) as total_pembayaran')
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

        $total_transaksi    = DB::table('transaksis')
                                ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                                ->where('tahun_ajarans.status_aktif', 1)
                                ->groupBy('kd_nota')
                                ->get();

        $totals = count($total_transaksi);

        return view('transaksi.index')
                    ->with('totals', $totals)
                    ->with('bulanan', $bulanan)
                    ->with('tahunan', $tahunan)
                    ->with('harian', $harian);
    }

    public function create(Request $request){
        
        $kelas      = Kelas::all();
        $id_kelas   = $request->input('id_kelas');
        $id_siswa   = $request->input('id_siswa');

        if(empty($id_kelas)){
            $siswa = [];
            $pembayaran = [];
        }else{
            $siswa = DB::table('rombels')
                        ->join('siswas', 'siswas.id_siswa', '=', 'rombels.id_siswa')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rombels.id_tahun')
                        ->where('id_kelas', $id_kelas)
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->get();

            $pembayaran = DB::table('set_pembayaran_kelas')
                            ->join('kelas', 'kelas.id_kelas', '=', 'set_pembayaran_kelas.id_kelas')
                            ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'set_pembayaran_kelas.id_jenis_pembayaran')
                            ->where('set_pembayaran_kelas.id_kelas', $id_kelas)
                            ->get();
            
            if(!empty($id_siswa)){
                $pembayaran = DB::table('set_pembayaran_kelas')
                                ->join('kelas', 'kelas.id_kelas', '=', 'set_pembayaran_kelas.id_kelas')
                                ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'set_pembayaran_kelas.id_jenis_pembayaran')
                                ->leftJoin('keringanans', 'keringanans.id_jenis_pembayaran', '=', 'jenis_pembayarans.id_jenis_pembayaran')
                                ->leftJoin('penerima_keringanans', 'penerima_keringanans.id_keringanan', '=', 'keringanans.id_keringanan')
                                ->where('set_pembayaran_kelas.id_kelas', $id_kelas)
                                ->select(
                                    'penerima_keringanans.id_siswa',
                                    'keringanans.keringanan',
                                    'jenis_pembayarans.nama_pembayaran',
                                    'kelas.id_kelas',
                                    'set_pembayaran_kelas.biaya',
                                    'jenis_pembayarans.id_jenis_pembayaran',
                                    'keringanans.besaran_keringanan'
                                )
                                ->get();

                // echo json_encode($pembayaran);
                // die;
            }else{
                $id_siswa = null;
            }
        }

        $nama_pembayar  = $request->input('nama_pembayar');
        $tgl_transaksi  = $request->input('tgl_transaksi');

        return view('transaksi.create')
            ->with('kelas', $kelas)
            ->with('siswa', $siswa)
            ->with('id_kelas', $id_kelas)
            ->with('pembayaran', $pembayaran)
            ->with('nama_pembayar', $nama_pembayar)
            ->with('id_siswa', $id_siswa)
            ->with('tgl_transaksi', $tgl_transaksi);
    }

    public function store(Request $request){
        $request->validate([
            'nama_pembayar'         => 'required',
            'tgl_transaksi'         => 'required',
            'id_kelas'              => 'required',
        ]);

        // dd($request->input('id_kelas'));

        $jumlah_bayar   = $request->input('jumlah_bayar');
        $kosong_bayar   = 0;
        $tahun          = TahunAjaran::where('status_aktif', 1)->first();
        
        $transaksi                  = DB::table('transaksis')->select('kd_nota')->latest('created_at')->first();
        if(empty($transaksi->kd_nota)){
            $int_kd_transaksi           = 1;
        }else{
            $kd_transaksi_potong_awal   = substr($transaksi->kd_nota, 3);
            $kd_transaksi_potong_akhir  = substr($kd_transaksi_potong_awal, -1);
            $int_kd_transaksi           = (int)$kd_transaksi_potong_akhir+1;
        }


        $krr    = explode('-', $request->input('tgl_transaksi'));
        $result = implode("", $krr);

        $kode_nota = 'TRX'.$result.$int_kd_transaksi;

        for($i=0; $i<count($jumlah_bayar); $i++){
            if($jumlah_bayar[$i] !== null){
                Transaksi::create([
                    'tgl_transaksi'         => $request->input('tgl_transaksi'),
                    'id_kelas'              => $request->input('id_kelas'),
                    'id_jenis_pembayaran'   => $request->input('id_jenis_pembayaran')[$i],
                    'jumlah_bayar'          => $request->input('jumlah_bayar')[$i],
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
            return redirect('transaksi')->with(['sukses' => 'Data Berhasil Disimpan']);
        }
    }

    public function nota($id){

        $nota = DB::table('transaksis')
                    ->where('kd_nota', $id)
                    ->Leftjoin('siswas', 'siswas.id_siswa', '=', 'transaksis.id_siswa')
                    ->select('kd_nota', 'tgl_transaksi', 'nama_pembayar', 'keterangan', 'siswas.nama_siswa', 'siswas.nis')
                    ->groupBy('kd_nota')
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
}
