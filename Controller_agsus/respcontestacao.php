<?php
session_start();
include '../conexao-agsus.php';
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = '';
}
//var_dump($_POST);
if($_POST['enviarResposta'] !== '1'){
    $_SESSION['msg'] = "<h6 class='text-danger'>Preencha a resposta da contestação.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../forca/index.php\"'>";
    exit();
}
if(!isset($_POST['idcontestacao']) || trim($_POST['idcontestacao']) === ''){
    $_SESSION['msg'] = "<h6 class='text-danger'>Preencha a resposta da contestação.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../forca/index.php\"'>";
    exit();
}
if(!isset($_POST['respcontestacao']) || trim($_POST['respcontestacao']) === ''){
    $_SESSION['msg'] = "<h6 class='text-danger'>Preencha a resposta da contestação.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../forca/index.php\"'>";
    exit();
}
$idcontestacao = $_POST['idcontestacao'];
$iddemonstrativo = $_POST['iddemonstrativo'];
$respcontestacao = trim($_POST['respcontestacao']);
$respcontestacao = str_replace("'", "", $respcontestacao);
date_default_timezone_set('America/Sao_Paulo');
$datahorainclusao = date('Y-m-d H:i:s');
$contestacao = trim($_POST['contestacao']);
$_SESSION['msg'] = "<h6 class='text-success'>Inserido com sucesso.</h6>";
$sql = "update contestacao set resposta = '$respcontestacao', dataresposta = '$datahorainclusao', flagresposta = 1 where idcontestacao = '$idcontestacao'";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../forca/index.php\"'>";
exit();