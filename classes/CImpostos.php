<?php
    error_reporting(-1);

class CImpostos{
//  Atributos

    function select($db_connection,$id=0,$where=null){
        $impostoQuery = "
                    SELECT
                            *                        
                        FROM
                            imposto
                        WHERE
                            0=0
                ";
        
        if($id!=0){
            $impostoQuery.= "
                                and imp_id=".$id."
                ";
            $impostoQuery.= $where;   
            $result = pg_query($db_connection, $impostoQuery);
            $res = pg_fetch_object($result);
            return $res;
            
        }else{
            $impostoQuery.= $where;
            $impostoQuery.= " order by imp_id desc ";
//            echo "$impostoQuery";
            $result = pg_query($db_connection, $impostoQuery);
            $arrTprodutos = array();
            while($res = pg_fetch_object($result)){
                $arrTprodutos[]=$res;
            }
            return $arrTprodutos;
        }
    }
    
    function update($db_connection,$dados){
        $sqlUpdateImpostos="
            UPDATE 
                    imposto
                SET
                    imp_nome='".trim($dados['impnome'])."',
                    imp_porcentagem='".trim($dados['impporcentagem'])."'
                WHERE
                    imp_id = '".$dados['impid']."';
            ";
        pg_query($db_connection, $sqlUpdateImpostos);
    }
    
    function insert($db_connection,$dados){
        
        $sqlInsertImpostos="
            INSERT 
                INTO
                    imposto(
                        imp_id_tproduto,
                        imp_nome,
                        imp_porcentagem
                        )
                    VALUES (
                        '".trim($dados['impidtproduto'])."',
                        '".trim($dados['impnome'])."',
                        '".trim($dados['impporcentagem'])."'
                    ) RETURNING imp_id;
            ";
        $id = pg_query($db_connection, $sqlInsertImpostos);
        return $id;
    }
    
    function delete($db_connection , $id){
//      Deleta o tipo de produto e seus impostos, normalmente eu apenas teria um flag de status e faria update
//      mas como o teste é do estilo CRUD, vamos fazer tudo do geito classico
        $sqlDeleteImposto="
             DELETE 
                FROM 
                    imposto
                WHERE
                    imp_id = '".$id."';
            ";
        pg_query($db_connection, $sqlDeleteImposto);
    }

}
