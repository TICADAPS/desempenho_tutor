<?php
session_start();
require __DIR__ . "/../../source/autoload.php";
include '../../conexao-agsus.php';
include '../../Controller_agsus/maskCpf.php';
include '../../Controller_agsus/fdatas.php';

if(!isset($_POST['btenv'])){
    echo "<script>alert('Área indisponível.')</script>";
    header('location: ../derruba_session.php');
    exit();
}
//var_dump($_POST);

if(!isset($_POST['ano']) || trim($_POST['ano']) === ''){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Selecione o ano.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"index.php\"'>"; 
    exit();
}
if(!isset($_POST['ciclo']) || trim($_POST['ciclo']) === ''){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Selecione o ciclo.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"index.php\"'>"; 
    exit();
}
if(!isset($_POST['descricao']) || trim($_POST['descricao']) === ''){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Preencha a descrição do ciclo.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"index.php\"'>"; 
    exit();
}
if(!isset($_POST['dtinicio']) || trim($_POST['dtinicio']) === '' ||  trim($_POST['dtinicio']) === '0000-00-00'){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Preencha a data de início do ciclo.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"index.php\"'>"; 
    exit();
}
if(!isset($_POST['dtfim']) || trim($_POST['dtfim']) === '' || trim($_POST['dtfim']) === '0000-00-00'){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Preencha a data de início do ciclo.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"index.php\"'>"; 
    exit();
}
$ano = $_POST['ano'];
$ciclo = $_POST['ciclo'];
$descricao = $_POST['descricao'];
$dtinicio = $_POST['dtinicio'];
$dtfim = $_POST['dtfim'];
//var_dump($ano,$ciclo,$descricao,$dtinicio,$dtfim);

//verificando se o ciclo já existe
$anociclo = (new Source\Models\Anocicloavaliacao())->findAnoCiclo($ano, $ciclo);
if($anociclo !== null){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Ciclo cadastrado anteriormente.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"index.php\"'>"; 
    exit();
}else{
    $newac = new Source\Models\Anocicloavaliacao();
    $newac->bootstrap($ano, $ciclo, $descricao, $dtinicio, $dtfim, '0');
    $rs = $newac->save();
    if($rs === null){
        $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Erro no gravação dos dados.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"index.php\"'>"; 
        exit();
    }else{
        $_SESSION['msg'] = "<h6 class='bg-light border rounded text-success p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Cadastrado com sucesso.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"index.php\"'>"; 
        exit();
    }
}
