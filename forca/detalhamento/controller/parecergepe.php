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
if(!isset($_POST['gepeid']) || trim($_POST['gepeid']) === ''){
    echo "<script>alert('Gestão, Ensino, Pesquisa e Extensão não encontrada.')</script>";
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
$gepeid = $_POST['gepeid'];
$gepech = floatval($_POST['ch']);
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

if(!isset($_POST['gepeflagparecer']) || trim($_POST['gepeflagparecer']) === ''){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Preencher campo Resultado da análise no item Gestão, Ensino, Pesquisa e Extensão.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
    exit();
}

if($_POST['gepeflagparecer'] === '0' && trim($_POST['gepeparecer'])==='' || $_POST['gepeflagparecer'] === '0' && !isset($_POST['gepeparecer'])){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Preencher campo Análise no item Gestão, Ensino, Pesquisa e Extensão.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
    exit();
}

$gepeparecer = '';
if(isset($_POST['gepeparecer'])){
    $gepeparecer = trim($_POST['gepeparecer']);
    $gepeparecer = str_replace("'", "", $gepeparecer);
    $gepeparecer = str_replace("\"", "", $gepeparecer);
}
$gepeflagparecer = $_POST['gepeflagparecer'];
date_default_timezone_set('America/Sao_Paulo');
$dthoje = date('Y-m-d H:i:s');
//var_dump($_POST);
$gepe = (new Source\Models\Medico_gesenspesext())->findById($gepeid);
//var_dump($gepe);
if($gepe !== null){
    $idaperfprof = $gepe->idaperfprof;
    $idg = (int)$gepe->idgesenspesext;
    $gepe->flagparecer = $gepeflagparecer;
    $gepe->parecer = $gepeparecer;
    $gepe->pareceruser = $user;
    $gepe->parecerdthr = $dthoje;
    if($gepeflagparecer === '1'){
//        var_dump($idg);
        switch ($idg){
            case 1: $gepe->pontuacao = ($gepech * 1.0); break; /* conforme manual */
            case 2: $gepe->pontuacao = ($gepech * 1.0); break; /* conforme manual */
            case 3: $gepe->pontuacao = ($gepech * 15.0); break; /* conforme manual */
            case 4: $gepe->pontuacao = ($gepech * 5.0); break; /* conforme manual */
            case 5: $gepe->pontuacao = ($gepech * 15.0); break; /* conforme manual */
            case 6: $gepe->pontuacao = ($gepech * 10.0); break; /* conforme manual */
            case 7: $gepe->pontuacao = ($gepech * 5.0); break; /* conforme manual */
            case 8: $gepe->pontuacao = ($gepech * 3.0); break; /* conforme manual */
            case 9: $gepe->pontuacao = ($gepech * 5.0); break; /* conforme manual */
            case 10: $gepe->pontuacao = ($gepech * 1.0); break; /* conforme manual */
        }
        
    }else{
        $gepe->pontuacao = 0.00;
    }
//    var_dump($gepe);
    $rsgepe = $gepe->save();
//    var_dump($rsgepe);
    if($rsgepe !== null){
        $_SESSION['msg'] = "<h6 class='bg-light rounded text-success p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Análise do item Gestão, Ensino, Pesquisa e Extensão gravada.</h6>";
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
