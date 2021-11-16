<?php
    include_once "../function/session.php";
    include_once "../Classes/CProdutos.php";
    include_once "../Classes/CImpostos.php";
    include_once "../Classes/CPVenda.php";
    include_once "../Classes/CVenda.php";
    
    $CImpostos = new CImpostos();
    $CProdutos = new CProdutos();
    $CPVenda = new CPVenda();
    $CVenda = new CVenda();
    
    if(!isset($_SESSION['carrinho'])){
        header('Location: http://localhost:8080/index.php');
    }
    $arrTotal = array(
        "ven_qtd_produtos"=>0,
        "ven_total_peso"=>0,
        "ven_total_valor"=>0,
        "ven_total_impostos"=>0
    );
       
    $arrProdutos =array();
    $arrProduto = array(
        'pven_produto_id'=>0,
        'pven_venda_id'=>0,
        'pven_quantidade'=>0,
        'pven_total_peso'=>0, 
        'pven_total_valor'=>0,
        'pven_total_impostos'=>0
    );
    foreach($_SESSION['carrinho'] as $pro_id=>$qtd){
        $Produto = $CProdutos->select($db_connection,$pro_id);
        $arrProduto['pven_produto_id']=$pro_id;
//        $Produto['pven_venda_id']=$pro_id;
        $arrProduto['pven_quantidade']=$qtd;
        $arrTotal['ven_qtd_produtos']+=$qtd;
        $arrProduto['pven_total_peso']=$Produto->pro_peso*$qtd;
        $arrTotal['ven_total_peso']+=$arrProduto['pven_total_peso'];
        $arrProduto['pven_total_valor']=$Produto->pro_valor*$qtd;
        $arrTotal['ven_total_valor']+=$arrProduto['pven_total_valor'];
        
        $vTotalImpostos=0;
        $arrImpostos= $CImpostos->select($db_connection,0," and imp_id_tproduto = '".$Produto->tpro_id."' ");
        foreach($arrImpostos as $index=>$Imp){
            $arrImp = calculaImpostoAplicado($Produto->pro_valor,$Imp->imp_porcentagem);
            $arrnomeImpostos[]=$Imp->imp_nome;
            $vTotalImpostos+=$arrImp['Float'];
        }
        $arrProduto['pven_total_impostos']=$vTotalImpostos*$qtd;
        $arrTotal['ven_total_impostos']+=$arrProduto['pven_total_impostos'];
        $arrProdutos[]=$arrProduto;
//        $arrProdutos[] = 
    }
//    echo "<pre>";
//        print_r($arrProdutos);
//        print_r($arrTotal);
//    echo "</pre>";
    
    $id = $CVenda->insert($db_connection, $arrTotal);
    $id = pg_fetch_object($id);
    foreach($arrProdutos as $val){
        $val['pven_venda_id']=$id->ven_id;
        $CPVenda->insert($db_connection, $val);
        $CProdutos->adicionarEstoque($db_connection, $val['pven_quantidade'], $val['pven_produto_id']);
    }
    echo json_encode(array("resposta"=>"Sucesso"));

    
    
