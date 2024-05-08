@extends('layouts.master')

@section('page-css')
@endsection

@section('main-content')
    @php
    $pertiId = $perti->org_defined_id;
    @endphp

    <div class="main-content pt-4">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('perguruan-tinggi') }}">Perguruan Tinggi</a></li>
                <li>Detail</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div><!-- end of main-content -->
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <div>
                            <h4>Identitas Perguruan Tinggi</h4>
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
                                </div>
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    {{-- <img class="img-fluid rounded mb-2"
                                        src="{{ asset('storage/peringkat_akreditasi/' . $perti->peringkat_logo) }}"
                                        alt="" /> --}}
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h4>Informasi Perguruan Tinggi</h4>
                                    @can('edit_data_perguruan_tinggi')
                                        <div class="button-group mb-3">
                                            <button type="button" class="btn btn-sm btn-primary">Edit</button>
                                            <button type="button" class="btn btn-sm btn-secondary">Detail</button>
                                        </div>
                                    @endcan
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tr>
                                                <th scope="col">SK Pendirian</th>
                                                <th>:</th>
                                                <td>{{ $perti->akta_nomor }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Tanggal SK Pendirian</th>
                                                <th>:</th>
                                                <td>{{ $perti->akta_tgl_dibuat }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Kota</th>
                                                <th>:</th>
                                                <td>{{ $perti->org_kota }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Alamat</th>
                                                <th>:</th>
                                                <td>{{ $perti->org_alamat }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Email</th>
                                                <th>:</th>
                                                <td>{{ $perti->org_email }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Telepon</th>
                                                <th>:</th>
                                                <td>{{ $perti->org_telp }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Website</th>
                                                <th>:</th>
                                                <td>{{ $perti->org_website }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Kepemilikan</th>
                                                <th>:</th>
                                                <td>
                                                    @if ($perti->parent_logo == 'not_set.png')
                                                    <img width="50px" height="50px"
                                                        src=" {{ asset('storage/' . $perti->parent_logo) }} "
                                                        alt="">
                                                    @else
                                                    <img width="50px" height="50px"
                                                        src=" {{ asset('storage/organization/logo/' . $perti->parent_logo) }} "
                                                        alt="">
                                                    @endif
                                                    <br>
                                                    {{ $perti->parent_nama }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td>:</td>
                                                <td>{{ $perti->org_status }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <h4>Pimpinan Perguruan Tinggi</h4>
                                    @can('access_pimpinan_perguruan_tinggi')
                                    <div class="button-group mb-3">
                                        <a href="{{ route('pimpinan-perti', ['id_perti' => $perti->org_defined_id]) }}"><button type="button" class="btn btn-sm btn-secondary">Detail</button></a>
                                    </div>
                                    @endcan

                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            @foreach ($pimpinan_perti as $item)
                                            <tr>
                                                <th scope="col">{{ $item->jabatan_nama }}</th>
                                                <th>:</th>
                                                <td>{{ $item->pimpinan_nama }}</td>
                                            </tr>
                                            @endforeach
                                           
                                        </table>
                                    </div>

                                </div>
                            </div>

                            <hr>
                            @include('akta.datatable.index')
                            <hr>
                            @include('akreditasi.datatable.perti.index')
                            <hr>
                            @include('program_studi.datatable.index')
                            <hr>
                            @include('berita_acara_perkara.datatable.index')



                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    {{-- datatable button --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    @include('akreditasi.datatable.perti.js')
    @include('program_studi.datatable.js')
    @include('berita_acara_perkara.datatable.js')
    @include('akta.datatable.js')



@endsection
