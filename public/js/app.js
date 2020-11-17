$('.custom-file-input').change(function(e){
    if(this.files.length > 0){
        $(this).siblings('.custom-file-label').text(this.files[0].name);
    }
    else{
        $(this).siblings('.custom-file-label').text("Pilih file");
    }
});
