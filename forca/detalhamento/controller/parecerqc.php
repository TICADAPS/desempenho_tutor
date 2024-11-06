<?php
session_start();
include_once './../../../conexao-agsus.php';
include_once './../../../conexao_agsus_2.php';
include_once __DIR__ .'/../../../vendor/autoload.php';

$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
$ibge = isset($_POST['ibge']) ? $_POST['ibge'] : '';
$cnes = isset($_POST['cnes']) ? $_POST['cnes'] : '';
$ine = isset($_POST['ine']) ? $_POST['ine'] : '';
$idap = isset($_POST['idap']) ? $_POST['idap'] : '';
$ano = isset($_POST['ano']) ? $_POST['ano'] : '';
$ciclo = isset($_POST['ciclo']) ? $_POST['ciclo'] : '';
$qcid = isset($_POST['qcid']) ? $_POST['qcid'] : '';
$qcch = isset($_POST['qcch']) ? $_POST['qcch'] : '';
$qcparecer = isset($_POST['qcparecerqa']) ? trim($_POST['qcparecerqa']) : '';
$qcflagparecer = isset($_POST['qcflagparecer']) ? $_POST['qcflagparecer'] : '';
$iduser = isset($_POST['iduser']) ? $_POST['iduser'] : '';

// Verificar se os dados foram recebidos corretamente
if ($cpf !== '' && $ibge !== '' && $cnes !== '' && $ine !== '' && $idap !== '' && $ano !== ''
    && $ciclo !== '' && $cnes !== '' && $qcflagparecer !== '' && $qcid !== '' && $qcch !== '') {

    date_default_timezone_set('America/Sao_Paulo');
    $dthoje = date('Y-m-d H:i:s');
    $sqlu = "select * from usuarios where id_user = '$iduser'";
    $queryu = mysqli_query($conn2, $sqlu) or die(mysqli_error($conn2));
    $rsu = mysqli_fetch_array($queryu);
    $user = '';
    if($rsu){
        do{
            $user = $rsu['nome_user'];
        }while($rsu = mysqli_fetch_array($queryu));
    }
    if($qcparecer !== ''){
        $qcparecer = str_replace("'", "", $qcparecer);
        $qcparecer = str_replace("\"", "", $qcparecer);
    }
    //var_dump($_POST);
    $qc = (new Source\Models\Medico_qualifclinica())->findById($qcid);
    //var_dump($qc);
    if($qc !== null){
        $idaperfprof = $qc->idaperfprof;
        $qc->flagparecer = $qcflagparecer;
        $qc->parecer = $qcparecer;
        $qc->pareceruser = $user;
        $qc->parecerdthr = $dthoje;
        if($qcflagparecer === '1'){
            $qc->pontuacao = ($qcch * 1); /* conforme manual */
        }else{
            $qc->pontuacao = 0.00;
        }
    //    var_dump($qc);
        $rsqc = $qc->save();
        //flagterminou null - no retorno ao médico indica que foi analisado mas ainda não foi habilitado para réplica
        //a habilitação (caso pontuação seja menor que 50) se dá após o envio do e-mail
        $ap = (new \Source\Models\Aperfeicoamentoprofissional())->findById($idaperfprof);
        if($ap !== null){
            $ap->flagterminou = '0';
            $ap->save();
        }
    //    var_dump($rsqc);
        if($rsqc !== null){
            echo "Análise do item Qualificação Clínica gravada com sucesso!";
        }else{
            echo "Erro na atualização dos dados.";
        }
    }else{
        echo "Cadastro de aperfeiçoamento profisional não encontrado.";
    }
}else {
    // Resposta em caso de erro nos dados
    echo "Erro: É obrigatório o preenchimento dos campos.";
}
exit();