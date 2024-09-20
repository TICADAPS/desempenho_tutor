<?php
session_start();
include_once './../../conexao-agsus.php';
if(!isset($_SESSION['perfil'])){
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../derruba_session.php\"'>";
    exit();
}
if(!isset($_SESSION['nivel'])){
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../derruba_session.php\"'>";
    exit();
}
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
var_dump($_POST);
/*
$_SESSION['msg'] = "";
if(isset($_POST['btsalvar'])){
    $ano = $_POST['ano'];
    $ciclo = $_POST['ciclo'];
    $dtlimite = $_POST['dtlimite'];
    $sqla = "select * from anoacicloavaliacao where ano = '$ano' and ciclo = '$ciclo' limit 1"; 
    $qa = mysqli_query($conn, $sqla) or die(mysqli_error($conn));
    $rsa = mysqli_fetch_array($qa);
    if($rsa){
        do{
            $id = $rsa['id'];
        }while ($rsa = mysqli_fetch_array($qa));
        $sqaup = "update anoacicloavaliacao set dtlimitecontestacao = '$dtlimite', flagdtlimitecontestacao = '1' where id = '$id'";
        $qaup = mysqli_query($conn, $sqaup) or die(mysqli_error($conn));
        if($qaup === true){
            $_SESSION['msg'] = "<h6 class='bg-success border rounded text-white p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Data limite de contestação salva e ativada com sucesso.</h6>";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                URL=\"../limiteContestacao/\"'>"; 
            exit();
        }else{
            $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Erro na gravação da data limite.</h6>";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                URL=\"../limiteContestacao/\"'>"; 
            exit();
        }
    }else{
        $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Ano e período inexistente na base de dados.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../limiteContestacao/\"'>"; 
        exit();
    }
}elseif(isset($_POST['btparar'])){
    $id = $_POST['idcontest'];
    $sqla = "select * from anoacicloavaliacao where id = '$id'"; 
    $qa = mysqli_query($conn, $sqla) or die(mysqli_error($conn));
    $rsa = mysqli_fetch_array($qa);
    if($rsa){
//        var_dump($rsa);
        $sqaup = "update anoacicloavaliacao set flagdtlimitecontestacao = '0' where id = '$id'";
        $qaup = mysqli_query($conn, $sqaup) or die(mysqli_error($conn));
        if($qaup === true){
            $_SESSION['msg'] = "<h6 class='bg-success border rounded text-white p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Contestação inativada com sucesso.</h6>";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                URL=\"../limiteContestacao/\"'>"; 
            exit();
        }else{
            $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Erro na gravação inativação da contestação.</h6>";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                URL=\"../limiteContestacao/\"'>"; 
            exit();
        }
    }else{
        $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Ano e período inexistente na base de dados.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../limiteContestacao/\"'>"; 
        exit();
    }
}else{
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Clique no botão para salvar ou para parar a contestação.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../limiteContestacao/\"'>"; 
    exit();
}


*/