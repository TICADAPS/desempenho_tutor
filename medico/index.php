<?php
session_start();
include '../conexao_agsus_2.php';
include '../conexao-agsus.php';
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
    <link rel="shortcut icon" href="./../img_agsus/iconAdaps.png"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12 col-md-4 mt-4 pl-5">
                <img src="../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
            </div>
            <div class="col-12 col-md-8 mt-5">
                <h4 class="mb-4 font-weight-bold text-center">Comprovante de Aperfeiçoamento Profissional</h4>
            </div>
        </div>
        <div class="container-fluid mt-4">
        <div class="row mr-2 ml-2">
            <div class="col-12 shadow rounded mr-2 ml-2">
                <div class="row mb-2 mt-2">
                    <div class="col-sm-12 pt-4 pr-2 pl-2">
                        <div class="card border">
                            <div class="card-header bg-secondary">
                                <h5 class="text-white">Cadastro do(s) Comprovante(s) de Aperfeiçoamento Profissional</h5>
                            </div>
                            <div class="card-body">
        <div class="row mb-2 mt-4">
            <div class="col-sm-12 pr-2 pl-2">
                <div class="card border-light">
                    <div class="card-header" style="background-color: #d9e5f9;">
                        <label><strong>Período avaliativo</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-3 pr-2 pl-2">
                                <div class="col-sm-3"><b>Ano</b></div>
                                <div class="col-sm-8"><input type="text" class="form-control" disabled="disabled" value="<?= $ano ?>" id="ano" name="ano" /></div>
                            </div>
                            <div class="col-sm-3 pr-2 pl-2">
                                <div class="col-sm-3"><b>Ciclo</b></div>
                                <div class="col-sm-8"><input type="text" class="form-control" disabled="disabled" value="<?= $ciclo ?>" id="ciclo" name="ciclo" /></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4 pl-2 pr-2">
                <div class="card border-light">
                    <div class="card-header" style="background-color: #d9e5f9;">
                        <label><strong>Dados Pessoais</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-8 pr-2 pl-2">
                                <b>Nome</b>
                                <div class="col-sm-12"><input type="text" class="form-control" disabled="disabled" value="<?= $medico ?>" id="medico" /></div>
                            </div>
                            <div class="col-sm-4 pr-2 pl-2">
                                <b>CPF</b>
                                <div class="col-sm-12"><input type="text" class="form-control" disabled="disabled" value="<?= $cpf ?>" id="cpf" /></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6 pr-2 pl-2">
                                <b>Município de Origem</b>
                                <div class="col-sm-12"><input type="text" class="form-control" disabled="disabled" value="<?= $municipioO ?>-<?= $ufO ?>" id="medico" /></div>
                            </div>
                            <div class="col-sm-3 pr-2 pl-2">
                                <b>CNES</b>
                                <div class="col-sm-12"><input type="text" class="form-control" disabled="disabled" value="<?= $cnes ?>" id="cnes" /></div>
                            </div>
                            <div class="col-sm-3 pr-2 pl-2">
                                <b>INE</b>
                                <div class="col-sm-12"><input type="text" class="form-control" disabled="disabled" value="<?= $ine ?>" id="ine" /></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" enctype="multipart/form-data" action="controller/rcb.php">
        <div class="row">
            <div class="col-12 mt-4 pl-2 pr-2">
                <div class="card border-light">
                    <div class="card-header" style="background-color: #d9e5f9;">
                        <label><strong>Atividade de Longa Duração</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-12 pr-2 pl-2">
                                <b>Declaro que fui autorizado pela Agência para a realização de curso de longa duração</b>
                                <div class="col-sm-12">
                                    <input type="radio" name="rdativ" id="rdativ1" value="1"> SIM &nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="rdativ" id="rdativ2" value="1"> NÃO
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 divLongDuracao">
                            <div class="col-sm-5 pr-2 pl-2">
                                <b>Tipo de atividade</b>
                                <div class="col-sm-12">
                                    <select class="form-control" id="slLongaDuracao" name="slLongaDuracao">
                                        <option value="">[--SELECIONE--]</option>
                                        <?php
                                        $sqlativ = "select idativlongduracao as idl, descricao as descl from ativlongduracao";
                                        $qativ = mysqli_query($conn, $sqlativ) or die(mysqli_error($conn));
                                        $rsativ = mysqli_fetch_array($qativ);
                                        if($rsativ !== null){
                                            do{ 
                                                $idl = $rsativ['idl'];
                                                $descl = $rsativ['descl'];
                                                ?>
                                                <option value="<?= $idl ?>"><?= $descl ?></option>
                                        <?php    
                                            }while ($rsativ = mysqli_fetch_array($qativ));
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2 pr-2 pl-2">
                                <b>Carga Horária</b>
                                <div class="col-sm-12"><input type="number" class="form-control" value="" id="cargahrLongaDuracao" name="cargahrLongaDuracao" /></div>
                            </div>
                            <div class="col-sm-4 pr-2 pl-2">
                                <b>Anexar documento</b>
                                <div class="col-sm-12"><input type="file" class="form-control" value="" id="anexoLongaDuracao" name="anexoLongaDuracao" /></div>
                            </div>
                        </div>
                        <div class="row mb-2 divLongDuracao" id="divLongDuracao1"></div>
                        <div class="row mb-2 divLongDuracao">
                            <div class="col-sm-6 pr-2 pl-2">
                                <div class="col-sm-12"><button type="button" class="btn btn-primary" id="btnLongaDuracao"><i class="fas fa-plus-circle"></i> ADD OUTRA ATIVIDADE</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4 pl-2 pr-2">
                <div class="card border-light">
                    <div class="card-header" style="background-color: #d9e5f9;">
                        <label><strong>Qualificação Clínica</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2 divQualiClinica">
                            <div class="col-sm-8 pr-2 pl-2">
                                <b>Atividade</b>
                                <div class="col-sm-12">
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
                            <div class="col-sm-4 pr-2 pl-2">
                                <b>Carga Horária</b>
                                <div class="col-sm-12"><input type="number" class="form-control" value="" id="cargahrQualiClinica" name="cargahrQualiClinica" /></div>
                            </div>
                            <div class="col-sm-6 pr-2 pl-2">
                                <b>Título da atividade</b>
                                <div class="col-sm-12"><input type="text" class="form-control" value="" id="tituloQualiClinica" name="tituloQualiClinica" /></div>
                            </div>
                            <div class="col-sm-6 pr-2 pl-2">
                                <b>Anexar documento</b>
                                <div class="col-sm-12"><input type="file" class="form-control" value="" id="anexoQualiClinica" name="anexoQualiClinica" /></div>
                            </div>
                        </div>
                        <div class="row mb-2 divQualiClinica" id="divQualiClinica1"></div>
                        <div class="row mb-2">
                            <div class="col-sm-6 pr-2 pl-2">
                                <div class="col-sm-12"><button type="button" class="btn btn-primary" id="btnQualiClinica" ><i class="fas fa-plus-circle"></i> ADD OUTRA ATIVIDADE</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4 pl-2 pr-2">
                <div class="card border-light">
                    <div class="card-header" style="background-color: #d9e5f9;">
                        <label><strong>Gestão, Ensino, Pesquisa e Extensão</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2 divGesEnsPesExt">
                            <div class="col-sm-8 pr-2 pl-2">
                                <b>Atividade</b>
                                <div class="col-sm-12">
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
                            <div class="col-sm-4 pr-2 pl-2">
                                <b>Carga Horária</b>
                                <div class="col-sm-12"><input type="number" class="form-control" value="" id="cargahrGesEnsPesExt" name="cargahrGesEnsPesExt" /></div>
                            </div>
                            <div class="col-sm-6 pr-2 pl-2">
                                <b>Título da atividade</b>
                                <div class="col-sm-12"><input type="text" class="form-control" value="" id="tituloGesEnsPesExt" name="tituloGesEnsPesExt" /></div>
                            </div>
                            <div class="col-sm-6 pr-2 pl-2">
                                <b>Anexar documento</b>
                                <div class="col-sm-12"><input type="file" class="form-control" value="" id="anexoGesEnsPesExt" name="anexoGesEnsPesExt" /></div>
                            </div>
                        </div>
                        <div class="row mb-2 divGesEnsPesExt" id="divGesEnsPesExt1"></div>
                        <div class="row mb-2">
                            <div class="col-sm-6 pr-2 pl-2">
                                <div class="col-sm-12"><button type="button" class="btn btn-primary" id="btnGesEnsPesExt" ><i class="fas fa-plus-circle"></i> ADD OUTRA ATIVIDADE</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4 pl-2 pr-2">
                <div class="card border-light">
                    <div class="card-header" style="background-color: #d9e5f9;">
                        <label><strong>Inovação Tecnológica</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2 divInovTec">
                            <div class="col-sm-8 pr-2 pl-2">
                                <b>Atividade</b>
                                <div class="col-sm-12">
                                    <select class="form-control" id="slInovTec" name="slInovTec">
                                        <option value="">[--SELECIONE--]</option>
                                        <?php
                                        $sqlgesenspesext = "select idinovtecnologica as idi, descricao as desci from inovtecnologica";
                                        $qgesenspesext = mysqli_query($conn, $sqlgesenspesext) or die(mysqli_error($conn));
                                        $rsgesenspesext = mysqli_fetch_array($qgesenspesext);
                                        if($rsgesenspesext !== null){
                                            do{ 
                                                $idi = $rsgesenspesext['idi'];
                                                $desci = $rsgesenspesext['desci'];
                                                ?>
                                                <option value="<?= $idi ?>"><?= $desci ?></option>
                                        <?php    
                                            }while ($rsgesenspesext = mysqli_fetch_array($qgesenspesext));
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 pr-2 pl-2">
                                <b>Carga Horária</b>
                                <div class="col-sm-12"><input type="number" class="form-control" value="" id="cargahrInovTec" name="cargahrInovTec" /></div>
                            </div>
                            <div class="col-sm-6 pr-2 pl-2">
                                <b>Título da atividade</b>
                                <div class="col-sm-12"><input type="text" class="form-control" value="" id="tituloInovTec" name="tituloInovTec" /></div>
                            </div>
                            <div class="col-sm-6 pr-2 pl-2">
                                <b>Anexar documento</b>
                                <div class="col-sm-12"><input type="file" class="form-control" value="" id="anexoInovTec" name="anexoInovTec" /></div>
                            </div>
                        </div>
                        <div class="row mb-2 divInovTec" id="divInovTec1"></div>
                        <div class="row mb-2">
                            <div class="col-sm-6 pr-2 pl-2">
                                <div class="col-sm-12"><button type="button" class="btn btn-primary" id="btnInovTec" ><i class="fas fa-plus-circle"></i> ADD OUTRA ATIVIDADE</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 offset-sm-4 mt-4 pl-2 pr-2">
                <button type="button" data-bs-toggle="modal" data-bs-target="#enviarModal" class="btn btn-success p-2 form-control" >ENVIAR FORMULÁRIO</button>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="enviarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="exampleModalLabel">Confirmação de envio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <p class="text-primary">Confirma o envio do cadastro?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NÃO</button>
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
    <br><br>
    <?php include '../includes/footer.php' ?>
    <script src="../js_agsus/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="addcamps.js"></script>
    <script>
    $(document).ready(function (){
       $('.divLongDuracao').hide();
    });
    $('#rdativ1').click(function(){
        $('.divLongDuracao').show(400);
    });
    $('#rdativ2').click(function(){
        $('.divLongDuracao').hide(300);
    });
    $('#btnLongaDuracao').click(function(){
       let a = 0;
       a = document.querySelectorAll('.divLongDuracao').length;
       console.log(a);
       addAtvLongDuracao(a);
    });
    $('#btnQualiClinica').click(function(){
       let a = 0;
       a = document.querySelectorAll('.divQualiClinica').length;
//       console.log(a);
       addQualiClinica(a);
    });
    $('#btnGesEnsPesExt').click(function(){
       let a = 0;
       a = document.querySelectorAll('.divGesEnsPesExt').length;
//       console.log(a);
       addGesEnsPesExt(a);
    });
    $('#btnInovTec').click(function(){
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
    </script>
</body>

</html>