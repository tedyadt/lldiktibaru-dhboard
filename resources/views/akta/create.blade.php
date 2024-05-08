@extends('layouts.master')

@section('page-css')
    
@endsection

@section('main-content')
@php
$pertiId = $_GET['id_perti'];
@endphp

<div class="main-content pt-4">
    <div class="breadcrumb">
        <ul>
            <li>
                <a href="{{ route('perguruan-tinggi' ) }}">Perguruan Tinggi</a> |
                <a href="{{ route('perguruan-tinggi.show', $pertiId ) }}">Detail</a> |
                <a href="{{ route('berita-acara-perkara', ['id_perti'=> $pertiId ]) }}">Perkara</a> |
                <a href="{{ route('berita-acara-perkara.create', ['id_perti'=> $pertiId ]) }}">Tambah</a> |
            </li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div><!-- end of main-content -->
    <form action="{{ route('akta', ['id_perti' => $pertiId]) }}"  method="post"  enctype="multipart/form-data">
    @csrf
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <h4>Status Perguruan Tinggi {{ $perti->org_nama }}</h4>
                        <div class="row">
                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                @if ($perti->org_logo == 'not_set.png')
                                    <img class="img-fluid rounded mb-2"
                                    src="{{ asset('storage/' . $perti->org_logo) }}" alt="" />                                        
                                @else
                                <img class="img-fluid rounded mb-2"
                                    src="{{ asset('storage/organization/logo/' . $perti->org_logo) }}" alt="" />                                        
                                @endif
                            </div>
                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                <h2 class="font-weight-bold text-center">{{ $perti->org_nama }}</h2>
                                <input type="hidden" name="id_organization" value="{{ $pertiId }}" required readonly>
                            </div>
                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                {{-- <img class="img-fluid rounded mb-2"
                                    src="{{ asset('storage/peringkat_akreditasi/' . $perti->peringkat_logo) }}"
                                    alt="" /> --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-4">
                                <div class="text-left">
                                    {{-- your conten should be here --}}
                                    <h5>Ijin Penyelenggaraan Perguruan Tinggi</h5>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="akta_nomor">Nomor Surat Keputusan<span style="color: red">*</span></label>
                                            <textarea class="form-control" id="akta_nomor" rows="2" name="akta_nomor"  required></textarea>
                                        </div>
                                        
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="akta_tgl_dibuat">Tanggal SK Dibuat<span style="color: red">*</span></label>
                                            <input class="form-control" id="akta_tgl_dibuat" type="date" name="akta_tgl_dibuat" required />
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="akta_perihal">Perihal SK<span style="color: red">*</span></label>
                                            <textarea class="form-control" id="akta_perihal" rows="2" name="akta_perihal"  required></textarea>
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="akta_jenis">Jenis SK<span style="color: red">*</span></label>
                                            <select class="form-control mb-1" id="akta_jenis" name="akta_jenis">
                                                <option value="Pembaruan"> Pembaruan</option>
                                            </select>
                                        </div>
            
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="akta_nama_atau_pengesah">Yang Mengesahkan<span style="color: red">*</span></label>
                                            <textarea class="form-control" id="akta_nama_atau_pengesah" rows="2" name="akta_nama_atau_pengesah" required></textarea>
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="org_status">Status Perguruan Tinggi<span style="color: red">*</span></label>
                                            <select class="form-control mb-1" id="org_status" name="org_status">
                                                <option value="">Pilih Opsi</option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Pembinaan"> Pembinaan</option>
                                                <option value="Alih Bentuk"> Alih Bentuk</option>
                                                <option value="Tidak Aktif">Tidak Aktif</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="text-left">
                                    <label for="">File Akta<small> pdf maksimal 18mb</small></label>
                                    <div class="card o-hidden mb-2">
                                        <iframe id="akta_preview" height="175" frameborder="0"></iframe>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input class="custom-file-input" id="aktaFileInp" type="file" aria-describedby="inputGroupFileAddon01" name="akta_dokumen"/>
                                            <label class="custom-file-label" for="inputGroupFile01" id="aktaFileLabelLogo">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.agreement')
        </from>
    
</div>

@endsection

@section('page-js')


@endsection