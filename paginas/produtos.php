<?php 
    include_once "../function/session.php";
    include_once "../Classes/CProdutos.php";
    include_once "../Classes/CTProdutos.php";
    
    $tituloPagina="Produtos";
    $_SESSION['btnMenu']='Cadastro';
    include_once 'Header.php';
    
//  PESQUISANDO produtos NO BANCO
    $CTProdutos = new CTProdutos();
    $CProdutos = new CProdutos();
    $arrProdutos = $CProdutos->select($db_connection,0,' order by pro_id desc ');
    $arrTProdutos = $CTProdutos->select($db_connection);
?>
<div class="card" style="margin-top: 15px">
  <div class="card-body">
    <h5 class="card-title">Produtos</h5>
    <?php if(count($arrTProdutos)==0){ ?>
        <button type="button" class="btn btn-primary" disabled>Adicionar novo produto</button>
        <br><small  class="form-text text-muted">É ncessario pelo menos 1 tipo de produto cadastrado para inserçãode produtos.</small>
    <?php  }else{ ?>
        <button type="button" class="btn btn-primary" onclick="location.href='formularioProduto.php'">Adicionar novo produto</button>
    <?php } ?>
    <table class="table table-striped" style="margin-top: 15px">
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th></th>
        </tr>
            <?php 
                foreach($arrProdutos as  $Produto){
            ?>
                <tr id='tr_<?= $Produto->pro_id ?>'>
                    <td ><?= $Produto->pro_id ?></td>
                    <td><?= $Produto->pro_nome ?></td>
                    <td><?= $Produto->pro_descricao ?></td>
                    <td>
                        <a id="<?= $Produto->pro_id ?>" class="btn btn-primary btnVisualizarProduto">Visualizar</a>
                        <a href="formularioProduto.php?id=<?= $Produto->pro_id ?>" class="btn btn-warning">Editar</a>
                        <a href="#" onclick="
                            if (confirm('Deseja realmente deletar o produto <?= $Produto->pro_nome ?> ?')) {
                                deletaproduto('<?= $Produto->pro_id ?>');
                            }
                           "class="btn btn-danger">Excluir</a>
                    </td>
                </tr>
                
            <?php 
                }
            ?>
    </table>
  </div>
</div>
<script>
    function deletaproduto(id){
        $.ajax({
            type: "POST",
            url: "deletaProduto.php",
            cache: false,
            data: {
                id:id
            },
            dataType: "json",
            success: function (json) {
                alert('Excluido com sucesso');
                $("#tr_"+id).hide();
            },error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }
    $(document).ready(function(){
        $(document).on('click', '.btnVisualizarProduto', function (evt) {
            btn = $(this);
            carregando();
            $.ajax({
                type: "POST",
                url: "viewProduto.php",
                cache: false,
                data: {
                    pro_id:btn.attr('id')
                },
                dataType: "html",
                success: function (html) {
                    $(html).insertAfter(btn.closest('tr'));
                    btn.removeClass(" btnVisualizarProduto ");
                    btn.addClass(" btnDesVisualizarProduto ");
                    btn.html("Esconder");
                    carregando();
                },error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        });
        $(document).on('click', '.btnDesVisualizarProduto', function (evt) {
            btn = $(this);
            btn.addClass(" btnVisualizarProduto ");
            btn.removeClass(" btnDesVisualizarProduto ");
            btn.html("Visualizar");
            $("#tr_info_"+btn.attr("id")).remove();
        });
    });
</script>

<?php
    include_once 'Footer.php';
?>
