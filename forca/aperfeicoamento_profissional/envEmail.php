<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";
include '../../conexao_agsus_2.php';
include '../../Controller_agsus/fdatas.php';
//var_dump($_POST);
$id = isset($_POST['id']) ? $_POST['id'] : '';
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
echo "id: $id, Nome: $nome, CPF: $cpf";
// Verificar se os dados foram recebidos corretamente
if ($id !== '' && $nome !== '' && $cpf !== '') {
    $sql = "select email from medico where CpfMedico = '$cpf' limit 1";
    $query = mysqli_query($conn2, $sql) or die(mysqli_error($conn2));
    $rs = mysqli_fetch_array($query);
    $destinatario = '';
    if($rs){
        do{
            $destinatario = trim($rs['email']);
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
    $assunto = "Aperfeiçoamento Profissional - Comprovantes.";
    $mensagemEmail = "*** ATENÇÃO: esta é uma mensagem eletrônica automática, as respostas não serão lidas.<br><br>";
    $mensagemEmail .= "Prezado(a) Tutor(a), Dr(a) $nome, <br><br>";
    $mensagemEmail .= "Lembramos que o prazo final para inserção dos comprovantes referentes ao aperfeiçoamento 
                profissional é até $dtfim. A apresentação desses documentos é essencial para evidenciar seu 
                compromisso com o desenvolvimento contínuo, algo indispensável para aprimorar suas competências e 
                garantir uma atuação cada vez mais atualizada e alinhada às necessidades.<br>
                Recomendamos que não deixe para o último momento e aproveite o prazo para organizar e registrar suas atividades.
                <br><br>";
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
//        var_dump($aptutor);
        date_default_timezone_set('America/Sao_Paulo');
        $dthrhoje = date('Y-m-d H:i:s');
        if($aptutor !== null){
            $aptutor->flagemailaviso = '1';
            $aptutor->emailaviso = $dthrhoje;
            $aptutor->save();
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
