<?php
session_start();
include '../conexao-agsus.php';
include '../conexao_agsus_2.php';
include_once '../vendor/autoload.php';
include './fdatas.php';
include './maskCpf.php';

if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = '';
}
if (!isset($_SESSION['perfil'])) {
    header("Location: ../../derruba_session.php");
    exit();
}
if (!isset($_SESSION['nivel'])) {
    header("Location: ../../derruba_session.php");
    exit();
}
if($_SESSION['perfil'] !== '3'){
    header("Location: ../../derruba_session.php");
    exit();
}
//var_dump($_POST);
if($_POST['enviarResposta'] !== '1'){
    $_SESSION['pgmsg'] = "2";
    $_SESSION['msg'] = "<h6 class='text-danger'>Preencha a resposta da contestação.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../forca/index.php\"'>";
    exit();
}
if(!isset($_POST['idcontestacao']) || trim($_POST['idcontestacao']) === ''){
    $_SESSION['pgmsg'] = "2";
    $_SESSION['msg'] = "<h6 class='text-danger'>Preencha a resposta da contestação.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../forca/index.php\"'>";
    exit();
}
if(!isset($_POST['respcontestacao']) || trim($_POST['respcontestacao']) === ''){
    $_SESSION['pgmsg'] = "2";
    $_SESSION['msg'] = "<h6 class='text-danger'>Preencha a resposta da contestação.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../forca/index.php\"'>";
    exit();
}
$idcontestacao = $_POST['idcontestacao'];
$iddemonstrativo = $_POST['iddemonstrativo'];
$respcontestacao = trim($_POST['respcontestacao']);
$respcontestacao = str_replace("'", "", $respcontestacao);
$respcontestacao = str_replace("\"", "", $respcontestacao);
date_default_timezone_set('America/Sao_Paulo');
$datahorainclusao = date('Y-m-d H:i:s');
$_SESSION['msg'] = "<h6 class='text-success'>Inserido com sucesso.</h6>";
$sql = "update contestacao set resposta = '$respcontestacao', dataresposta = '$datahorainclusao', flagresposta = 1 where idcontestacao = '$idcontestacao'";
$env = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//var_dump($env);
if($env === true){
    $sqldem = "select * from demonstrativo where iddemonstrativo = '$iddemonstrativo'";
    $querydem = mysqli_query($conn, $sqldem);
    $rsdem = mysqli_fetch_array($querydem);
    $emailTutor = $nomeTutor = $flaginativo = "";
    if($rsdem){
        do{
            $fkcpf = $rsdem['fkcpf'];
            $fkibge = $rsdem['fkibge'];
            $fkcnes = $rsdem['fkcnes'];
            $fkine = $rsdem['fkine'];
            $ano = $rsdem['ano'];
            $ciclo = $rsdem['ciclo'];
            $fkcpfmask = mask($fkcpf, "###.###.###-##");
            $sqlmed = "select NomeMedico, email, flagInativo from medico where CpfMedico = '$fkcpfmask' and flaginativo <> 1 order by idMedico desc limit 1";
            $querymed = mysqli_query($conn2, $sqlmed);
            $rsmed = mysqli_fetch_array($querymed);
            if($rsmed){
                do{
                    $nomeTutor = $rsmed['NomeMedico'];
                    $emailTutor = $rsmed['email'];
                    $flaginativo = $rsmed['flagInativo'];
                }while ($rsmed = mysqli_fetch_array($querymed));
            }
        }while ($rsdem = mysqli_fetch_array($querydem));
    }
    if($flaginativo !== ''){
        $email = new Source\Support\Email();
        date_default_timezone_set('America/Sao_Paulo');
        $dthrhoje = date('Y-m-d H:i:s');
        $assunto = "Resposta sobre a(s) contestação(ões) apresentada(s) pelo Médico Tutor $nomeTutor";
        $mensagemEmail = "*** ATENÇÃO: o remetente deste e-mail é noreply, usado para disparos automáticos de mensagens. "
                . "Para outras informações e esclarecimentos favor encaminhar sua manifestação para o e-mail soumedico@agenciasus.org.br.<br><br>";
        $mensagemEmail .= "Prezado(a) Colaborador(a) $nomeTutor, <br><br>";
        $mensagemEmail .= "Em resposta à(s) sua(s) contestação(ões), ".$respcontestacao."<br><br>";
        $mensagemEmail .= "Estamos disponíveis para fornecer esclarecimentos adicionais, e queremos expressar nossa gratidão pela "
                . "sua participação no ".$ciclo."º Ciclo do Programa de Avaliação e Desempenho Tutor Médico - ano $ano.<br><br>";
        $mensagemEmail .= "Atenciosamente,<br><br>";
        $mensagemEmail .= "Agência Brasileira de Apoio à Gestão do SUS – AgSUS";
        $email = (new \Source\Support\Email())->bootstrap(
                "$assunto",
                "$mensagemEmail",
                "$emailTutor",
                "$nomeTutor",
                "",
                "");
        $email->attach("../img_agsus/Logo_400x200.png", "AgSUS");
        if ($email->send()) {
            echo "<h6 class='text-success'><i class='fas fa-arrow-circle-right'></i> &nbsp;E-Mail enviado com sucesso.</h6>";
            $_SESSION['msg'] = "<h6 class='text-success'><i class='fas fa-arrow-circle-right'></i> &nbsp;E-Mail enviado com sucesso.</h6>";
        } else {
            $_SESSION['msg'] = "<h6 class='text-danger'><i class='fas fa-arrow-circle-right'></i> &nbsp;Erro no envio do E-Mail.</h6>";
        }
    }else{
        $_SESSION['msg'] = "<h6 class='text-danger'><i class='fas fa-arrow-circle-right'></i> &nbsp;O Tutor está inativo no sistema. O E-Mail NÃO foi enviado.</h6>";
    }
    
}else{
     $_SESSION['msg'] = "<h6 class='text-danger'><i class='fas fa-arrow-circle-right'></i> &nbsp;Falha na gravação da resposta da contestação.</h6>";
}
$_SESSION['pgmsg'] = "2";
echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../forca/index.php\"'>";
exit();