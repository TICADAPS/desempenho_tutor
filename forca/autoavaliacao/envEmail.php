<?php
require __DIR__ . "/../../source/autoload.php";
include '../../conexao_agsus_2.php';

// Definir o tipo de conteúdo como JSON
header('Content-Type: application/json');
// Receber o JSON enviado pelo JavaScript através de fetch
$data = json_decode(file_get_contents('php://input'), true);
// Verificar se os dados foram recebidos corretamente
if (isset($data['id']) && isset($data['nome']) && isset($data['cpf'])) {
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
        $aptutor = (new \Source\Models\Aperfeicoamentoprofissional())->findById($id);
        if($aptutor !== null){
            $aptutor->flagenvemail = '1';
            $aptutor->dthrenvemail = $dthrhoje;
            $aptutor->save();
        }
    }
}

