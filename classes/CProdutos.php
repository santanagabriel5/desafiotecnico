<?php

class CProdutos{   

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
            $produtoQuery.= " order by pro_id desc ";
            $produtoQuery.= $where;   
            $result = pg_query($db_connection, $produtoQuery);
            $res = pg_fetch_object($result);
            return $res;
            
        }else{
            $produtoQuery.= $where;
            $produtoQuery.= " order by pro_id desc ";
            $result = pg_query($db_connection, $produtoQuery);
            $arrProdutos = array();
            while($res = pg_fetch_object($result)){
                $arrProdutos[]=$res;
            }
            return $arrProdutos;
        }
    }
    
    function update($db_connection,$dados){
        $sqlUpdateProduto="
            UPDATE 
                    produto
                SET
                    pro_nome='".trim($dados['pro_nome'])."',
                    pro_valor='".trim($dados['pro_valor'])."',
                    pro_descricao='".trim($dados['pro_descricao'])."',
                    pro_id_tproduto='".trim($dados['pro_id_tproduto'])."', 
                    pro_peso='".trim($dados['pro_peso'])."'
                WHERE
                    pro_id = '".$dados['pro_id']."';
            ";
        pg_query($db_connection, $sqlUpdateProduto);
    }
    
    function insert($db_connection,$dados){
        
        $sqlInsertProduto="
            INSERT 
                INTO
                    produto(
                        pro_nome,
                        pro_valor,
                        pro_descricao,
                        pro_id_tproduto, 
                        pro_peso
                        )
                    VALUES (
                         '".trim($dados['pro_nome'])."',
                         '".trim($dados['pro_valor'])."',
                         '".trim($dados['pro_descricao'])."',
                         '".trim($dados['pro_id_tproduto'])."',
                         '".trim($dados['pro_peso'])."'
                    );
            ";
        pg_query($db_connection, $sqlInsertProduto);
    }
    
    function delete($db_connection , $id){
//      Deleta o tipo de produto e seus impostos, normalmente eu apenas teria um flag de status e faria update
//      mas como o teste é do estilo CRUD, vamos fazer tudo do geito classico
        
        $sqlDeleteProduto="
             DELETE 
                FROM 
                    produto
                WHERE
                    pro_id = '".$id."';
            ";
        pg_query($db_connection, $sqlDeleteProduto);
        

    }

}
