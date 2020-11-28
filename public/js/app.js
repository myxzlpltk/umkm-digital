$('.custom-file-input').change(function(e){
    if(this.files.length > 0){
        $(this).siblings('.custom-file-label').text(this.files[0].name);
    }
    else{
        $(this).siblings('.custom-file-label').text("Pilih file");
    }
});

if($('.input-stock').length > 0){
    $('.input-stock .input-group-prepend').click(function (){
        var x = parseInt($('.input-stock input').val());
        if(x > 0){
            $('.input-stock input').val(x-1);
        }
    });

    $('.input-stock .input-group-append').click(function (){
        var x = parseInt($('.input-stock input').val());
        $('.input-stock input').val(x+1);
    });
}

if($('.btn-delete').length > 0){
    $('.btn-delete').click(function (){
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda akan menghapus data ini. Data yang terhapus tidak dapat dikembalikan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus saja',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.value) {
                $(this).closest('form').submit();
            }
        });
    });
}

if($('.btn-alert').length > 0){
    $('.btn-alert').click(function (){
        Swal.fire({
            title: 'Apakah anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.value) {
                $(this).closest('form').submit();
            }
        });
    });
}
