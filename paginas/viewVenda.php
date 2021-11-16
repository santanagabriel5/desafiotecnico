<?php 
    include_once "../function/session.php";
    include_once "../Classes/CVenda.php";
    include_once "../Classes/CPVenda.php";
    
    $tituloPagina="Relatorio Vendas";
    $_SESSION['btnMenu']='RelVendas';
    include_once 'Header.php';
    
//  PESQUISANDO produtos NO BANCO
    $CVenda = new CVenda();
    $CPVenda = new CPVenda();
    $Venda = $CVenda->select($db_connection,$_GET['id']);
    
    $arrPVenda = $CPVenda->select($db_connection, $Venda->ven_id);
//    pe($arrPVenda);
?>
<div class="card" style="margin-top: 15px">
  <div class="card-body">
    <div style="float: left">
        <h5 class="card-title">Venda</h5>
    </div>
    <div style="float: right;">
        <a href="vendaExcell.php?id=<?= $Venda->ven_id ?>" target="_blank" rel="noopener noreferrer">
            <button type="button" class="btn btn-success " style="margin-bottom: 10px;" >Gerar Planilha</button>
        </a>
    </div>
    <table class="table table-striped" style="margin-top: 15px">
        <tr>
            <th colspan="6" style="text-align: center"> Resumo </th>
        </tr>
        <tr>
            <th>Id</th>
            <th>Data</th>
            <th>Peso</th>
            <th>Qtd. Produtos</th>
            <th>Valor</th>
            <th>Valor Impostos</th>
        </tr>
        <tr>
            <td ><?= $Venda->ven_id ?></td>
            <td><?= converte_data_YMDHIS_Timestamp($Venda->ven_data) ?></td>
            <td><?= $Venda->ven_total_peso ?>g</td>
            <td><?= $Venda->ven_qtd_produtos ?></td>
            <td><?= converteMoeda($Venda->ven_total_valor) ?></td>
            <td><?= converteMoeda($Venda->ven_total_impostos) ?></td>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center"> Produtos </th>
        </tr>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Peso</th>
            <th>Qtd</th>
            <th>Valor</th>
            <th>Valor Impostos</th>
        </tr>
        <?php 
            foreach($arrPVenda as $Venda){
        ?>
            <tr>
                <td><?= $Venda->pven_id ?></td>
                <td><?= $Venda->pro_nome ?></td>
                <td><?= $Venda->pven_total_peso ?>g</td>
                <td><?= $Venda->pven_quantidade ?></td>
                <td><?= converteMoeda($Venda->pven_total_valor) ?></td>
                <td><?= converteMoeda($Venda->pven_total_impostos) ?></td>
            </tr>
        <?php 
            }
        ?>
    </table>
  </div>
</div>

<?php
    include_once 'Footer.php';
?>
