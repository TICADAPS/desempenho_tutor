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
$gepeid = isset($_POST['gepeid']) ? $_POST['gepeid'] : '';
$gepech = isset($_POST['gepech']) ? $_POST['gepech'] : '';
$gepeparecer = isset($_POST['gepeparecer']) ? trim($_POST['gepeparecer']) : '';
$gepeflagparecer = isset($_POST['gepeflagparecer']) ? $_POST['gepeflagparecer'] : '';
$iduser = isset($_POST['iduser']) ? $_POST['iduser'] : '';

// Verificar se os dados foram recebidos corretamente
if ($cpf !== '' && $ibge !== '' && $cnes !== '' && $ine !== '' && $idap !== '' && $ano !== ''
    && $ciclo !== '' && $cnes !== '' && $gepeflagparecer !== '' && $gepeid !== '' && $gepech !== '') {

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
    if($gepeparecer !== ''){
        $gepeparecer = str_replace("'", "", $gepeparecer);
        $gepeparecer = str_replace("\"", "", $gepeparecer);
    }
    //var_dump($_POST);
    $gepe = (new Source\Models\Medico_gesenspesext())->findById($gepeid);
    //var_dump($gepe);
    if($gepe !== null){
        $idaperfprof = $gepe->idaperfprof;
        $idg = (int)$gepe->idgesenspesext;
        $gepe->flagparecer = $gepeflagparecer;
        $gepe->parecer = $gepeparecer;
        $gepe->pareceruser = $user;
        $gepe->parecerdthr = $dthoje;
        if($gepeflagparecer === '1'){
    //        var_dump($idg);
            switch ($idg){
                case 1: $gepe->pontuacao = ($gepech * 1.0); break; /* conforme manual */
                case 2: $gepe->pontuacao = ($gepech * 1.0); break; /* conforme manual */
                case 3: $gepe->pontuacao = ($gepech * 15.0); break; /* conforme manual */
                case 4: $gepe->pontuacao = ($gepech * 5.0); break; /* conforme manual */
                case 5: $gepe->pontuacao = ($gepech * 15.0); break; /* conforme manual */
                case 6: $gepe->pontuacao = ($gepech * 10.0); break; /* conforme manual */
                case 7: $gepe->pontuacao = ($gepech * 5.0); break; /* conforme manual */
                case 8: $gepe->pontuacao = ($gepech * 3.0); break; /* conforme manual */
                case 9: $gepe->pontuacao = ($gepech * 5.0); break; /* conforme manual */
                case 10: $gepe->pontuacao = ($gepech * 1.0); break; /* conforme manual */
            }

        }else{
            $gepe->pontuacao = 0.00;
        }
    //    var_dump($gepe);
        $rsgepe = $gepe->save();
    //    var_dump($rsgepe);
        if($rsgepe !== null){
            echo "Análise do item Gestão, Ensino, Pesquisa e Extensão gravada com sucesso!";
        }else{
            echo "Erro na atualização dos dados.";
        }
        //flagterminou null - no retorno ao médico indica que foi analisado mas ainda não foi habilitado para réplica
        //a habilitação (caso pontuação seja menor que 50) se dá após o envio do e-mail
        $ap = (new \Source\Models\Aperfeicoamentoprofissional())->findById($idaperfprof);
        if($ap !== null){
            $ap->flagterminou = null;
            $ap->save();
        }
    }else{
        echo "Cadastro de aperfeiçoamento profisional não encontrado.";
    }
}else {
    // Resposta em caso de erro nos dados
    echo "Erro: É obrigatório o preenchimento dos campos.";
}
exit();