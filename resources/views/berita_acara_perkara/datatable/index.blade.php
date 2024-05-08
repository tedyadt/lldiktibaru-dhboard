@can('access_perkara_perguruan_tinggi')
<h4>Daftar Perkara Perguruan Tinggi </h4>
<p class="mb-4">Daftar Perkara Perguruan Tinggi {{ $perti->org_nama }}</p>
<div class="table-responsive">
    <table class="display table table-striped table-bordered" id="table_perkara"
        style="width:100%">
        <thead>
            <tr>
                <th>id</th>
                <th>No</th>
                <th>Perkara</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<!--  Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail Berita Acara</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body modal-body-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Berita Acara Perkara</h5>
                            <p id="bap_perkara"></p>
                            <ul class="list-unstyled">
                                <li class="media media-detail">
                                    {{-- <div class="timeline-badge bg-primary mr-3" style="width: 20px; height: 20px;"></div>
                                    <div class="media-body">
                                        <h4 class="mt-0 mb" style="font-weight: bold;"></h4>
                                        <p class="mb" style="color: #666;"></p>
                                        <p style="margin-bottom: 0;"></p>
                                    </div> --}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Berita Acara</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body modal-body-update" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Berita Acara Perkara</h5>
                            <p id="bap_perkara_update"></p>
                            <ul class="list-unstyled">
                                <li class="media media-update">
                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form id="update-bap-form" method="post"> {{-- setting routenya di berita_acara_perkara/datatable/js.blade.php --}}
                                                    @csrf
                                                    <input type="hidden" id="id_bap_value" required readonly name="bap_defined_id">
                                                    <div class="row">
                                                        <div class="col-md-12 form-group mb-3">
                                                            <label for="bap_status">Status Perkara<span style="color: red">*</span></label>
                                                            <select id="bap_status" style="width: 100%" class="form-control mb-1" name="bap_status" required>
                                                                <option value="">Pilih</option>
                                                                <option value="Belum Diproses">Belum Diproses</option>
                                                                <option value="Sedang Diproses">Sedang Diproses</option>
                                                                <option value="Selesai Diproses">Selesai Diproses</option>
                                                            </select> 
                                                        </div>
                                                        <div class="col-md-12 form-group mb-3">
                                                            <label for="bap_keterangan">Keterangan</label>
                                                            <textarea class="form-control" id="bap_keterangan" rows="5" name="bap_keterangan"></textarea>
                                                        </div>
                                                        <div class="col-md-12 ">
                                                            <p class="mb-1">Kami dengan ini mengonfirmasi bahwa pengguna</p>
                                                            <table>
                                                                <tr>
                                                                    <th>Nama</th>
                                                                    <td>:</td>
                                                                    <td>{{ Auth::user()->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Nip</th>
                                                                    <td>:</td>
                                                                    <td>{{  Auth::user()->nip }}</td>
                                                                </tr>
                                                            </table>
                                                            <p class="mt-1">yang tercantum telah setuju untuk bertindak sebagai penanggung jawab atas data yang dibuat.</p>
                                                            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                                                            <label class="checkbox checkbox-primary">
                                                                <input type="checkbox" name="agreement" required /><span>Checklist Untuk Menyetujui</span><span style="color: red">*</span><span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-12 form-group mb-3">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <button type="submit" class="btn btn-primary btn-block">Save changes</button>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <button type="button" class="btn btn-secondary btn-block" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endcan

