<?php
    include_once "../function/session.php";
    include_once "../Classes/CProdutos.php";

    $CProdutos = new CProdutos();
    if($_POST['id']!="0"){
//      INSERT
        $dados['pro_id'] = $_POST['id'];
        $dados['pro_nome'] = $_POST['nome'];
        $dados['pro_descricao'] = $_POST['descricao'];
        $dados['pro_peso'] = $_POST['peso'];
        $dados['pro_valor'] = $_POST['valor'];
        $dados['pro_valor'] = str_replace(',', '.', $dados['pro_valor']);
        $dados['pro_id_tproduto'] = $_POST['tproduto'];

        $CProdutos->update($db_connection,$dados);
        header('Location: http://localhost:8080/paginas/produtos.php');
        
    }else{
//      INSERT
        $dados['pro_nome'] = $_POST['nome'];
        $dados['pro_descricao'] = $_POST['descricao'];
        $dados['pro_peso'] = $_POST['peso'];
        $dados['pro_valor'] = $_POST['valor'];
        $dados['pro_valor'] = str_replace(',', '.', $dados['pro_valor']);
        $dados['pro_id_tproduto'] = $_POST['tproduto'];
        $CProdutos->insert($db_connection,$dados);
        header('Location: http://localhost:8080/paginas/produtos.php');
    }