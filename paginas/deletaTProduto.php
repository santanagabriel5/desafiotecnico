<?php
    include_once "../function/session.php";
    include_once "../Classes/CTProdutos.php";

    
    $CTProdutos = new CTProdutos();
    $CTProdutos->delete($db_connection,$_POST['id']);
    
    echo json_encode(array("resposta"=>"Sucesso"));
    

