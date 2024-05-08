@can('access_data_akreditasi_prodi')
<h4>Daftar Akreditasi Program Studi</h4>
<p class="mb-4"> Daftar Akreditasi Program Studi {{ $prodi->prodi_jenjang }} {{ $prodi->prodi_nama }} {{ $prodi->org_nama }}  </p>
<div class="table-responsive">
    <table class="display table table-striped table-bordered" id="table_akreditasi"
        style="width:100%">
        <thead>
            <tr>
                <th>id</th>
                <th>No</th>
                <th>Nomor Sk Akreditasi</th>
                <th>Tanggal Dibuat SK</th>
                <th>Masa Berlaku Mulai</th>
                <th>Masa Berlaku Selesai</th>
                <th>Lembaga Akreditasi</th>
                <th>Peringkat Akreditasi</th>
                <th>Status</th>
=            </tr>
        </thead>
    </table>
</div>    
@endcan                            
