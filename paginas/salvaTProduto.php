<?php
    include_once "../function/session.php";
    include_once "../Classes/CTProdutos.php";

    $CTProdutos = new CTProdutos();
    if($_POST['id']!="0"){
//      INSERT
        $dados['tpro_id'] = $_POST['id'];
        $dados['tpro_nome'] = $_POST['nome'];
        $dados['tpro_descricao'] = $_POST['descricao'];
        $CTProdutos->update($db_connection,$dados);
        header('Location: http://localhost:8080/paginas/tprodutos.php');
        
    }else{
//      INSERT
        $dados['tpro_nome'] = $_POST['nome'];
        $dados['tpro_descricao'] = $_POST['descricao'];
        $CTProdutos->insert($db_connection,$dados);
        header('Location: http://localhost:8080/paginas/tprodutos.php');
    }