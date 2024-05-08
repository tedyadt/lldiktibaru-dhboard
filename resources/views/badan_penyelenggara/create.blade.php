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
<div class="main-content pt-4">
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('badan-penyelenggara') }}">Badan Penyelenggara</a></li>
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


    <form action="{{ route('badan-penyelenggara') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row ">
            <div class="col-md-8 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        {{-- your conten should be here --}}
                        <h5>Informasi Badan Penyelenggara</h5>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="org_nama">Nama Badan Penyelenggara<span style="color: red">*</span></label>
                                <textarea class="form-control" id="org_nama" rows="3" name="org_nama"required>{{ old('org_nama') }}</textarea>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="org_alamat">Alamat Badan Penyelenggara <span style="color: red">*</span></label>
                                <textarea class="form-control" id="org_alamat" rows="3" name="org_alamat"  required>{{ old('org_alamat') }}</textarea>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="org_nama_singkat">Akronim Badan Penyelenggara <span style="color: red">*</span></label>
                                <textarea class="form-control" id="org_nama_singkat" rows="2" name="org_nama_singkat"  required>{{ old('org_nama_singkat') }}</textarea>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="org_kota">Kota Badan Penyelenggara <span style="color: red">*</span></label>
                                <select class="form-control select2" id="org_kota" name="org_kota" required>
                                    <option>Pilih</option>
                                    <!-- Opsi dari API akan ditambahkan di sini -->
                                </select>
                            </div>                            
                            <div class="col-md-4 form-group mb-3">
                                <label for="org_email">Email Badan Penyelenggara</label>
                                <textarea class="form-control" id="org_email" rows="3" name="org_email" >{{ old('org_email') }}</textarea>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="org_telp">Telepon Badan Penyelenggara</label>
                                <textarea class="form-control" id="org_telp" rows="3" name="org_telp" >{{ old('org_telp') }}</textarea>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="org_website">Website Badan Penyelenggara</label>
                                <textarea class="form-control" id="org_website" rows="3" name="org_website" >{{ old('org_website') }}</textarea>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <label for="">Logo Badan Penyelenggara <br> <small>jpg/jpeg/png max 5mb</small></label>
                        <div class="card o-hidden mb-2">
                            <center>
                                <iframe align="center" frameborder='0' id="blah" height="245" ></iframe>
                            </center>
                        </div>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input class="custom-file-input" id="logoInp" type="file" aria-describedby="inputGroupFileAddon01" name="org_logo"/>
                                @if(old('org_logo'))
                                    <input type="hidden" name="org_logo" value="{{ old('org_logo') }}">
                                    <p>File terpilih: {{ old('org_logo') }}</p>
                                @endif
                                <label class="custom-file-label" for="logoInp" id="imgLabelLogo">Choose file</label>
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
                        <h5>Akta Pendirian Badan Penyelenggara</h5>
                        {{-- your conten should be here --}}
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
                                <textarea class="form-control" id="akta_perihal" rows="2" name="akta_perihal" required >{{ old('akta_perihal') }}</textarea>
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
                        <label for="">File Akta <small>pdf maksimal 18mb</small></label>
                        <div class="card o-hidden mb-2">
                            <iframe id="akta_preview" height="215" frameborder="0"></iframe>
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

        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        {{-- your conten should be here --}}
                        <h5>Akta Kemenkumham</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="kumham_nomor_sk">Nomor Surat Keputusan</label>
                                    <textarea class="form-control kumham_input" id="kumham_nomor_sk" rows="2" name="kumham_nomor_sk"  >{{ old('kumham_nomor_sk') }}</textarea>
                                </div>
                                <div class="col-md-12 form-group mb-3">
                                    <label for="kumham_tgl_sk">Tanggal Surat Keputusan</label>
                                    <input class="form-control kumham_input" style="height: 50px" id="kumham_tgl_sk" type="date" name="kumham_tgl_sk" value="{{ old('kumham_tgl_sk') }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">File Surat Keputusan</label>
                                <div class="card o-hidden mb-2">
                                    <iframe id="kumham_dokumen_preview" frameborder="0"></iframe>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input class="custom-file-input kumham_input" id="form_inp_kumham_dokumen" type="file" aria-describedby="inputGroupFileAddon01" name="kumham_dokumen" />
                                        <label class="custom-file-label" for="inputGroupFile01" id="kumham_dokumen_inp_label">Choose file</label>
                                    </div>
                                </div>
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
        // Ambil data dari API dan isi opsi select menggunakan Select2
        $(document).ready(function() {
            var oldAktaKotaNotaris = "{{ old('akta_kota_notaris') }}";
            var oldOrgKota = "{{ old('org_kota') }}";
            // Ambil data dari API
            fetch(`http://127.0.0.1:8000/kota`)
                .then(response => response.json())
                .then(data => {
                    // Iterasi melalui setiap item dalam array data.data
                    for (let i = 0; i < data.data.length; i++) {
                        // Ambil item dari array data
                        const item = data.data[i];
                        // Gabungkan type dan name dalam satu variabel
                        var typeAndName = `${item.type} ${item.name}`;
                        // Tentukan apakah opsi harus dipilih berdasarkan nilai oldAktaKotaNotaris
                        var selectedAktaKotaNotaris = typeAndName === oldAktaKotaNotaris ? 'selected' : '';
                        var selectedOrgKota = typeAndName === oldOrgKota ? 'selected' : '';
                        $('#org_kota').append(`<option value="${typeAndName}" ${selectedOrgKota}>${typeAndName}</option>`);
                        $('#akta_kota_notaris').append(`<option value="${typeAndName}" ${selectedAktaKotaNotaris}>${typeAndName}</option>`);
                     }

                    // Inisialisasi Select2
                    $('#org_kota').select2();
                    $('#akta_kota_notaris').select2();
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    <script>

        $("#form_inp_kumham_dokumen").change(function(){
            readURL(this, '#kumham_dokumen_preview');
        });

        // Ketika pengguna memilih file img, perbarui label
        $('#form_inp_kumham_dokumen').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Mengambil nama file dari path lengkap

            // Memeriksa panjang nama file
            if (fileName.length > 20) {
                // Jika lebih dari 10 karakter, singkat nama file
                var shortenedFileName = fileName.substr(0, 15) + '...' + fileName.substr(-7);
                $('#kumham_dokumen_inp_label').text(shortenedFileName); // Mengatur label dengan nama file yang disingkat
            } else {
                // Jika tidak, gunakan nama file lengkap
                $('#kumham_dokumen_inp_label').text(fileName); // Mengatur label dengan nama file
            }
        });
    </script>


                        

@endsection