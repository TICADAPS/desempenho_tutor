<?php
session_start();
include_once './../../../conexao-agsus.php';
include_once './../../../conexao_agsus_2.php';
include_once './../../../mask.php';
include_once __DIR__ .'/../../../vendor/autoload.php';
if(!isset($_SESSION['msg'])){
    $_SESSION['msg'] = '';
}
if(!isset($_POST['cpf']) || trim($_POST['cpf']) === ''){
    echo "<script>alert('CPF não encontrado.')</script>";
    header('location: ../../derruba_session.php');
    exit();
}
if(!isset($_POST['ibge']) || trim($_POST['ibge']) === ''){
    echo "<script>alert('Município não encontrado.')</script>";
    header('location: ../../derruba_session.php');
    exit();
}
if(!isset($_POST['cnes']) || trim($_POST['cnes']) === ''){
    echo "<script>alert('CNES não encontrados.')</script>";
    header('location: ../../derruba_session.php');
    exit();
}
if(!isset($_POST['ine']) || trim($_POST['ine']) === ''){
    echo "<script>alert('INE não encontrado.')</script>";
    header('location: ../../derruba_session.php');
    exit();
}
$cpf = $_POST['cpf'];
$ibge = $_POST['ibge'];
$cnes = $_POST['cnes'];
$ine = $_POST['ine'];
$idap = $_POST['idap'];
$ano = $_POST['ano'];
$ciclo = $_POST['ciclo'];
$iduser = $_SESSION["idUser"];
$sqlu = "select * from usuarios where id_user = '$iduser'";
$qu = mysqli_query($conn2, $sqlu) or die(mysqli_error($conn2));
$ru = mysqli_fetch_array($qu);
$user = "";
if($ru){
    do{
        $user = $ru['nome_user'];
    }while($ru = mysqli_fetch_array($qu));
}
//var_dump($_POST);
$cpfmask = mask($cpf, "###.###.###-##");
$sqlm = "select NomeMedico, email from medico where CpfMedico = '$cpfmask' and flagInativo <> 1 limit 1";
$qm = mysqli_query($conn2, $sqlm) or die(mysqli_errno($conn2));
$rsm = mysqli_fetch_array($qm);
if($rsm){
    do{
        $nome = $rsm['NomeMedico'];
        $email = $rsm['email'];
    }while ($rsm = mysqli_fetch_array($qm));
    date_default_timezone_set('America/Sao_Paulo');
    $dthoje = date('Y-m-d H:i:s');
    //var_dump($_POST);
    $ap = (new Source\Models\Aperfeicoamentoprofissional())->findById($idap);
    //var_dump($qc);
    if($ap !== null){
        //E-Mail disparado automático pelo app.
        $assunto = "Assunto do E-Mail";
        $mensagemEmail = "*** ATENÇÃO: Este é um e-mail automático enviado pelo sistema. Informamos que esta caixa de e-mail não é monitorada, portanto, por favor, não responda a esta mensagem."
                . "<br><br>";
        $mensagemEmail .= "Prezado(a) Tutor(a) Médico(a) $nome, <br><br>";
        $mensagemEmail .= 'Comunicamos que <b>VOCÊ ALCANÇOU A META DE 50 CRÉDITOS</b> referente ao domínio de Comprovantes de Aperfeiçoamento, conforme exigido para o "Ciclo do Programa de Avaliação de Desempenho do Médico Tutor". <br><br>';
        $mensagemEmail .= "-- <br>";
        $mensagemEmail .= "Atenciosamente, <br><br>";
        $mensagemEmail .= "Agência Brasileira de Apoio à Gestão do Sistema Único de Saúde - AgSUS.<br><br>";
        $mensagemEmail .= "Link de acesso: https://agsusbrasil.org/sistema-integrado/login.php";
        $email = (new \Source\Support\Email())->bootstrap(
                "$assunto",
                "$mensagemEmail",
                "$email",
                "$nome",
                "",
                "");
        $email->attach("../../../img/Logo_agsus.jpg", "AgSUS");
        if ($email->send()) {
            $ap->flagemail = '1';
            $ap->flagup = '0'; // nega a atualização e finaliza o processo.
            $ap->dthremail = $dthoje;
            $ap->usuario = $user;
            //Mudando a flagup para que o médico possa preencher e enviar a atualização das atividades
            $ap->flagparecer = '1';
            $ap->flagterminou = '1';
            $ap->save();
            $qc = (new Source\Models\Medico_qualifclinica())->findJQCUp($idap);
            //        var_dump($qc);
            if ($qc !== null) {
                foreach ($qc as $q) {
                    $idqc = $q->id;
                    $qcUp = (new Source\Models\Medico_qualifclinica())->findById($idqc);
                    if ($qcUp !== null) {
                        $qcUp->flagup = '0';
                        $rsqcUp = $qcUp->save();
                    }
                }
            }
            $gepe = (new Source\Models\Medico_gesenspesext)->findJGepeUp($idap);
            if ($gepe !== null) {
                foreach ($gepe as $g) {
                    $idgepe = $g->id;
                    $gepeUp = (new Source\Models\Medico_gesenspesext())->findById($idgepe);
                    if ($gepeUp !== null) {
                        $gepeUp->flagup = '0';
                        $gepeUp->save();
                    }
                }
            }
            $it = (new Source\Models\Medico_inovtecnologica())->findJItUp($idap);
            if ($it !== null) {
                foreach ($it as $i) {
                    $idit = $i->id;
                    $itUp = (new Source\Models\Medico_inovtecnologica())->findById($idit);
                    if ($itUp !== null) {
                        $itUp->flagup = '0';
                        $itUp->save();
                    }
                }
            }
            $_SESSION['msg'] = "<h6 class='bg-light rounded text-success p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; E-Mail enviado com sucesso.</h6>";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                    URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>";
            exit();
        } else {
            $_SESSION['msg'] = "<h6 class='text-danger'><i class='fas fa-arrow-circle-right'></i> &nbsp;Erro no envio do E-Mail.</h6>";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                    URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>";
            exit();
        }
    }else{
        $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Cadastro de aperfeiçoamento profisional não encontrado.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
        exit();
    }
}else{
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; O médico está inativo no sistema, provavelmente foi demitido.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
    exit();
}

