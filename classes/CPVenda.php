<?php

class CPVenda{   

    function select($db_connection,$id=0,$where=null){
        $produtoQuery = "
                    SELECT
                            *                        
                        FROM
                            produto
                            left join tproduto on tpro_id = pro_id_tproduto
                        WHERE
                            0=0
                ";
        
        if($id!=0){
            $produtoQuery.= "
                                and pro_id=".$id;"
                ";
            $result = pg_query($db_connection, $produtoQuery);
            $res = pg_fetch_object($result);
            return $res;
            
        }else{
            $produtoQuery.= $where;
//            $produtoQuery.= " order by pro_id desc ";
            $result = pg_query($db_connection, $produtoQuery);
            $arrProdutos = array();
            while($res = pg_fetch_object($result)){
                $arrProdutos[]=$res;
            }
            return $arrProdutos;
        }
    }
    
    function insert($db_connection,$dados){
//        print_r($dados);exit();
        $sqlInsertProduto="
            INSERT 
                INTO
                    pvenda(
                        pven_produto_id,
                        pven_venda_id,
                        pven_quantidade,
                        pven_total_peso, 
                        pven_total_valor,
                        pven_total_impostos
                        )
                    VALUES (
                         '".trim($dados['pven_produto_id'])."',
                         '".trim($dados['pven_venda_id'])."',
                         '".trim($dados['pven_quantidade'])."',
                         '".trim($dados['pven_total_peso'])."',
                         '".trim($dados['pven_total_valor'])."',
                         '".trim($dados['pven_total_impostos'])."'
                    );
            ";
//        echo $sqlInsertProduto;exit();
        pg_query($db_connection, $sqlInsertProduto);
    }
    

}
