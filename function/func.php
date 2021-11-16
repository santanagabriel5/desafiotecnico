<?php

function OpenCon(){
    $dbhost = "localhost";
    $dbuser = "postgres";
    $dbpass = "123";
    $db = "pgteste";
//    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
    $connString = "host=$dbhost dbname=$db user=$dbuser password=$dbpass";
    $db_connection = pg_connect($connString);
    return $db_connection;
}

function converte_data_YMD_DMY($Data){
    return date("d/m/Y", strtotime($Data));
}

function converte_data_YMDHIS_Timestamp($db){
    $timestamp = strtotime($db);
    return date("d/m/Y H:i:s", $timestamp);
}

function diff_Datas_YMD($data1,$data2){
//    echo $data1;
    $date1=date_create($data1);
    $date2=date_create($data2);
    $diff=date_diff($date1,$date2);
    return $diff->format("%a");
}

function converteMoeda($value){
     if (strpos($value, "0") == 0){
         $value = str_replace(',', '.', $value);
         $value = number_format($value, 2, ',', '.');
         echo "R$ " . $value . " reais<br>";
     }else{
//         $value = str_replace('.', '', $value);
         $value = str_replace(',', '.', $value);
         $value = number_format($value, 2, ',', '.');
         echo "R$ " . $value . " reais<br>";
     }
}

function calculaImpostoAplicado($valor, $imposto){
//  Calcula o valor do imposto
    $val1 = $valor*($imposto/100);
//  Muda ponto para virgula e arredonda
    $arr = array("Float"=>number_format($val1, 2, '.', ''));
    $arr['String'] = number_format($val1, 2, ',', '.');
    return $arr;
    
}

function pe($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}
