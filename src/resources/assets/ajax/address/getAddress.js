/**
 * Created by slayerfat on 21/09/15.
 */
$("document").ready(function(){
    $.ajax({
        type: 'GET',
        dataType: "json",
        url: '/direcciones/estados',
        data: null,
        success: function (datos){
            // se chequea entre los datos recibidos (json)
            $.each(datos, function(index, estado) {
                $('#state_id').append(
                    '<option value="'+estado.id+'">'+estado.description+'</option>');
            });
        }
    });

    $("#state_id").change(function(){

        var id = $("#state_id").val();

        $.ajax({
            type: 'GET',
            dataType: "json",
            url: '/direcciones/municipios/'+id,
            data: null,
            success: function (datos){
                // se borran los municipios existentes
                $('#town_id').empty();
                $('#town_id').append('<option value="">Seleccione</option>');
                // se chequea entre los datos recibidos (json)
                $.each(datos, function(index, municipio) {
                    $('#town_id').append(
                        '<option value="'+municipio.id+'">'+municipio.description+'</option>');
                });
                $('#parish_id').empty();
            }
        });
    });

    $("#town_id").change(function(){

        var id = $("#town_id").val();

        $.ajax({
            type: 'GET',
            dataType: "json",
            url: '/direcciones/parroquias/'+id,
            data: null,
            success: function (datos){
                $('#parish_id').empty();
                $('#parish_id').append('<option value="">Seleccione</option>');
                $.each(datos, function(index, municipio) {
                    $('#parish_id').append(
                        '<option value="'+municipio.id+'">'+municipio.description+'</option>');
                });
            }
        });
    });
});
