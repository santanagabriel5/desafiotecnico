<?php

class CPVenda{   

    function select($db_connection,$id=0,$where=null){
        $produtoQuery = "
                    SELECT
                            *                        
                        FROM
                            pvenda
                            left join produto on pro_id = pven_produto_id
                        WHERE
                            pven_venda_id=".$id."
                ";
        $produtoQuery.= $where;
//            $produtoQuery.= " order by pro_id desc ";
        $result = pg_query($db_connection, $produtoQuery);
        $arrPVendas = array();
        while($res = pg_fetch_object($result)){
            $arrPVendas[]=$res;
        }
        return $arrPVendas;
        

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
