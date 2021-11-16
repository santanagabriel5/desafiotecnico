<?php 
    include_once "../function/session.php";
    include_once "../Classes/CProdutos.php";
    include_once "../Classes/CImpostos.php";
    
    //  PESQUISANDO produto NO BANCO
        $CImpostos = new CImpostos();
        $CProdutos = new CProdutos();
        $Produto= $CProdutos->select($db_connection,$_POST['pro_id']);
        $vTotalImpostos = 0;
?>
<tr  id="tr_info_<?= $Produto->pro_id ?>">
    <td colspan="4">
        <div class="card" style="margin-top: 1px">
          <div class="card-body">
              <h5 class="card-title" ><?= $Produto->pro_id." : ".$Produto->pro_nome ?> </h5>
              <table >
                  <tr>
                        <td style="padding: 2px"><h6 class="card-subtitle mb-2 text-muted" ><b>Valor:</b> <?= converteMoeda($Produto->pro_valor) ?></h6></td>
                        <td style="padding: 2px"><h6 class="card-subtitle mb-2 text-muted" ><b>Peso:</b> <?= $Produto->pro_peso ?>g</h6></td>
                        <td style="padding: 2px"><h6 class="card-subtitle mb-2 text-muted" ><b>Qtd:</b> <?= $Produto->pro_qtd ?></h6></td>
                        <td style="padding: 2px"><h6 class="card-subtitle mb-2 text-muted" ><b>Tipo de Produto:</b> <?= $Produto->tpro_nome ?></h6></td>
                        <?php 
                            $arrImpostos= $CImpostos->select($db_connection,0," and imp_id_tproduto = '".$Produto->tpro_id."' ");
                            $x=0;
                            if(count($arrImpostos)>0){
                        ?>
                            <td style="padding: 2px"><h6 class="card-subtitle mb-2 text-muted" ><b>Impostos:</b></h6></td>
                        <?php
                                foreach($arrImpostos as $index=>$Imp){
                        ?>
                            <td style="padding: 2px">
                                <h6 class="card-subtitle mb-2 text-muted" >
                                    <?php 
    //                                Ta ficando muito grande e nem eu to entendo oq ta acontecendo, hora de dividir
    //                                A virgula antes de imposto, APENAS do 2 pra frente
                                        echo $index > 0 ? ', ' : "";
    //                                Nome do imposto
                                        echo $Imp->imp_nome;
    //                                Porcentagem do imposto
                                        echo " ( ".str_replace('.', ',', $Imp->imp_porcentagem)." %";
    //                                Valor do imposto aplicado
                                        $arrImp = calculaImpostoAplicado($Produto->pro_valor,$Imp->imp_porcentagem);
                                        $vTotalImpostos+=$arrImp['Float'];
                                        echo " | R$ ".$arrImp['String'].") ";
                                    ?>
                                </h6>
                            </td>
                        <?php
                                }
                        ?>  
                        <td style="padding: 2px"><h6 class="card-subtitle mb-2 text-muted" ><b>Total Impostos:</b> <?= converteMoeda($vTotalImpostos) ?></h6></td>
                        <?php
                            }
                        ?>  
                  </tr>
                  <tr>
                      <td style="padding: 2px" colspan="4"><h6 class="card-subtitle mb-2 text-muted" ><b>Descrição:</b> <?= $Produto->pro_descricao ?></h6></td>
                  </tr>
              </table>
          </div>
        </div>
    </td>
</tr>
