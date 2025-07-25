$(document).ready(function() {
    // disabled versi
    $('#versi').prop('disabled', true);

    $('#jenis_peta').on('change', function(){
        if ( $(this).val() === 'WB' ) {
        $('#versi')
            .prop('disabled', false)   // enable versi
            .focus();                  
        } else {
        $('#versi')
            .prop('disabled', true)    // disable lagi kalo ganti pilihan   
            .val('');                  // reset pilihan
        }
    });
    
    $('#prevPeta').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        const url = $form.attr('action');
        const data = $form.serialize();

        $('#prevTabel').DataTable().clear().destroy();
        $('#prevCard').hide();
        $('#loadingText').show();

        $.post(url, data)
            .done(function(resp) {
                // console.log(resp); 
                $('#loadingText').hide();
                $('#statusText').empty();
                $('#statusText').hide();
                if (!resp.files || !resp.files.length) {
                    $('#prevTabel_wrapper').remove();
                    $('#statusText').html(`<div class="alert alert-danger">Folder kosong atau link salah.</div>`);
                } else {
                    $('#prevCard').fadeIn();
                    $('#prevTabel').show();
                    $('#prevTabel').DataTable({
                        destroy: true,
                        data: resp.files,
                        columns: [
                            { data: 'name', title: 'Nama File' },
                            { data: 'link', title: 'Link',
                                render: link => link ? `<a href="${link}" target="_blank" class="btn btn-sm btn-primary">View</a>` : 'No Link'
                            }
                        ],
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                        dom: 'Bflrtip',
                        responsive: true
                    });
                    $('#simpanPeta').show();

                    $('#store_kegiatan_id').val(resp.kegiatan_id);
                    $('#store_tahun').val(resp.tahun_kegiatan);
                    $('#store_bulan').val(resp.bulan_kegiatan);
                    $('#store_jenis').val(resp.jenis_peta);
                    $('#store_versi').val(resp.versi);
                    $('#store_link').val(resp.link);
                    $('#store_peta').val(JSON.stringify(resp.files));
                }
            })
            .fail(function(xhr) {
                let msg = 'Terjadi kesalahan. Coba cek input atau koneksi.';
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }

                $('#loadingText').hide();
                $('#statusText').html(`<div class="alert alert-danger">${msg}</div>`);
                $('#prevTabel').hide();
                // $('#prevTabel').parent().html(`<div class="alert alert-danger">${msg}</div>`);
                $('#prevCard').fadeIn();
                $('#simpanPeta').hide();
            });
    });


    
    $('#storePeta').submit(function(event) {
        event.preventDefault();
    
        swal({
            text: 'Apakah anda yakin untuk simpan peta?',
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