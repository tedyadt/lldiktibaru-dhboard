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
    <form action="{{ route('berita-acara-perkara', ['id_perti' => $pertiId]) }}"  method="post"  enctype="multipart/form-data">
    @csrf
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <h4>Berita Acara Perguruan Tinggi {{ $perti->org_nama }}</h4>
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
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2 form-group mb-3">
                                        <label for="bap_status">Status Perkara<span style="color: red">*</span></label>
                                        <select id="bap_status" style="width: 100%" class="form-control mb-1" name="bap_status" required>
                                            <option value="">Pilih</option>
                                            <option value="Belum Diproses">Belum Diproses</option>
                                            <option value="Sedang Diproses">Sedang Diproses</option>
                                            <option value="Selesai Diproses">Selesai Diproses</option>
                                        
                                        </select> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 form-group mb-3">
                                        <label for="bap_perkara">Berita Acara Perkara<span style="color: red">*</span></label>
                                        <textarea class="form-control" id="bap_perkara" rows="7" name="bap_perkara"  required></textarea>
                                    </div>
                                    
                                    <div class="col-md-5 form-group mb-3">
                                        <label for="bap_keterangan">Keterangan</label>
                                        <textarea class="form-control" id="bap_keterangan" rows="7" name="bap_keterangan"></textarea>
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