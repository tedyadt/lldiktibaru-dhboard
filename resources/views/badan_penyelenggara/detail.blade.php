@extends('layouts.master')

@section('page-css')
    
@endsection

@section('main-content')
<div class="main-content pt-4">
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('badan-penyelenggara') }}">Badan Penyelenggara</a></li>
            <li>detail</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div><!-- end of main-content -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4>Identitas Badan Penyelenggara</h4>
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            @if($bp->org_logo == 'not_set.png')
                                <img class="img-fluid rounded mb-2" src="{{ asset('storage/not_set.png') }}" alt="" />
                            @else
                                <img class="img-fluid rounded mb-2" src="{{ asset('storage/organization/logo/'.$bp->org_logo) }}" alt="" />
                            @endif
                        </div>                        
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <h2 class="font-weight-bold text-center">{{ $bp->org_nama }}</h2>
                        </div>                        
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-4 ">
                            <div class="mb-4">
                                <p class="text-primary mb-1">Nama Badan Penyelenggara</p>
                                <span>
                                    {{ $bp->org_nama }}
                                </span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">Kontak</p>
                                <table>
                                    <tr>
                                        <th>Email</th>
                                        <td>:</td>
                                        <td>{{ $bp->org_email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon</th>
                                        <td>:</td>
                                        <td>{{ $bp->org_telp }}</td>
                                    </tr>
                                    <tr>
                                        <th>Website</th>
                                        <td>:</td>
                                        <td>{{ $bp->org_website }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">Alamat</p>
                                <span>
                                    {{ $bp->org_alamat }}
                                </span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">Status</p>
                                <span>
                                    {{ $bp->org_status }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="mb-4">
                                <p class="text-primary mb-1">Nomor Akta</p>
                                <span>
                                    {{ $bp->akta_nomor }}
                                </span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">Tanggal Dibuat Akta</p>
                                <span>
                                    {{ $bp->akta_tgl_dibuat }}
                                </span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">Jenis Akta</p>
                                <span>
                                    {{ $bp->akta_jenis }}
                                </span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    File Akta Pendirian
                                </p>
                                <span>
                                    <i class="text-20 bi bi-file-earmark-pdf"></i>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        @if ($bp->akta_dokumen == 'not_set.png')
                                        <img src=" {{ asset('storage/not_set.png') }}" width="50" height="50">
                                        @else 
                                        <a download href="{{ asset('storage/organization/akta/'.$bp->akta_dokumen) }}" class="btn btn-sm btn-primary"><i class="bi bi-download"></i></a>
                                        <a href="{{ asset('storage/organization/akta/'.$bp->akta_dokumen) }}" class="btn btn-sm btn-secondary"><i class="bi bi-eye"></i></a>
                                        @endif
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="mb-4">
                                <p class="text-primary mb-1">Nomor Surat Keputusan</p>
                                <span>
                                    {{ $bp->kumham_nomor_sk }}
                                </span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">Tanggal Dibuat SK</p>
                                <span>
                                    @if ($bp->kumham_tgl_sk == '1000-01-01')
                                        not set
                                    @else
                                    {{ $bp->kumham_tgl_sk }}
                                    @endif
                                </span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    File Akta
                                </p>
                                <span>
                                    <i class="text-20 bi bi-file-earmark-pdf"></i>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        @if ($bp->kumham_dokumen == 'not_set.png')
                                            <img src=" {{ asset('storage/not_set.png') }}" width="50" height="50">
                                        @else 
                                        <a download href="{{ asset('storage/organization/kumham/'.$bp->kumham_dokumen) }}" class="btn btn-sm btn-primary"><i class="bi bi-download"></i></a>
                                        <a href="{{ asset('storage/organization/kumham/'.$bp->kumham_dokumen) }}" class="btn btn-sm btn-secondary"><i class="bi bi-eye"></i></a>
                                        @endif
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr />
                    @can('show_data_perguruan_tinggi')                            
                    <h4>Daftar Perguruan Tinggi</h4>
                    <p class="mb-4">Daftar perguruan tinggi di bawah {{ $bp->org_nama }}</p>
                        
                    <div class="row justify-content-center">
                        @foreach ($perguruantinggi as $item)
                        <div class="col-md-3">
                            <div class="card card-profile-1 mb-4">
                                <div class="card-body text-center">
                                    <div class="avatar box-shadow-2 mb-3">
                                        @if ($item->org_logo == 'not_set.png')
                                        <img src="{{ asset('storage/'.$item->org_logo) }}" alt="logo_pt" />    
                                        @else
                                        <img src="{{ asset('storage/organization/logo/'.$item->org_logo) }}" alt="logo_pt" />    
                                        @endif
                                    </div>
                                    <h5 class="m-3">{{ $item->org_nama }}</h5>
                                    <a href="{{ route('perguruan-tinggi.show', ['perguruan_tinggi' => $item->org_defined_id]) }}" class="btn btn-primary btn-rounded">Detail</a>
                                </div>
                            </div>
                        </div>                            
                        @endforeach
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')
    
@endsection