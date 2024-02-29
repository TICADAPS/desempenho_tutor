<?php
session_start();
include '../conexao-agsus.php';
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = null;
}
//var_dump($_POST);
if($_POST['enviarContestacao'] !== '1'){
    $_SESSION['msg'] = "<h6 class='text-danger'>Preencha o formulário de contestação.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../demonstrativo/index.php\"'>";
    exit();
}
$iddemonstrativo = $_POST['iddemonstrativo'];
$cpf = $_POST['cpf'];
$ibge = $_POST['ibge'];
$cnes = $_POST['cnes'];
$ine = $_POST['ine'];
if(!isset($_POST['contestacao']) || trim($_POST['contestacao']) === ''){
    $_SESSION['msg'] = "<h6 class='text-danger'>Preencha o formulário de contestação.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../demonstrativo/index.php\"'>";
    exit();
}
date_default_timezone_set('America/Sao_Paulo');
$datahorainclusao = date('Y-m-d H:i:s');
$contestacao = trim($_POST['contestacao']);
$contestacao = str_replace("'", "", $contestacao);
$_SESSION['msg'] = "<h6 class='text-success'>Inserido com sucesso.</h6>";
$sql = "insert into contestacao values (null, '$contestacao','$datahorainclusao','0',null, null,'$cpf','$ibge','$cnes','$ine','$iddemonstrativo')";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../demonstrativo/index.php\"'>";
exit();