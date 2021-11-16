<?php
    include_once "../function/session.php";
    include_once "../Classes/CProdutos.php";
    include_once "../Classes/CImpostos.php";
    
    //  PESQUISANDO produto NO BANCO
        $CImpostos = new CImpostos();
        $CProdutos = new CProdutos();
        $Produto= $CProdutos->select($db_connection,$_POST['pro_id']);
        $vTotalImpostos = 0;
        $arrnomeImpostos = array();
?>
<div class="card-body" >
    <div class="modal-header">
        <h5 class="modal-title" ><?= $Produto->pro_nome ?></h5>
    </div>
    <div class="modal-body">
        <div class="input-group" >
            <div class="form-outline">
                <input type="text" id="quantidade" class="form-control" value="1"/>
            </div>
            <button type="button" id="btn_adicionar" class="btn btn-primary" onclick="atualizaTotais()">Calcular</button>
        </div>
        <table class="table table-striped" style="margin-top: 5px">
            <tr>
                <th colspan="3" style="text-align: center">UNITARIO</th>
            </tr>
            <tr>
                <td><b>Valor</b></td>
                <td><b>Peso</b></td>
                <td><b>Impostos</b></td>
            </tr>
            <tr>
                <td><?= converteMoeda($Produto->pro_valor) ?></td>
                <td><?= $Produto->pro_peso ?>g</td>
                <?php 
                    $arrImpostos= $CImpostos->select($db_connection,0," and imp_id_tproduto = '".$Produto->tpro_id."' ");
                    $x=0;
                    if(count($arrImpostos)>0){
                        foreach($arrImpostos as $index=>$Imp){
                            $arrImp = calculaImpostoAplicado($Produto->pro_valor,$Imp->imp_porcentagem);
                            $arrnomeImpostos[]=$Imp->imp_nome;
                            $vTotalImpostos+=$arrImp['Float'];
                        }
                    }
                  ?>
                <td title="<?= implode(',', $arrnomeImpostos) ?>"><?= converteMoeda($vTotalImpostos) ?></td>
            </tr>
            <tr>
                <th colspan="3" style="text-align: center">TOTAIS</th>
            </tr>
            <tr>
                <td><b>Valor</b></td>
                <td><b>Peso</b></td>
                <td><b>Impostos</b></td>
            </tr>
            <tr id="tr_totais"></tr>
        </table>
        <div style="float: right;margin-bottom: 5px">
            <button type="button" class="btn btn-secondary "  onclick="cancelaAdd()" >Cancelar</button>
            <button type="button" class="btn btn-primary "  onclick="addProduto()" >Adicionar a compra</button>
        </div>
    </div>
</div>
<script>
    var valor = <?= $Produto->pro_valor ?>;
    var peso = <?= $Produto->pro_peso ?>;
    var tImposto = <?= $vTotalImpostos ?>;
    var id = <?= $Produto->pro_id ?>;
    
    function checkKey() {
        var clean = this.value.replace(/[^0-9]/g, "").replace(/(,.*?),(.*,)?/, "$1");
        if (clean !== this.value) this.value = clean;
    }
    document.querySelector('#quantidade').oninput = checkKey;
    
    function atualizaTotais(){
        qtd = $("#quantidade").val();
        if(qtd <= 0){
            alert("QUANTIDADE NÃO PODE SER IGUAL A ZERO!");
            return false;
        }
        nvalor = valor*qtd;
        nvalor = nvalor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
        npeso = peso*qtd;
        ntImposto = tImposto*qtd;
        ntImposto = ntImposto.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
        conteudo = "<td> "+nvalor+" reais</td><td>"+npeso+"g</td><td>"+ntImposto+"</td>";
        $("#tr_totais").html(conteudo);
    }
    atualizaTotais();
    
    function addProduto(){
        qtd = $("#quantidade").val();
        carregando();
        $.ajax({
            type: "POST",
            url: "vendaCarrinho.php",
            cache: false,
            data: {
                pro_id:id,
                qtd:qtd
            },
            dataType: "html",
            success: function (html) {
                $("#divCarrinho").html(html);
                $("#cardCarrinho").show();
                carregando();
            },error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }
    
</script>