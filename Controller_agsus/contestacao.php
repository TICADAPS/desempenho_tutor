<?php
session_start();
include '../conexao-agsus.php';
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = null;
}
var_dump($_POST);

/*
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
if (!isset($_SESSION['q1'])) {
    $_SESSION['q1'] = "";
}
if(!isset($_POST['ckassunto1']) && !isset($_POST['ckassunto2']) && !isset($_POST['ckassunto3']) && !isset($_POST['ckassunto4']) && !isset($_POST['ckassunto5'])){
    $_SESSION['msg'] = "<h6 class='text-danger'>Selecione o título da contestação.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../demonstrativo/index.php\"'>";
    exit();
}
if(isset($_POST['ckassunto5']) && trim($_POST['assuntonovo']) === ''){
    $_SESSION['msg'] = "<h6 class='text-danger'>Digite o novo assunto.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../demonstrativo/index.php\"'>";
    exit();
}
$assuntoid = array();
if(isset($_POST['ckassunto1'])){
    $assuntoid[0] = $_POST['ckassunto1'];
}
if(isset($_POST['ckassunto2'])){
    if(count($assuntoid)===0){
        $assuntoid[0] = $_POST['ckassunto2'];
    }else{
        $assuntoid[1] = $_POST['ckassunto2'];
    }
}
if(isset($_POST['ckassunto3'])){
    if(count($assuntoid)===0){
        $assuntoid[0] = $_POST['ckassunto3'];
    }else{
        if(count($assuntoid)===1){
            $assuntoid[1] = $_POST['ckassunto3'];
        }else{
            $assuntoid[2] = $_POST['ckassunto3'];
        }
    }
}
if(isset($_POST['ckassunto4'])){
    if(count($assuntoid)===0){
        $assuntoid[0] = $_POST['ckassunto4'];
    }else{
        if(count($assuntoid)===1){
            $assuntoid[1] = $_POST['ckassunto4'];
        }else{
            if(count($assuntoid)===2){
                $assuntoid[2] = $_POST['ckassunto4'];
            }else{
                $assuntoid[3] = $_POST['ckassunto4'];
            }
        }
    }
}
if(isset($_POST['ckassunto5'])){
    if(count($assuntoid)===0){
        $assuntoid[0] = $_POST['ckassunto5'];
    }else{
        if(count($assuntoid)===1){
            $assuntoid[1] = $_POST['ckassunto5'];
        }else{
            if(count($assuntoid)===2){
                $assuntoid[2] = $_POST['ckassunto5'];
            }else{
                if(count($assuntoid)===3){
                    $assuntoid[4] = $_POST['ckassunto5'];
                }else{
                    $assuntoid[5] = $_POST['ckassunto5'];
                }
            }
        }
    }
}
//var_dump($assuntoid);
if(!isset($_POST['contestacao']) || trim($_POST['contestacao']) === ''){
    $_SESSION['msg'] = "<h6 class='text-danger'>Preencha o formulário de contestação.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../demonstrativo/index.php\"'>";
    exit();
}
date_default_timezone_set('America/Sao_Paulo');
$datahorainclusao = date('Y-m-d H:i:s');
$assunto = trim($_POST['assunto']);
$assuntonovo = '';
if(isset($_POST['ckassunto5'])){
    if(!isset($_POST['assuntonovo']) || trim($_POST['assuntonovo']) === ''){
        $_SESSION['msg'] = "<h6 class='text-danger'>Preencha o novo assunto da contestação.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                URL=\"../demonstrativo/index.php\"'>";
        exit();
    }
    $assuntonovo = trim($_POST['assuntonovo']);
    $assuntonovo = str_replace("'", "", $assuntonovo);
    $assuntonovo = str_replace("\"", "", $assuntonovo);
}
$contestacao = trim($_POST['contestacao']);
$contestacao = str_replace("'", "", $contestacao);
$contestacao = str_replace("\"", "", $contestacao);
$_SESSION['msg'] = "<h6 class='text-success'>Inserido com sucesso.</h6>";
$sql = "insert into contestacao values (null, '$contestacao','$datahorainclusao','0',null, null,'$cpf','$ibge','$cnes','$ine','$iddemonstrativo')";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
$sqlc = "select max(idcontestacao) as ultimoid from contestacao where datahora = '$datahorainclusao' and fkcpf = '$cpf'";
$queryc = mysqli_query($conn, $sqlc) or die(mysqli_error($conn));
$rsc = mysqli_fetch_array($queryc);
if($rsc){
    do{
        $idc = $rsc['ultimoid'];
    }while ($rsc = mysqli_fetch_array($queryc));
    foreach ($assuntoid as $a){
        if($a === '1'){
            $sqlca = "insert into contestacao_assunto values ('$idc','$a','$assuntonovo')";
            mysqli_query($conn, $sqlca) or die(mysqli_error($conn));
        }else{
            $sqlca = "insert into contestacao_assunto values ('$idc','$a',null)";
            mysqli_query($conn, $sqlca) or die(mysqli_error($conn));
        }
    }
}
$_SESSION['pgmsg'] = "2";
echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../demonstrativo/index.php\"'>";
exit();
 * 
 */