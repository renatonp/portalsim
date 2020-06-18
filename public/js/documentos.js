

var infoArqEnviada = false;

$("#lancarArquivo").click(function () {

    if(!infoArqEnviada){
        infoArqEnviada = true;
        $("#lancarArquivo").prop('disabled', true);
         
        
        if ($("#processo").val() == "" || $("#processo").val() == null) {
            alert("Por favor escolha um processo para anexar um documento");
            infoArqEnviada = false;
            $("#lancarArquivo").prop('disabled', false);
            return false;
        }
        if ($("#descricao").val() == "") {
            alert("Por favor informe a descrição deste documento");
            infoArqEnviada = false;
            $("#lancarArquivo").prop('disabled', false);            
            return false;
        }
        if ($("#file").val() == "") {
            alert("Por favor escolha um documento para enviar");
            infoArqEnviada = false;
            $("#lancarArquivo").prop('disabled', false);            
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
            
        $input = document.getElementById('file');


        if (!window.FileReader) {
            infoArqEnviada = false;
            $("#lancarArquivo").prop('disabled', false);
            return false;
        }
    
        $input = document.getElementById('file');
        file = $input.files[0];
        // $nome_arquivo.innerHTML = file.name;
        // $tamanho.innerHTML = file.size + " bytes";
        $ext = /\..*$/g.exec(file.name);
        
        if (file.size > 2048000) {
            alert("O arquivo deve ter no máximo 2Mb");
            infoArqEnviada = false;
            $("#lancarArquivo").prop('disabled', false);
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf' && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF' ) {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            infoArqEnviada = false;
            $("#lancarArquivo").prop('disabled', false);
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        $("#formDocumentos").submit();
    }
    else{
        console.log("Segundo envio");
    }
});


var table = $('#documentosLancados').DataTable({
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
    },
    "paging": false,
    "ordering": false,
    "info": false,
    "searching": false,
});
