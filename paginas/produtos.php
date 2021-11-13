<?php 
    include_once "../function/session.php";
    include_once "../Classes/CCourses.php";
    
    $tituloPagina="Produtos";
    $_SESSION['btnMenu']='Cadastro';
    include_once 'Header.php';
    
//  PESQUISANDO Cursos NO BANCO
//    $CCourses = new Courses();
//    $arrCourses= $CCourses->select($mysqli);

?>
<div class="card" style="margin-top: 15px">
  <div class="card-body">
    <h5 class="card-title">Cursos</h5>
    <button type="button" class="btn btn-primary" onclick="location.href='formularioCurso.php'">Adicionar novo Curso</button>
    <table class="table table-striped" style="margin-top: 15px">
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th></th>
        </tr>
            <?php 
//            print_r($arrCourses);
                foreach($arrCourses as  $course){
            ?>
                <tr>
                    <td><?= $course->getId() ?></td>
                    <td><?= $course->getNameCourse() ?></td>
                    <td>
                        <a href="curso.php?id=<?= $course->getId() ?>" class="btn btn-primary">Visualizar</a>
                        <a href="formularioCurso.php?id=<?= $course->getId() ?>" class="btn btn-warning">Editar</a>
                        <?php 
                            if($course->getStatus()==1){
                        ?>
                        <a href="#" onclick="
                            if (confirm('Deseja realmente desativar o curso <?= $course->getNameCourse() ?> ?')) {
                                window.location='ativaDesativaCursos.php?Id=<?= $course->getId() ?>&pagina=cursos';
                            }
                           " class="btn btn-danger">Desativar</a>
                        <?php 
                            }else{
                        ?>
                            <a href="#" class="btn btn-success"
                               onclick="
                                        if (confirm('Deseja realmente ativar o curso <?= $course->getNameCourse() ?> ?')) {
                                            window.location='ativaDesativaCursos.php?Id=<?= $course->getId() ?>&pagina=cursos';
                                        }
                                       "
                            >Ativar</a>
                        <?php 
                            }
                        ?>
                    </td>
                </tr>
            <?php 
                }
            ?>
    </table>
  </div>
</div>


<?php
    include_once 'Footer.php';
?>
