<?php
session_start();
include_once './../../../conexao-agsus.php';
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
if(!isset($_POST['itid']) || trim($_POST['itid']) === ''){
    echo "<script>alert('Inovação Tecnológica.')</script>";
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
$itid = $_POST['itid'];
$itch = floatval($_POST['ch']);
date_default_timezone_set('America/Sao_Paulo');
$dthoje = date('d/m/Y');
$iduser = $_SESSION["idUser"];
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

if(!isset($_POST['itflagparecer']) || trim($_POST['itflagparecer']) === ''){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Preencher campo Resultado da análise no item Inovação Tecnológica.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
    exit();
}

if($_POST['itflagparecer'] === '0' && trim($_POST['itparecer'])==='' || $_POST['itflagparecer'] === '0' && !isset($_POST['itparecer'])){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Preencher campo Análise no item Inovação Tecnológica.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
    exit();
}

$itparecer = '';
if(isset($_POST['itparecer'])){
    $itparecer = trim($_POST['itparecer']);
    $itparecer = str_replace("'", "", $itparecer);
    $itparecer = str_replace("\"", "", $itparecer);
}
$itflagparecer = $_POST['itflagparecer'];
date_default_timezone_set('America/Sao_Paulo');
$dthoje = date('Y-m-d H:i:s');
//var_dump($_POST);
$it = (new Source\Models\Medico_inovtecnologica())->findById($itid);
//var_dump($it);
if($it !== null){
    $idt = $it->idinovtecnologica ;
    $it->flagparecer = $itflagparecer;
    $it->parecer = $itparecer;
    $it->pareceruser = $user;
    $it->parecerdthr = $dthoje;
    if($itflagparecer === '1'){
        switch ($idt){
            case 1: $it->pontuacao = ($itch * 1.0); break; /* conforme manual */
            case 2: $it->pontuacao = ($itch * 1.0); break; /* conforme manual */
        }
    }else{
        $it->pontuacao = 0.00;
    }
//    var_dump($it);
    $rsit = $it->save();
//    var_dump($rsit);
    if($rsit !== null){
        $_SESSION['msg'] = "<h6 class='bg-success border rounded text-white p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Análise do item Inovação Tecnológica gravada.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
        exit();
    }else{
        $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Erro na atualização dos dados.</h6>";
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
