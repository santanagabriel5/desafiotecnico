
<?php 
        include_once "../Classes/CImpostos.php";
        
    if(isset($_POST['id'])){
    //  PESQUISANDO tipo produto NO BANCO
        $CImpostos = new CImpostos();
        $Impostos= $CImpostos->select($db_connection,$_POST['id']);
    }
?>
<div class="card-body">
    <h5 class="card-title">Cadastro Imposto </h5>
    <form action="salvaImposto.php" method="post" id='formImposto'>
        <input type="hidden" id='impid' name="impid" value="<?= (isset($_POST['id'])?$_POST['id']:0); ?>">
        <input type="hidden" id='impidtproduto' name="impidtproduto" value="<?= $_POST['id_tprod']; ?>">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" id='impnome' required name="impnome"
                <?php 
                    if(isset($_POST['id'])){
                        echo "Value='".trim($Impostos->imp_nome)."'";
                    }
                ?>  
           class="form-control" placeholder="Nome Imposto" >
        </div>
        <div class="mb-3">
            <label for="nome" class="form-label">Porcentagem</label>
            <input type="text" id='impporcentagem' required name="impporcentagem"
                <?php 
                    if(isset($_POST['id'])){
                        echo "Value='".trim($Impostos->imp_porcentagem)."'";
                    }
                ?>  
           class="form-control" placeholder="Nome">
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <button type="button" onclick="cancelarCadastroImposto()" class="btn btn-warning">Cancelar</button>
    </form>
</div>
<script>
    $('#formImposto').on('submit',function (e) {
        impid = $("#impid").val();
        impidtproduto = $("#impidtproduto").val();
        impnome = $("#impnome").val();
        impporcentagem = $("#impporcentagem").val();
        $.ajax({
            type: "POST",
            url: "salvaImposto.php",
            cache: false,
            data: {
                impid:impid,
                impidtproduto:impidtproduto,
                impnome:impnome,
                impporcentagem:impporcentagem
            },
            dataType: "json",
            success: function (json) {
                if(impid==0){
                    alert('Imposto inserido com sucesso');
                }else{
                    alert('Imposto atualizado com sucesso');
                }
//                alert(json['resposta']);
//                $("#divFormImposto").html(html);
//                $("#divFormImposto").show();
            },error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
        e.preventDefault();
    });

</script>

