<?php
session_start();
require __DIR__ . "/../../source/autoload.php";
include '../../conexao-agsus.php';
include '../../Controller_agsus/maskCpf.php';
include '../../Controller_agsus/fdatas.php';

if(!isset($_REQUEST['id']) || trim($_REQUEST['id']) === ''){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Selecione o ciclo desejado.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"index.php\"'>"; 
    exit();
}
$id = $_REQUEST['id'];
$anociclo = (new Source\Models\Anocicloavaliacao())->findById($id);
if($anociclo !== null){
    $anociclo->flagativo = '1';
    $rs = $anociclo->destroy();
    if($rs === null){
        
        $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Erro no gravação dos dados.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"index.php\"'>"; 
        exit();
    }else{
        $_SESSION['msg'] = "<h6 class='bg-light border rounded text-success p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Ciclo excluído.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"index.php\"'>"; 
        exit();
    }
}