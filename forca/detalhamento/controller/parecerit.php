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
$itid = isset($_POST['itid']) ? $_POST['itid'] : '';
$itch = isset($_POST['itch']) ? $_POST['itch'] : '';
$itparecer = isset($_POST['itparecer']) ? trim($_POST['itparecer']) : '';
$itflagparecer = isset($_POST['itflagparecer']) ? $_POST['itflagparecer'] : '';
$iduser = isset($_POST['iduser']) ? $_POST['iduser'] : '';

// Verificar se os dados foram recebidos corretamente
if ($cpf !== '' && $ibge !== '' && $cnes !== '' && $ine !== '' && $idap !== '' && $ano !== ''
    && $ciclo !== '' && $cnes !== '' && $itflagparecer !== '' && $itid !== '' && $itch !== '') {
    
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
    //var_dump($_POST);
    if($itflagparecer !== ''){
        $itflagparecer = str_replace("'", "", $itflagparecer);
        $itflagparecer = str_replace("\"", "", $itflagparecer);
    }
    
    $it = (new Source\Models\Medico_inovtecnologica())->findById($itid);
    //var_dump($it);
    if($it !== null){
        $idaperfprof = $it->idaperfprof;
        $idt = $it->idinovtecnologica ;
        $it->flagparecer = $itflagparecer;
        $it->parecer = $itparecer;
        $it->pareceruser = $user;
        $it->parecerdthr = $dthoje;
        if($itflagparecer === '1'){
            switch ($idt){
                case 1: $it->pontuacao = ($itch * 1.0); break; /* conforme manual */
                case 2: $it->pontuacao = ($itch * 1.0); break; /* conforme manual */
            }
        }else{
            $it->pontuacao = 0.00;
        }
    //    var_dump($it);
        $rsit = $it->save();
    //    var_dump($rsit);
        //flagterminou null - no retorno ao médico indica que foi analisado mas ainda não foi habilitado para réplica
        //a habilitação (caso pontuação seja menor que 50) se dá após o envio do e-mail
        $ap = (new \Source\Models\Aperfeicoamentoprofissional())->findById($idaperfprof);
        if($ap !== null){
            $ap->flagterminou = '0';
            $ap->save();
        }
        if($rsit !== null){
            echo "Análise do item Inovação Tecnológica gravada com sucesso!";
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