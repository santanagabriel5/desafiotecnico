<?php 
    include_once "../function/session.php";
    include_once "../Classes/CTProdutos.php";
    include_once "../Classes/CImpostos.php";
    
    $tituloPagina="Tipo Produtos";
    $_SESSION['btnMenu']='Cadastro';
    include_once 'Header.php';
    
//  PESQUISANDO tprodutos NO BANCO
    $CTProdutos = new CTProdutos();
    $arrTProdutos= $CTProdutos->select($db_connection);

    $CImpostos = new CImpostos();
?>
<div class="card" style="margin-top: 15px">
  <div class="card-body">
    <h5 class="card-title">Tipo de Produtos</h5>
    <button type="button" class="btn btn-primary" onclick="location.href='formularioTProduto.php'">Adicionar novo tipo de produto</button>
    <table class="table table-striped" style="margin-top: 15px">
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Impostos</th>
            <th></th>
        </tr>
            <?php 
//            print_r($arrCourses);
                foreach($arrTProdutos as  $TProdutos){
            ?>
                <tr id='tr_<?= $TProdutos->tpro_id ?>'>
                    <td><?= $TProdutos->tpro_id ?></td>
                    <td><?= $TProdutos->tpro_nome ?></td>
                    <td><?= $TProdutos->tpro_descricao ?></td>
                    <td><?php
                        $arrImpostos= $CImpostos->select($db_connection,0," and imp_id_tproduto = '".$TProdutos->tpro_id."' ");
                        $x=0;
                        foreach($arrImpostos as $index=>$Imp){
                            echo $index > 0 ? ', ' : "";
                            echo $Imp->imp_nome." ( ".str_replace('.', ',', $Imp->imp_porcentagem)." % ) ";
                        }
                    ?></td>
                    <td>
                        <a href="formularioTProduto.php?id=<?= $TProdutos->tpro_id ?>" class="btn btn-warning">Editar</a>
                        <a href="#" onclick="
                            if (confirm('Deseja realmente deletar o tipo produto <?= $TProdutos->tpro_nome ?> e seus impostos ?')) {
                                deletaTproduto('<?= $TProdutos->tpro_id ?>');
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
    function deletaTproduto(id){
        $.ajax({
            type: "POST",
            url: "deletaTProduto.php",
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
    });
</script>

<?php
    include_once 'Footer.php';
?>
