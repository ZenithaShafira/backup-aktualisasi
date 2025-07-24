$(document).ready(function () {
    $('#kegiatan_id').prop('disabled', true);
    $('#bulan_kegiatan').prop('disabled', true);
    $('#tahun_kegiatan').prop('disabled', true);
    $('#folder_url').prop('disabled', true);
    $("#editButton").prop("disabled", true);
    $("#prevEditButton").prop("disabled", true).hide();

    function checkButtons() {
        const allEnabled =
            !$('#kegiatan_id').prop('disabled') &&
            !$('#bulan_kegiatan').prop('disabled') &&
            !$('#tahun_kegiatan').prop('disabled') &&
            !$('#folder_url').prop('disabled') 

        if (allEnabled) {
            $("#prevEditButton").prop("disabled", false).show();
        } else {
            $("#prevEditButton").prop("disabled", true).hide();
        }

        if ($('#folder_url').val() !== '') {
            $("#editButton").prop("disabled", false);
        } else {
            $("#editButton").prop("disabled", true);
        }
    }

    $('#jenis_peta').on('change', function() {
        const jenis = $(this).val();
        // console.log(jenis);

        $('#kegiatan_id').html('<option value="" disabled selected>Loading...</option>');

        $.ajax({
            url: `/edit-peta/get-kegiatan/${jenis}`,
            type: 'GET',
            success: function (data) {
                // console.log(data);
                let options = '<option value="" disabled selected>Pilih Kegiatan</option>';
                data.forEach(function (item) {
                    options += `<option value="${item.kode_kegiatan}">(${item.kode_kegiatan}) ${item.nama_kegiatan}</option>`;
                });
                $('#kegiatan_id').html(options);
                $('#kegiatan_id').prop('disabled', false);
                checkButtons();
            },
            error: function () {
                $('#kegiatan_id').html('<option value="" disabled selected>Gagal memuat data</option>');
            }
        });
    });

    $('#kegiatan_id').on('change', function() {
        const jenis = $('#jenis_peta').val();
        const kegiatan = $(this).val();
        // console.log(jenis);

        $('#bulan_kegiatan').html('<option value="" disabled selected>Loading...</option>');

        $.ajax({
            url: `/edit-peta/get-bulan/${jenis}/${kegiatan}`,
            type: 'GET',
            success: function (data) {
                // console.log(data);
                let options = '<option value="" disabled selected>Pilih Bulan</option>';
                data.forEach(function (item) {
                    options += `<option value="${item.bulan_kegiatan}">${item.nama_bulan}</option>`;
                });
                $('#bulan_kegiatan').html(options);
                $('#bulan_kegiatan').prop('disabled', false);
                checkButtons();
            },
            error: function () {
                $('#bulan_kegiatan').html('<option value="" disabled selected>Gagal memuat data</option>');
            }
        });
    });

    $('#bulan_kegiatan').on('change', function() {
        const jenis = $('#jenis_peta').val();
        const kegiatan = $('#kegiatan_id').val();
        const bulan = $(this).val();
        // console.log(jenis);

        $('#tahun_kegiatan').html('<option value="" disabled selected>Loading...</option>');

        $.ajax({
            url: `/edit-peta/get-tahun/${jenis}/${kegiatan}/${bulan}`,
            type: 'GET',
            success: function (data) {
                // console.log(data);
                let options = '<option value="" disabled selected>Pilih Tahun</option>';
                data.forEach(function (item) {
                    options += `<option value="${item.tahun_kegiatan}">${item.tahun_kegiatan}</option>`;
                });
                $('#tahun_kegiatan').html(options);
                $('#tahun_kegiatan').prop('disabled', false);
                checkButtons();
            },
            error: function () {
                $('#tahun_kegiatan').html('<option value="" disabled selected>Gagal memuat data</option>');
            }
        });
    });

    $('#tahun_kegiatan').on('change', function() {
        const jenis = $('#jenis_peta').val();
        const kegiatan = $('#kegiatan_id').val();
        const bulan = $('#bulan_kegiatan').val();
        const tahun = $(this).val();

        $('#folder_url').val('Loading...');

        $.ajax({
            url: `/edit-peta/get-link/${jenis}/${kegiatan}/${bulan}/${tahun}`,
            type: 'GET',
            success: function (data) {
                // console.log(data);
                $('#folder_url').val(data.data[0].link_folder);
                $('#history_id').val(data.data[0].id);
                checkButtons();  

                // $('#prevLamaTabel').DataTable({
                //     destroy: true,     
                //     data: data.list_peta,    
                //     columns: [
                //         { data: 'nama_file', title: 'Nama File' },
                //         { data: 'link_file', title: 'Link',
                //             render: link => `<a href="${link}" target="_blank">View</a>`
                //         }
                //     ],
                //     lengthMenu: [[10,25,50,100,-1],[10,25,50,100,'All']],
                //     dom:'Bflrtip',
                //     responsive: true
                //     });
            },
            error: function () {
                $('#folder_url').val("Gagal memuat data");
            }
        });
    });
    
    $('#editButton').on('click', function () {
        $('#folder_url').prop('disabled', false).focus();
        checkButtons();
    });
    
    $('#prevEditButton').on('click', function () {
        const history = $('#history_id').val();
        const link = $('#folder_url').val();

        $.ajax({
            url: '/edit-peta/get-prev-baru',
            type: 'GET',
            data: { link: $('#folder_url').val() },
            success: function (data) {
                $('#prevBaruTabel').DataTable({
                    destroy: true,     
                    data: data,    
                    columns: [
                        { data: 'name', title: 'Nama File' },
                        { data: 'link', title: 'Link',
                            render: link => `<a href="${link}" target="_blank">View</a>`
                        }
                    ],
                    lengthMenu: [[10,25,50,100,-1],[10,25,50,100,'All']],
                    dom:'Bflrtip',
                    responsive: true
                });

                $('#hasilPrev').val(JSON.stringify(data));
            },
            error: function () {
                $('#folder_url').val("Gagal memuat data");
            }
        });
    });

    $('#editPeta').submit(function(event) {
        event.preventDefault();
    
        swal({
            text: 'Apakah anda yakin untuk edit peta?',
            icon: 'warning',
            buttons: true,
            dangerMode: false,
        }).then((willProceed) => {
            if (willProceed) {
                this.submit();
            } else {
                swal.close();
            }
        });
    });
});
