$("#frmAcceso").on('submit',function(e)
{
    e.preventDefault();
    logina=$("#logina").val();
    clavea=$("#clavea").val();
    console.log(logina+ ' - ' + clavea);
    $.post("../ajax/usuario.php?op=verificar",
        {"logina":logina,"clavea":clavea},
        function(data)
    {
        console.log(data);        
        if (data!="null")
        {
            $(location).attr("href","escritorio.php");            
        }
        else
        {
            bootbox.alert("Usuario y/o Password incorrectos");
        }        
    });
})