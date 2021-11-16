    <link href="<?= $urlImports ?>css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="<?= $urlImports ?>js/bootstrap.min.js"></script>
    <script src="<?= $urlImports ?>js/jquery-3.6.0.min.js"></script>
    

<!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->
<header>
    <title><?= $tituloPagina ?></title>
</header>
<body>
    <div id="divCarregando" style="position:fixed;padding:0;margin:0;top:0;left:0;width: 100%;height: 100%;background:rgba(237, 234, 234,0.5);z-index: 99;display: none;">
        <div class="text-center" style="margin-top: 20%">
            <div class="spinner-border" role="status" style="width: 20rem; height: 20rem;">
              <!--<span class="sr-only"></span>-->
            </div>
        </div>
    </div>
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded">
            <div class="container-fluid">
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= ($_SESSION['btnMenu']=='home' ? "active":"") ?>"   href="<?= $urlImports ?>index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_SESSION['btnMenu']=='Venda' ? "active":"") ?>" href="<?= $urlPaginas ?>vendaHub.php">Venda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= ($_SESSION['btnMenu']=='Cadastro' ? "active":"") ?>" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Cadastros
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                            <li><a class="dropdown-item" href="<?= $urlPaginas ?>produtos.php">Produtos</a></li>
                            <li><a class="dropdown-item" href="<?= $urlPaginas ?>tprodutos.php">Tipo Produtos</a></li>
                            <li><a class="dropdown-item" href="<?= $urlPaginas ?>impostos.php">Impostos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_SESSION['btnMenu']=='RelVendas' ? "active":"") ?>" href="<?= $urlPaginas ?>vendas.php">Rel.Vendas</a>
                    </li>
                </ul>
              </div>
            </div>
        </nav>
<script>
    function carregando(){
        if($("#divCarregando").is(":hidden")){
            $("#divCarregando").show();
        }else{
            $("#divCarregando").hide();
        }
    }
</script>
