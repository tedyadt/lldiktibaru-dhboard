@extends('layouts.master')

@section('page-css')
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('main-content')
@php
    $pertiId = $_GET['id_perti'];
@endphp

    <div class="main-content pt-4">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('program-studi', ['id_perti' => $pertiId]) }}">Progam Studi</a></li>
                <li>tambah</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        @if ($errors->any())
            <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
            </div>
        @endif


        <form action="{{ route('program-studi', ['id_perti' => $pertiId  ]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <input type="hidden" name="id_organization" value="{{ request('id_perti') }}">

                <div class="col-md-6 mb-4">
                    <div class="card text-left">
                        <div class="card-body">
                            {{-- your conten should be here --}}
                            <div class="row">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="prodi_kode">Kode Prodi<span style="color: red">*</span></label>
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-md-2  col-2">
                                    <input type="text" style="width:50px; height: 50px; font-size: 24px"
                                        class="form-control text-center font-weight-bold" name="kode_prodi_digits[]"
                                        id="digit1" maxlength="1" pattern="[0-9]" onkeyup="moveToNextInput(this, 'digit2')" required value="{{ old('kode_prodi_digits.0') }}">
                                </div>
                                <div class="col-md-2  col-2">
                                    <input type="text" style="width:50px; height: 50px; font-size: 24px"
                                        class="form-control text-center font-weight-bold" name="kode_prodi_digits[]"
                                        id="digit2" maxlength="1" pattern="[0-9]" onkeyup="moveToNextInput(this, 'digit3')" required value="{{ old('kode_prodi_digits.1') }}">
                                </div>
                                <div class="col-md-2  col-2">
                                    <input type="text" style="width:50px; height: 50px; font-size: 24px"
                                        class="form-control text-center font-weight-bold" name="kode_prodi_digits[]"
                                        id="digit3" maxlength="1" pattern="[0-9]" onkeyup="moveToNextInput(this, 'digit4')" required value="{{ old('kode_prodi_digits.2') }}">
                                </div>
                                <div class="col-md-2  col-2">
                                    <input type="text" style="width:50px; height: 50px; font-size: 24px"
                                        class="form-control text-center font-weight-bold" name="kode_prodi_digits[]"
                                        id="digit4" maxlength="1" pattern="[0-9]" onkeyup="moveToNextInput(this, 'digit5')"required value="{{ old('kode_prodi_digits.3') }}">
                                </div>
                                <div class="col-md-2  col-2">
                                    <input type="text" style="width:50px; height: 50px; font-size: 24px"
                                        class="form-control text-center font-weight-bold" name="kode_prodi_digits[]"
                                        id="digit5" maxlength="1" pattern="[0-9]" required value="{{ old('kode_prodi_digits.4') }}">
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-8 mb-4">
                    <div class="card text-left">
                        <div class="card-body">
                            {{-- your content should be here --}}
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="">Nama Program Studi<span style="color: red">*</span></label>
                                    <textarea class="form-control" id="prodi_nama" rows="3" name="prodi_nama" required>{{ old('prodi_nama') }}</textarea>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="prodi_jenjang">Jenjang <span style="color: red">*</span></label>
                                    <select class="form-control mb-1" id="prodi_jenjang" name="prodi_jenjang">
                                        <option value="">Pilih</option>
                                        <option value="S1" {{ old('prodi_jenjang') == 'S1' ? 'selected' : '' }}>S-1</option>
                                        <option value="S2" {{ old('prodi_jenjang') == 'S2' ? 'selected' : '' }}>S-2</option>
                                        <option value="S3" {{ old('prodi_jenjang') == 'S3' ? 'selected' : '' }}>S-3</option>
                                        <option value="D1" {{ old('prodi_jenjang') == 'D1' ? 'selected' : '' }}>D-1</option>
                                        <option value="D2" {{ old('prodi_jenjang') == 'D2' ? 'selected' : '' }}>D-2</option>
                                        <option value="D3" {{ old('prodi_jenjang') == 'D3' ? 'selected' : '' }}>D-3</option>
                                        <option value="D4" {{ old('prodi_jenjang') == 'D4' ? 'selected' : '' }}>D-4</option>
                                    </select>
                                    <label for="prodi_active_status">Status Program Studi<span style="color: red">*</span></label>
                                    <select class="form-control mb-1" id="prodi_active_status" name="prodi_active_status">
                                        <option value="Aktif" {{ old('prodi_active_status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('prodi_active_status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 mb-4">
                    <div class="card text-left">
                        <div class="card-body">
                            {{-- your conten should be here --}}
                            <h5>Ijin Pembuatan Program Studi</h5>
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="akta_nomor">Nomor Akta<span style="color: red">*</span></label>
                                    <textarea class="form-control" id="akta_nomor" rows="2" name="akta_nomor"  required>{{ old('akta_nomor') }}</textarea>
                                </div>
                                
                                <div class="col-md-6 form-group mb-3">
                                    <label for="akta_tgl_dibuat">Tanggal Akta Dibuat<span style="color: red">*</span></label>
                                    <input class="form-control" id="akta_tgl_dibuat" type="date" name="akta_tgl_dibuat" required value="{{ old('akta_tgl_dibuat') }}" />
                                </div>
                                
                              
                                <div class="col-md-6 form-group mb-3">
                                    <label for="akta_perihal">Perihal Akta<span style="color: red">*</span></label>
                                    <textarea class="form-control" id="akta_perihal" rows="2" name="akta_perihal"  required>{{ old('akta_perihal') }}</textarea>
                                </div>
    
                                <div class="col-md-6 form-group mb-3">
                                    <label for="akta_jenis">Jenis Akta<span style="color: red">*</span></label>
                                    <select class="form-control mb-1" id="akta_jenis" name="akta_jenis">
                                        <option value="Pendirian">Pendirian</option>
                                    </select>
                                </div>
    
                                <div class="col-md-6 form-group mb-3">
                                    <label for="akta_nama_atau_pengesah">Nama Notaris<span style="color: red">*</span></label>
                                    <textarea class="form-control" id="akta_nama_atau_pengesah" rows="2" name="akta_nama_atau_pengesah" required>{{ old('akta_nama_atau_pengesah') }}</textarea>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="akta_kota_notaris">Kota Notaris<span style="color: red">*</span></label>
                                    <select class="form-control select2" id="akta_kota_notaris" name="akta_kota_notaris" required>
                                        <option>Pilih</option>
                                        <!-- Opsi dari API akan ditambahkan di sini -->
                                    </select>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-4 mb-4">
                    <div class="card text-left">
                        <div class="card-body">
                            <label for="">File Akta<small>pdf</small></label>
                            <div class="card o-hidden mb-2">
                                <iframe id="akta_preview" height="175" frameborder="0"></iframe>
                            </div>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input class="custom-file-input" id="aktaFileInp" type="file" aria-describedby="inputGroupFileAddon01" name="akta_dokumen" value=""/>
                                    <label class="custom-file-label" for="inputGroupFile01" id="aktaFileLabelLogo">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            @include('layouts.agreement')
        </form>
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

        $("#logoInp").change(function(){
            readURL(this, '#blah');
        });

        // Ketika pengguna memilih file img, perbarui label
        $('#logoInp').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Mengambil nama file dari path lengkap

            // Memeriksa panjang nama file
            if (fileName.length > 20) {
                // Jika lebih dari 10 karakter, singkat nama file
                var shortenedFileName = fileName.substr(0, 15) + '...' + fileName.substr(-7);
                $('#imgLabelLogo').text(shortenedFileName); // Mengatur label dengan nama file yang disingkat
            } else {
                // Jika tidak, gunakan nama file lengkap
                $('#imgLabelLogo').text(fileName); // Mengatur label dengan nama file
            }
        });
    </script>

    <script>
        $("#aktaFileInp").change(function(){
            readURL(this, '#akta_preview');
        });

        // Ketika pengguna memilih file akta, perbarui label
        $('#aktaFileInp').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Mengambil nama file dari path lengkap

            // Memeriksa panjang nama file
            if (fileName.length > 20) {
                // Jika lebih dari 20 karakter, singkat nama file
                var shortenedFileName = fileName.substr(0, 15) + '...' + fileName.substr(-7);
                $('#aktaFileLabelLogo').text(shortenedFileName); // Mengatur label dengan nama file yang disingkat
            } else {
                // Jika tidak, gunakan nama file lengkap
                $('#aktaFileLabelLogo').text(fileName); // Mengatur label dengan nama file
            }
        });

    </script>

    <script>
        $(document).ready(function() {
            $('#badan-penyelenggara-select').select2();
        });

        $(document).ready(function() {
            $('#badan-penyelenggara-select').change(function() {
                let selectedValue = $(this).val();
                if(selectedValue == '') { // Jika nilai yang dipilih adalah kosong
                    // Reset nilai select
                    this.selectedIndex = 0; // Atur indeksnya ke 0 (pilihan pertama)
                    document.getElementById('org_logo').setAttribute('src', ''); // Mengosongkan sumber gambar
                    document.getElementById('org_nama').innerText = ''; // Mengosongkan teks
                    document.getElementById('org_status').innerText = ''; // Mengosongkan teks
                } else {
                    let orgLogoUrl = $('#org_logo').data('url');
                    $.ajax({
                        url: '{{ route("badan-penyelenggara.getBPById", ":value") }}'.replace(':value', selectedValue),
                        type: 'GET',
                        success: function(response) {
                            console.log(response)
                            let logoUrl = orgLogoUrl + '/'+ response.data[0]['org_logo'];

                            $('#org_logo').attr('src', logoUrl);
                            $('#org_nama_label').text(response.data[0]['org_nama']);
                            $('#org_status_label').text(response.data[0]['org_status']);
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
                    let lembagaLogoUrl = $('#lembaga_logo').data('url');
                    $.ajax({
                        url: '{{ route("lembaga-akreditasi.getById", ":value") }}'.replace(':value', selectedValue),
                        type: 'GET',
                        success: function(response) {
                            console.log(response);
                            let logoUrl = lembagaLogoUrl + '/'+ response.data[0]['lembaga_logo'];

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
        function moveToNextInput(currentInput, nextInputId) {
            if (currentInput.value.length === currentInput.maxLength) {
                document.getElementById(nextInputId).focus();
            }
        }
    </script>
        <script>
            // Ambil data dari API dan isi opsi select menggunakan Select2
            $(document).ready(function() {
                var oldAktaKotaNotaris = "{{ old('akta_kota_notaris') }}";
                // Ambil data dari API
                fetch(`http://127.0.0.1:8000/kota`)
                    .then(response => response.json())
                    .then(data => {
                        // Iterasi melalui setiap item dalam array data.data
                        for (let i = 0; i < data.data.length; i++) {
                            // Ambil item dari array data
                            const item = data.data[i];
                            var typeAndName = `${item.type} ${item.name}`;
                            var selectedAktaKotaNotaris = typeAndName === oldAktaKotaNotaris ? 'selected' : '';
                            // Tambahkan opsi-opsi dropdown untuk setiap item
                            $('#akta_kota_notaris').append('<option value="' + item.type +" "+ item.name + '">' + item.type +" "+ item.name + '</option>');
                            $('#akta_kota_notaris').append(`<option value="${typeAndName}" ${selectedAktaKotaNotaris}>${typeAndName}</option>`);
                        }
    
                        // Inisialisasi Select2
                        $('#akta_kota_notaris').select2();
                    })
                    .catch(error => console.error('Error:', error));
            });
        </script>
    
    
@endsection
