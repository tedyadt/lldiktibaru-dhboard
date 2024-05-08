<?php

namespace App\Http\Controllers;

use App\Models\Akta;
use App\Models\Organization;
use Yajra\Datatables\Datatables;
use App\Models\OrganizationStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreAktaRequest;
use App\Http\Requests\UpdateAktaRequest;
use RealRashid\SweetAlert\Facades\Alert;


class AktaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create_data_akta_perti'), 403);
        $perti = Organization::select([
            'org_nama', 'org_logo'
        ])->where('org_defined_id', '=', request('id_perti'))->first();

        if(!$perti || !request('id_perti')){
            return view('layouts.not_found.half');
        }

        return  view('akta.create', [
            'perti' => $perti
        ]);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAktaRequest $request)
    {
        try{

            $validatedDataAgreement = $request->validate([
                'agreement' => 'required',
                'id_user' => 'required|exists:users,id'
            ]);

            if($validatedDataAgreement['id_user'] ==  Auth::User()->id){
                $id_user = $validatedDataAgreement['id_user'];
            }else{
                Alert::error('Fail', 'Aktifitas Mencurigakan');
                return redirect()->route('perguruan-tinggi', ['id_perti' => request('id_perti')]);
            }

            $validatedDataOrg = $request->validate([
                'id_organization' => 'required|exists:organizations,org_defined_id'
            ]);
            $validatedDataAkta = $request->validate([
                'akta_nomor' => 'required|string',
                'akta_tgl_dibuat' => 'required|date',
                'akta_nama_atau_pengesah' => 'required|string',
                'akta_perihal' => 'required',
                'akta_jenis' => 'sometimes|in:Pendirian,Pembaruan',
                'akta_dokumen' => 'sometimes|mimes:pdf|max:18000'
            ]);
            $akta_defined_id = $this->createDefinedId(Akta::count()+1);
            $filenameSimpanAkta = 'not_set.png';
            if ($request->hasFile('akta_dokumen')) {
                $filenameSimpanAkta = $this->generateFilename($request->file('akta_dokumen')->getClientOriginalExtension(), 'akta_dokumen', $akta_defined_id);
                $storeAkta = $request->file('akta_dokumen')->storeAs('public/organization/akta/', $filenameSimpanAkta);
            }
            $validatedDataAkta['akta_defined_id'] = $akta_defined_id;
            $validatedDataAkta['id_user'] =  $id_user;
            $validatedDataAkta['id_organization'] = $validatedDataOrg['id_organization'];
            $validatedDataAkta['akta_dokumen'] = $filenameSimpanAkta;
            $validatedDataAkta['akta_jenis'] = $request->input('akta_jenis', 'Pendirian' );

            $validatedDataOrgStatus = [
                'id_organization' => $validatedDataOrg['id_organization'],
                'org_status' => $request->input('org_status', 'Aktif'),
                'id_akta' => $akta_defined_id
            ];

            DB::beginTransaction();
            try{

                Akta::create($validatedDataAkta);
                OrganizationStatus::create($validatedDataOrgStatus);

                DB::commit();

                Alert::success('Success', 'Data Telah Tersimpan');
                return redirect()->route('perguruan-tinggi.show', $validatedDataOrg['id_organization']);

            }catch(\Exception $e){
                DB::rollback();
                dd($e->getMessage());

                // Alert::error('Fail', 'Data Gagal Disimpan');
                // return redirect()->route('badan-penyelenggara');
            }



        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Akta $akta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Akta $akta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAktaRequest $request, Akta $akta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Akta $akta)
    {
        //
    }

    public function aktabyidpertijson($id_perti){
        $akta = Akta::select([
            'aktas.akta_nomor',
            'aktas.akta_defined_id',
            'aktas.akta_tgl_dibuat', 
            'aktas.akta_nama_atau_pengesah',
            'aktas.akta_perihal',
            'aktas.akta_jenis',
            'aktas.akta_dokumen',
            'organization_statuses.org_status'
        ])
        ->join('organization_statuses', 'organization_statuses.id_akta', '=', 'aktas.akta_defined_id')
        ->where('aktas.id_organization', '=', $id_perti)
        ->get();

        return Datatables::of($akta)->make(true);
    }
}
