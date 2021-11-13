<?php
    include_once "../function/session.php";
    include_once "../Classes/CImpostos.php";

    $CImpostos = new CImpostos();
    if($_POST['impid']!="0"){
//      INSERT
        $dados['impid'] = $_POST['impid'];
        $dados['impnome'] = $_POST['impnome'];
        $dados['impporcentagem'] = $_POST['impporcentagem'];
        $CImpostos->update($db_connection,$dados);
        echo json_encode(array('resposta'=>"sucesso"));        
    }else{
//      INSERT
        $dados['impidtproduto'] = $_POST['impidtproduto'];
        $dados['impnome'] = $_POST['impnome'];
        $dados['impporcentagem'] = $_POST['impporcentagem'];
        $CImpostos->insert($db_connection,$dados);
        echo json_encode(array('resposta'=>"sucesso"));
    }