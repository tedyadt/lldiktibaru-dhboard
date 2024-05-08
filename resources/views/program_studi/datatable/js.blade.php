<script>
    $(document).ready(function() {
        const pertiId = '{{$pertiId}}';

        @can('create_data_program_studi')
        const addButton = {
            text: '+ Add New',
            attr: {
                id: 'add-new-program-studi',
                class: 'btn btn-primary',
            },
        }
        @endcan

        const tableButtons = [
            @can('create_data_program_studi')
                addButton
            @endcan
        ]
        const table = $('#main_table').DataTable({
            dom: 'Bfrtip',
            buttons: tableButtons,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("program-studi.getByIdperti", ["id_perti" => ":pertiId"]) }}'.replace(':pertiId', pertiId),                },
            columns: [{
                    data: 'prodi_defined_id',
                    name: 'prodi_defined_id',
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
                    data: 'prodi_kode',
                    name: 'prodi_kode'
                },
                {
                    data: 'prodi_nama',
                    name: 'prodi_nama'
                },
                {
                    data: 'prodi_jenjang',
                    name: 'prodi_jenjang'
                },
                {
                    data: 'prodi_active_status',
                    name: 'prodi_active_status'
                },
                {
                    data: 'akreditasi_sk',
                    name: 'akreditasi_sk',
                    render: function(data, type, row) {
                        if (data === null) {
                            return 'not set';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'lembaga_nama',
                    name: 'lembaga_nama',
                    render: function(data, type, row) {
                        if (data === null) {
                            return 'not set';
                        } else {
                            return data;
                        }
                    }

                },
                {
                    data: 'peringkat_nama',
                    name: 'peringkat_nama',
                    render: function(data, type, row) {
                        if (data === null) {
                            return 'not set';
                        } else {
                            return data;
                        }
                    }

                },
                {
                    data: 'action',
                    name: 'Action',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        var detailUrl =
                            "{{ route('program-studi.show', ':prodi_defined_id') }}".replace(
                                ':prodi_defined_id', row.prodi_defined_id)+ "?id_perti=" + pertiId;;
                        // var editUrl = "{{ route('program-studi.edit', ':prodi_defined_id') }}"
                        //     .replace(':prodi_defined_id', row.prodi_defined_id);

                        return `
                    <div class="btn-group dropleft">
                        <button class="btn bg-primary _r_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="_dot _r_block-dot bg-danger"></span>
                            <span class="_dot _r_block-dot bg-warning"></span>
                            <span class="_dot _r_block-dot bg-success"></span>
                        </button>
                        <div class="dropdown-menu" x-placement="bottom-start">
                            @can('show_data_program_studi')
                            <a class="dropdown-item" href="${detailUrl}">Detail</a>
                            @endcan
                        </div>
                    </div>
                `;
                    }
                }
            ],
            order: [
                [0, 'asc']
            ] // Order by the first column ('id') in ascending order
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#add-new-program-studi').click(function() {
            var url = '{{ route("program-studi.create", ['id_perti' => $pertiId]) }}';
            window.location.href = url;
        });
    });
</script>
