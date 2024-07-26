<?php
session_start();
include '../../conexao_agsus_2.php';
include '../../conexao-agsus.php';

if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
//var_dump($_SESSION['msg']);
$cpftratado = '00101831161';
$cpf = substr_replace($cpftratado, "-", 9, 0);
$cpf = substr_replace($cpf, ".", 6, 0);
$cpf = substr_replace($cpf, ".", 3, 0);
$medico = 'CAROLINA MILITAO SPAGNOL';
$ibgeO = '352690';
$cnes = '3797902';
$ine = '1587021';
$ano = '2024';
$ciclo = '1';
$_SESSION['cpf'] = $cpftratado;
$_SESSION['nome'] = $medico;
$sql = "select * from municipio m inner join estado e on m.Estado_cod_uf = e.cod_uf and m.cod_munc = '$ibgeO'";
$query = mysqli_query($conn2, $sql) or die(mysqli_error($conn2));
$rs = mysqli_fetch_array($query);
$municipioO = $ufO = "";
if($rs){
    do{
        $municipioO = $rs['Municipio'];
        $ufO = $rs['UF'];
    }while ($rs = mysqli_fetch_array($query));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperfeiçoamento Profissional</title>
    <link rel="shortcut icon" href="../../img_agsus/iconAdaps.png"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12 col-md-4 mt-4 pl-5">
                <img src="../../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
            </div>
            <div class="col-12 col-md-8 mt-5">
                <h4 class="mb-4 font-weight-bold text-left">Comprovante de Aperfeiçoamento Profissional</h4>
            </div>
        </div>
        <div class="container-fluid mt-4">
        <div class="row  ">
            <div class="col-12">
                <?php
                if ($_SESSION['msg'] !== "") {
                    echo $_SESSION['msg'];
                }
                $_SESSION['msg'] = "";
                ?>
            </div>
        </div>
        <div class="row  ">
            <div class="col-12 shadow rounded  ">
                <div class="row mb-2 mt-2">
                    <div class="col-md-12 pt-2 pb-2">
                        <div class="card border">
                            <div class="card-header text-white bg-dark">
                                <h5 class="text-white"><b>Cadastro do Comprovante de Aperfeiçoamento Profissional</b></h5>
                            </div>
                            <div class="card-body">
        <div class="row mb-2 mt-2">
            <div class="col-md-12">
                <div class="card border-0">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Período avaliativo</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <div class="col-md-12"><b>Ano</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $ano ?>" id="ano" name="ano" /></div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12"><b>Ciclo</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $ciclo ?>" id="ciclo" name="ciclo" /></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-0">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Dados Pessoais</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-8">
                                <div class="col-md-12"><b>Nome</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $medico ?>" id="medico" /></div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12"><b>CPF</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $cpf ?>" id="cpf" /></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Município de Origem</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $municipioO ?>-<?= $ufO ?>" id="medico" /></div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12"><b>CNES</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $cnes ?>" id="cnes" /></div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12"><b>INE</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $ine ?>" id="ine" /></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" enctype="multipart/form-data" action="controller/rcb.php">
            <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
            <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
            <input type="hidden" value="<?= $cnes ?>" name="cnes">
            <input type="hidden" value="<?= $ine ?>" name="ine">
            <input type="hidden" value="<?= $ano ?>" name="ano">
            <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-0">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Atividade de Longa Duração</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="col-md-12"><b>Declaro que fui autorizado pela Agência para a realização de curso de longa duração?</b></div>
                                <div class="col-md-6">
                                    <select class="form-control " id="rdativ" name="rdativ">
                                        <option value="">[--SELECIONE--]</option>
                                        <option value="1">SIM</option>
                                        <option value="0">NÃO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
<!--                        <div class="row mb-2 divLongDuracao">
                            <div class="col-md-5">
                                <b>Tipo de atividade</b>
                                <div class="col-md-12">
                                    <select class="form-control" id="slLongaDuracao" name="slLongaDuracao">
                                        <option value="">[--SELECIONE--]</option>-->
                                        <?php
//                                        $sqlativ = "select idativlongduracao as idl, descricao as descl from ativlongduracao";
//                                        $qativ = mysqli_query($conn, $sqlativ) or die(mysqli_error($conn));
//                                        $rsativ = mysqli_fetch_array($qativ);
//                                        if($rsativ !== null){
//                                            do{ 
//                                                $idl = $rsativ['idl'];
//                                                $descl = $rsativ['descl'];
                                                ?>
                                                <!--<option value="<?= $idl ?>"><?= $descl ?></option>-->
                                        <?php    
//                                            }while ($rsativ = mysqli_fetch_array($qativ));
//                                        }
                                        ?>
<!--                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <b>Carga Horária</b>
                                <div class="col-md-12"><input type="number" class="form-control" value="" id="cargahrLongaDuracao" name="cargahrLongaDuracao" /></div>
                            </div>
                            <div class="col-md-4">
                                <b>Anexar documento</b>
                                <div class="col-md-12"><input type="file" class="form-control" value="" id="anexoLongaDuracao" name="anexoLongaDuracao" /></div>
                            </div>-->
<!--                        </div>
                        <div class="row mb-2 divLongDuracao">
                            <div class="col-md-6">
                                <div class="col-md-12"><button type="button" class="btn btn-primary" id="btnLongaDuracao"><i class="fas fa-plus-circle"></i> ADD ATIVIDADES</button></div>
                            </div>
                        </div>
                        <div class="row mb-2 divLongDuracao" id="divLongDuracao1"></div>
-->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-0">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Qualificação Clínica</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="col-md-12"><b>Possui atividade a declarar neste item?</b></div>
                                <div class="col-md-3">
                                    <select class="form-control " id="rdQual" name="rdQual">
                                        <option value="">[--SELECIONE--]</option>
                                        <option value="1">SIM</option>
                                        <option value="0">NÃO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 divQualiClinica">
                            <div class="col-md-8">
                                <div class="col-md-12"><b>Atividade</b></div>
                                <div class="col-md-12">
                                    <select class="form-control" id="slQualiClinica" name="slQualiClinica">
                                        <option value="">[--SELECIONE--]</option>
                                        <?php
                                        $sqlqualifcli = "select idqualifclinica as idq, descricao as descq from qualifclinica";
                                        $qqualifcli = mysqli_query($conn, $sqlqualifcli) or die(mysqli_error($conn));
                                        $rsqualifcli = mysqli_fetch_array($qqualifcli);
                                        if($rsqualifcli !== null){
                                            do{ 
                                                $idq = $rsqualifcli['idq'];
                                                $descq = $rsqualifcli['descq'];
                                                ?>
                                                <option value="<?= $idq ?>"><?= $descq ?></option>
                                        <?php    
                                            }while ($rsqualifcli = mysqli_fetch_array($qqualifcli));
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12"><b>Carga Horária</b></div>
                                <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrQualiClinica" name="cargahrQualiClinica" /></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Título da atividade</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" id="tituloQualiClinica" name="tituloQualiClinica" /></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Anexar documento</b></div>
                                <div class="col-md-12"><input type="file" class="form-control" id="anexoQualiClinica" name="anexoQualiClinica" /></div>
                            </div>
                        </div>
                        <div class="row mb-2 divQualiClinica">
                            <div class="col-md-6">
                                <div class="col-md-12"><button type="button" class="btn btn-primary" id="btnQualiClinica" ><i class="fas fa-plus-circle"></i> ADD ATIVIDADES</button></div>
                            </div>
                        </div>
                        <div class="row mb-2 divQualiClinica">
                            <div class="col-md-12 pl-5">
                                <label class="text-info"><small><i class="fas fa-hand-point-up"></i> &nbsp;Clique conforme o número de atividades a serem preenchidas.</small>
                            </div>
                        </div>
                        <div class="row mb-2 divQualiClinica" id="divQualiClinica1"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-0">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Gestão, Ensino, Pesquisa e Extensão</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="col-md-12"><b>Possui atividade a declarar neste item?</b></div>
                                <div class="col-md-3">
                                    <select class="form-control " id="rdGes" name="rdGes">
                                        <option value="">[--SELECIONE--]</option>
                                        <option value="1">SIM</option>
                                        <option value="0">NÃO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 divGesEnsPesExt">
                            <div class="col-md-8">
                                <div class="col-md-12"><b>Atividade</b></div>
                                <div class="col-md-12">
                                    <select class="form-control" id="slGesEnsPesExt" name="slGesEnsPesExt">
                                        <option value="">[--SELECIONE--]</option>
                                        <?php
                                        $sqlgesenspesext = "select idgesenspesext as idg, descricao as descg from gesenspesext";
                                        $qgesenspesext = mysqli_query($conn, $sqlgesenspesext) or die(mysqli_error($conn));
                                        $rsgesenspesext = mysqli_fetch_array($qgesenspesext);
                                        if($rsgesenspesext !== null){
                                            do{ 
                                                $idg = $rsgesenspesext['idg'];
                                                $descg = $rsgesenspesext['descg'];
                                                ?>
                                                <option value="<?= $idg ?>"><?= $descg ?></option>
                                        <?php    
                                            }while ($rsgesenspesext = mysqli_fetch_array($qgesenspesext));
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12"><b>Carga Horária</b></div>
                                <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrGesEnsPesExt" name="cargahrGesEnsPesExt" /></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Título da atividade</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" id="tituloGesEnsPesExt" name="tituloGesEnsPesExt" /></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Anexar documento</b></div>
                                <div class="col-md-12"><input type="file" class="form-control" id="anexoGesEnsPesExt" name="anexoGesEnsPesExt" /></div>
                            </div>
                        </div>
                        <div class="row mb-2 divGesEnsPesExt">
                            <div class="col-md-6">
                                <div class="col-md-12"><button type="button" class="btn btn-primary" id="btnGesEnsPesExt" ><i class="fas fa-plus-circle"></i> ADD ATIVIDADES</button></div>
                            </div>
                        </div>
                        <div class="row mb-2 divGesEnsPesExt">
                            <div class="col-md-12 pl-5">
                                <label class="text-info"><small><i class="fas fa-hand-point-up"></i> &nbsp;Clique conforme o número de atividades a serem preenchidas.</small>
                            </div>
                        </div>
                        <div class="row mb-2 divGesEnsPesExt" id="divGesEnsPesExt1"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-0">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Inovação Tecnológica</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="col-md-12"><b>Possui atividade a declarar neste item?</b></div>
                                <div class="col-md-3">
                                    <select class="form-control " id="rdInov" name="rdInov">
                                        <option value="">[--SELECIONE--]</option>
                                        <option value="1">SIM</option>
                                        <option value="0">NÃO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 divInovTec">
                            <div class="col-md-8">
                                <div class="col-md-12"><b>Atividade</b></div>
                                <div class="col-md-12">
                                    <select class="form-control" id="slInovTec" name="slInovTec">
                                        <option value="">[--SELECIONE--]</option>
                                        <?php
                                        $sqlinovtecnologica = "select idinovtecnologica as idi, descricao as desci from inovtecnologica";
                                        $qinovtecnologica = mysqli_query($conn, $sqlinovtecnologica) or die(mysqli_error($conn));
                                        $rsinovtecnologica = mysqli_fetch_array($qinovtecnologica);
                                        if($rsinovtecnologica !== null){
                                            do{ 
                                                $idi = $rsinovtecnologica['idi'];
                                                $desci = $rsinovtecnologica['desci'];
                                                ?>
                                                <option value="<?= $idi ?>"><?= $desci ?></option>
                                        <?php    
                                            }while ($rsinovtecnologica = mysqli_fetch_array($qinovtecnologica));
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12"><b>Carga Horária</b></div>
                                <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrInovTec" name="cargahrInovTec" /></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Título da atividade</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" id="tituloInovTec" name="tituloInovTec" /></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Anexar documento</b></div>
                                <div class="col-md-12"><input type="file" class="form-control" id="anexoInovTec" name="anexoInovTec" /></div>
                            </div>
                        </div>
                        <div class="row mb-2 divInovTec">
                            <div class="col-md-6">
                                <div class="col-md-12"><button type="button" class="btn btn-primary" id="btnInovTec" ><i class="fas fa-plus-circle"></i> ADD ATIVIDADES</button></div>
                            </div>
                        </div>
                        <div class="row mb-2 divInovTec">
                            <div class="col-md-12 pl-5">
                                <label class="text-info"><small><i class="fas fa-hand-point-up"></i> &nbsp;Clique conforme o número de atividades a serem preenchidas.</small>
                            </div>
                        </div>
                        <div class="row mb-2 divInovTec" id="divInovTec1"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 offset-sm-4 mt-4">
                <!--<input type="submit" class="btn btn-success p-2 form-control" name="enviaCadastro" value="ENVIAR FORMULÁRIO" />-->
                <button type="button" onclick="revisao();" class="shadow btn btn-success form-control" >ENVIAR FORMULÁRIO</button>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="enviarModal" tabindex="-1" aria-labelledby="enviarModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content p-1 bg-light">
              <div class="modal-header border-top border-left border-right"  style="background-color: #0055A1;">
                <h5 class="modal-title text-white" id="exampleModalLabel">Confirmação de envio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body border-top border-left border-right">
                  <div class="row">
                      <div class="col-md-12 p-3">
                            <p class="text-primary">Confirma o envio do cadastro?</p>
                      </div>
                  </div>
              </div>
              <div class="modal-footer border">
                  <button type="button" class="btn btn-secondary " data-dismiss="modal">NÃO</button> &nbsp; 
                  <button type="submit" name="enviaCadastro" class="btn btn-success">&nbsp; SIM &nbsp;</button>
              </div>
            </div>
          </div>
        </div>
        </form>
            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <br>
    <?php include './footer.php' ?>
    <script src="../../js_agsus/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="addcamps.js"></script>
    <script>
    $(document).ready(function (){
       $('.divLongDuracao').hide();
       $('.divQualiClinica').hide();
       $('.divGesEnsPesExt').hide();
       $('.divInovTec').hide();
       $('#enviarModal').modal('hide');
    });
    $('#rdativ').change(function(){
        let rdativ = $('#rdativ').val();
        if(rdativ === '1'){
            $('.divLongDuracao').show(400);
        }else{
            $('.divLongDuracao').hide(300);
        }
    });
    $('#rdQual').click(function(){
        let rdQual = $('#rdQual').val();
        if(rdQual === '1'){
            $('.divQualiClinica').show(400);
        }else{
            $('.divQualiClinica').hide(300);
        }
    });
    $('#rdGes').click(function(){
        let rdGes = $('#rdGes').val();
        if(rdGes === '1'){
            $('.divGesEnsPesExt').show(400);
        }else{
            $('.divGesEnsPesExt').hide(300);
        }
    });
    $('#rdInov').click(function(){
        let rdInov = $('#rdInov').val();
        if(rdInov === '1'){
            $('.divInovTec').show(400);
        }else{
            $('.divInovTec').hide(300);
        }
    });
    $('#btnLongaDuracao').click(function(){
       let a = 0;
       a = document.querySelectorAll('.divLongDuracao').length;
//       console.log(a);
       addAtvLongDuracao(a);
    });
    $('#btnQualiClinica').click(function(){
       let slQualiClinica = $('#slQualiClinica').val();
       let cargahrQualiClinica = $('#cargahrQualiClinica').val();
       let tituloQualiClinica = $('#tituloQualiClinica').val().trim();
       let anexoQualiClinica = $('#anexoQualiClinica').val();
       if(slQualiClinica === '' || cargahrQualiClinica === '' || tituloQualiClinica === '' || anexoQualiClinica === ''){
           swal({
                title: "Atenção!",
                text: "Preencha os campos da atividade Qualificação Clínica!",
                icon: "warning",
                button: "OK"
            });
            return;
       }
       let a = 0;
       a = document.querySelectorAll('.divQualiClinica').length;
//       console.log(a);
       addQualiClinica(a);
    });
    $('#btnGesEnsPesExt').click(function(){
       let slGesEnsPesExt = $('#slGesEnsPesExt').val();
       let cargahrGesEnsPesExt = $('#cargahrGesEnsPesExt').val();
       let tituloGesEnsPesExt = $('#tituloGesEnsPesExt').val().trim();
       let anexoGesEnsPesExt = $('#anexoGesEnsPesExt').val();
       if(slGesEnsPesExt === '' || cargahrGesEnsPesExt === '' || tituloGesEnsPesExt === '' || anexoGesEnsPesExt === ''){
           swal({
                title: "Atenção!",
                text: "Preencha os campos da atividade Gestão, Ensino, Pesquisa e Extensão!",
                icon: "warning",
                button: "OK"
            });
            return;
       }
       let a = 0;
       a = document.querySelectorAll('.divGesEnsPesExt').length;
//       console.log(a);
       addGesEnsPesExt(a);
    });
    $('#btnInovTec').click(function(){
       let slInovTec = $('#slInovTec').val();
       let cargahrInovTec = $('#cargahrInovTec').val();
       let tituloInovTec = $('#tituloInovTec').val().trim();
       let anexoInovTec = $('#anexoInovTec').val();
       if(slInovTec === '' || cargahrInovTec === '' || tituloInovTec === '' || anexoInovTec === ''){
           swal({
                title: "Atenção!",
                text: "Preencha os campos da atividade Inovação Tecnológica!",
                icon: "warning",
                button: "OK"
            });
            return;
       }
       let a = 0;
       a = document.querySelectorAll('.divInovTec').length;
//       console.log(a);
       addInovTec(a);
    });
    function retiraAtvLongDur(num){
        $('#atvLongDur'+num).remove();
        $('#cargaLongDur'+num).remove();
        $('#anexoLongDur'+num).remove();
        $('#btnLongDur'+num).remove();
    }
    function retiraQualiClinica(num){
        $('#qualiClinica'+num).remove();
        $('#divcargaQualiClinica'+num).remove();
        $('#divtituloQualiClinica'+num).remove();
        $('#divanexoQualiClinica'+num).remove();
        $('#divbtnQualiClinica'+num).remove();
    }
    function retiraGesEnsPesExt(num){
        $('#gesEnsPesExt'+num).remove();
        $('#divcargaGesEnsPesExt'+num).remove();
        $('#divtituloGesEnsPesExt'+num).remove();
        $('#divanexoGesEnsPesExt'+num).remove();
        $('#divbtnGesEnsPesExt'+num).remove();
    }
    function retiraInovTec(num){
        $('#inovTec'+num).remove();
        $('#divcargaInovTec'+num).remove();
        $('#divtituloInovTec'+num).remove();
        $('#divanexoInovTec'+num).remove();
        $('#divbtnInovTec'+num).remove();
    }
    function revisao(){
        let rdativ = $('#rdativ').val();
        let rdQual = $('#rdQual').val();
        let rdGes = $('#rdGes').val();
        let rdInov = $('#rdInov').val();
        let analise = true;
        if(rdativ === '0' && rdQual === '0' && rdGes === '0' && rdInov === '0'){
            analise = false;
//            console.log(analise);
            swal({
                title: "Atenção!",
                text: "Ao mennos uma atividade deve ser preenchida!",
                icon: "warning",
                button: "OK"
            });
            $('#rdativ').focus(); return;
        }else{
            analise = true;
        }
        if(rdativ === ''){
            analise = false;
//            console.log(analise);
            swal({
                title: "Atenção!",
                text: "Responda a pergunta no item Atividade de Longa Duração!",
                icon: "warning",
                button: "OK"
            });
//          alert('Responda a pergunta no item Atividade de Longa Duração');
            $('#rdativ').focus(); return;
        }else{
            analise = true;
        }
        if(rdQual === ''){
            analise = false;
//            console.log(analise);
            swal({
                title: "Atenção!",
                text: "Responda a pergunta no item Qualificação Clínica!",
                icon: "warning",
                button: "OK"
            });
//            alert('Responda a pergunta no item Qualificação Clínica');
            $('#rdQual').focus(); return;
        }else{
            if(rdQual === '1'){
                let slQualiClinica = $('#slQualiClinica').val();
                let cargahrQualiClinica = $('#cargahrQualiClinica').val();
                let tituloQualiClinica = $('#tituloQualiClinica').val().trim();
                let anexoQualiClinica = $('#anexoQualiClinica').val();
//                console.log(anexoQualiClinica);
                if(slQualiClinica === '' || cargahrQualiClinica === '' || tituloQualiClinica === '' || anexoQualiClinica === ''){
                    analise = false;
                    swal({
                        title: "Atenção!",
                        text: "Preencha os campos no item Qualificação Clínica!",
                        icon: "warning",
                        button: "OK"
                    });
    //                alert('Preencha os campos no item Qualificação Clínica');
                    if(slQualiClinica === ''){
                        $('#slQualiClinica').focus(); return;
                    }
                    if(cargahrQualiClinica === ''){
                        $('#cargahrQualiClinica').focus(); return;
                    }
                    if(tituloQualiClinica === ''){
                        $('#tituloQualiClinica').focus(); return;
                    }
                    if(anexoQualiClinica === ''){
                        $('#anexoQualiClinica').focus(); return;
                    }
                }
            }else{
                analise = true;
            }
        }
        if(rdGes === ''){
            analise = false;
//            console.log(analise);
            swal({
                title: "Atenção!",
                text: "Responda a pergunta no item Gestão, Ensino, Pesquisa e Extensão!",
                icon: "warning",
                button: "OK"
            });
//            alert('Responda a pergunta no item Gestão, Ensino, Pesquisa e Extensão');
            $('#rdGes').focus(); return;
        }else{
            if(rdGes === '1'){
                let slGesEnsPesExt = $('#slGesEnsPesExt').val();
                let cargahrGesEnsPesExt = $('#cargahrGesEnsPesExt').val();
                let tituloGesEnsPesExt = $('#tituloGesEnsPesExt').val().trim();
                let anexoGesEnsPesExt = $('#anexoGesEnsPesExt').val();
//                console.log(anexoQualiClinica);
                if(slGesEnsPesExt === '' || cargahrGesEnsPesExt === '' || tituloGesEnsPesExt === '' || anexoGesEnsPesExt === ''){
                    analise = false;
                    swal({
                        title: "Atenção!",
                        text: "Preencha os campos no item Gestão, Ensino, Pesquisa e Extensão!",
                        icon: "warning",
                        button: "OK"
                    });
    //                alert('Preencha os campos no item Gestão, Ensino, Pesquisa e Extensão');
                    if(slGesEnsPesExt === ''){
                        $('#slGesEnsPesExt').focus(); return;
                    }
                    if(cargahrGesEnsPesExt === ''){
                        $('#cargahrGesEnsPesExt').focus(); return;
                    }
                    if(tituloGesEnsPesExt === ''){
                        $('#tituloGesEnsPesExt').focus(); return;
                    }
                    if(anexoGesEnsPesExt === ''){
                        $('#anexoGesEnsPesExt').focus(); return;
                    }
                }else{
                    analise = true;
                }
            }
        }
        if(rdInov === ''){
            analise = false;
//            console.log(analise);
            swal({
                title: "Atenção!",
                text: "Responda a pergunta no item Inovação Tecnológica!",
                icon: "warning",
                button: "OK"
            });
//            alert('Responda a pergunta no item Inovação Tecnológica');
            $('#rdInov').focus(); return;
        }else{
            if(rdInov === '1'){
                let slInovTec = $('#slInovTec').val();
                let cargahrInovTec = $('#cargahrInovTec').val();
                let tituloInovTec = $('#tituloInovTec').val().trim();
                let anexoInovTec = $('#anexoInovTec').val();
//                console.log(anexoQualiClinica);
                if(slInovTec === '' || cargahrInovTec === '' || tituloInovTec === '' || anexoInovTec === ''){
                    analise = false;
                    swal({
                        title: "Atenção!",
                        text: "Preencha os campos no item Inovação Tecnológica!",
                        icon: "warning",
                        button: "OK"
                    });
    //                alert('Preencha os campos no item Inovação Tecnológica');
                    if(slInovTec === ''){
                        $('#slInovTec').focus(); return;
                    }
                    if(cargahrInovTec === ''){
                        $('#cargahrInovTec').focus(); return;
                    }
                    if(tituloInovTec === ''){
                        $('#tituloInovTec').focus(); return;
                    }
                    if(anexoInovTec === ''){
                        $('#anexoInovTec').focus(); return;
                    }
                }else{
                    analise = true;
                }
            }
        }
        if(analise === true){
            $('#enviarModal').modal('show');
        }else{
            $('#enviarModal').modal('hide');
        }
//        console.log(analise);
    }
    </script>
</body>

</html>