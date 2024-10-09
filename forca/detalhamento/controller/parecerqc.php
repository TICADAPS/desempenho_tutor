<?php
session_start();
include_once './../../../conexao-agsus.php';
include_once './../../../conexao_agsus_2.php';
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
if(!isset($_POST['qcid']) || trim($_POST['qcid']) === ''){
    echo "<script>alert('Qualificação Clínica não encontrada.')</script>";
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
$qcid = $_POST['qcid'];
$qcch = floatval($_POST['ch']);
date_default_timezone_set('America/Sao_Paulo');
$dthoje = date('d/m/Y');
//$iduser = $_SESSION["idUser"];
$iduser = '2765';
$sqlu = "select * from usuarios where id_user = '$iduser'";
$queryu = mysqli_query($conn2, $sqlu) or die(mysqli_error($conn2));
$rsu = mysqli_fetch_array($queryu);
$user = '';
if($rsu){
    do{
        $user = $rsu['nome_user'];
    }while($rsu = mysqli_fetch_array($queryu));
}
//var_dump($_POST);

if(!isset($_POST['qcflagparecer']) || trim($_POST['qcflagparecer']) === ''){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Preencher campo Resultado da análise no item Qualificação Clínica.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
    exit();
}

if($_POST['qcflagparecer'] === '0' && trim($_POST['qcparecer'])==='' || $_POST['qcflagparecer'] === '0' && !isset($_POST['qcparecer'])){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Preencher campo Análise no item Qualificação Clínica.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
    exit();
}

$qcparecer = '';
if(isset($_POST['qcparecer'])){
    $qcparecer = trim($_POST['qcparecer']);
    $qcparecer = str_replace("'", "", $qcparecer);
    $qcparecer = str_replace("\"", "", $qcparecer);
}
$qcflagparecer = $_POST['qcflagparecer'];
date_default_timezone_set('America/Sao_Paulo');
$dthoje = date('Y-m-d H:i:s');
//var_dump($_POST);
$qc = (new Source\Models\Medico_qualifclinica())->findById($qcid);
//var_dump($qc);
if($qc !== null){
    $idaperfprof = $qc->idaperfprof;
    $qc->flagparecer = $qcflagparecer;
    $qc->parecer = $qcparecer;
    $qc->pareceruser = $user;
    $qc->parecerdthr = $dthoje;
    if($qcflagparecer === '1'){
        $qc->pontuacao = ($qcch * 1); /* conforme manual */
    }else{
        $qc->pontuacao = 0.00;
    }
//    var_dump($qc);
    $rsqc = $qc->save();
//    var_dump($rsqc);
    if($rsqc !== null){
        $_SESSION['msg'] = "<h6 class='bg-success border rounded text-white p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Análise do item Qualificação Clínica gravada.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
        exit();
    }else{
        $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Erro na atualização dos dados.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
        exit();
    }
    //flagterminou null - no retorno ao médico indica que foi analisado mas ainda não foi habilitado para réplica
    //a habilitação (caso pontuação seja menor que 50) se dá após o envio do e-mail
    $ap = (new \Source\Models\Aperfeicoamentoprofissional())->findById($idaperfprof);
    if($ap !== null){
        $ap->flagterminou = null;
        $ap->save();
    }
}else{
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Cadastro de aperfeiçoamento profisional não encontrado.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
    exit();
}
