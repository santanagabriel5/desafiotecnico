<?php
    error_reporting(-1);

class CImpostos{
//  Atributos
    private $imp_id;
    private $imp_nome;
    private $imp_id_produto;
    private $imp_procentagem;

    function getImp_id() {
        return $this->imp_id;
    }

    function getImp_nome() {
        return $this->imp_nome;
    }

    function getImp_id_produto() {
        return $this->imp_id_produto;
    }

    function getImp_procentagem() {
        return $this->imp_procentagem;
    }

    function setImp_id($imp_id) {
        $this->imp_id = $imp_id;
    }

    function setImp_nome($imp_nome) {
        $this->imp_nome = $imp_nome;
    }

    function setImp_id_produto($imp_id_produto) {
        $this->imp_id_produto = $imp_id_produto;
    }

    function setImp_procentagem($imp_procentagem) {
        $this->imp_procentagem = $imp_procentagem;
    }

    
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
                                and imp_id=".$id;"
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
