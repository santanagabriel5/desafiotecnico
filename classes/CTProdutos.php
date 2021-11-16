<?php

class CTProdutos{   

    function select($db_connection,$id=0,$where=null){
        $tprodutoQuery = "
                    SELECT
                            *                        
                        FROM
                            tproduto
                        WHERE
                            0=0
                ";
        
        if($id!=0){
            $tprodutoQuery.= "
                                and tpro_id=".$id."
                ";
            $tprodutoQuery.= " order by tpro_id desc ";
            $tprodutoQuery.= $where;   
            $result = pg_query($db_connection, $tprodutoQuery);
            $res = pg_fetch_object($result);
            return $res;
            
        }else{
            $tprodutoQuery.= $where;
            $tprodutoQuery.= " order by tpro_id desc ";
            $result = pg_query($db_connection, $tprodutoQuery);
            $arrTprodutos = array();
            while($res = pg_fetch_object($result)){
                $arrTprodutos[]=$res;
            }
            return $arrTprodutos;
        }
    }
    
    function update($db_connection,$dados){
        $sqlUpdateTProdutos="
            UPDATE 
                    tproduto
                SET
                    tpro_nome='".trim($dados['tpro_nome'])."',
                    tpro_descricao='".trim($dados['tpro_descricao'])."'
                WHERE
                    tpro_id = '".$dados['tpro_id']."';
            ";
        pg_query($db_connection, $sqlUpdateTProdutos);
    }
    
    function insert($db_connection,$dados){
        
        $sqlInsertTProdutos="
            INSERT 
                INTO
                    tproduto(
                        tpro_nome,
                        tpro_descricao
                        )
                    VALUES (
                         '".trim($dados['tpro_nome'])."',
                         '".trim($dados['tpro_descricao'])."'
                    );
            ";
        pg_query($db_connection, $sqlInsertTProdutos);
    }
    
    function delete($db_connection , $id){
//      Deleta o tipo de produto e seus impostos, normalmente eu apenas teria um flag de status e faria update
//      mas como o teste é do estilo CRUD, vamos fazer tudo do geito classico
        $sqlDeleteImposto="
             DELETE 
                FROM 
                    imposto
                WHERE
                    imp_id_tproduto = '".$id."';
            ";
        pg_query($db_connection, $sqlDeleteImposto);
        
        $sqlDeleteTProduto="
             DELETE 
                FROM 
                    tproduto
                WHERE
                    tpro_id = '".$id."';
            ";
        pg_query($db_connection, $sqlDeleteTProduto);
        

    }

}
