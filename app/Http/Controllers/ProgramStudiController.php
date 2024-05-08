<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use App\Http\Requests\StoreProgramStudiRequest;
use App\Http\Requests\UpdateProgramStudiRequest;
use App\Models\Akreditasi;
use App\Models\Akta;
use App\Models\LembagaAkreditasi;
use App\Models\Organization;
use App\Models\PeringkatAkreditasi;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\Datatables\Datatables;



class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('access_data_program_studi'), 403);
        $id_perti = request('id_perti');
        $org = Organization::select([
            'org_defined_id', 'org_nama'
        ])
        ->where('org_defined_id', '=', $id_perti)
        ->first();

        if(!$org){
            return view('layouts.not_found.half');
        }

        return view('program_studi.index', [
            'perti' => $org
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        abort_if(Gate::denies('create_data_program_studi'), 403);

        $id_perti = $request->input('id_perti');
        $organization = Organization::select([
            'org_defined_id', 'org_nama'
        ])
        ->where('org_defined_id', '=', $id_perti)
        ->where('id_organization_type', 3)
        ->first();

        if (!$id_perti || !$organization) {
            return response()->view('layouts.not_found.half', [], 403);
        }else{
            return view('program_studi.create', [
                
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramStudiRequest $request)
    {
        abort_if(Gate::denies('create_data_program_studi'), 403);
        try {
            $validatedDataAgreement = $request->validate([
                'agreement' => 'required',
                'id_user' => 'required|exists:users,id',
                'id_organization' => 'required|exists:organizations,org_defined_id'
            ],[
                'agreement.required' => 'Anda harus mengkonfirmasi kebijakan penggunaan data pribadi.',
                'id_user.required' => 'ID pengguna harus diisi.',
                'id_user.exists' => 'ID pengguna yang dipilih tidak valid.',
                'id_organization.required' => 'Perguruan tinggi harus dipilih.',
                'id_organization.exists' => 'Perguruan tinggi yang dipilih tidak valid.'
            ]);

            if($validatedDataAgreement['id_user'] ==  Auth::User()->id){
                $id_user = $validatedDataAgreement['id_user'];
            }else{
                Alert::error('Fail', 'Aktifitas Mencurigakan');
                return redirect()->route('perguruan-tinggi.show', ['id_perti' => request('id_perti')]);
            }

            //validated Data Perti
            if($validatedDataAgreement['id_organization'] !=  request('id_perti')){
                Alert::error('Fail', 'Aktifitas Mencurigakan');
                return redirect()->route('perguruan-tinggi.show', ['id_perti' => request('id_perti')]);
            }

            $validatedDataDigit = $request->validate([
                'kode_prodi_digits.*' => 'required|numeric|digits:1'
            ],[
                'kode_prodi_digits.*.required' => 'Setiap digit kode Prodi harus diisi.',
                'kode_prodi_digits.*.numeric' => 'Setiap digit kode Prodi harus berupa angka.',
                'kode_prodi_digits.*.digits' => 'Setiap digit kode Prodi harus berupa angka.'

            ]);
            $digits = $request->input('kode_prodi_digits');
            $prodi_kode = implode('', $digits);
            $id_organization = $validatedDataAgreement['id_organization'];

            // dd($prodi_kode);

            $validatedDataProdi = $request->validate([
                'prodi_nama' => 'required|string',
                'prodi_jenjang' => 'required|string',
                'prodi_active_status' => 'required|in:Aktif,Tidak Aktif',
            ],[
                'prodi_nama.required' => 'Nama program studi harus diisi.',
                'prodi_nama.string' => 'Nama program studi harus berupa teks.',
            
                'prodi_jenjang.required' => 'Jenjang program studi harus diisi.',
                'prodi_jenjang.string' => 'Jenjang program studi harus berupa teks.',
            
                'prodi_active_status.required' => 'Status aktif program studi harus dipilih.',
                'prodi_active_status.in' => 'Status aktif program studi harus salah satu dari "Aktif" atau "Tidak Aktif".'
            ]
            );

            $prodi_defined_id = $this->createDefinedId($prodi_kode);

            $validatedDataProdi['prodi_defined_id'] = $prodi_defined_id;
            $validatedDataProdi['id_organization'] = $id_organization;
            $validatedDataProdi['prodi_kode'] = $prodi_kode;
            $validatedDataProdi['id_user'] = $id_user;

            // dd($validatedDataProdi);

            $validatedDataAkta = $request->validate([
                'akta_nomor' => 'required|string',
                'akta_tgl_dibuat' => 'required|date',
                'akta_nama_atau_pengesah' => 'required|string',
                'akta_kota_notaris' => 'required|string',
                'akta_jenis' => 'required|in:Pendirian,Pembaruan',
                'akta_perihal' => 'required|max:200',
                'akta_dokumen' => 'nullable|mimes:pdf|max:2048'
            ],[
                'akta_nomor.required' => 'Nomor SK harus diisi.',
                'akta_nomor.string' => 'Nomor SK harus berupa teks.',
            
                'akta_tgl_dibuat.required' => 'Tanggal pembuatan SK harus diisi.',
                'akta_tgl_dibuat.date' => 'Tanggal pembuatan SK harus dalam format tanggal yang valid.',
            
                'akta_nama_atau_pengesah.required' => 'Nama atau pengesah SK harus diisi.',
                'akta_nama_atau_pengesah.string' => 'Nama atau pengesah SK harus berupa teks.',
            
                'akta_kota_notaris.required' => 'Kota notaris SK harus diisi.',
                'akta_kota_notaris.string' => 'Kota notaris SK harus berupa teks.',
            
                'akta_jenis.required' => 'Jenis SK harus diisi.',
                'akta_jenis.in' => 'Jenis SK harus salah satu dari "Pendirian" atau "Pembaruan".',
            
                'akta_perihal.required' => 'Perihal SK harus diisi.',
                'akta_perihal.max' => 'Perihal SK tidak boleh melebihi 200 karakter.',
            
                'akta_dokumen.nullable' => 'Dokumen SK harus berupa file PDF.',
                'akta_dokumen.mimes' => 'Format file SK harus PDF.',
                'akta_dokumen.max' => 'Ukuran file SK tidak boleh melebihi 2 MB.'
            ]
            );
            $akta_defined_id = $this->createDefinedId(Akta::count()+1);
            $filenameSimpanAkta = 'not_set.png';
            if ($request->hasFile('akta_dokumen')) {
                $filenameSimpanAkta = $this->generateFilename($request->file('akta_dokumen')->getClientOriginalExtension(), 'akta_dokumen', $akta_defined_id);
                $storeAkta = $request->file('akta_dokumen')->storeAs('public/organization/akta/', $filenameSimpanAkta);
            }

            $validatedDataAkta['akta_defined_id'] = $akta_defined_id;
            $validatedDataAkta['id_user'] =  $id_user;
            $validatedDataAkta['id_prodi'] = $prodi_defined_id;
            $validatedDataAkta['akta_dokumen'] = $filenameSimpanAkta;

            // dd($validatedDataAkta); 
            $validatedDataAkreditasi = [
                'akreditasi_defined_id'=> $this->createDefinedId($prodi_defined_id.rand(1,1000)),
                'id_prodi' => $prodi_defined_id 
            ]; 

            DB::beginTransaction();
            try {
                ProgramStudi::create($validatedDataProdi);
                Akta::create($validatedDataAkta);
                // Akreditasi::create($validatedDataAkreditasi);

                DB::commit();
                Alert::success('Success', 'Data Telah Tersimpan');
                return redirect()->route('perguruan-tinggi.show', ['perguruan_tinggi' => $id_organization]);

            } catch (\Exception $e) {
                DB::rollback();
                dd($e->getMessage());
            }

            abort(404);

        } catch (\Exception $e) {
            // dd($e->getMessage());
            Alert::error('Fail', $e->getMessage());
            return redirect()->route('program-studi.create', ['id_perti'=>$id_organization])->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_prodi)
    {
        abort_if(Gate::denies('access_data_akreditasi_prodi'), 403);
        $id_perti = request('id_perti');
        $prodi = ProgramStudi::select([
            'program_studis.prodi_defined_id',
            'organizations.org_nama',
            'program_studis.prodi_nama',
            'program_studis.prodi_jenjang'
        ])
        ->join('organizations', 'organizations.org_defined_id', '=', 'program_studis.id_organization')
        ->where('prodi_defined_id', '=', $id_prodi)
        ->where('id_organization', '=', $id_perti)
        ->first();

        if(!$prodi || !$id_perti){
            return view('layouts.not_found.half');
        }

        return view('program_studi.detail', [
            'prodi' => $prodi,
            'id_perti' => $id_perti
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramStudi $programStudi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgramStudiRequest $request, ProgramStudi $programStudi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramStudi $programStudi)
    {
        //
    }

    public function prodibyidpertijson($id_perti){
        $prodibyidperti = ProgramStudi::select([
            'prodi_nama',
            'prodi_kode',
            'prodi_defined_id',
            'prodi_jenjang',
            'prodi_active_status',
            'akreditasis.akreditasi_sk',
            'peringkat_akreditasis.peringkat_nama',
            'lembaga_akreditasis.lembaga_nama'
        ])
        ->leftJoin('akreditasis', function ($join) {
            $join->on('akreditasis.id_prodi', '=', 'program_studis.prodi_defined_id');
        })
        ->leftJoin('peringkat_akreditasis', function ($join) {
            $join->on('peringkat_akreditasis.id', '=', 'akreditasis.id_peringkat_akreditasi');
        })
        ->leftJoin('lembaga_akreditasis', function ($join) {
            $join->on('lembaga_akreditasis.id', '=', 'akreditasis.id_lembaga_akreditasi');
        })
        ->where('program_studis.id_organization', '=', $id_perti)
        ->orderBy('akreditasis.akreditasi_tgl_awal', 'asc')
        ->get();
    
        return Datatables::of($prodibyidperti)->make(true);
    
    }
}


