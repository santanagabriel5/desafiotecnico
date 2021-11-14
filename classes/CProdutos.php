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
        $sqlUpdateProdutos="
            UPDATE 
                    produto
                SET
                    pro_nome='".trim($dados['pro_nome'])."',
                    pro_descricao='".trim($dados['pro_descricao'])."'
                WHERE
                    pro_id = '".$dados['pro_id']."';
            ";
        pg_query($db_connection, $sqlUpdateProdutos);
    }
    
    function insert($db_connection,$dados){
        
        $sqlInsertProdutos="
            INSERT 
                INTO
                    produto(
                        pro_nome,
                        pro_descricao
                        )
                    VALUES (
                         '".trim($dados['pro_nome'])."',
                         '".trim($dados['pro_descricao'])."'
                    );
            ";
        pg_query($db_connection, $sqlInsertProdutos);
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
