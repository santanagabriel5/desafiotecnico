<?php
    include_once "../function/session.php";
    include_once "../Classes/CProdutos.php";

    
    $CProdutos = new CProdutos();
    $CProdutos->delete($db_connection,$_POST['id']);
    
    echo json_encode(array("resposta"=>"Sucesso"));
    

