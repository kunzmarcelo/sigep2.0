
function ativar(cod) {
    var resposta = confirm("Deseja excluir esse registro?");

    if (resposta === true) {
        $("#cod").focus();
        $("#cod").val(cod);
        $("#cod").blur();
        //alert(cod);
        //var cod = $("#cod").val();
        //alert(cod);
        $.ajax({       
            type: "GET",
            url: "../ajax/deletar_funcao_peca.php",
            data: "id=" + cod,
            success: function (doc) {
               // carregando();
                //window.location.assign('pgAdmin.php?pagina=listaAtleta&statusAtivo=true');
                location.reload();
                //alert('registro ativado');
            },
            error: function () {
                alert('Erro ao excluir registro');
            }
        });
    }
}
/*
function ativar2(cod) {
    
        $("#cod").focus();
        $("#cod").val(cod);
        $("#cod").blur();
        //alert(cod);
        //var cod = $("#cod").val();
        //alert(cod);
        $.ajax({       
            type: "GET",
            url: "../ajax/ativarAtleta.php",
            data: "cod_atleta=" + cod,
            success: function (doc) {
               // carregando();
                //window.location.assign('pgAdmin.php?pagina=listaAtleta&statusAtivo=true');
                location.reload();
                //alert('registro ativado');
            },
            error: function () {
                alert('Erro ao ativar o cadastro');
            }
        });
    
}

/*
 if (resposta === true) {
        $("#cod").focus();
        $("#cod").val(cod);
        $("#cod").blur();
        var cod = $("#cod").val();
        //alert(cod);
        $.ajax({
            type: "GET",
            url: "../ajax/excluirAtleta.php",
            data: "cod_atleta=" + cod,
            success: function (doc) {
               // carregando();
                location.reload();
                //alert('registro excluido');
            },
            error: function () {
                alert('Erro ao deletar o registro');
            }
        });
    }
*/
/*
function excluir(cod) {
    var resposta = confirm("Deseja remover esse registro?");

    if (resposta === true) {
        $("#cod").focus();
        $("#cod").val(cod);
        $("#cod").blur();
        var cod = $("#cod").val();
        //alert(cod);
        $.ajax({
            type: "GET",
            url: "../ajax/excluirAtleta.php",
            data: "cod_atleta=" + cod,
            success: function (doc) {
               // carregando();
                location.reload();
                //alert('registro excluido');
            },
            error: function () {
                alert('Erro ao deletar o registro');
            }
        });
    }
}
*/