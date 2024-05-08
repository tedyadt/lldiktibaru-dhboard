<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\BeritaAcaraPerkara;
use App\Models\BeritaAcaraPerkaraStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class BeritaAcaraPerkaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('access_perkara_perguruan_tinggi'), 403);

        $id_perti = request('id_perti');
        $org = Organization::select([
            'org_defined_id', 'org_nama'
        ])
        ->where('org_defined_id', '=', $id_perti)
        ->first();

        if(!$org){
            return view('layouts.not_found.half');
        }

        return view('berita_acara_perkara.index', [
            'perti' => $org
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create_perkara_perguruan_tinggi'), 403);
        $perti = Organization::select([
            'org_nama', 'org_logo'
        ])->where('org_defined_id', '=', request('id_perti'))->first();

        if(!$perti || !request('id_perti')){
            return view('layouts.not_found.half');
        }

        return  view('berita_acara_perkara.create', [
            'perti' => $perti
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('create_perkara_perguruan_tinggi'), 403);
        // dd($request);
        try{
            $validatedDataAgreement = $request->validate([
                'agreement' => 'required',
                'id_user' => 'required|exists:users,id',
                'id_organization' => 'required|exists:organizations,org_defined_id'
            ]);
    
            if($validatedDataAgreement['id_user'] ==  Auth::User()->id){
                $id_user = $validatedDataAgreement['id_user'];
            }else{
                Alert::error('Fail', 'Aktifitas Mencurigakan');
                return redirect()->route('berita-acara-perkara', ['id_perti' => request('id_perti')]);
            }
    
            if($validatedDataAgreement['id_organization'] != request('id_perti')){
                Alert::error('Fail', 'Aktifitas Mencurigakan');
                return redirect()->route('berita-acara-perkara', ['id_perti' => request('id_perti')]);
            }
        
            $validatedDataBAP = $request->validate([
                'bap_perkara' => 'required|string',
            ]);
            $bap_defined_id =  $this->createDefinedId(BeritaAcaraPerkara::count()+1+rand(1,99));
            $validatedDataBAP['bap_defined_id'] = $bap_defined_id;
            $validatedDataBAP['id_organization'] = $validatedDataAgreement['id_organization'];
            $validatedDataBAP['id_user'] = $id_user;
    
            $validatedDataBAPStatus = $request->validate([
                'bap_status' => 'required|in:Belum Diproses,Sedang Diproses,Selesai Diproses',
                'bap_keterangan' => 'nullable|string',
            ]);
            $validatedDataBAPStatus['id_bap'] = $bap_defined_id;
            $validatedDataBAPStatus['id_user'] = $id_user;

            DB::beginTransaction();
            try{

                BeritaAcaraPerkara::create($validatedDataBAP);
                BeritaAcaraPerkaraStatus::create($validatedDataBAPStatus);

                DB::commit();

                Alert::success('Success', 'Data Telah Tersimpan');
                return redirect()->route('perguruan-tinggi.show', ['perguruan_tinggi' => request('id_perti')]);

            }catch(\Exception $e){
                DB::rollback();
                // dd($e->getMessage());

                Alert::error('Fail', 'Data Gagal Disimpan');
                return redirect()->route('berita-acara-perkara.create', ['id_perti' => request('id_perti')]);
            }

    
        }catch(\Exception $e){
            // dd($e->getMessage());
                Alert::error('Fail', 'Data Gagal Disimpan');
                return redirect()->route('berita-acara-perkara.create', ['id_perti' => request('id_perti')]);
        }        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $bap_defined_id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BeritaAcaraPerkara $beritaAcaraPerkara)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BeritaAcaraPerkara $beritaAcaraPerkara)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BeritaAcaraPerkara $beritaAcaraPerkara)
    {
        //
    }

    public function createstatus(Request $request){
        abort_if(Gate::denies('edit_perkara_perguruan_tinggi'), 403);
        // dd($request);
        try{
            $validatedDataAgreement = $request->validate([
                'agreement' => 'required',
                'id_user' => 'required|exists:users,id',
                'bap_defined_id' => 'required|exists:berita_acara_perkaras,bap_defined_id'
            ]);
            
            if($validatedDataAgreement['id_user'] ==  Auth::User()->id){
                $id_user = $validatedDataAgreement['id_user'];
            }else{
                Alert::error('Fail', 'Aktifitas Mencurigakan');
                return redirect()->route('berita-acara-perkara', ['id_perti' => request('id_perti')]);
            }
    
            if($validatedDataAgreement['bap_defined_id'] != request('id_bap')){
                Alert::error('Fail', 'Aktifitas Mencurigakan');
                return redirect()->route('berita-acara-perkara', ['id_perti' => request('id_perti')]);
            }

            $validatedDataBAPStatus = $request->validate([
                'bap_status' => 'required|in:Belum Diproses,Sedang Diproses,Selesai Diproses',
                'bap_keterangan' => 'nullable|string',
            ]);
            $validatedDataBAPStatus['id_bap'] = $validatedDataAgreement['bap_defined_id'];
            $validatedDataBAPStatus['id_user'] = $id_user;

            BeritaAcaraPerkaraStatus::create($validatedDataBAPStatus);

            Alert::success('Success', 'Data Telah Tersimpan');
            return redirect()->back();

        }catch(\Exception $e){
            dd($e->getMessage());
        }

    }

    public function beritaacaraperkarabyidorganization($id_orgainzation){
        $bap = BeritaAcaraPerkara::select([
            'berita_acara_perkaras.bap_perkara', 
            'berita_acara_perkaras.bap_defined_id',
            'berita_acara_perkara_statuses.bap_status',
            'berita_acara_perkara_statuses.bap_keterangan'
        ])
        ->join('berita_acara_perkara_statuses', function ($join) {
            $join->on('berita_acara_perkara_statuses.id_bap', '=', 'berita_acara_perkaras.bap_defined_id')
                 ->whereRaw('berita_acara_perkara_statuses.id = 
                    (SELECT MAX(id) FROM berita_acara_perkara_statuses 
                    WHERE berita_acara_perkara_statuses.id_bap = berita_acara_perkaras.bap_defined_id)');
        })        
        ->where('id_organization', '=', $id_orgainzation)
        ->get();

        return Datatables::of($bap)->make(true);

    }

    public function statusdetail($id_bap){
        $bap_status = BeritaAcaraPerkaraStatus::select([
            'bap_status', 'bap_keterangan', 'created_at'
        ])
        ->where('id_bap', $id_bap)
        ->get();

        return Datatables::of($bap_status)->make(true);
    }
}
