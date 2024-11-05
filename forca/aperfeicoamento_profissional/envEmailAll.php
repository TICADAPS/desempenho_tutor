<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";
include '../../conexao-agsus.php';
include '../../conexao_agsus_2.php';
include '../../mask.php';
include '../../Controller_agsus/fdatas.php';
//var_dump($_POST);
$ano = isset($_POST['ano']) ? $_POST['ano'] : '';
$ciclo = isset($_POST['ciclo']) ? $_POST['ciclo'] : '';
//var_dump($_POST);
// Verificar se os dados foram recebidos corretamente
if ($ano !== '' && $ciclo !== '') {
    $ano = $_POST['ano'];
    $ciclo = $_POST['ciclo'];
    $sqlm = "select id, cpf from aperfeicoamentoprofissional where ano = '$ano' and ciclo = '$ciclo' and (flaginativo is null or flaginativo <> 1) and (flagemailaviso is null or flagemailaviso <> 1)";
    $querym = mysqli_query($conn, $sqlm) or die(mysqli_error($conn));
    $rsm = mysqli_fetch_array($querym);
    if($rsm){
        do{
            $nome = $destinatario = '';
            $id = $rsm['id'];
            $cpf = $rsm['cpf'];
            $cpf = mask($cpf, "###.###.###-##");
            $sql = "select NomeMedico, email from medico where CpfMedico = '$cpf' limit 1";
            $query = mysqli_query($conn2, $sql) or die(mysqli_error($conn2));
            $rs = mysqli_fetch_array($query);
            $destinatario = '';
            if($rs){
                do{
                    $nome = $rs['NomeMedico'];
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
                $cptutor = (new \Source\Models\Aperfeicoamentoprofissional())->findById($id);
        //        var_dump($cptutor);
                date_default_timezone_set('America/Sao_Paulo');
                $dthrhoje = date('Y-m-d H:i:s');
                if($cptutor !== null){
                    $cptutor->flagemailaviso = '1';
                    $cptutor->emailaviso = $dthrhoje;
                    $cptutor->save();
                }
                echo "$id";
            }else{
                echo '0';
            }
        }while($rsm = mysqli_fetch_array($querym));
    }else{
        echo '0';
    }
}
