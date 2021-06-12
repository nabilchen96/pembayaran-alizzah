<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use App\Pengeluaran;
use App\RekapTransaksi;
use App\TahunAjaran;
use App\Exports\PengeluaranExport;
use Maatwebsite\Excel\Facades\Excel;

class PengeluaranController extends Controller
{
    public function index(){
        $harian     = DB::table('pengeluarans')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'pengeluarans.id_tahun')
                        ->where('tgl_pengeluaran', date('Y-m-d'))
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->sum('total_harga');

        $bulanan    = DB::table('pengeluarans')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'pengeluarans.id_tahun')
                        ->whereMonth('tgl_pengeluaran', '=', date('m'))
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->sum('total_harga');

        $tahunan    = DB::table('pengeluarans')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'pengeluarans.id_tahun')
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->sum('total_harga');

        $total_transaksi    = DB::table('pengeluarans')
                                ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'pengeluarans.id_tahun')
                                ->where('tahun_ajarans.status_aktif', 1)
                                ->groupBy('kd_nota')
                                ->get();

        $totals = count($total_transaksi);

        return view('pengeluaran.index')
                ->with('totals', $totals)
                ->with('bulanan', $bulanan)
                ->with('tahunan', $tahunan)
                ->with('harian', $harian);
    }

    public function json(){
        $pengeluaran = DB::table('pengeluarans')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'pengeluarans.id_tahun')
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->orderBy('pengeluarans.tgl_pengeluaran', 'DESC')
                        ->get();

        return Datatables::of($pengeluaran)->make(true);
    }

    public function create(Request $request){

        if($request->input('jenis_pengeluaran') == 'Gaji Pegawai'){
            $data = DB::table('set_gajis')
                    ->join('pegawais', 'pegawais.id_pegawai', '=', 'set_gajis.id_pegawai')
                    ->select(
                        'pegawais.nama_pegawai',
                        'pegawais.nip',
                        'pegawais.jenis_pegawai',
                        'pegawais.id_pegawai',
                        DB::raw('sum(gaji_rincian) as total_gaji')
                    )
                    ->groupBy('pegawais.id_pegawai')
                    ->get();

            return view('pengeluaran.gajipegawai')->with('data', $data);
        }else{  
            return view('pengeluaran.pengeluaranlain');            
        }
    }

    public function pengeluaranlain(Request $request){
        $request->validate([
            'tgl_pengeluaran'   => 'required',
            'keterangan'        => 'required',
            'qty'               => 'required',
            'harga_satuan'      => 'required',
            'total_harga'       => 'required'
        ]);

        $tahun          = TahunAjaran::where('status_aktif', 1)->first();
        $transaksi      = DB::table('pengeluarans')
                            ->select('kd_nota')
                            ->where('id_tahun', $tahun->id_tahun)
                            ->latest('created_at')->first();
        
        if(empty($transaksi->kd_nota)){
            $int_kd_transaksi           = 1;
        }else{
            $kd_transaksi_potong_awal   = substr($transaksi->kd_nota, 3);
            $kd_transaksi_potong_akhir  = substr($kd_transaksi_potong_awal, -1);
            $int_kd_transaksi           = (int)$kd_transaksi_potong_akhir+1;
        }

        $krr    = explode('-', $request->input('tgl_pengeluaran'));
        $result = implode("", $krr);

        $kode_nota = 'TRK'.$result.$int_kd_transaksi;

        Pengeluaran::create([
            'tgl_pengeluaran'   => $request->input('tgl_pengeluaran'),
            'keterangan'        => $request->input('keterangan'),
            'qty'               => $request->input('qty'),
            'harga_satuan'      => $request->input('harga_satuan'),
            'total_harga'       => $request->input('total_harga'),
            'id_tahun'          => $tahun->id_tahun,
            'kd_nota'           => $kode_nota
        ]);

        RekapTransaksi::create([
            'tgl_transaksi'     => $request->input('tgl_pengeluaran'),
            'jenis_transaksi'   => 'pengeluaran',
            'jumlah_transaksi'  => $request->input('total_harga'),
            'keterangan'        => $request->input('keterangan'),
            'kd_nota'           => $kode_nota,
            'id_tahun'          => $tahun->id_tahun
        ]);

        return redirect('pengeluaran')->with(['sukses' => 'Data Berhasil Disimpan!']);
    }

    public function gajipegawai(Request $request){
        
        $tahun = DB::table('tahun_ajarans')->where('status_aktif', 1)->first();

        if($request->input('id_pegawai') == null){
            return back()->with(['gagal' => 'Pilih minimal 1 pegawai']);
        }else{
            for($i=0; $i<=count($request->input('id_pegawai'))-1; $i++){
                $gaji = DB::table('set_gajis')
                        ->join('pegawais', 'pegawais.id_pegawai', '=', 'set_gajis.id_pegawai')
                        ->select(
                            'pegawais.nama_pegawai',
                            'pegawais.nip',
                            'pegawais.jenis_pegawai',
                            'pegawais.id_pegawai',
                            DB::raw('sum(gaji_rincian) as total_gaji')
                        )
                        ->where('pegawais.id_pegawai', $request->input('id_pegawai')[$i])
                        ->groupBy('pegawais.id_pegawai')
                        ->first();


                $transaksi      = DB::table('pengeluarans')
                                    ->select('kd_nota')
                                    ->where('id_tahun', $tahun->id_tahun)
                                    ->latest('created_at')->first();
    
    
                if(empty($transaksi->kd_nota)){
                    $int_kd_transaksi           = 1;
                }else{
                    $kd_transaksi_potong_awal   = substr($transaksi->kd_nota, 3);
                    $kd_transaksi_potong_akhir  = substr($kd_transaksi_potong_awal, -1);
                    $int_kd_transaksi           = (int)$kd_transaksi_potong_akhir+1;
                }

                $krr    = explode('-', $request->input('tgl_pengeluaran'));
                $result = implode("", $krr);

                $kode_nota = 'TRK'.$result.$int_kd_transaksi;

                Pengeluaran::create([
                    'tgl_pengeluaran'   => $request->input('tgl_pengeluaran'),
                    'keterangan'        => 'gaji pegawai atas nama '.$gaji->nama_pegawai,
                    'qty'               => 1,
                    'harga_satuan'      => $gaji->total_gaji,
                    'total_harga'       => $gaji->total_gaji * 1,
                    'id_tahun'          => $tahun->id_tahun,
                    'kd_nota'           => $kode_nota
                ]);

                RekapTransaksi::create([
                    'tgl_transaksi'     => $request->input('tgl_pengeluaran'),
                    'jenis_transaksi'   => 'pengeluaran',
                    'jumlah_transaksi'  => $gaji->total_gaji * 1,
                    'keterangan'        => 'gaji pegawai atas nama '.$gaji->nama_pegawai,
                    'kd_nota'           => $kode_nota,
                    'id_tahun'          => $tahun->id_tahun
                ]);
            }
        }

        return redirect('pengeluaran')->with(['sukses' => 'Data Berhasil Disimpan!']);
    }

    public function export(){
        return Excel::download(new PengeluaranExport, 'Data_pengeluaran.xlsx');
    }
}
