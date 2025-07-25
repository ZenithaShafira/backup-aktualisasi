$(document).ready(function() {
    $('#wbTabel').DataTable({
        aLengthMenu: [
            [10, 25, 50, 100, 200, -1],
            [10, 25, 50, 100, 200, "All"]
        ],
        dom: 'Bflrtip',
        destroy: true,
        processing: true,
        // serverSide: true,
        responsive: true,
        ajax: {
            url:"/dashboard/kondisi-wb",
        },
        columns: [
            {data: 'nama_kecamatan', name:'nama_kecamatan' , searchable:true},
            {data: 'nama_kelurahan', name:'nama_kelurahan' , searchable:true},
            {data: 'bs_lengkap', name:'blok_sensus' , searchable:true},
            {data: 'bs_2020', name:'bs_2020', searchable:true},
            {data: 'bs_2010', name:'bs_2010', searchable:true},
        ],       
    });

    $('#wsTabel').DataTable({
        aLengthMenu: [
            [10, 25, 50, 100, 200, -1],
            [10, 25, 50, 100, 200, "All"]
        ],
        dom: 'Bflrtip',
        destroy: true,
        processing: true,
        // serverSide: true,
        responsive: true,
        ajax: {
            url:"/dashboard/kondisi-ws",
        },
        columns: [
            {data: 'nama_kecamatan', name:'nama_kecamatan' , searchable:true},
            {data: 'nama_kelurahan', name:'nama_kelurahan' , searchable:true},
            {data: 'nama_sls', name:'nama_sls' , searchable:true},
            {data: 'sls_lengkap', name:'sls_sensus' , searchable:true},
            {data: 'kegiatan', name:'kegiatan', searchable:true},
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