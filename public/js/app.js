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
