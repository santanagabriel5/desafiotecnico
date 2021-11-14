<?php 
    include_once "../function/session.php";
    include_once "../Classes/CTProdutos.php";
    include_once "../Classes/CImpostos.php";

    $tituloPagina="Formulario Tipo de Produto";
    $_SESSION['btnMenu']='Cadastro';
    include_once 'Header.php';
    
    if(isset($_GET['id'])){
    //  PESQUISANDO tipo produto NO BANCO
        $CTProdutos = new CTProdutos();
        $TProduto= $CTProdutos->select($db_connection,$_GET['id']);
    }

?>
<div class="container-fluid" style="margin-top: 15px">
    <div class="card" style="width: 40% ;display: inline-block">
      <div class="card-body">
        <h5 class="card-title"><?= isset($_GET['id']) ? "Edição" : "Cadastro" ?> de Tipo de Produto </h5>
        <form action="salvaTProduto.php" method="post">
            <input type="hidden" name="id" value="<?= (isset($_GET['id'])?$_GET['id']:0); ?>">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input required type="text" required name="nome"
                    <?php 
                        if(isset($_GET['id'])){
                            echo "Value='".trim($TProduto->tpro_nome)."'";
                        }
                    ?>  
               class="form-control" id="nameCourse" placeholder="Nome" aria-describedby="nameCourse">
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea required class="form-control" name="descricao" rows="3" maxlength="149"><?php 
                        if(isset($_GET['id'])){
                            echo trim($TProduto->tpro_descricao);
                        }
                    ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        <?php
//      Eu sei, desativar e so permitir adicionar na edição é meio sujo, mas até hj eu não sei como resolver essa situação de
//      "inserir uma tabela q precisa de vinculo com uma tabela q ainda não existe", deve ter um geito mais legal de se fazer
//      e um dia eu vou encontrar
        
            if(isset($_GET['id'])){
        ?>
            <button id="btnAdicionaImposto" type="button" class="btn btn-primary">Adicionar Imposto</button>
        <?php
            }else{
        ?>
            <button type="button" class="btn btn-primary" disabled>Adicionar Imposto</button>
            <br><small id="ajudaImpostos" class="form-text text-muted">Impostos so podem ser adicionados na edição do tipo de produto.</small>
        <?php
            }
        ?>
      </div>
        <!--<a href='cursos.php' class='btn btn-primary'>Retornar</a>-->
    </div>
    <div class="card" id="divFormImposto" style="width: 40% ;display: inline-block;vertical-align: top;">
        <!--<a href='cursos.php' class='btn btn-primary'>Retornar</a>-->
    </div>
</div>
<?php 
//LISTANDO IMPOSTOS
    $CImpostos = new CImpostos();
    $arrImpostos= $CImpostos->select($db_connection,0," and imp_id_tproduto = '".$_GET['id']."' ");

?>
    <div class="card" style="margin-top: 15px;margin-left:15px ;width: 25%">
        <div class="card-body">
            <table class="table table-striped" style="margin-top: 15px">
                <tr>
                    <th colspan="3"  style="text-align:center">Impostos</th>
                </tr>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Porcentagem</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="list-imp">
                <?php 
                    foreach($arrImpostos as $Imp){
                ?>  
                    <tr id="tr_imposto_<?= $Imp->imp_id ?>">
                        <td><?= $Imp->imp_nome ?></td>
                        <td><?= str_replace('.', ',', $Imp->imp_porcentagem);  ?> %</td>
                        <td>
                            <a id="<?= $Imp->imp_id ?>" class="btn btn-warning btnEditaImposto">Editar</a>
                            <a href="#" onclick="
                                if (confirm('Deseja realmente deletar o imposto <?= $Imp->imp_nome ?> ?')) {
                                    deletaImposto('<?= $Imp->imp_id ?>');
                                }
                               "class="btn btn-danger">Excluir</a>
                        </td>
                    </tr>
                <?php 
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<script>
    function deletaImposto(id){
        $.ajax({
            type: "POST",
            url: "deletaImposto.php",
            cache: false,
            data: {
                id:id
            },
            dataType: "json",
            success: function (json) {
                alert('Imposto excluido com sucesso');
                $("#tr_imposto_"+id).hide();
                cancelarCadastroImposto();
            },error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }
    function cancelarCadastroImposto(){
        $("#impid").val("");
        $("#impidtproduto").val("");
        $("#impnome").val("");
        $("#impporcentagem").val("");
        $("#divFormImposto").hide();
    }
    $(document).ready(function(){
        $("#btnAdicionaImposto").click(function(){
            $.ajax({
                type: "POST",
                url: "formularioImposto.php",
                cache: false,
                data: {
                    id_tprod:'<?= $_GET['id'] ?>'
                },
                dataType: "html",
                success: function (html) {
                    $("#divFormImposto").html(html);
                    $("#divFormImposto").show();
                },error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        });
//        $(".btnEditaImposto").click(function(){
        $(document).on('click', '.btnEditaImposto', function (evt) {
            imp_id = $(this).attr('id');
            $.ajax({
                type: "POST",
                url: "formularioImposto.php",
                cache: false,
                data: {
                    id_tprod:'<?= $_GET['id'] ?>',
                    imp_id:imp_id
                },
                dataType: "html",
                success: function (html) {
                    $("#divFormImposto").html(html);
                    $("#divFormImposto").show();
                },error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        });
    });
</script>
<?php
    include_once 'Footer.php';
?>
