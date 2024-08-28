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
$idld = $_POST['idld'];
$idap = $_POST['idap'];
$cpf = $_POST['cpf'];
$ibgeO = $_POST['ibgeO'];
$cnes = $_POST['cnes'];
$ine = $_POST['ine'];
$ano = $_POST['ano'];
$ciclo = $_POST['ciclo'];
//validação dos campos obrigatórios
if (!isset($_POST['rdativ']) || $_POST['rdativ'] === "") {
    $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Marque a resposta no item Atividade de Longa Duração.</strong></small></p>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                    URL=\"../index.php\"'>";
    exit();
}
$rdativ = $_POST['rdativ'];
$dthrcadastro = date('Y-m-d H:i:s');
$apold = (new \Source\Models\Aperfeicoamentoprofissional())->findById($idld);
if($apold !== null){
   $apold->flagativlongduracao = $rdativ;
   $apold->flagparecer = null;
   $apold->parecer = null;
   $apold->pareceruser = null;
   $apold->parecerdthr = null;
   $apold->pontuacao = null;
   $rsapold = $apold->save();
   if ($rsapold === null) {
        $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Erro no gravação dos dados.</strong></small></p>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                                URL=\"../index.php\"'>";
        exit();
    }
}
$_SESSION['msg'] = "<p class='text-success bg-light shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Dados cadastrados com sucesso!</strong></small></p>";
echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../index.php\"'>";
exit();

