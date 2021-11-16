<?php
    include_once "../function/session.php";
    include_once "../Classes/CProdutos.php";
    include_once "../Classes/CImpostos.php";
    
    
    //  PESQUISANDO produto NO BANCO
        $CImpostos = new CImpostos();
        $CProdutos = new CProdutos();
        
        
    if(isset($_SESSION['carrinho'][$_POST['pro_id']])){
        $_SESSION['carrinho'][$_POST['pro_id']]+=$_POST['qtd'];
    }else{
        $_SESSION['carrinho'][$_POST['pro_id']]=$_POST['qtd'];
    }
    $arrTotal = array(
        "qtd"=>0,
        "peso"=>0,
        "valor"=>0,
        "imposto"=>0
    );
//    print_r($_SESSION['carrinho']);
    ?>
<div style="max-height: 250px;width: 100%;overflow-y: scroll">
    <table class="table table-striped" style="margin-top: 5px">
        <tr>
            <th colspan="5" style="text-align: center">Produtos</th>
        </tr>
        <tr>
            <td><b>Nome</b></td>
            <td><b>Quantidade</b></td>
            <td><b>Peso</b></td>
            <td><b>Valor</b></td>
            <td><b>Impostos</b></td>
        </tr>
        <?php 
            foreach($_SESSION['carrinho'] as $pro_id=>$qtd){
                $Produto= $CProdutos->select($db_connection,$pro_id);
        ?>
            <tr>
                <td>
                <?php 
                    echo $Produto->pro_nome;
                ?>
                </td>
                <td>
                    <?php
                        echo $qtd;
                        $arrTotal['qtd']+=$qtd;
                    ?>
                </td>
                <td>
                    <?php
                        echo $Produto->pro_peso*$qtd."g";
                        $arrTotal['peso']+=$Produto->pro_peso*$qtd;
                    ?>
                </td>
                <td>
                    <?php
                        echo converteMoeda($Produto->pro_valor*$qtd);
                        $arrTotal['valor']+=$Produto->pro_valor*$qtd;
                    ?>
                </td>
                <?php 
                    $vTotalImpostos=0;
                    $arrImpostos= $CImpostos->select($db_connection,0," and imp_id_tproduto = '".$Produto->tpro_id."' ");
                    foreach($arrImpostos as $index=>$Imp){
                        $arrImp = calculaImpostoAplicado($Produto->pro_valor,$Imp->imp_porcentagem);
                        $arrnomeImpostos[]=$Imp->imp_nome;
                        $vTotalImpostos+=$arrImp['Float'];
                    }
                ?>
                <td>
                    <?php
                        echo converteMoeda($vTotalImpostos*$qtd);
                        $arrTotal['imposto']+=$vTotalImpostos*$qtd;
                    ?>
                </td>
            </tr>
        <?php 
            }
        ?>
        <tr>
            <th colspan="5" style="text-align: center">Totais</th>
        </tr>
        <tr>
            <td><b>#</b></td>
            <td><b>Quantidade</b></td>
            <td><b>Peso</b></td>
            <td><b>Valor</b></td>
            <td><b>Impostos</b></td>
        </tr>
        <tr>
            <td></td>
            <td><?= $arrTotal['qtd'] ?></td>
            <td><?= $arrTotal['peso']."g" ?></td>
            <td><?= converteMoeda($arrTotal['valor']) ?></td>
            <td><?= converteMoeda($arrTotal['imposto']) ?></td>
        </tr>
    </table>
</div>
    

