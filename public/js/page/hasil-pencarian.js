function checkFormReady() {
    var jenisPetaVal = $('#jenis_peta').val();
    var keywordVal = $('#keyword').val().trim();

    if (jenisPetaVal && keywordVal) {
        $('#tombolSearch').prop('disabled', false);
    } else {
        $('#tombolSearch').prop('disabled', true);
    }
}

$(document).ready(function() {
    $('#jenis_peta').on('change', checkFormReady);   
    $('#keyword').on('input', checkFormReady);
    checkFormReady(); 
        
    $('#cariPeta').on('submit', function(e){
        e.preventDefault();
        const $form = $(this);
        const url   = $form.attr('action');
        const data  = $form.serialize();

        const $container = $('#hasilContainer');
        $container.empty(); 

        $.get(url, data)
            .done(function(resp) {
                if (!resp || Object.keys(resp).length === 0) {
                    $container.html('<div class="alert alert-warning">Peta tidak ditemukan.</div>');
                    return;
                }

                let index = 0;
                $.each(resp, function(groupKey, rows) {
                    index++;
                    const tableId = `hasilSearch_${index}`;

                    const cardHtml = `
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>${groupKey}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped w-100" id="${tableId}">
                                            <thead>
                                                <tr>
                                                    <th>Nama Kecamatan</th>
                                                    <th>Nama Kelurahan</th>
                                                    <th>Nama File</th>
                                                    <th>Link</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    $container.append(cardHtml);

                    $(`#${tableId}`).DataTable({
                        data: rows,
                        columns: [
                            { data: 'nama_kec', title: 'Nama Kecamatan' },
                            { data: 'nama_kel', title: 'Nama Kelurahan' },
                            { data: 'nama_file', title: 'Nama File' },
                            {
                                data: 'link_file',
                                title: 'Peta',
                                render: function(data) {
                                    return `<a href="${data}" target="_blank" class="btn btn-sm btn-primary">View</a>`;
                                }
                            }
                        ],
                        responsive: true,
                        destroy: true,
                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
                        dom: 'Bflrtip'
                    });
                });
            })
            .fail(function(xhr) {
                let msg = 'Terjadi kesalahan. Silahkan cek input atau koneksi.';
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                $('#hasilContainer').html(`<div class="alert alert-danger">${msg}</div>`);
            });
    });

});