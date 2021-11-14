<?php 
    include_once "../function/session.php";
    include_once "../Classes/CProdutos.php";
    include_once "../Classes/CTProdutos.php";

    $tituloPagina="Formulario de Produtos";
    $_SESSION['btnMenu']='Cadastro';
    include_once 'Header.php';
    
    if(isset($_GET['id'])){
    //  PESQUISANDO tipo produto NO BANCO
        $CProdutos = new CProdutos();
        $Produto= $CProdutos->select($db_connection,$_GET['id']);
    }

?>
<div class="container-fluid" style="margin-top: 15px">
    <div class="card" style="width: 40% ;display: inline-block">
      <div class="card-body">
        <h5 class="card-title"><?= isset($_GET['id']) ? "Edição" : "Cadastro" ?> de Produto </h5>
        <form action="salvaProduto.php" method="post">
            <input type="hidden" name="id" value="<?= (isset($_GET['id'])?$_GET['id']:0); ?>">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input required type="text" required name="nome"
                    <?php 
                        if(isset($_GET['id'])){
                            echo "Value='".trim($Produto->pro_nome)."'";
                        }
                    ?>  
               class="form-control" id="nameCourse" placeholder="Nome">
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea required class="form-control" name="descricao" rows="3" maxlength="149"><?php 
                        if(isset($_GET['id'])){
                            echo trim($Produto->pro_descricao);
                        }
                    ?></textarea>
            </div>
            <div class="mb-3">
                <label for="peso" class="form-label">Peso</label>
                <input required type="text" id='peso' required name="peso"
                    <?php 
                        if(isset($_GET['id'])){
                            echo "Value='".trim($Produto->pro_peso)."'";
                        }
                    ?>  
               class="form-control" placeholder="Digite apenas o valor do peso em gramas.">
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input required type="text" id='valor' required name="valor"
                    <?php 
                        if(isset($_GET['id'])){
                            echo "Value='".trim(str_replace('.', ',', $Produto->pro_valor))."'";
                        }
                    ?>  
               class="form-control" placeholder="Digite apenas o valor do produto.">
            </div>
            <div class="mb-3">
                <label for="nome" class="form-label">Tipo de Produto</label>
                <select required name="tproduto" class="form-control">
                    <option value="">...</option>
                    <?php 
                        $CTProdutos = new CTProdutos();
                        $arrTProdutos= $CTProdutos->select($db_connection);
                        foreach($arrTProdutos as $TProdutos){
                    ?>
                        <option <?= $TProdutos->tpro_id == $Produto->pro_id_tproduto ? "Selected":""  ?> value="<?= $TProdutos->tpro_id ?>"><?= $TProdutos->tpro_nome ?></option>
                    <?php 
                        }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>

<script>
    function checkKey() {
        var clean = this.value.replace(/[^0-9]/g, "")
                               .replace(/(,.*?),(.*,)?/, "$1");
        if (clean !== this.value) this.value = clean;
    }
    function checkKeyVirgula() {
        var clean = this.value.replace(/[^0-9,]/g, "")
                               .replace(/(,.*?),(.*,)?/, "$1");
        if (clean !== this.value) this.value = clean;
    }

    document.querySelector('#peso').oninput = checkKey;
    document.querySelector('#valor').oninput = checkKeyVirgula;
</script>
<?php
    include_once 'Footer.php';
?>
