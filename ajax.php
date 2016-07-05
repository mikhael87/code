$.ajax({
    url:'<?php echo sfConfig::get('sf_app_registro_url'); ?>juego/actualizarVariante',
    type:'POST',
    dataType:'html',
    data: 'disc='+disc+'&vari='+vari,
    success:function(data, textStatus){
        $('#variante_div').html(data);
        actualizar_equipos();
    }});
