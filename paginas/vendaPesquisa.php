<?php
    include_once "../function/session.php";
    include_once "../Classes/CProdutos.php";
    
    
//  PESQUISANDO produtos NO BANCO
    $CProdutos = new CProdutos();
    $arrProdutos= $CProdutos->select($db_connection,0," and pro_nome ilike '%".trim($_POST['pesquisa'])."%' order by pro_id desc limit 15 ");

?>

<table class="table table-striped" style="margin-top: 15px">
    <tr>
        <th>Nome</th>
        <th>Preço</th>
        <th></th>
    </tr>
        <?php 
            foreach($arrProdutos as  $Produto){
        ?>
            <tr id='tr_<?= $Produto->pro_id ?>'>
                <td><?= $Produto->pro_nome ?></td>
                <td><?= converteMoeda($Produto->pro_valor) ?></td>
                <td> <a id="<?= $Produto->pro_id ?>" class="btn btn-primary btnAdicionarProduto">Adicionar</a></td>
            </tr>

        <?php 
            }
        ?>
</table>

<script>
    function cancelaAdd(){
        $("#divAddProduto").hide();
        $("#divAddProduto").html();
    }
    $(document).ready(function(){
        $(document).on('click', '.btnAdicionarProduto', function (evt) {
            btn = $(this);
            carregando();
            $.ajax({
                type: "POST",
                url: "vendaProduto.php",
                cache: false,
                data: {
                    pro_id:btn.attr("id")
                },
                dataType: "html",
                success: function (html) {
                    $("#divAddProduto").html(html);
                    $("#divAddProduto").show();
//                    $("#modalAddProduto").modal('show');
                    carregando();
                },error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        });
    });
</script>

