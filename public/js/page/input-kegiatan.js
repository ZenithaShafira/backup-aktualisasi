// $(".pwstrength").pwstrength();

$(document).ready(function() {
    var table = $('#kegiatanTable').DataTable({
        aLengthMenu: [
            [10, 25, 50, 100, 200, -1],
            [10, 25, 50, 100, 200, "All"]
        ],
        dom: 'Bflrtip',
        destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url:"/input-kegiatan",
        },
        columns: [
            {data: 'kode_kegiatan', name:'kode_kegiatan' , searchable:true},
            {data: 'nama_kegiatan', name:'nama_kegiatan', searchable:true},
        ],       
    });
    
    $('#tambahKegiatan').submit(function(event) {
        event.preventDefault();
    
        swal({
            text: 'Apakah anda yakin untuk tambah kegiatan?',
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
})