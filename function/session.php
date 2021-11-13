<?php
    error_reporting(-1);
    session_start();
    if(basename($_SERVER['PHP_SELF']) != "index.php"){
        $urlImports = "../";
        $urlPaginas = "";
    }else{
        $urlPaginas = "pages/";
        $urlImports = "";
    }
    include_once 'func.php';
    $db_connection = OpenCon();
    $result = pg_query($db_connection, "SELECT * FROM produto");
//    while($res = pg_fetch_object($result)){
//        echo $res->nome;
////        print_r($res);
//    }
?>