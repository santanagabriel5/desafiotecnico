<?php

class CVenda{   

    function select($db_connection,$id=0,$where=null){
        $produtoQuery = "
                    SELECT
                            *                        
                        FROM
                            venda
                        WHERE
                            0=0
                ";
        
        if($id!=0){
            $produtoQuery.= " and ven_id=".$id." ";
            $result = pg_query($db_connection, $produtoQuery);
            $res = pg_fetch_object($result);
            return $res;
            
        }else{
            $produtoQuery.= $where;
            $result = pg_query($db_connection, $produtoQuery);
            $arrVendas = array();
            while($res = pg_fetch_object($result)){
                $arrVendas[]=$res;
            }
            return $arrVendas;
        }
    }
    
    function insert($db_connection,$dados){
        
        $sqlInsertProduto="
            INSERT 
                INTO
                    venda(
                        ven_total_valor,
                        ven_total_impostos,
                        ven_qtd_produtos, 
                        ven_total_peso
                        )
                    VALUES (
                         '".trim($dados['ven_total_valor'])."',
                         '".trim($dados['ven_total_impostos'])."',
                         '".trim($dados['ven_qtd_produtos'])."',
                         '".trim($dados['ven_total_peso'])."'
                    ) RETURNING ven_id;
            ";
        $id = pg_query($db_connection, $sqlInsertProduto);
        return $id;
    }
    

}
