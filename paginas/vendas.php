<?php 
    include_once "../function/session.php";
    include_once "../Classes/CVenda.php";
    
    $tituloPagina="Relatorio Vendas";
    $_SESSION['btnMenu']='RelVendas';
    include_once 'Header.php';
    
//  PESQUISANDO produtos NO BANCO
    $CVenda = new CVenda();
    $arrVendas= $CVenda->select($db_connection,0,' order by ven_id desc ');
?>
<div class="card" style="margin-top: 15px">
  <div class="card-body">
    <h5 class="card-title">Vendas</h5>
    <table class="table table-striped" style="margin-top: 15px">
        <tr>
            <th>Id</th>
            <th>Data</th>
            <th>Peso</th>
            <th>Qtd. Produtos</th>
            <th>Valor</th>
            <th>Valor Impostos</th>
            <th></th>
        </tr>
            <?php 
                foreach($arrVendas as  $Venda){
            ?>
                <tr>
                    <td ><?= $Venda->ven_id ?></td>
                    <td><?= converte_data_YMDHIS_Timestamp($Venda->ven_data) ?></td>
                    <td><?= $Venda->ven_total_peso ?></td>
                    <td><?= $Venda->ven_qtd_produtos ?></td>
                    <td><?= converteMoeda($Venda->ven_total_valor) ?></td>
                    <td><?= converteMoeda($Venda->ven_total_impostos) ?></td>
                    <td>
                        <a href="viewVenda.php?id=<?= $Venda->ven_id ?>"class="btn btn-primary">Visualizar</a>
                    </td>
                </tr>
                
            <?php 
                }
            ?>
    </table>
  </div>
</div>
<script>
//    $(document).ready(function(){
//        $(document).on('click', '.btnVisualizarProduto', function (evt) {
//            btn = $(this);
//            carregando();
//            $.ajax({
//                type: "POST",
//                url: "viewProduto.php",
//                cache: false,
//                data: {
//                    pro_id:btn.attr('id')
//                },
//                dataType: "html",
//                success: function (html) {
//                    $(html).insertAfter(btn.closest('tr'));
//                    btn.removeClass(" btnVisualizarProduto ");
//                    btn.addClass(" btnDesVisualizarProduto ");
//                    btn.html("Esconder");
//                    carregando();
//                },error: function(xhr, status, error) {
//                    alert(xhr.responseText);
//                }
//            });
//        });
//        $(document).on('click', '.btnDesVisualizarProduto', function (evt) {
//            btn = $(this);
//            btn.addClass(" btnVisualizarProduto ");
//            btn.removeClass(" btnDesVisualizarProduto ");
//            btn.html("Visualizar");
//            $("#tr_info_"+btn.attr("id")).remove();
//        });
//    });
</script>

<?php
    include_once 'Footer.php';
?>
