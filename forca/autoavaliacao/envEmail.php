<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";
include '../../conexao_agsus_2.php';
//var_dump($_POST);
$id = isset($_POST['id']) ? $_POST['id'] : '';
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
// Verificar se os dados foram recebidos corretamente
if ($id !== '' && $nome !== '' && $cpf !== '') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    
    $sql = "select email from medico where CpfMedico = '$cpf' limit 1";
    $query = mysqli_query($conn2, $sql) or die(mysqli_error($conn2));
    $rs = mysqli_fetch_array($query);
    $destinatario = '';
    if($rs){
        do{
            $destinatario = $rs['email'];
        }while($rs = mysqli_fetch_array($query));
    }
    $assunto = "Competências profissionais - autoavaliação.";
    $mensagemEmail = "*** ATENÇÃO: esta é uma mensagem eletônica automática, as respostas não serão lidas.<br><br>";
    $mensagemEmail .= "Prezado Tutor(a), Dr(a) $nome, <br><br>";
    $mensagemEmail .= "TEXTO PADRÃO A SER ENVIADO<br><br>";
    $mensagemEmail .= "-- <br>";
    $mensagemEmail .= "Atenciosamente, <br><br>";
    $email = (new \Source\Support\Email())->bootstrap(
            "$assunto",
            "$mensagemEmail",
            "$destinatario",
            "$nome",
            "",
            "");
    $email->attach("../../img/Logo_agsus.jpg", "AgSUS");
    if ($email->send()) {
        $cptutor = (new \Source\Models\Competencias_profissionais())->findById($id);
//        var_dump($cptutor);
        date_default_timezone_set('America/Sao_Paulo');
        $dthrhoje = date('Y-m-d H:i:s');
        if($cptutor !== null){
            $cptutor->flagenvemail = '1';
            $cptutor->dthrenvemail = $dthrhoje;
            $cptutor->save();
        }
        echo '';
//        echo "<h6 class='p-2 rounded' style='background-color: #E2EDD9;'><i class='fas fa-chevron-circle-right'></i>&nbsp; E-Mail enviado com sucesso!</h6>";
    }else{
        echo "<h6 class='p-2 rounded bg-warning'><i class='fas fa-chevron-circle-right'></i>&nbsp; Erro: Falha na comunicação.</h6>";
    }
}else{
    // Resposta em caso de erro nos dados
    echo "<h6 class='p-2 rounded bg-warning'><i class='fas fa-chevron-circle-right'></i>&nbsp; Erro: Dados inexistentes em nossa base.</h6>";
}
exit();
