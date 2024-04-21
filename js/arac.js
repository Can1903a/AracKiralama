$(document).ready(function(){
    $.datetimepicker.setLocale('tr');
    $('#baslangic_tarihi').datetimepicker({
        value:'unixtime'
    });
    $('#baslangic_tarihi, #bitis_tarihi').datetimepicker({
        timepicker:false,
        format:'d.m.Y',
        step: 30,
        minDate: 0,
        closeOnDateSelect: true,
    });
    
    $('#sube').change(function(){
        var sube_id = $(this).val();
        $.ajax({
            url: 'bosaraclar.php',
            type: 'post',
            data: {sube_id: sube_id},
            success:function(response){
                $('#araclar').html(response);
            }
        });
    });
});