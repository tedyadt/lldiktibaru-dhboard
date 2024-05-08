@can('access_data_program_studi')
<h4>Daftar Program Studi </h4>
<p class="mb-4">Daftar program Studi di bawah {{ $perti->org_nama }}</p>
<div class="table-responsive">
    <table class="display table table-striped table-bordered" id="main_table"
        style="width:100%">
        <thead>
            <tr>
                <th>id</th>
                <th>No</th>
                <th>Kode PS</th>
                <th>Nama Program Studi</th>
                <th>Jenjang</th>
                <th>Status</th>
                <th>Nomor SK</th>
                <th>Lembaga Akreditasi</th>
                <th>Peringkat Akreditasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>                                
@endcan
