
<?php 
        include_once "../Classes/CImpostos.php";
        include_once "../function/session.php";

    if(isset($_POST['imp_id'])){
    //  PESQUISANDO tipo produto NO BANCO
        $CImpostos = new CImpostos();
        $Impostos= $CImpostos->select($db_connection,$_POST['imp_id']);
        
    }
?>
<div class="card-body">
    <h5 class="card-title"> <?= isset($_POST['imp_id']) ? "Edição":"Cadastro" ?> de Imposto </h5>
    <form action="salvaImposto.php" method="post" id='formImposto'>
        <input type="hidden" id='impid' name="impid" value="<?= (isset($_POST['imp_id'])?$_POST['imp_id']:0); ?>">
        <input type="hidden" id='impidtproduto' name="impidtproduto" value="<?= $_POST['id_tprod']; ?>">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input required type="text" id='impnome' required name="impnome"
                <?php 
                    if(isset($_POST['imp_id'])){
                        echo "Value='".trim($Impostos->imp_nome)."'";
                    }
                ?>  
           class="form-control" placeholder="Nome Imposto" >
        </div>
        <div class="mb-3">
            <label for="nome" class="form-label">Porcentagem</label>
            <input required type="text" id='impporcentagem' required name="impporcentagem"
                <?php 
                    if(isset($_POST['imp_id'])){
                        echo "Value='".trim(str_replace('.', ',', $Impostos->imp_porcentagem))."'";
                    }
                ?>  
           class="form-control" placeholder="Digite apenas o valor porcentagem.">
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <button type="button" onclick="cancelarCadastroImposto()" class="btn btn-warning">Cancelar</button>
    </form>
</div>
<script>
    function checkKey() {
        var clean = this.value.replace(/[^0-9,]/g, "")
                               .replace(/(,.*?),(.*,)?/, "$1");
        if (clean !== this.value) this.value = clean;
    }

    document.querySelector('#impporcentagem').oninput = checkKey;
    $('#formImposto').on('submit',function (e) {
        carregando();
        impid = $("#impid").val();
        impidtproduto = $("#impidtproduto").val();
        impnome = $("#impnome").val();
        impporcentagem = $("#impporcentagem").val();
        $.ajax({
            type: "POST",
            url: "salvaImposto.php",
            cache: false,
            data: {
                impid:impid,
                impidtproduto:impidtproduto,
                impnome:impnome,
                impporcentagem:impporcentagem
            },
            dataType: "json",
            success: function (json) {
                if(impid == 0){
                    carregando();
                    alert('Imposto inserido com sucesso');
                    var conteudo = "<tr id='tr_imposto_"+json.impid+"'><td>"+json.impnome+"</td><td>"+json.impporcentagem+" %</td><td><a id='"+json.impid+"' class='btn btn-warning btnEditaImposto'>Editar</a> <a onclick=\"if (confirm('Deseja realmente deletar o imposto "+json.impnome+"?')) {deletaImposto('"+json.impid+"');}\" class='btn btn-danger'>Excluir</a></td></tr>";
                    $(conteudo).prependTo("#list-imp");
                }else{
                    carregando();
                    alert('Imposto atualizado com sucesso');
                    var conteudo = "<td>"+json.impnome+"</td><td>"+json.impporcentagem+" %</td><td><a id='"+json.impid+"' class='btn btn-warning btnEditaImposto'>Editar</a> <a  onclick=\"if (confirm('Deseja realmente deletar o imposto "+json.impnome+"?')) {deletaImposto('"+json.impid+"');}\" class='btn btn-danger'>Excluir</a></td>";
                    $("#tr_imposto_"+json.impid).html(conteudo);
                }
//                $("#divFormImposto").html(html);
                $("#divFormImposto").hide();
            },error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
        e.preventDefault();
    });
    
</script>

