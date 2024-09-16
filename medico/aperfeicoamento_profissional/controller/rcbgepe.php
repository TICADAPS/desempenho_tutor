<?php
session_start();
require __DIR__ . "/../../../source/autoload.php";
include '../../../conexao_agsus_2.php';
include '../../../conexao-agsus.php';

if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
date_default_timezone_set('America/Sao_Paulo');
//dados pessoais do médico
$gepeid = $_POST['gepeid'];
$idap = $_POST['idap'];
$cpf = $_POST['cpf'];
$ibgeO = $_POST['ibgeO'];
$cnes = $_POST['cnes'];
$ine = $_POST['ine'];
$ano = $_POST['ano'];
$ciclo = $_POST['ciclo'];
//validação dos campos obrigatórios
if (!isset($_POST['slGesEnsPesExt']) || $_POST['slGesEnsPesExt'] === "") {
    $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Selecione a atividade no item Gestão, Ensino, Pesquisa e Extensão.</strong></small></p>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                    URL=\"../index.php\"'>";
    exit();
}
if (!isset($_POST['cargahrGesEnsPesExt']) || $_POST['cargahrGesEnsPesExt'] === "") {
    $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Preencha o campo Carga Horária no item Gestão, Ensino, Pesquisa e Extensão.</strong></small></p>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                    URL=\"../index.php\"'>";
    exit();
}
if (!isset($_POST['tituloGesEnsPesExt']) || $_POST['tituloGesEnsPesExt'] === "") {
    $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Preencha o campo Título da atividade no item Gestão, Ensino, Pesquisa e Extensão.</strong></small></p>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                    URL=\"../index.php\"'>";
    exit();
}
$slGesEnsPesExt = $_POST['slGesEnsPesExt'];
$cargahrGesEnsPesExt = $_POST['cargahrGesEnsPesExt'];
$tituloGesEnsPesExt = $_POST['tituloGesEnsPesExt'];
//var_dump($_POST, $_FILES);
//anexar arquivo PDF de Gestão, Ensino, Pesquisa e Extensão
if (isset($_FILES["anexoGesEnsPesExt"]) && basename($_FILES["anexoGesEnsPesExt"]["name"]) != "") {
    $datahoraArquivo = date('Ymd_His');
    // Pegando o tipo do arquivo
    $arquivo = basename($_FILES["anexoGesEnsPesExt"]["name"]);
    $separa = explode(".", $arquivo);
    $separa = array_reverse($separa);
    $tipo = $separa[0];
    // Salvado arquivo com qualquer nome

    $nomeNovo = $cpf . "_" . $datahoraArquivo . "_up." . $tipo;
    $pasta = "" . date('Y_m_d');
    //criando novo diretório, caso não exista.
    if (!file_exists("../anexoGEPE/$pasta")) {
        mkdir("../anexoGEPE/$pasta/", 0777, true);
    }
    $diretorio = "anexoGEPE/$pasta/";
    $target_file = $diretorio . $nomeNovo;
    $uploadOk = 1;
    $msgBool = true;
    $arquivoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // verifica se o arquivo voucher já existe.
    if (file_exists($target_file)) {
        $imagem = $target_file;
        $uploadOk = 0;
    }

    // checando o tamanho máximo do arquivo
    if ($_FILES["anexoGesEnsPesExt"]["size"] > 5000000) {
        $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Arquivo acima do permgepeido (até 5.000MB).</strong></small></p>";
        echo $mensagem;
        $uploadOk = 0;
        $msgBool = false;
    }

    // Allow certain file formats
    if ($arquivoFileType != "pdf") {
        $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;A extensão do arquivo deve ser PDF.</strong></small></p>";
        echo $mensagem;
        $uploadOk = 0;
        $msgBool = false;
    }

    // Check se $uploadOk é 1 para realizar o upload do arquivo.
    if ($uploadOk == 1) {
        move_uploaded_file($_FILES["anexoGesEnsPesExt"]["tmp_name"], "../" . $target_file);
        $agepei = $target_file;
    } else {
        $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Não salvou o arquivo PDF.</strong></small></p>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                        URL=\"../index.php\"'>";
        exit();
    }
} else {
    $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;É necessário anexar o documento no item Gestão, Ensino, Pesquisa e Extensão.</strong></small></p>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                        URL=\"../index.php\"'>";
    exit();
}
$dthrcadastro = date('Y-m-d H:i:s');
//    var_dump($idaperfprof);
$mgepe = new Source\Models\Medico_gesenspesext();
$mgepe->bootstrap($slGesEnsPesExt, $idap, $tituloGesEnsPesExt, $cargahrGesEnsPesExt, $agepei, $dthrcadastro);
//                var_dump($mgepe);
$rsmgepe = $mgepe->save();
if ($rsmgepe === null) {
    $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Erro no gravação dos dados .</strong></small></p>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                            URL=\"../index.php\"'>";
    exit();
}
$gepeold = (new \Source\Models\Medico_gesenspesext())->findById($gepeid);
if($gepeold !== null){
    $gepeold->flagup = 1;
    $rsgepeold = $gepeold->save();
    if ($rsgepeold === null) {
        $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Erro no gravação dos dados.</strong></small></p>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                                URL=\"../index.php\"'>";
        exit();
    }
    $ap = (new \Source\Models\Aperfeicoamentoprofissional())->findById($idap);
    if($ap !== null){
        $ap->flagretorno = 1;
        $ap->save();
    }
}
$_SESSION['msg'] = "<p class='text-success bg-light shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Dados cadastrados com sucesso!</strong></small></p>";
echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../index.php\"'>";
exit();

