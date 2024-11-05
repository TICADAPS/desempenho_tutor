<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";
include '../../conexao_agsus_2.php';
include '../../Controller_agsus/fdatas.php';
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
    $anociclo = (new \Source\Models\Anocicloavaliacao())->findTudo();
    $dtfim = '';
    if($anociclo !== null){
        foreach ($anociclo as $a){
            if($a->flagativo === '1'){
                $dtfim = vemdata($a->dtfim);
            }
        }
    }
    $assunto = "Competências profissionais - autoavaliação.";
    $mensagemEmail = "*** ATENÇÃO: esta é uma mensagem eletrônica automática, as respostas não serão lidas.<br><br>";
    $mensagemEmail .= "Prezado Tutor(a), Dr(a) $nome, <br><br>";
    $mensagemEmail .= "Lembramos que o prazo final para preenchimento do instrumento que avalia as suas Competências "
            . "Profissionais (autoavaliação) é até $dtfim. Esta avaliação é uma oportunidade excelente para reflexão "
            . "sobre seu desenvolvimento e suas práticas, contribuindo para a melhoria contínua e a excelência na "
            . "atuação na Atenção Primária a Saúde. Além disso, seu preenchimento é fundamental para fortalecer a "
            . "qualidade do acompanhamento e a promoção de práticas assistenciais.<br>"
            . "Recomendamos que não deixe para o último momento e aproveite o prazo para realizar uma análise cuidadosa.<br><br>";
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
