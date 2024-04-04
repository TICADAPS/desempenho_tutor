<?php
session_start();
include '../conexao-agsus.php';
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = null;
}
//var_dump($_POST);

if($_POST['enviarContestacao'] !== '1'){
    $_SESSION['pgmsg'] = "2";
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
    $_SESSION['pgmsg'] = "2";
    $_SESSION['msg'] = "<h6 class='text-danger'>Selecione o título da contestação.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../demonstrativo/index.php\"'>";
    exit();
}
if(isset($_POST['ckassunto1'])){
    if(!isset($_POST['contestacao1']) || trim($_POST['contestacao1']) === ""){
        $_SESSION['pgmsg'] = "2";
        $_SESSION['msg'] = "<h6 class='text-danger'>Preencha o campo referente à sua contestação.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                URL=\"../demonstrativo/index.php\"'>";
        exit();
    }
}
if(isset($_POST['ckassunto2'])){
    if(!isset($_POST['contestacao2']) || trim($_POST['contestacao2']) === ""){
        $_SESSION['pgmsg'] = "2";
        $_SESSION['msg'] = "<h6 class='text-danger'>Preencha o campo referente à sua contestação.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                URL=\"../demonstrativo/index.php\"'>";
        exit();
    }
}
if(isset($_POST['ckassunto3'])){
    if(!isset($_POST['contestacao3']) || trim($_POST['contestacao3']) === ""){
        $_SESSION['pgmsg'] = "2";
        $_SESSION['msg'] = "<h6 class='text-danger'>Preencha o campo referente à sua contestação.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                URL=\"../demonstrativo/index.php\"'>";
        exit();
    }
}
if(isset($_POST['ckassunto4'])){
    if(!isset($_POST['contestacao4']) || trim($_POST['contestacao4']) === ""){
        $_SESSION['pgmsg'] = "2";
        $_SESSION['msg'] = "<h6 class='text-danger'>Preencha o campo referente à sua contestação.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                URL=\"../demonstrativo/index.php\"'>";
        exit();
    }
}
if(isset($_POST['ckassunto5'])){
    if(trim($_POST['assuntonovo']) === ''){
        $_SESSION['pgmsg'] = "2";
        $_SESSION['msg'] = "<h6 class='text-danger'>Digite o novo assunto.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                URL=\"../demonstrativo/index.php\"'>";
        exit();
    }
    if(!isset($_POST['contestacao5']) || trim($_POST['contestacao5']) === ""){
        $_SESSION['pgmsg'] = "2";
        $_SESSION['msg'] = "<h6 class='text-danger'>Preencha o campo referente à sua contestação.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                URL=\"../demonstrativo/index.php\"'>";
        exit();
    }
}
$assuntoid = array();
$contestacao = array();
if(isset($_POST['ckassunto1'])){
    $assuntoid[0] = $_POST['ckassunto1'];
    $contes = trim($_POST['contestacao1']);
    $contes = str_replace("'", "", $contes);
    $contes = str_replace("\"", "", $contes);
    $contestacao[0] = $contes;
}
if(isset($_POST['ckassunto2'])){
    if(count($assuntoid)===0){
        $assuntoid[0] = $_POST['ckassunto2'];
        $contes = trim($_POST['contestacao2']);
        $contes = str_replace("'", "", $contes);
        $contes = str_replace("\"", "", $contes);
        $contestacao[0] = $contes;
    }else{
        $assuntoid[1] = $_POST['ckassunto2'];
        $contes = trim($_POST['contestacao2']);
        $contes = str_replace("'", "", $contes);
        $contes = str_replace("\"", "", $contes);
        $contestacao[1] = $contes;
    }
}
if(isset($_POST['ckassunto3'])){
    if(count($assuntoid)===0){
        $assuntoid[0] = $_POST['ckassunto3'];
        $contes = trim($_POST['contestacao3']);
        $contes = str_replace("'", "", $contes);
        $contes = str_replace("\"", "", $contes);
        $contestacao[0] = $contes;
    }else{
        if(count($assuntoid)===1){
            $assuntoid[1] = $_POST['ckassunto3'];
            $contes = trim($_POST['contestacao3']);
            $contes = str_replace("'", "", $contes);
            $contes = str_replace("\"", "", $contes);
            $contestacao[1] = $contes;
        }else{
            $assuntoid[2] = $_POST['ckassunto3'];
            $contes = trim($_POST['contestacao3']);
            $contes = str_replace("'", "", $contes);
            $contes = str_replace("\"", "", $contes);
            $contestacao[2] = $contes;
        }
    }
}
if(isset($_POST['ckassunto4'])){
    if(count($assuntoid)===0){
        $assuntoid[0] = $_POST['ckassunto4'];
        $contes = trim($_POST['contestacao4']);
        $contes = str_replace("'", "", $contes);
        $contes = str_replace("\"", "", $contes);
        $contestacao[0] = $contes;
    }else{
        if(count($assuntoid)===1){
            $assuntoid[1] = $_POST['ckassunto4'];
            $$contes = trim($_POST['contestacao4']);
            $contes = str_replace("'", "", $contes);
            $contes = str_replace("\"", "", $contes);
            $contestacao[1] = $contes;
        }else{
            if(count($assuntoid)===2){
                $assuntoid[2] = $_POST['ckassunto4'];
                $contes = trim($_POST['contestacao4']);
                $contes = str_replace("'", "", $contes);
                $contes = str_replace("\"", "", $contes);
                $contestacao[2] = $contes;
            }else{
                $assuntoid[3] = $_POST['ckassunto4'];
                $contes = trim($_POST['contestacao4']);
                $contes = str_replace("'", "", $contes);
                $contes = str_replace("\"", "", $contes);
                $contestacao[3] = $contes;
            }
        }
    }
}
$assuntonovo = '';
if(isset($_POST['ckassunto5'])){
    if(count($assuntoid)===0){
        $assuntoid[0] = $_POST['ckassunto5'];
        $contes = trim($_POST['contestacao5']);
        $contes = str_replace("'", "", $contes);
        $contes = str_replace("\"", "", $contes);
        $contestacao[0] = $contes;
        $assuntonovo = trim($_POST['assuntonovo']);
        $assuntonovo = str_replace("'", "", $assuntonovo);
        $assuntonovo = str_replace("\"", "", $assuntonovo);
    }else{
        if(count($assuntoid)===1){
            $assuntoid[1] = $_POST['ckassunto5'];
            $contes = trim($_POST['contestacao5']);
            $contes = str_replace("'", "", $contes);
            $contes = str_replace("\"", "", $contes);
            $contestacao[1] = $contes;
            $assuntonovo = trim($_POST['assuntonovo']);
            $assuntonovo = str_replace("'", "", $assuntonovo);
            $assuntonovo = str_replace("\"", "", $assuntonovo);
        }else{
            if(count($assuntoid)===2){
                $assuntoid[2] = $_POST['ckassunto5'];
                $contes = trim($_POST['contestacao5']);
                $contes = str_replace("'", "", $contes);
                $contes = str_replace("\"", "", $contes);
                $contestacao[2] = $contes;
                $assuntonovo = trim($_POST['assuntonovo']);
                $assuntonovo = str_replace("'", "", $assuntonovo);
                $assuntonovo = str_replace("\"", "", $assuntonovo);
            }else{
                if(count($assuntoid)===3){
                    $assuntoid[3] = $_POST['ckassunto5'];
                    $contes = trim($_POST['contestacao5']);
                    $contes = str_replace("'", "", $contes);
                    $contes = str_replace("\"", "", $contes);
                    $contestacao[3] = $contes;
                    $assuntonovo = trim($_POST['assuntonovo']);
                    $assuntonovo = str_replace("'", "", $assuntonovo);
                    $assuntonovo = str_replace("\"", "", $assuntonovo);
                }else{
                    $assuntoid[4] = $_POST['ckassunto5'];
                    $contes = trim($_POST['contestacao5']);
                    $contes = str_replace("'", "", $contes);
                    $contes = str_replace("\"", "", $contes);
                    $contestacao[4] = $contes;
                    $assuntonovo = trim($_POST['assuntonovo']);
                    $assuntonovo = str_replace("'", "", $assuntonovo);
                    $assuntonovo = str_replace("\"", "", $assuntonovo);
                }
            }
        }
    }
}
//var_dump($assuntoid);
date_default_timezone_set('America/Sao_Paulo');
$datahorainclusao = date('Y-m-d H:i:s');
$_SESSION['msg'] = "<h6 class='text-success'>Inserido com sucesso.</h6>";
$sql = "insert into contestacao values (null,'$datahorainclusao','0',null, null,'$cpf','$ibge','$cnes','$ine','$iddemonstrativo')";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
$sqlc = "select max(idcontestacao) as ultimoid from contestacao where datahora = '$datahorainclusao' and fkcpf = '$cpf'";
$queryc = mysqli_query($conn, $sqlc) or die(mysqli_error($conn));
$rsc = mysqli_fetch_array($queryc);
if($rsc){
    do{
        $idc = $rsc['ultimoid'];
    }while ($rsc = mysqli_fetch_array($queryc));
    for($x=0; $x < count($assuntoid); $x++){
        if($assuntoid[$x] === '1'){
            $a = $assuntoid[$x];
            $c = $contestacao[$x];
            $sqlca = "insert into contestacao_assunto values ('$idc','$a','$assuntonovo','$c')";
            mysqli_query($conn, $sqlca) or die(mysqli_error($conn));
        }else{
            $a = $assuntoid[$x];
            $c = $contestacao[$x];
            $sqlca = "insert into contestacao_assunto values ('$idc','$a',null,'$c')";
            mysqli_query($conn, $sqlca) or die(mysqli_error($conn));
        }
    }
    echo "<h6 class='text-success'><i class='fas fa-arrow-circle-right'></i> &nbsp;Contestação(ões) enviada(s) com sucesso.</h6>";
}
$_SESSION['pgmsg'] = "2";
echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../demonstrativo/index.php\"'>";
exit();
 