<?php 
    include_once "../function/session.php";
    include_once "../Classes/CProdutos.php";
    
    $tituloPagina="Venda";
    $_SESSION['btnMenu']='Venda';
    include_once 'Header.php';
    
//  PESQUISANDO produtos NO BANCO
    $CProdutos = new CProdutos();
    $arrProdutos= $CProdutos->select($db_connection);
    unset($_SESSION['carrinho']);
?>

    <div class="card" style="margin-top: 15px">
      <div class="card-body">
        <div style="height: 500px">
            <h5 class="card-title">Venda</h5>
            <div class="container-fluid">
                <!--Parte de pesquisa-->
                <div class="card" style="margin-top: 15px;width: 49%;display: inline-block;vertical-align: top;">
                    <div class="card-body">
                        <div class="input-group">
                            <div class="form-outline">
                                <input type="search" id="pesquisa" class="form-control" style="width: 400px" />
                            </div>
                            <button type="button" id="btn_pesquisar" class="btn btn-primary">Pesquisar</button>
                        </div>
                        <div id="div_venda_pesquisar" style="overflow-y: scroll;max-height: 400px">

                        </div>
                    </div>
                </div>
                <!--Parte de adição de produto-->
                <div class="card" style="margin-top: 15px;width: 49%;display: inline-block;vertical-align: top;" id="divAddProduto">

                </div>
            </div>
        </div>
      </div>
    </div>
<div class="card" id="cardCarrinho" style="margin-top: 5px ;display: none;">
    <div class="card-body">
        <h5 class="card-title">
            <div style="float: left">
                Carrinho
            </div>
            <div style="float: right;">
                <button type="button" class="btn btn-primary " id="btnFinalizaCompra" style="margin-bottom: 10px;" >Finalizar compra</button>
            </div>
        </h5>
        <div id="divCarrinho">
            
        </div>
    </div>
</div>

<script>
    var $loading = $('#loadingDiv').hide();
    $(document)
      .ajaxStart(function () {
        $loading.show();
      })
      .ajaxStop(function () {
        $loading.hide();
      });
      
    $("#divAddProduto").hide();
    $(document).ready(function(){
        $(document).on('click', '#btn_pesquisar', function (evt) {
            carregando();
            $.ajax({
                type: "POST",
                url: "vendaPesquisa.php",
                cache: false,
                data: {
                    pesquisa:$("#pesquisa").val()
                },
                dataType: "html",
                success: function (html) {
                    $("#div_venda_pesquisar").html(html);
                    carregando();
                },error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        });
        
        $(document).on('click', '#btnFinalizaCompra', function (evt) {
            carregando();
            $.ajax({
                type: "POST",
                url: "vendaFinaliza.php",
                cache: false,
                data: {
                },
                dataType: "json",
                success: function (json) {
                    carregando();
                    alert("Venda finalizada com sucesso");
                    location.reload();
                },error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        });
        $(document).on('click', '.btnDesVisualizarProduto', function (evt) {
            btn = $(this);
            btn.addClass(" btnVisualizarProduto ");
            btn.removeClass(" btnDesVisualizarProduto ");
            btn.html("Visualizar");
            $("#tr_info_"+btn.attr("id")).remove();
        });
    });
</script>

<?php
    include_once 'Footer.php';
?>
