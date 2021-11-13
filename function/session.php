<?php
    error_reporting(-1);
    session_start();
    if(basename($_SERVER['PHP_SELF']) != "index.php"){
        $urlImports = "../";
        $urlPaginas = "";
    }else{
        $urlPaginas = "paginas/";
        $urlImports = "";
    }
    include_once 'func.php';
    $db_connection = OpenCon();
    return $db_connection;
//    $result = pg_query($db_connection, "SELECT * FROM produto");
//    while($res = pg_fetch_object($result)){
//        echo $res->nome;
////        print_r($res);
//    }
?>