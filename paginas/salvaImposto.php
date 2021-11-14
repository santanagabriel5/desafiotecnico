<?php
    include_once "../function/session.php";
    include_once "../Classes/CImpostos.php";

    $CImpostos = new CImpostos();
    if($_POST['impid']!="0"){
//      Update
        $dados['impid'] = $_POST['impid'];
        $dados['impnome'] = $_POST['impnome'];
        $dados['impporcentagem'] = $_POST['impporcentagem'];
        $dados['impporcentagem'] = str_replace(',', '.', $dados['impporcentagem']);
        $CImpostos->update($db_connection,$dados);
        $dados['impporcentagem'] = str_replace('.', ',', $dados['impporcentagem']);
        echo json_encode(array(
            'resposta'=>"sucesso",
            'impid'=>$dados['impid'],
            'impnome'=>$dados['impnome'],
            'impporcentagem'=>$dados['impporcentagem']
            ));        
    }else{
//      INSERT
        $dados['impidtproduto'] = $_POST['impidtproduto'];
        $dados['impnome'] = $_POST['impnome'];
        $dados['impporcentagem'] = $_POST['impporcentagem'];
        $dados['impporcentagem'] = str_replace(',', '.', $dados['impporcentagem']);
        $id = $CImpostos->insert($db_connection,$dados);
        $val = pg_fetch_object($id);
        $dados['impporcentagem'] = str_replace('.', ',', $dados['impporcentagem']);
        echo json_encode(array(
            'resposta'=>"sucesso",
            'impid'=>$val->imp_id,
            'impnome'=>$dados['impnome'],
            'impporcentagem'=>$dados['impporcentagem']
            ));
    }