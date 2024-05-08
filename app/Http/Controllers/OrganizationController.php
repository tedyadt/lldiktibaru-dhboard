<?php

namespace App\Http\Controllers;

use App\Models\Akta;
use App\Models\Akreditasi;
use App\Models\Organization;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\LembagaAkreditasi;
use Illuminate\Support\Facades\DB;
use App\Models\PeringkatAkreditasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use App\Models\Kepemilikan;
use App\Models\Kumham;
use App\Models\OrganizationStatus;
use App\Models\PimpinanOrganisasi;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if($request->is('badan-penyelenggara*')) {
            abort_if(Gate::denies('access_data_badan_penyelenggara'), 403);

            return view('badan_penyelenggara.index');
        } elseif ($request->is('perguruan-tinggi*')) {
            abort_if(Gate::denies('access_data_perguruan_tinggi'), 403);

            return view('perguruan_tinggi.index');
        } else {
            abort(404);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if($request->is('badan-penyelenggara*')) {
            abort_if(Gate::denies('create_data_badan_penyelenggara'), 403);
            return view('badan_penyelenggara.create');
        } elseif ($request->is('perguruan-tinggi*')) {
            abort_if(Gate::denies('create_data_perguruan_tinggi'), 403);

            $badanPenyelenggara_s = Organization::select([
                'organizations.org_defined_id', 'organizations.org_nama', 'organizations.org_logo', 'organization_statuses.org_status'
            ])
            ->join('organization_statuses', 'organization_statuses.id_organization', '=', 'organizations.org_defined_id')->latest('organization_statuses.created_at')
            ->where('organizations.id_organization_type', '=', 2)
            ->get();
            return view('perguruan_tinggi.create', [
                'badanPenyelenggara_s' => $badanPenyelenggara_s
            ]);
        } else {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizationRequest $request)
    {
        if($request->is('badan-penyelenggara*')) {
            abort_if(Gate::denies('create_data_badan_penyelenggara'), 403);
            try{
                $validatedDataAgreement = $request->validate([
                    'agreement' => 'required',
                    'id_user' => 'required|exists:users,id'
                ],[
                    'agreement.required' => 'Anda harus mengkonfirmasi kebijakan penggunaan data pribadi.',
                    'id_user.required' => 'ID pengguna harus diisi.',
                    'id_user.exists' => 'ID pengguna yang dipilih tidak valid.'
                ]);

                if($validatedDataAgreement['id_user'] ==  Auth::User()->id){
                    $id_user = $validatedDataAgreement['id_user'];
                }else{
                    return false;
                }

                $validatedDataOrg = $request->validate([
                    'org_nama' => 'required|string',
                    'org_nama_singkat' => 'required|string',
                    'org_alamat' => 'required|string',
                    'org_kota' => 'required|string',
                    'org_email' => 'nullable|email|unique:organizations,org_email',
                    'org_website' => 'nullable|unique:organizations,org_website',
                    'org_telp' => 'nullable|unique:organizations,org_telp|max:18',
                    'org_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:5000'
                ], 
                [
                    'org_nama.required' => 'Kolom nama badan penyelenggara harus diisi.',
                    'org_nama.string' => 'Nama badan penyelenggara harus berupa teks.',
                    'org_nama_singkat.required' => 'Kolom akronim badan penyelenggara harus diisi.',
                    'org_nama_singkat.string' => 'Akronim badan penyelenggara harus berupa teks.',
                    'org_alamat.required' => 'Kolom alamat badan penyelenggara harus diisi.',
                    'org_alamat.string' => 'Alamat badan penyelenggara harus berupa teks.',
                    'org_kota.required' => 'Kolom kota badan penyelenggara harus diisi.',
                    'org_kota.string' => 'Kota badan penyelenggara harus berupa teks.',
                    'org_email.email' => 'Email badan penyelenggara harus berupa alamat email yang valid.',
                    'org_email.unique' => 'Email badan penyelenggara sudah digunakan.',
                    'org_website.unique' => 'Website badan penyelenggara sudah digunakan.',
                    'org_telp.unique' => 'Nomor telepon badan penyelenggara sudah digunakan.',
                    'org_telp.max' => 'Nomor telepon badan penyelenggara tidak boleh lebih dari :max karakter.',
                    'org_logo.image' => 'Logo badan penyelenggara harus berupa gambar.',
                    'org_logo.mimes' => 'Format logo badan penyelenggara harus: jpeg, png, jpg.',
                    'org_logo.max' => 'Ukuran logo badan penyelenggara tidak boleh lebih dari :max kilobita.',
                ]);
                $org_defined_id = $this->createDefinedId(Organization::count()+1);
                $id_organization_type = 2; //2 karena 2 adalah badan penyelenggara
                $filenameSimpanOrg = 'not_set.png';
                if ($request->hasFile('org_logo')) {
                    $filenameSimpanOrg = $this->generateFilename($request->file('org_logo')->getClientOriginalExtension(), 'Logo_BP', $org_defined_id);
                    $storeOrg = $request->file('org_logo')->storeAs('public/organization/logo/', $filenameSimpanOrg);
                }

                $validatedDataOrg['org_kode'] = $this->generateIdLength(Organization::count()+1 ,6);
                $validatedDataOrg['org_defined_id'] = $org_defined_id;
                $validatedDataOrg['id_user'] = $id_user;
                $validatedDataOrg['org_logo'] = $filenameSimpanOrg;
                $validatedDataOrg['id_organization_type'] = $id_organization_type;                
                // dd($validatedDataOrg);

                $validatedDataAkta = $request->validate([
                    'akta_nomor' => 'required|string',
                    'akta_tgl_dibuat' => 'required|date',
                    'akta_nama_atau_pengesah' => 'required|string',
                    'akta_kota_notaris' => 'required|string',
                    'akta_jenis' => 'required|in:Pendirian,Pembaruan',
                    'akta_perihal' => 'required|max:200',
                    'akta_dokumen' => 'nullable|mimes:pdf|max:18000'
                ],
                [
                    'akta_nomor.required' => 'Kolom nomor akta harus diisi.',
                    'akta_nomor.string' => 'Kolom nomor akta harus berupa teks.',
                
                    'akta_tgl_dibuat.required' => 'Kolom tanggal pembuatan akta harus diisi.',
                    'akta_tgl_dibuat.date' => 'Kolom tanggal pembuatan akta harus dalam format tanggal yang valid.',
                
                    'akta_nama_atau_pengesah.required' => 'Kolom nama notaris akta harus diisi.',
                    'akta_nama_atau_pengesah.string' => 'Kolom nama notaris akta harus berupa teks.',
                
                    'akta_kota_notaris.required' => 'Kolom kota notaris harus diisi.',
                    'akta_kota_notaris.string' => 'Kolom kota notaris harus berupa teks.',
                
                    'akta_jenis.required' => 'Kolom jenis akta harus diisi.',
                    'akta_jenis.in' => 'Kolom jenis akta harus salah satu dari "Pendirian" atau "Pembaruan".',
                
                    'akta_perihal.required' => 'Kolom perihal akta harus diisi.',
                    'akta_perihal.max' => 'Kolom perihal akta tidak boleh lebih dari 200 karakter.',
                
                    'akta_dokumen.mimes' => 'Dokumen akta harus dalam format PDF.',
                    'akta_dokumen.max' => 'Ukuran dokumen akta tidak boleh melebihi 18 MB.'
                ]);
                $akta_defined_id = $this->createDefinedId(Akta::count()+1);
                $filenameSimpanAkta = 'not_set.png';
                if ($request->hasFile('akta_dokumen')) {
                    $filenameSimpanAkta = $this->generateFilename($request->file('akta_dokumen')->getClientOriginalExtension(), 'akta_dokumen', $akta_defined_id);
                    $storeAkta = $request->file('akta_dokumen')->storeAs('public/organization/akta/', $filenameSimpanAkta);
                }
                $validatedDataAkta['akta_defined_id'] = $akta_defined_id;
                $validatedDataAkta['id_user'] =  $id_user;
                $validatedDataAkta['id_organization'] = $org_defined_id;
                $validatedDataAkta['akta_dokumen'] = $filenameSimpanAkta;

                $validatedDataOrgStatus = [
                    'org_status' => 'Aktif',
                    'id_organization' => $org_defined_id,
                    'id_akta' => $akta_defined_id
                ];

                $validatedDatakumham = $request->validate([
                    'kumham_nomor_sk' => 'nullable',
                    'kumham_tgl_sk' => 'nullable|date', 
                    'kumham_dokumen' => 'nullable|mimes:pdf|max:18000'
                ],
                [
                    'kumham_nomor_sk.nullable' => 'Kolom nomor SK Kementerian Hukum dan HAM boleh kosong.',
                    
                    'kumham_tgl_sk.nullable' => 'Kolom tanggal SK Kementerian Hukum dan HAM boleh kosong.',
                    'kumham_tgl_sk.date' => 'Kolom tanggal SK Kementerian Hukum dan HAM harus dalam format tanggal yang valid.',
                
                    'kumham_dokumen.nullable' => 'Kolom dokumen SK Kementerian Hukum dan HAM boleh kosong.',
                    'kumham_dokumen.mimes' => 'Dokumen SK Kementerian Hukum dan HAM harus dalam format PDF.',
                    'kumham_dokumen.max' => 'Ukuran dokumen SK Kementerian Hukum dan HAM tidak boleh melebihi 18 MB.'
                ]);
                $validatedDatakumham['id_akta'] = $akta_defined_id;
                $validatedDatakumham['id_user'] =  $id_user;
                $filenameSimpanKumham = 'not_set.png';
                if ($request->hasFile('kumham_dokumen')) {     
                    $filenameSimpanKumham = $this->generateFilename($request->file('kumham_dokumen')->getClientOriginalExtension(),'Kumham', $akta_defined_id);              
                    $storeKumham = $request->file('kumham_dokumen')->storeAs('public/organization/kumham/', $filenameSimpanKumham);
                }
                $validatedDatakumham['kumham_dokumen'] = $filenameSimpanKumham;

                // dd($validatedDatakumham);

                DB::beginTransaction();
                try{

                    Organization::create($validatedDataOrg);
                    Akta::create($validatedDataAkta);
                    OrganizationStatus::create($validatedDataOrgStatus);
                    Kumham::create($validatedDatakumham);

                    DB::commit();

                    Alert::success('Success', 'Data Telah Tersimpan');
                    return redirect()->route('badan-penyelenggara');

                }catch(\Exception $e){
                    DB::rollback();
                    // dd($e->getMessage());

                    Alert::error('Fail', 'Data Gagal Disimpan');
                    return redirect()->route('badan-penyelenggara.create')->withInput()->withErrors($e->getMessage());
                }


            }catch(\Exception $e){
                Alert::error('Fail', 'Data Gagal Disimpan');
                return redirect()->route('badan-penyelenggara.create')->withInput()->withErrors($e->getMessage());
            }


        } elseif ($request->is('perguruan-tinggi*')) {
            abort_if(Gate::denies('create_data_perguruan_tinggi'), 403);
            // dd($request);
            try{
                $validatedDataDigit = $request->validate([
                    'kode_pt_digits.*' => 'required|numeric|digits:1'
                ],[
                    'kode_pt_digits.*.required' => 'Setiap digit kode PT harus diisi.',
                    'kode_pt_digits.*.numeric' => 'Setiap digit kode PT harus berupa angka.',
                    'kode_pt_digits.*.digits' => 'Setiap digit kode PT harus berupa angka.'
                ]);
                
                $digits = $request->input('kode_pt_digits');
                $org_kode = implode('', $digits);

                $validatedDataAgreement = $request->validate([
                    'agreement' => 'required',
                    'id_user' => 'required|exists:users,id'
                ],[
                    'agreement.required' => 'Anda harus mengkonfirmasi kebijakan penggunaan data pribadi.',
                    'id_user.required' => 'ID pengguna harus diisi.',
                    'id_user.exists' => 'ID pengguna yang dipilih tidak valid.'
                ]);

                if($validatedDataAgreement['id_user'] ==  Auth::User()->id){
                    $id_user = $validatedDataAgreement['id_user'];
                }else{
                    Alert::error('Fail', 'Aktifitas Mencurigakan');
                    return redirect()->route('perguruan-tinggi', ['id_perti' => request('id_perti')]);
                }

                $validatedDataOrg = $request->validate([
                    'org_nama' => 'required|string',
                    'org_nama_singkat' => 'required|string',
                    'org_alamat' => 'required|string',
                    'org_kota' => 'required|string',
                    'org_email' => 'nullable|email|unique:organizations,org_email',
                    'org_website' => 'nullable|string|unique:organizations,org_website',
                    'org_telp' => 'nullable|numeric|unique:organizations,org_telp',
                    'org_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
                ],[
                    'org_nama.required' => 'Nama perguruan tinggi harus diisi.',
                    'org_nama.string' => 'Nama perguruan tinggi harus berupa teks.',
                
                    'org_nama_singkat.required' => 'Nama singkat perguruan tinggi harus diisi.',
                    'org_nama_singkat.string' => 'Nama singkat perguruan tinggi harus berupa teks.',
                
                    'org_alamat.required' => 'Alamat perguruan tinggi harus diisi.',
                    'org_alamat.string' => 'Alamat perguruan tinggi harus berupa teks.',
                
                    'org_kota.required' => 'Kota perguruan tinggi harus diisi.',
                    'org_kota.string' => 'Kota perguruan tinggi harus berupa teks.',
                
                    'org_email.email' => 'Format email tidak valid.',
                    'org_email.unique' => 'Email sudah digunakan oleh perguruan tinggi lain.',
                    
                    'org_website.string' => 'Website harus berupa teks.',
                    'org_website.unique' => 'Website sudah digunakan oleh perguruan tinggi lain.',
                
                    'org_telp.numeric' => 'Nomor telepon harus berupa angka.',
                    'org_telp.unique' => 'Nomor telepon sudah digunakan oleh perguruan tinggi lain.',
                
                    'org_logo.image' => 'Logo harus berupa file gambar.',
                    'org_logo.mimes' => 'Format file logo harus jpeg, png, atau jpg.',
                    'org_logo.max' => 'Ukuran file logo tidak boleh melebihi 5 MB.'
                ]);
                $org_defined_id = $this->createDefinedId(Organization::count()+1);
                $id_organization_type = 3; //3 karena 3 adalah perguruan tinggi
                $filenameSimpanOrg = 'not_set.png';
                if ($request->hasFile('org_logo')) {
                    $filenameSimpanOrg = $this->generateFilename($request->file('org_logo')->getClientOriginalExtension(), 'Logo_PT_'.$validatedDataOrg['org_nama_singkat'], $org_defined_id);
                    $storeOrg = $request->file('org_logo')->storeAs('public/organization/logo/', $filenameSimpanOrg);
                }

                $validatedDataOrg['org_kode'] = $org_kode;
                $validatedDataOrg['org_defined_id'] = $org_defined_id;
                $validatedDataOrg['id_user'] = $id_user;
                $validatedDataOrg['org_logo'] = $filenameSimpanOrg;
                $validatedDataOrg['id_organization_type'] = $id_organization_type;

                // dd($validatedDataOrgStatus);
                $validatedDataAkta = $request->validate([
                    'akta_nomor' => 'required|string',
                    'akta_tgl_dibuat' => 'required|date',
                    'akta_nama_atau_pengesah' => 'required|string',
                    'akta_perihal' => 'required',
                    'akta_jenis' => 'sometimes|in:Pendirian,Pembaruan',
                    'akta_dokumen' => 'sometimes|mimes:pdf|max:18000'
                ],[
                    'akta_nomor.required' => 'Nomor SK harus diisi.',
                    'akta_nomor.string' => 'Nomor SK harus berupa teks.',
                
                    'akta_tgl_dibuat.required' => 'Tanggal pembuatan SK harus diisi.',
                    'akta_tgl_dibuat.date' => 'Tanggal pembuatan SK harus dalam format tanggal yang valid.',
                
                    'akta_nama_atau_pengesah.required' => 'Pengesah SK harus diisi.',
                    'akta_nama_atau_pengesah.string' => 'Pengesah SKharus berupa teks.',
                
                    'akta_perihal.required' => 'Perihal SK harus diisi.',
                
                    'akta_jenis.in' => 'Jenis SK harus salah satu dari "Pendirian" atau "Pembaruan".',
                
                    'akta_dokumen.mimes' => 'Dokumen SK harus dalam format PDF.',
                    'akta_dokumen.max' => 'Ukuran dokumen SK tidak boleh melebihi 18 MB.'
                ]);
                $akta_defined_id = $this->createDefinedId(Akta::count()+1);
                $filenameSimpanAkta = 'not_set.png';
                if ($request->hasFile('akta_dokumen')) {
                    $filenameSimpanAkta = $this->generateFilename($request->file('akta_dokumen')->getClientOriginalExtension(), 'akta_dokumen', $akta_defined_id);
                    $storeAkta = $request->file('akta_dokumen')->storeAs('public/organization/akta/', $filenameSimpanAkta);
                }
                $validatedDataAkta['akta_defined_id'] = $akta_defined_id;
                $validatedDataAkta['id_user'] =  $id_user;
                $validatedDataAkta['id_organization'] = $org_defined_id;
                $validatedDataAkta['akta_dokumen'] = $filenameSimpanAkta;
                $validatedDataAkta['akta_jenis'] = $request->input('akta_jenis', 'Pendirian' );
                // dd($validatedDataAkta);

                $validatedDataOrgStatus = [
                    'id_organization' => $org_defined_id,
                    'org_status' => $request->input('org_status', 'Aktif'),
                    'id_akta' => $akta_defined_id
                ];

                $validatedDataKepemilikan = $request->validate([
                    'parent_organization_id' => 'required|exists:organizations,org_defined_id'
                ],[
                    'parent_organization_id.required' => 'Badan Penyelenggara harus dipilih.',
                    'parent_organization_id.exists' => 'Badan Penyelenggara yang dipilih tidak valid.'
                ]);
                $validatedDataKepemilikan['child_organization_id'] = $org_defined_id;

                $validatedDataAkreditasi = [
                    'akreditasi_defined_id'=> $this->createDefinedId($org_defined_id.rand(1,1000)),
                    'id_organization' => $org_defined_id 
                ]; 


                DB::beginTransaction();
                try{

                    Organization::create($validatedDataOrg);
                    Akta::create($validatedDataAkta);
                    Kepemilikan::create($validatedDataKepemilikan);
                    OrganizationStatus::create($validatedDataOrgStatus);
                    // Akreditasi::create($validatedDataAkreditasi);

                    DB::commit();

                    Alert::success('Success', 'Data Telah Tersimpan');
                    return redirect()->route('perguruan-tinggi');

                }catch(\Exception $e){
                    DB::rollback();
                    dd($e->getMessage());

                    Alert::error('Fail', 'Data Gagal Disimpan');
                    return redirect()->route('perguruan-tinggi.create')->withInput()->withErrors($e->getMessage());
                }
                
            }catch(\Exception $e){
                // dd($e->getMessage());
                Alert::error('Fail', 'Data Gagal Disimpan');
                return redirect()->route('perguruan-tinggi.create')->withInput()->withErrors($e->getMessage());

            }
        } else {
            abort(404);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization, Request $request, $org_defined_id)
    {
        if($request->is('badan-penyelenggara*')) {
            abort_if(Gate::denies('show_data_badan_penyelenggara'), 403);
            try{
                if (Gate::allows('view_all_badan_penyelenggara')) {
                    //lanjutkan  proses jika diizinkan
                } elseif(Gate::allows('view_restrict_badan_penyelenggara')) {
                    if (auth()->user()->id_organization_type == 1){
                    //lanjutkan  proses jika diizinkan
                    }elseif(auth()->user()->id_organization_type == 2){
                        if($org_defined_id != auth()->user()->id_organization){
                            Alert::error('Fail', 'Anda Tidak Memiliki Akses');
                            return redirect()->route('badan-penyelenggara');                
                        }
                    }elseif(auth()->user()->id_organization_type == 3){

                        $badanPenyelenggaraByIdPT = Kepemilikan::select([
                            'organizations.org_defined_id'
                        ])
                        ->join('organizations', 'organizations.org_defined_id', '=', 'kepemilikans.parent_organization_id')
                        ->where('kepemilikans.parent_organization_id', '=', $org_defined_id)->latest('kepemilikans.created_at')
                        ->where('kepemilikans.child_organization_id', '=', auth()->user()->id_organization)
                        ->first();

                        if (!$badanPenyelenggaraByIdPT) {
                            // Jika tidak ada hasil dari query
                            Alert::error('Fail', 'Aktifitas Mencurigakan');
                            return redirect()->route('badan-penyelenggara');            
                        }                   
                    }else{
                        Alert::error('Fail', 'Anda Tidak Memiliki Akses');
                        return redirect()->route('badan-penyelenggara');            
                    }
                }else{
                    Alert::erro('Fail', 'Anda Tidak Memiliki Akses');
                    return redirect()->route('badan-penyelenggara');            
                }

                $org = Organization::select([
                    'organizations.org_nama',
                    'organizations.org_nama_singkat',
                    'organizations.org_kode',
                    'organizations.org_defined_id',
                    'organizations.org_email',
                    'organizations.org_telp',
                    'organizations.org_kota',
                    'organizations.org_alamat',
                    'organizations.org_website',
                    'organizations.org_logo',

                    'organization_statuses.org_status',

                    'aktas.akta_nomor',
                    'aktas.akta_tgl_dibuat',
                    'aktas.akta_kota_notaris',
                    'aktas.akta_perihal',
                    'aktas.akta_jenis',
                    'aktas.akta_dokumen',

                    'kumhams.kumham_nomor_sk',
                    'kumhams.kumham_tgl_sk',
                    'kumhams.kumham_dokumen'
                ])
                ->join('aktas', 'aktas.id_organization', '=', 'organizations.org_defined_id')->latest('aktas.akta_tgl_dibuat')
                ->join('organization_statuses', 'organization_statuses.id_organization', '=', 'organizations.org_defined_id')->latest('organization_statuses.created_at')
                ->leftJoin('kumhams', function ($join) {
                    $join->on('kumhams.id_akta', '=', 'aktas.akta_defined_id');
                })                 
                ->where('org_defined_id', '=', $org_defined_id)
                ->first();  
                
                if(!$org){
                    return view('layouts.not_found.half');
                }

                $perguruantinggi = Kepemilikan::select([
                    'organizations.org_defined_id',
                    'organizations.org_nama_singkat',
                    'organizations.org_logo',
                    'organizations.org_nama',
                ])
                ->join('organizations', 'organizations.org_defined_id', '=', 'kepemilikans.child_organization_id')
                ->where('kepemilikans.parent_organization_id', '=', $org_defined_id)
                ->get();

                return view('badan_penyelenggara.detail', [
                    'bp' => $org,
                    'perguruantinggi' => $perguruantinggi
                ]);
            }catch(\Exception $e){
                dd($e->getMessage());
            }

        } elseif ($request->is('perguruan-tinggi*')) {
            abort_if(Gate::denies('show_data_perguruan_tinggi'), 403);
            try{

                // Memeriksa apakah pengguna memiliki izin untuk melakukan tindakan tertentu
                if (Gate::allows('view_all_perguruan_tinggi')) {
                    //lanjutkan  proses jika diizinkan
                } elseif(Gate::allows('view_restrict_perguruan_tinggi')) {
                    if (auth()->user()->id_organization_type == 1){
                    //lanjutkan  proses jika diizinkan
                    }elseif(auth()->user()->id_organization_type == 2){
                        $perguruantinggi = DB::table('kepemilikans')->select([
                            'organizations.org_defined_id',
                        ])
                        ->join('organizations', 'organizations.org_defined_id', '=', 'kepemilikans.child_organization_id')
                        ->where('organizations.org_defined_id', '=', $org_defined_id)
                        ->first();

                        if (!$perguruantinggi) {
                            // Jika tidak ada hasil dari query
                            Alert::error('Fail', 'Aktifitas Mencurigakan');
                            return redirect()->route('perguruan-tinggi');            
                        }                   
                    }elseif(auth()->user()->id_organization_type == 3){
                        if($org_defined_id != auth()->user()->id_organization){
                            Alert::error('Fail', 'Aktifitas Mencurigakan');
                            return redirect()->route('perguruan-tinggi');            
                        }
                    }else{
                        Alert::error('Fail', 'Anda Tidak Memiliki Akses');
                        return redirect()->route('perguruan-tinggi');            
                    }
                }else{
                    Alert::erro('Fail', 'Anda Tidak Memiliki Akses');
                    return redirect()->route('perguruan-tinggi');            
                }


                $org = Organization::select([
                    'organizations.org_nama',
                    'organizations.org_nama_singkat',
                    'organizations.org_kode',
                    'organizations.org_defined_id',
                    'organizations.org_email',
                    'organizations.org_telp',
                    'organizations.org_kota',
                    'organizations.org_alamat',
                    'organizations.org_website',
                    'organizations.org_logo',

                    'organization_statuses.org_status',
    
                    'aktas.akta_nomor',
                    'aktas.akta_tgl_dibuat',
                    'aktas.akta_kota_notaris',
                    'aktas.akta_perihal',
                    'aktas.akta_dokumen',

                    'kepemilikans.parent_organization_id',
                    'parent_org.org_nama as parent_nama',
                    'parent_org.org_logo as parent_logo',

                    'organization_statuses.org_status'
                ])
                ->join('aktas', 'aktas.id_organization', '=', 'organizations.org_defined_id')->latest('aktas.created_at')
                ->join('organization_statuses', 'organization_statuses.id_akta', '=', 'aktas.akta_defined_id')->latest('aktas.created_at')
                ->join('kepemilikans', 'kepemilikans.child_organization_id', '=', 'organizations.org_defined_id')->latest('kepemilikans.created_at')              
                ->join('organizations as parent_org', 'parent_org.org_defined_id', '=', 'kepemilikans.parent_organization_id')
                ->where('organizations.org_defined_id', '=', $org_defined_id)
                ->first(); 

                if(!$org){
                    return view('layouts.not_found.half');
                }

                $id_jabatan_values = DB::table('pimpinan_organisasis')
                ->select('id_jabatan')
                ->where('id_organization', '=', $org_defined_id)
                ->distinct()
                ->pluck('id_jabatan')
                ->toArray();

                // dd($id_jabatan_values);

                // abort_if(Gate::denies('access_data_perguruan_tinggi'), 403);
                $pimpinan_perti = DB::table('pimpinan_organisasis')
                ->select('pimpinan_nama', 'id_jabatan', 'jabatan_nama', 'pimpinan_organisasis.created_at')
                ->join('jabatans', 'jabatans.id', '=', 'pimpinan_organisasis.id_jabatan')
                ->whereIn('id_jabatan', $id_jabatan_values)
                ->whereIn('pimpinan_organisasis.created_at', function ($query) use ($id_jabatan_values) {
                    $query->select(DB::raw('MAX(pimpinan_organisasis.created_at)'))
                        ->from('pimpinan_organisasis')
                        ->whereIn('id_jabatan', $id_jabatan_values)
                        ->groupBy('id_jabatan');
                })
                ->where('id_organization', '=', $org_defined_id)
                ->orderBy('id_jabatan', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();

                // dd($pimpinan_perti);
                                                
                return view('perguruan_tinggi.detail', [
                    'perti' => $org,
                    'pimpinan_perti' => $pimpinan_perti
                ]);
            }catch(\Exception $e){
                dd($e->getMessage());
            }

        } else {
            abort(404);
        }
       
                                
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        //
    }

    public function organizationbyidorganizationtype($id_organization_type){
        $organizationByIdOrganizationType = Organization::select([
            'org_defined_id',
            'org_nama',
            'organization_statuses.org_status',
            'org_logo'
        ])
        ->join('organization_statuses', 'organization_statuses.id_organization', '=', 'organizations.org_defined_id')->latest('organization_statuses.created_at')
        ->where('id_organization_type', '=', $id_organization_type)->get();

        return Datatables::of($organizationByIdOrganizationType)->make(true);
    }

    public function organizationbydefinedid($org_defined_id){
        $organizationByOrgDefinedId = Organization::select([
            'org_defined_id',
            'org_nama',
            'organization_statuses.org_status',            
            'org_logo'
        ])
        ->join('organization_statuses', 'organization_statuses.id_organization', '=', 'organizations.org_defined_id')->latest('organization_statuses.created_at')
        ->where('org_defined_id', '=', $org_defined_id)->get();

        return Datatables::of($organizationByOrgDefinedId)->make(true);
    }

    public function badanpenyelenggarajson(){
        $id_bp = 2;
        $badanPenyelenggara = Organization::select([
            'organizations.org_defined_id',
            'org_nama',
            'org_logo',
            'org_nama_singkat'
        ])
        ->where('organizations.id_organization_type', '=', $id_bp)
        ->get();

        return Datatables::of($badanPenyelenggara)->make(true);
    }

    public function badanpenyelenggarabyidjson($org_defined_id){
        $id_bp = 2;
        $badanPenyelenggaraById = Organization::select([
            'organizations.org_defined_id',
            'organizations.org_nama',
            'organizations.org_logo',
            'organizations.org_nama_singkat'
        ])
        ->where('organizations.org_defined_id', '=', $org_defined_id)
        ->where('organizations.id_organization_type', '=', $id_bp)
        ->get();

        return Datatables::of($badanPenyelenggaraById)->make(true);
    }

    public function badanpenyelenggarabyidptjson($id_pt){
        $badanPenyelenggaraByIdPT = Kepemilikan::select([
            'organizations.org_defined_id',
            'organizations.org_nama',
            'organizations.org_logo',
            'organizations.org_nama_singkat'
        ])
        ->join('organizations', 'organizations.org_defined_id', '=', 'kepemilikans.parent_organization_id')
        ->where('kepemilikans.child_organization_id', '=', $id_pt)
        ->get();

        return Datatables::of($badanPenyelenggaraByIdPT)->make(true);
    }

    public function badanpenyelenggaradefault(){
        $id_bp = -1;
        $badanPenyelenggaraDefault = Organization::select([
            'organizations.org_defined_id',
            'organizations.org_nama',
            'organization_statuses.org_status',
            'aktas.akta_nomor',
            'organizations.org_logo',
            'organizations.org_nama_singkat'
        ])
        ->join('aktas', 'aktas.id_organization', '=', 'organizations.org_defined_id')
        ->join('organization_statuses', 'organization_statuses.id_organization', '=', 'organizations.org_defined_id')->latest('organization_statuses.created_at')
        ->where('organizations.org_defined_id', '=', $id_bp)
        ->get();

        return Datatables::of($badanPenyelenggaraDefault)->make(true);

    }

    public function perguruantinggijson(){
        $id_pt = 3;
        $perguruantinggi = Organization::select([
            'org_defined_id',
            'org_kode',
            'org_nama_singkat',
            'org_nama',
            'org_kota',
            'org_logo',
            'org_nama_singkat',
            'organization_statuses.org_status',
        ])
        ->join('organization_statuses', 'organization_statuses.id_organization', '=', 'organizations.org_defined_id')->latest('organization_statuses.created_at')
        ->where('organizations.id_organization_type', '=', $id_pt)
        ->get();

        return Datatables::of($perguruantinggi)->make(true);
    }

    public function perguruantinggibyidjson($id){
        $perguruantinggi = Organization::select([
            'organizations.org_defined_id',
            'organizations.org_kode',
            'organizations.org_nama_singkat',
            'organizations.org_nama',
            'organizations.org_kota',
            'organizations.org_logo',
            'organizations.org_nama_singkat',
            'organization_statuses.org_status',

        ])
        ->join('organization_statuses', 'organization_statuses.id_organization', '=', 'organizations.org_defined_id')->latest('organization_statuses.created_at')
        ->where('organizations.org_defined_id', '=', $id)->get();

        return Datatables::of($perguruantinggi)->make(true);
    }

    public function perguruantinggibyidbpjson($id_bp){
        $perguruantinggi = Kepemilikan::select([
            'organizations.org_defined_id',
            'organizations.org_kode',
            'organizations.org_nama_singkat',
            'organizations.org_nama',
            'organizations.org_kota',
            'organizations.org_logo',
            'organizations.org_nama_singkat',
            'peringkat_akreditasis.peringkat_nama',
        ])
        ->join('organizations', 'organizations.org_defined_id', '=', 'kepemilikans.child_organization_id')
        ->join('organization_statuses', 'organization_statuses.id_organization', '=', 'organizations.org_defined_id')->latest('organization_statuses.created_at')
        ->where('kepemilikans.parent_organization_id', '=', $id_bp)
        ->get();

        return Datatables::of($perguruantinggi)->make(true);
    }

    public function perguruantinggidefault(){
        $id_pt = 0;
        $perguruantinggidefault = Organization::select([
            'org_defined_id',
            'org_kode',
            'org_nama_singkat',
            'org_nama',
            'org_kota',
            'org_logo',
            'org_nama_singkat',
            'organization_statuses.org_status',
        ])
        ->join('organization_statuses', 'organization_statuses.id_organization', '=', 'organizations.org_defined_id')->latest('organization_statuses.created_at')
        ->where('organizations.id_organization_type', '=', $id_pt)
        ->get();

        return Datatables::of($perguruantinggidefault)->make(true);
    }

    public function kota(){
        $kotas = DB::table('kotas')->select([
            'type', 'name'
        ])->orderBy('name', 'ASC')->get();

        return Datatables::of($kotas)->make(true);
    }

}
