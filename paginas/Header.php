    <link href="<?= $urlImports ?>css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="<?= $urlImports ?>js/bootstrap.min.js"></script>
    <script src="<?= $urlImports ?>js/jquery-3.6.0.min.js"></script>


<!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->
<header>
    <title><?= $tituloPagina ?></title>
</header>
<body>
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded">
            <div class="container-fluid">
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= ($_SESSION['btnMenu']=='home' ? "active":"") ?>"   href="<?= $urlImports ?>index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_SESSION['btnMenu']=='alunos' ? "active":"") ?>" href="<?= $urlPaginas ?>alunos.php">Venda</a>
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
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?= ($_SESSION['btnMenu']=='alunos' ? "active":"") ?>" href="<?= $urlPaginas ?>alunos.php">Carrinho <?= "(2)" ?></a>
                    </li>
                </ul>
              </div>
            </div>
        </nav>
        
