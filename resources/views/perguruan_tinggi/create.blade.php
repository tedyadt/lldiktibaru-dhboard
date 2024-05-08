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
            <li>
                <a href="{{ route('perguruan-tinggi' ) }}">Perguruan Tinggi</a> |
                <a href="{{ route('perguruan-tinggi.create' ) }}">Tambah</a> |
            </li>
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

    <form action="{{ route('perguruan-tinggi') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-7 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        {{-- your conten should be here --}}
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="perti_kode">Kode PT<span style="color: red">*</span></label>
                            </div>
                        </div>
                        <div class="row mr-2">
                            <div class="col-md-2 col-2">
                                <input type="text" style="width:50px; height: 50px; font-size: 24px" class="form-control text-center font-weight-bold" name="kode_pt_digits[]" id="digit1" maxlength="1" pattern="[0-9]" required onkeyup="moveToNextInput(this, 'digit2')" value="{{ old('kode_pt_digits.0') }}">
                            </div>
                            <div class="col-md-2 col-2">
                                <input type="text" style="width:50px; height: 50px; font-size: 24px" class="form-control text-center font-weight-bold" name="kode_pt_digits[]" id="digit2" maxlength="1" pattern="[0-9]" required onkeyup="moveToNextInput(this, 'digit3')"value="{{ old('kode_pt_digits.1') }}">
                            </div>
                            <div class="col-md-2 col-2 ">
                                <input type="text" style="width:50px; height: 50px; font-size: 24px" class="form-control text-center font-weight-bold" name="kode_pt_digits[]" id="digit3" maxlength="1" pattern="[0-9]" required onkeyup="moveToNextInput(this, 'digit4')" value="{{ old('kode_pt_digits.2') }}">
                            </div>
                            <div class="col-md-2 col-2">
                                <input type="text" style="width:50px; height: 50px; font-size: 24px" class="form-control text-center font-weight-bold" name="kode_pt_digits[]" id="digit4" maxlength="1" pattern="[0-9]" required onkeyup="moveToNextInput(this, 'digit5')" value="{{ old('kode_pt_digits.3') }}">
                            </div>
                            <div class="col-md-2 col-2">
                                <input type="text" style="width:50px; height: 50px; font-size: 24px" class="form-control text-center font-weight-bold" name="kode_pt_digits[]" id="digit5" maxlength="1" pattern="[0-9]" required onkeyup="moveToNextInput(this, 'digit6')" value="{{ old('kode_pt_digits.4') }}">
                            </div>
                            <div class="col-md-2 col-2">
                                <input type="text" style="width:50px; height: 50px; font-size: 24px" class="form-control text-center font-weight-bold" name="kode_pt_digits[]" id="digit6" maxlength="1" pattern="[0-9]" required value="{{ old('kode_pt_digits.5') }}">
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
                        {{-- your conten should be here --}}
                        <h5>Identitas Perguruan Tinggi</h5>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="org_nama">Nama Perguruan Tinggi<span style="color: red">*</span></label>
                                <textarea class="form-control" id="org_nama" rows="3" name="org_nama" required>{{ old('org_nama') }}</textarea>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="org_alamat">Alamat Perguruan Tinggi <span style="color: red">*</span></label>
                                <textarea class="form-control" id="org_alamat" rows="3" name="org_alamat"  required>{{ old('org_alamat') }}</textarea>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="org_nama_singkat">Akronim Perguruan Tinggi <span style="color: red">*</span></label>
                                <textarea class="form-control" id="org_nama_singkat" rows="2" name="org_nama_singkat" required>{{ old('org_nama_singkat') }}</textarea>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="org_kota">Kota Perguruan Tinggi<span style="color: red">*</span></label>
                                <select class="form-control select2" id="org_kota" name="org_kota" required>
                                    <option>Pilih</option>
                                    <!-- Opsi dari API akan ditambahkan di sini -->
                                </select>
                            </div>                            

                            <div class="col-md-4 form-group mb-3">
                                <label for="org_email">Email Perguruan Tinggi</label>
                                <textarea class="form-control" id="org_email" rows="3" name="org_email" >{{ old('org_email') }}</textarea>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="org_telp">Telepon Perguruan Tinggi</label>
                                <textarea class="form-control" id="org_telp" rows="3" name="org_telp" >{{ old('org_telp') }}</textarea>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="org_website">Website Perguruan Tinggi</label>
                                <textarea class="form-control" id="org_website" rows="3" name="org_website" >{{ old('org_website') }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <small>
                                    <span style="color:blue">*</span> Status Perguruan Tinggi akan otomatis berstatus aktif
                                </small>
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <label for="">Logo Perguruan Tinggi<small> jpg/jpeg/png max 5mb</small></label>
                        <div class="card o-hidden mb-2">
                            <center>
                                <iframe align="center" frameborder='0' id="blah" height="245" ></iframe>
                            </center>
                        </div>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input class="custom-file-input" id="logoInp" type="file" aria-describedby="inputGroupFileAddon01" name="org_logo" value=""/>
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
                        {{-- your conten should be here --}}
                        <div class="row ">
                            <div class="col-md-12 form-group mb-3">
                                <label for="badan-penyelenggara-select ">Badan Penyelenggara<span style="color: red">*</span></label>
                                <select id="badan-penyelenggara-select" class="js-example-basic-single" name="parent_organization_id" style="width: 100%" required>
                                    <option value="">Pilih</option>
                                    @foreach ($badanPenyelenggara_s as $item)
                                    <option value="{{ $item->org_defined_id }}">{{ $item->org_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row m-3">
                                <div class="col-md-5 d-flex justify-content-center align-items-center">
                                    <img class="img-fluid rounded mb-2" id="org_logo" data-url="{{ asset('storage/organization/logo/') }}"  alt="" />
                                </div>
                                <div class="col-md-5 d-flex justify-content-center align-items-center flex-column">
                                    <h2 id="org_nama_label" class="font-weight-bold text-center mb-0"></h2>
                                    <h6 id="org_status_label" class="font-weight-bold text-center mt-2"></h6>
                                </div>
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
                        <h5>Ijin Penyelenggaraan Perguruan Tinggi</h5>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="akta_nomor">Nomor Surat Keputusan<span style="color: red">*</span></label>
                                <textarea class="form-control" id="akta_nomor" rows="2" name="akta_nomor"  required>{{ old('akta_nomor') }}</textarea>
                            </div>
                            
                            <div class="col-md-6 form-group mb-3">
                                <label for="akta_tgl_dibuat">Tanggal SK Dibuat<span style="color: red">*</span></label>
                                <input class="form-control" id="akta_tgl_dibuat" type="date" name="akta_tgl_dibuat" required value="{{ old('akta_tgl_dibuat') }}" />
                            </div>
                            
                          
                            <div class="col-md-6 form-group mb-3">
                                <label for="akta_perihal">Perihal SK<span style="color: red">*</span></label>
                                <textarea class="form-control" id="akta_perihal" rows="2" name="akta_perihal"  required>{{ old('akta_perihal') }}</textarea>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="akta_nama_atau_pengesah">Yang Mengesahkan<span style="color: red">*</span></label>
                                <textarea class="form-control" id="akta_nama_atau_pengesah" rows="2" name="akta_nama_atau_pengesah" required>{{ old('akta_nama_atau_pengesah') }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <small>
                                    <span style="color:blue">*</span> Status SK akan otomatis berstatus sebagai akta pendirian
                                </small>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <label for="">File Akta<small> pdf maksimal 18mb</small></label>
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
                            if (response.data[0]['org_logo'] === 'not_set.png') {
                                logoUrl = '{{ asset("storage/not_set.png") }}';
                            } else {
                                logoUrl = orgLogoUrl + '/' + response.data[0]['org_logo'];
                            }
                            $('#org_logo').attr('src', logoUrl);
                            $('#org_nama_label').text(response.data[0]['org_nama']);
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
        // Ambil data dari API dan isi opsi select menggunakan Select2
        $(document).ready(function() {
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
                        var selectedOrgKota = typeAndName === oldOrgKota ? 'selected' : '';
                        $('#org_kota').append(`<option value="${typeAndName}" ${selectedOrgKota}>${typeAndName}</option>`);
                    }

                    // Inisialisasi Select2
                    $('#org_kota').select2();
                })
                .catch(error => console.error('Error:', error));
        });
    </script>


    <script>
        function moveToNextInput(currentInput, nextInputId) {
            if (currentInput.value.length === currentInput.maxLength) {
                document.getElementById(nextInputId).focus();
            }
        }
    </script>
    
@endsection
