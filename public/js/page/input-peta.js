$(document).ready(function() {
    $('#kegiatan_id').select2({
        dropdownParent: $('#kegiatan_id').parent(), // optional
        width: '100%',
        placeholder: '-- Pilih Kegiatan --'
    });
});