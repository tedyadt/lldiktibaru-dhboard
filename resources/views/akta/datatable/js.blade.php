<script>
    $(document).ready(function() {
        const pertiId = '{{$pertiId}}';
        
        @can('create_data_akta_perti')
        const addButton = {
            text: '+ Add New',
            attr: {
                id: 'add-new-perkara',
                class: 'btn btn-primary',
            },
        }
        @endcan

        const tableButtons = [
            @can('create_data_akta_perti')
                addButton
            @endcan
        ]
        const table = $('#table_akta').DataTable({
            dom: 'Bfrtip',
            buttons: tableButtons,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("akta.getByIdperti", ["id_perti" => ":pertiId"]) }}'.replace(':pertiId', pertiId),                
            },
            columns: [
                {
                    data: 'akta_defined_id',
                    name: 'akta_defined_id',
                    visible: false
                },
                {
                    data: null,
                    visible: true,
                    orderable: false,
                    width: "5%",
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'akta_nomor',
                    name: 'akta_nomor'
                },
                {
                    data: 'akta_perihal',
                    name: 'akta_perihal'
                },
                {
                    data: 'akta_tgl_dibuat',
                    name: 'akta_tgl_dibuat'
                },
                {
                    data: 'akta_jenis',
                    name: 'akta_jenis'
                },
                {
                    data: 'akta_nama_atau_pengesah',
                    name: 'akta_nama_atau_pengesah'
                },
                {
                    data: 'org_status',
                    name: 'org_status'
                },
            
                // {
                //     data: 'action',
                //     name: 'Action',
                //     searchable: false,
                //     orderable: false,
                //     render: function(data, type, row, meta) {
                //         var detailUrl =
                //             "{{ route('berita-acara-perkara.getStatusDetail', ':bap_defined_id') }}".replace(
                //                 ':bap_defined_id', row.bap_defined_id);

                //         var data_bap_perkara = row.bap_perkara;
                //         var data_bap_defined_id = row.bap_defined_id;

                //         return `
                //     <div class="btn-group dropleft">
                //         <button class="btn bg-primary _r_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                //             <span class="_dot _r_block-dot bg-danger"></span>
                //             <span class="_dot _r_block-dot bg-warning"></span>
                //             <span class="_dot _r_block-dot bg-success"></span>
                //         </button>
                //         <div class="dropdown-menu" x-placement="bottom-start">
                //             @can('show_perkara_perguruan_tinggi')
                //             <a class="dropdown-item" style="cursor:pointer;" data-toggle="modal" id="detail_link" data-target="#exampleModalCenter"  data-url="${detailUrl}" data-bap-perkara="${data_bap_perkara}">Detail</a>
                //             @endcan
                //             @can('edit_perkara_perguruan_tinggi')
                //             <a class="dropdown-item" style="cursor:pointer;" data-toggle="modal" id="update_link" data-target="#modalUpdate"  data-bap-perkara="${data_bap_perkara}" data-bap-defined-id="${data_bap_defined_id}">Update</a>
                //             @endcan
                //         </div>
                //     </div>
                // `;
                //     }
                // }
            ],
            order: [
                [4, 'asc']
            ] // Order by the first column ('id') in ascending order
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#add-new-perkara').click(function() {
            var url = '{{ route("akta.create", ['id_perti' => $pertiId]) }}';
            window.location.href = url;
        });
    });
</script>

<script>
    $(document).on('click', '#detail_link', function(e) {
        e.preventDefault();
        var detailUrl = $(this).data('url');
        var bapPerkara = $(this).data('bap-perkara');
        $.ajax({
            url: detailUrl,
            type: 'GET',
            success: function(response) {
                // Menghapus konten sebelumnya dari modal
                $('.media-detail').empty();

                $('#bap_perkara').text(bapPerkara)
                response.data.forEach(function(item) {
                    var $mediaItem = $('<li class="media media-detail"></li>');
                    var $timelineBadge = $('<div class="timeline-badge bg-primary mr-3" style="width: 20px; height: 20px;"></div>');
                    var $mediaBody = $('<div class="media-body"></div>');

                    var $title = $('<h4 class="mt-0 mb-0" style="font-weight: bold;"></h4>').text(item.bap_status);
                    var createdDate = item.created_at.substring(0, 10);
                    var $date = $('<p class="mb-0" style="color: #666;"></p>').text(createdDate);
                    var $description = $('<p style="margin-bottom: 2;"></p>').text(item.bap_keterangan);

                    $mediaBody.append($title, $date, $description);
                    $mediaItem.append($timelineBadge, $mediaBody);

                    $('.modal-body-detail').append($mediaItem);
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
</script>

<script>
    $(document).on('click', '#update_link', function(e) {
        e.preventDefault();
        var bapPerkara = $(this).data('bap-perkara');
        var bapDefinedId = $(this).data('bap-defined-id');
        
        var formAction = "{{ route('berita-acara-perkara.createStatus', 'id_bap=:bapDefinedId') }}";
        formAction = formAction.replace(':bapDefinedId', bapDefinedId);
        $('#update-bap-form').attr('action', formAction);
        $('#bap_perkara_update').text(bapPerkara);
        $('#id_bap_value').val(bapDefinedId);
        
    });
</script>

