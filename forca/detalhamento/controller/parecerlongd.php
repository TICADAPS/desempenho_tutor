<?php
session_start();
include_once './../../../conexao-agsus.php';
include_once './../../../conexao_agsus_2.php';
include_once __DIR__ .'/../../../source/autoload.php';

$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
$ibge = isset($_POST['ibge']) ? $_POST['ibge'] : '';
$cnes = isset($_POST['cnes']) ? $_POST['cnes'] : '';
$ine = isset($_POST['ine']) ? $_POST['ine'] : '';
$idap = isset($_POST['idap']) ? $_POST['idap'] : '';
$ano = isset($_POST['ano']) ? $_POST['ano'] : '';
$ciclo = isset($_POST['ciclo']) ? $_POST['ciclo'] : '';
$iduser = isset($_POST['iduser']) ? $_POST['iduser'] : '';
$flagparecerap = isset($_POST['flagparecerap']) ? $_POST['flagparecerap'] : '';
$parecerap = isset($_POST['parecerap']) ? trim($_POST['parecerap']) : '';

// Verificar se os dados foram recebidos corretamente
if ($cpf !== '' && $ibge !== '' && $cnes !== '' && $ine !== '' && $idap !== '' && $ano !== ''
    && $ciclo !== '' && $cnes !== '' && $flagparecerap !== '') {
    if($parecerap !== ''){
        $parecerap = str_replace("'", "", $parecerap);
        $parecerap = str_replace("\"", "", $parecerap);
    }
//    var_dump($_POST);
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
    $ap = (new Source\Models\Aperfeicoamentoprofissional())->findById($idap);
//    var_dump($ap);
    if($ap !== null){
        $flagativlongduracao = $ap->flagativlongduracao;
        $ap->flagparecer = $flagparecerap;
        $ap->parecer = $parecerap;
        $ap->pareceruser = $user;
        $ap->parecerdthr = $dthoje;
        if($flagparecerap === '1' && $flagativlongduracao === '1'){
            $ap->pontuacao = 50.00;
        }else{
            $ap->pontuacao = 0.00;
        }
        $ap->flagterminou = '0';
    //    var_dump($ap);
        $rsap = $ap->save();
//        var_dump($rsap);
        if($rsap !== null){
            echo "Análise do item Atividade de Longa Duração gravada com sucesso!";
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