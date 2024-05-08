@extends('layouts.master')

@section('page-css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
                <a href="{{ route('akreditasi', ['id_perti'=> $pertiId ]) }}">Akreditasi</a> |
                <a href="{{ route('akreditasi.create', ['id_perti'=> $pertiId ]) }}">Tambah</a> |
            </li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div><!-- end of main-content -->
    <form action="{{ route('akreditasi', ['id_perti' => $pertiId]) }}"  method="post"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
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
                            <input type="hidden" name="id_organization" value="{{ $pertiId }}" required readonly>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            {{-- <img class="img-fluid rounded mb-2"
                                src="{{ asset('storage/peringkat_akreditasi/' . $perti->peringkat_logo) }}"
                                alt="" /> --}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                @csrf

                                <div class="col-md-6 form-group mb-3">
                                    <label for="akreditasi_sk">Nomor Surat Keputusan Akreditasi<span style="color: red">*</span></label>
                                    <textarea class="form-control" id="akreditasi_sk" rows="2" name="akreditasi_sk"  required></textarea>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="akreditasi_tgl_dibuat">Tanggal Dibuat SK<span style="color: red">*</span></label>
                                    <input class="form-control" style="height: 50px" id="akreditasi_tgl_dibuat" type="date" name="akreditasi_tgl_dibuat" required />
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="akreditasi_tgl_awal">Tanggal Mulai SK Akreditasi<span style="color: red">*</span></label>
                                    <input class="form-control" style="height: 50px" id="akreditasi_tgl_awal" type="date" name="akreditasi_tgl_awal" required />
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="akreditasi_tgl_akhir">Tanggal Berakhir SK Akreditasi<span style="color: red">*</span></label>
                                    <input class="form-control" style="height: 50px" id="akreditasi_tgl_akhir" type="date" name="akreditasi_tgl_akhir" required />
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label for="lembaga-akreditasi-select">Lembaga Akreditasi<span style="color: red">*</span></label>
                                    <select id="lembaga-akreditasi-select" style="width: 100%" class="js-example-basic-single" name="id_lembaga_akreditasi" required>
                                        <option value="">Pilih</option>
                                        @foreach ($lembaga_s as $item)
                                        <option value="{{ $item->id }}">{{ $item->lembaga_nama }}</option>    
                                        @endforeach
            
                                    </select> 
                                    <div class="row">
                                        <div class="col-md-5 d-flex justify-content-center align-items-center">
                                            <img class="img-fluid rounded mb-2" id="lembaga_logo" data-url="{{ asset('storage/lembaga_akreditasi/') }}"  alt="" />
                                        </div>
                                        <div class="col-md-5 d-flex justify-content-center align-items-center">
                                            <h6 id="lembaga_nama" class="font-weight-bold text-center mb-0"></h6>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="peringkat-akreditasi-select">Peringkat Akreditasi<span style="color: red">*</span></label>
                                    <select id="peringkat-akreditasi-select" style="width: 100%" class="js-example-basic-single" name="id_peringkat_akreditasi" required>
                                        <option value="">Pilih</option>
                                        @foreach ($peringkat_s as $item)
                                        <option value="{{ $item->id }}">{{ $item->peringkat_nama }}</option>    
                                        @endforeach
            
                                    </select> 
                                    <div class="row">
                                        <div class="col-md-5 d-flex justify-content-center align-items-center">
                                            <img class="img-fluid rounded mb-2" id="akreditasi_logo" data-url="{{ asset('storage/peringkat_akreditasi/') }}"  alt="" />
                                        </div>
                                        <div class="col-md-5 d-flex justify-content-center align-items-center flex-column">
                                            <h6 id="akreditasi_nama" class="font-weight-bold text-center mb-0"></h6>
                                        </div> 
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">File SK Akreditasi <small>pdf</small></label>
                            <div class="card o-hidden mb-2">
                                <iframe id="akreditasi_dokumen_preview" height="175" frameborder="0"></iframe>
                            </div>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input class="custom-file-input" id="akreditasi_dokumen_input" type="file" aria-describedby="inputGroupFileAddon01" name="akreditasi_dokumen"/>
                                    <label class="custom-file-label" for="inputGroupFile01" id="akreditasi_dokumen_input_label">Choose file</label>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    function readURL(input, selector) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(selector).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


<script>
    $(document).ready(function() {
        $('#lembaga-akreditasi-select').select2();
    });

    $(document).ready(function() {
        $('#lembaga-akreditasi-select').change(function() {
            let selectedValue = $(this).val();
            if(selectedValue == ''){
                this.selectedIndex = 0; // Atur indeksnya ke 0 (pilihan pertama)
                $('#lembaga_logo').attr('src', '');                        
                $('#lembaga_nama').text('');
            }else{
                let bpLogoUrl = $('#lembaga_logo').data('url');
                $.ajax({
                    url: '{{ route("lembaga-akreditasi.getById", ":value") }}'.replace(':value', selectedValue),
                    type: 'GET',
                    success: function(response) {
                        let logoUrl = bpLogoUrl + '/'+ response.data[0]['lembaga_logo'];

                        $('#lembaga_logo').attr('src', logoUrl);                        
                        $('#lembaga_nama').text(response.data[0]['lembaga_nama']);
                        $('#lembaga_status').text(response.data[0]['lembaga_status']);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#peringkat-akreditasi-select').select2();
    });

    $(document).ready(function() {
        $('#peringkat-akreditasi-select').change(function() {
            let selectedValue = $(this).val();
            if(selectedValue == ''){
                this.selectedIndex = 0; // Atur indeksnya ke 0 (pilihan pertama)
                $('#akreditasi_logo').attr('src', '');                        
                $('#akreditasi_nama').text('');

            }else{
                let peringkatAkreditasiLogoUrl = $('#akreditasi_logo').data('url');
                $.ajax({
                    url: '{{ route("peringkat-akreditasi.getById", ":value") }}'.replace(':value', selectedValue),
                    type: 'GET',
                    success: function(response) {
                        let logoUrl = peringkatAkreditasiLogoUrl + '/'+ response.data[0]['peringkat_logo'];

                        $('#akreditasi_logo').attr('src', logoUrl);                        
                        $('#akreditasi_nama').text(response.data[0]['peringkat_nama']);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
</script>

<script>
    // Dapatkan elemen input tanggal awal
    var startDateInput = document.getElementById("akreditasi_tgl_awal");
    // Dapatkan elemen input tanggal akhir
    var endDateInput = document.getElementById("akreditasi_tgl_akhir");

    // Tambahkan event listener untuk perubahan nilai pada input tanggal awal
    startDateInput.addEventListener("change", function() {
        // Tetapkan nilai minimum tanggal pada input tanggal akhir
        endDateInput.min = startDateInput.value;
    });
</script>

<script>

    $("#akreditasi_dokumen_input").change(function(){
        readURL(this, '#akreditasi_dokumen_preview');
    });

    // Ketika pengguna memilih file img, perbarui label
    $('#akreditasi_dokumen_input').change(function() {
        var fileName = $(this).val().split('\\').pop(); // Mengambil nama file dari path lengkap

        // Memeriksa panjang nama file
        if (fileName.length > 20) {
            // Jika lebih dari 10 karakter, singkat nama file
            var shortenedFileName = fileName.substr(0, 15) + '...' + fileName.substr(-7);
            $('#akreditasi_dokumen_input_label').text(shortenedFileName); // Mengatur label dengan nama file yang disingkat
        } else {
            // Jika tidak, gunakan nama file lengkap
            $('#akreditasi_dokumen_input_label').text(fileName); // Mengatur label dengan nama file
        }
    });
</script>


@endsection
