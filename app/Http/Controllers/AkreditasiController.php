<?php

namespace App\Http\Controllers;

use App\Models\Akreditasi;
use App\Models\Organization;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\LembagaAkreditasi;
use App\Models\PeringkatAkreditasi;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class AkreditasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('id_perti')) {
            abort_if(Gate::denies('access_data_akreditasi_perti'), 403);
            try{
                $id_perti = request('id_perti');
                $org = Organization::select([
                    'org_defined_id', 'org_nama'
                ])
                ->where('org_defined_id', '=', $id_perti)
                ->first();
    
                if(!$org || !$id_perti){
                    return view('layouts.not_found.half');
                }
    
                return view('akreditasi.perti.index', [
                    'perti' => $org 
                ]);
            }catch(\Exception $e){
                dd($e->getMessage());
            }
           
        } elseif ($request->has('id_prodi')) {

        } else {
            return view('layouts.not_found.half');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->has('id_prodi') && $request->has('id_perti') ) {
            abort_if(Gate::denies('create_data_akreditasi_prodi'), 403);
            $lembaga_s = LembagaAkreditasi::select([
                'id', 'lembaga_nama', 'lembaga_nama_singkat', 'lembaga_logo'
            ])->get();
            $peringkat_s = PeringkatAkreditasi::select([
                'id', 'peringkat_nama', 'peringkat_logo'
            ])->get();
            $prodi = ProgramStudi::select([
                'prodi_defined_id',
            ])
            ->where('prodi_defined_id', '=', request('id_prodi'))
            ->where('id_organization', '=', request('id_perti'))
            ->first();
    
            if(!$prodi || !request('id_prodi') || !request('id_perti')){
                return view('layouts.not_found.half');
            }

            return view('akreditasi.prodi.create', [
                'lembaga_s' => $lembaga_s,
                'peringkat_s' => $peringkat_s,
                'prodi' => $prodi
            ]);

        }elseif ($request->has('id_perti')) {
            abort_if(Gate::denies('create_data_akreditasi_perti'), 403);
            $lembaga_s = LembagaAkreditasi::select([
                'id', 'lembaga_nama', 'lembaga_nama_singkat', 'lembaga_logo'
            ])->get();
            $peringkat_s = PeringkatAkreditasi::select([
                'id', 'peringkat_nama', 'peringkat_logo'
            ])->get();
            $perti = Organization::select([
                'org_nama', 'org_logo'
            ])->where('org_defined_id', '=', request('id_perti'))->first();
    
            if(!$perti || !request('id_perti')){
                return view('layouts.not_found.half');
            }
    
            return view('akreditasi.perti.create', [
                'lembaga_s' => $lembaga_s,
                'peringkat_s' => $peringkat_s,
                'perti' => $perti
            ]);

        } else {
            return view('layouts.not_found.half');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('id_prodi') && $request->has('id_perti') ) {
            abort_if(Gate::denies('create_data_akreditasi_prodi'), 403);
            try{
                $validatedDataAgreement = $request->validate([
                    'agreement' => 'required',
                    'id_user' => 'required|exists:users,id',
                    'id_organization' => 'required|string|exists:organizations,org_defined_id',
                    'id_prodi' => 'required|string|exists:program_studis,prodi_defined_id',
                ]);
    
                if($validatedDataAgreement['id_user'] ==  Auth::User()->id){
                    $id_user = $validatedDataAgreement['id_user'];
                }else{
                    Alert::error('Fail', 'Aktifitas Mencurigakan');
                    return redirect()->route('akreditasi', ['id_perti' => request('id_perti')]);
                }

                if($request->id_prodi != request('id_prodi') || $request->id_perti != request('id_perti')){
                    Alert::error('Fail', 'Aktifitas Mencurigakan');
                    return redirect()->back();
                }
                
                $validatedDataAkreditasi = $request->validate([
                    'akreditasi_sk' => 'required|string',
                    'akreditasi_tgl_dibuat' => 'required|string|date',
                    'akreditasi_tgl_awal' => 'required|string|date',
                    'akreditasi_tgl_akhir' => 'required|string|date',
                    'id_lembaga_akreditasi' => 'required|string|exists:lembaga_akreditasis,id',
                    'id_peringkat_akreditasi' => 'required|string|exists:peringkat_akreditasis,id',
                    'id_prodi' => 'required|string|exists:program_studis,prodi_defined_id',
                    'akreditasi_dokumen' => 'nullable|mimes:pdf|max:2048'
                ]);
                $akreditasi_defined_id =  $this->createDefinedId($validatedDataAkreditasi['akreditasi_sk'].rand(1,99));
                $validatedDataAkreditasi['akreditasi_defined_id'] = $akreditasi_defined_id;

                $filenameSimpanAkreditasi = 'not_set.png';
                if ($request->hasFile('akreditasi_dokumen')) {     
                    $filenameSimpanAkreditasi = $this->generateFilename($request->file('akreditasi_dokumen')->getClientOriginalExtension(),'akreditasi', $request->akreditasi_sk);              
                    $store = $request->file('akreditasi_dokumen')->storeAs('public/organization/akreditasi/', $filenameSimpanAkreditasi);
                }
                $validatedDataAkreditasi['akreditasi_dokumen'] = $filenameSimpanAkreditasi;
    
                $is_active = 'not set';
                $tgl_awal = new \DateTime($request->akreditasi_tgl_awal);
                $tgl_akhir = new \DateTime($request->akreditasi_tgl_akhir);
                $now = new \DateTime();
                // Memeriksa kondisi 1: melewati tgl akhir
                if ($now > $tgl_akhir) {
                    $is_active = 'berakhir';
                } 
                // Memeriksa kondisi 2: di antara tgl awal dan akhir
                elseif ($now >= $tgl_awal && $now <= $tgl_akhir) {
                    $is_active = 'aktif';
                } 
                // Memeriksa kondisi 3: sebelum tgl_awal
                else {
                    $is_active = 'Akan Dimulai';
                }
    
                $validatedDataAkreditasi['akreditasi_status'] = $is_active;
                $validatedDataAkreditasi['id_user'] = $id_user;

                Akreditasi::create($validatedDataAkreditasi);
                Alert::success('Sukses', 'Data Ditambahkan');
                return redirect()->route('perguruan-tinggi.show', ['perguruan_tinggi' => request('id_perti')]);


            }catch(\Exception $e){
                dd($e->getMessage());
            }
        }elseif ($request->has('id_perti')) {
            abort_if(Gate::denies('create_data_akreditasi_perti'), 403);
            try{
                $validatedDataAgreement = $request->validate([
                    'agreement' => 'required',
                    'id_user' => 'required|exists:users,id',
                    'id_organization' => 'required|string|exists:organizations,org_defined_id',
                ]);
    
                if($validatedDataAgreement['id_user'] ==  Auth::User()->id){
                    $id_user = $validatedDataAgreement['id_user'];
                }else{
                    Alert::error('Fail', 'Aktifitas Mencurigakan');
                    return redirect()->route('akreditasi', ['id_perti' => request('id_perti')]);
                }
    
                if($request->id_organization != request('id_perti')){
                    Alert::error('Fail', 'Aktifitas Mencurigakan');
                    return redirect()->route('akreditasi', ['id_perti' => request('id_perti')]);
                }
    
                $validatedDataAkreditasi = $request->validate([
                    'akreditasi_sk' => 'required|string',
                    'akreditasi_tgl_dibuat' => 'required|string|date',
                    'akreditasi_tgl_awal' => 'required|string|date',
                    'akreditasi_tgl_akhir' => 'required|string|date',
                    'id_lembaga_akreditasi' => 'required|string|exists:lembaga_akreditasis,id',
                    'id_peringkat_akreditasi' => 'required|string|exists:peringkat_akreditasis,id',
                    'id_organization' => 'required|string|exists:organizations,org_defined_id',
                    'akreditasi_dokumen' => 'nullable|mimes:pdf|max:2048'
                ]);
                $akreditasi_defined_id =  $this->createDefinedId($validatedDataAkreditasi['akreditasi_sk'].rand(1,99));
                $validatedDataAkreditasi['akreditasi_defined_id'] = $akreditasi_defined_id;
    
                $filenameSimpanAkreditasi = 'not_set.png';
                if ($request->hasFile('akreditasi_dokumen')) {     
                    $filenameSimpanAkreditasi = $this->generateFilename($request->file('akreditasi_dokumen')->getClientOriginalExtension(),'akreditasi', $request->akreditasi_sk);              
                    $store = $request->file('akreditasi_dokumen')->storeAs('public/organization/akreditasi/', $filenameSimpanAkreditasi);
                }
                $validatedDataAkreditasi['akreditasi_dokumen'] = $filenameSimpanAkreditasi;
    
                $is_active = 'not set';
                $tgl_awal = new \DateTime($request->akreditasi_tgl_awal);
                $tgl_akhir = new \DateTime($request->akreditasi_tgl_akhir);
                $now = new \DateTime();
                // Memeriksa kondisi 1: melewati tgl akhir
                if ($now > $tgl_akhir) {
                    $is_active = 'berakhir';
                } 
                // Memeriksa kondisi 2: di antara tgl awal dan akhir
                elseif ($now >= $tgl_awal && $now <= $tgl_akhir) {
                    $is_active = 'aktif';
                } 
                // Memeriksa kondisi 3: sebelum tgl_awal
                else {
                    $is_active = 'Akan Dimulai';
                }
    
                $validatedDataAkreditasi['akreditasi_status'] = $is_active;
                $validatedDataAkreditasi['id_user'] = $id_user;
    
                Akreditasi::create($validatedDataAkreditasi);
                Alert::success('Sukses', 'Data Ditambahkan');
                return redirect()->route('perguruan-tinggi.show', ['perguruan_tinggi' => request('id_perti')]);
    
            }catch(\Exception $e){
                dd($e->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Akreditasi $akreditasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Akreditasi $akreditasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Akreditasi $akreditasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Akreditasi $akreditasi)
    {
        //
    }

    public function akreditasibyidpertiprodijson($id_perti_prodi, $byperti_prodi ){
        $akreditasis = Akreditasi::select([
            'akreditasis.akreditasi_defined_id',
            'akreditasis.akreditasi_sk',
            'akreditasis.akreditasi_tgl_dibuat',
            'akreditasis.akreditasi_tgl_awal',
            'akreditasis.akreditasi_tgl_akhir',
            'akreditasis.akreditasi_status',
            'akreditasis.akreditasi_dokumen',
            'peringkat_akreditasis.peringkat_nama',
            'peringkat_akreditasis.peringkat_logo',
            'lembaga_akreditasis.lembaga_nama',
            'lembaga_akreditasis.lembaga_nama_singkat',
            'lembaga_akreditasis.lembaga_logo',
        ])
        ->leftJoin('peringkat_akreditasis', function ($join) {
            $join->on('peringkat_akreditasis.id', '=', 'akreditasis.id_peringkat_akreditasi');
        })
        ->leftJoin('lembaga_akreditasis', function ($join) {
            $join->on('lembaga_akreditasis.id', '=', 'akreditasis.id_lembaga_akreditasi');
        })
        ->where($byperti_prodi, '=', $id_perti_prodi)
        ->get();

        return Datatables::of($akreditasis)->make(true);

    }


}
