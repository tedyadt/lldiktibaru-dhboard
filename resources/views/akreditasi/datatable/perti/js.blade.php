<script>
    $(document).ready(function() {
        const pertiId = '{{$pertiId}}';
        
        @can('create_data_akreditasi_perti')
        const addButton = {
            text: '+ Add New',
            attr: {
                id: 'add-new-akreditasi',
                class: 'btn btn-primary',
            },
        }
        @endcan

        const tableButtons = [
            @can('create_data_akreditasi_perti')
                addButton
            @endcan
        ]
        const table = $('#table_akreditasi').DataTable({
            dom: 'Bfrtip',
            buttons: tableButtons,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("akreditasi.getByIdperti_prodi", ["id_perti_prodi" => ":pertiId", "byperti_prodi"=>"id_organization"]) }}'.replace(':pertiId', pertiId),                
            },
            columns: [
                {
                    data: 'akreditasi_defined_id',
                    name: 'akreditasi_defined_id',
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
                    data: 'akreditasi_sk',
                    name: 'akreditasi_sk'
                },
                {
                    data: 'akreditasi_tgl_dibuat',
                    name: 'akreditasi_tgl_dibuat',
                    render: function(data, type, row) {
                        if (data === '1000-01-01') {
                            return 'not set';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'akreditasi_tgl_awal',
                    name: 'akreditasi_tgl_awal',
                    render: function(data, type, row) {
                        if (data === '1000-01-01') {
                            return 'not set';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'akreditasi_tgl_akhir',
                    name: 'akreditasi_tgl_akhir',
                    render: function(data, type, row) {
                        if (data === '1000-01-01') {
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
                    data: 'akreditasi_status',
                    name: 'akreditasi_status'
                },

            ],
            order: [
                [0, 'desc']
            ] // Order by the first column ('id') in ascending order
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#add-new-akreditasi').click(function() {
            var url = '{{ route("akreditasi.create", ['id_perti' => $pertiId]) }}';
            window.location.href = url;
        });
    });
</script>

