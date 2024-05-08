@can('access_data_akta_perti')
<h4>Daftar Akta Perguruan Tinggi </h4>
<p class="mb-4">Daftar Perkara Perguruan Tinggi {{ $perti->org_nama }}</p>
<div class="table-responsive">
    <table class="display table table-striped table-bordered" id="table_akta"
        style="width:100%">
        <thead>
            <tr>
                <th>id</th>
                <th>no</th>
                <th>No Surat Keputusan</th>
                <th>Perihal Surat Keputusan</th>
                <th>Surat Keputusan Dibuat</th>
                <th>Jenis Surat Keputusan</th>
                <th>Disahkan Oleh</th>
                <th>Status Perguruan TInggi</th>
            </tr>
        </thead>
    </table>
</div>
@endcan

