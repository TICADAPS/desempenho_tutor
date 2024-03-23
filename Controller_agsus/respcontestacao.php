<?php
session_start();
include '../conexao-agsus.php';
include_once '../vendor/autoload.php';
include './fdatas.php';

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
$respcontestacao = str_replace("\"", "", $respcontestacao);
date_default_timezone_set('America/Sao_Paulo');
$datahorainclusao = date('Y-m-d H:i:s');
$_SESSION['msg'] = "<h6 class='text-success'>Inserido com sucesso.</h6>";
$sql = "update contestacao set resposta = '$respcontestacao', dataresposta = '$datahorainclusao', flagresposta = 1 where idcontestacao = '$idcontestacao'";
$env = mysqli_query($conn, $sql) or die(mysqli_error($conn));
//var_dump($env);
if($env === true){
    $email = new \Source\Support\Email();
    /*
    $assunto = "Considerações sobre a confirmação de presença do(a) bolsista $nomeMedico na tutoria";
    $mensagemEmail = "*** ATENÇÃO: o remetente deste e-mail é noreply, usado para disparos automáticos de mensagens. "
            . "Para tirar dúvidas e receber mais informações, envie uma mensagem para "
            . "Unidade de Logísica, E-Mail: logistica@agenciasus.org.br.<br><br>";
    $mensagemEmail .= "Prezado Tutor, Dr(a) $nomeTutor, <br><br>";
    $mensagemEmail .= "Segue(m) a(s) consideração(ões) referente(s) à confirmação da presença do(a) bolsista $nomeMedico na tutoria clínica, no período de $perInSaida a $perOutSaida:<br>";
    $mensagemEmail .= "Unidade de Logística: $consid<br>";
    $mensagemEmail .= "Estamos à disposição para quaisquer esclarecimentos. <br><br>";
    $mensagemEmail .= "-- <br>";
    $mensagemEmail .= "Atenciosamente, <br><br>";
    $mensagemEmail .= "Unidade de Logísica - logistica@agenciasus.org.br (E-Mail para mais informações).";
    //                                          var_dump($creditoMedico,$debito,$nomeBolsista,$emailBolsista,$valordebtxt);
    $email = (new \Source\Support\Email())->bootstrap(
            "$assunto",
            "$mensagemEmail",
            "$emailTutor",
            "$nomeTutor",
            "",
            "");
    $email->attach("../img/Logo_adaps.png", "Logo_adaps");
    if ($email->send()) {
        $ctutor->flagemailt = '1';
        $ctutor->dthremailt = $dthrhoje;
        $ctutor->save();
        $_SESSION['msg'] = "<h6 class='text-success'><i class='fas fa-arrow-circle-right'></i> &nbsp;E-Mail enviado com sucesso.</h6>";
    } else {
        $_SESSION['msg'] = "<h6 class='text-danger'><i class='fas fa-arrow-circle-right'></i> &nbsp;Erro no envio do E-Mail.</h6>";
    }*/
}else{
     $_SESSION['msg'] = "<h6 class='text-danger'><i class='fas fa-arrow-circle-right'></i> &nbsp;Falha na gravação da resposta da contestação.</h6>";
}

$_SESSION['pgmsg'] = "2";
echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../forca/index.php\"'>";
exit();