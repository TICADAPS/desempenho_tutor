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
$cpf = $_POST['cpf'];
$ibgeO = $_POST['ibgeO'];
$cnes = $_POST['cnes'];
$ine = $_POST['ine'];
$ano = $_POST['ano'];
$ciclo = $_POST['ciclo'];
$rdativ = $rdpergld = '';
if(isset($_POST['rdativ'])){
    $rdativ = $_POST['rdativ'];
}
if(isset($_POST['rdpergld'])){
    $rdpergld = $_POST['rdpergld'];
}
//var_dump($_POST);

//barreira para não permitir mais de um cadastro por ciclo
$aperfprof = (new \Source\Models\Aperfeicoamentoprofissional())->findCpfIbgeCnesIne($cpf, $ibgeO, $cnes, $ine, $ano, $ciclo);
//var_dump($aperfprof);
if($aperfprof !== null){
    //validação dos campos obrigatórios
    if($rdpergld === '2'){
        if(!isset($_POST['rdativup']) || $_POST['rdativup'] === ''){
            $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Marque a assertiva no item Atividade de Longa Duração.</strong></small></p>";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                    URL=\"../index.php\"'>";
            exit();
        }
    }
    if($rdpergld === '2'){
        $rdativ = $_POST['rdativup'];
    }
    $rdQual = $rdGes = $rdInov = '';
    if(isset($_POST['rdQual'])&& $_POST['rdQual'] !== null){
        $rdQual = $_POST['rdQual'];
    }
    if(isset($_POST['rdGes']) && $_POST['rdGes'] !== null){
        $rdGes = $_POST['rdGes'];
    }
    if(isset($_POST['rdInov']) && $_POST['rdInov'] !== null){
        $rdInov = $_POST['rdInov'];
    }
    //var_dump($_POST, $_FILES);
    //arrays dos dados do formulário - imprevisibilidade da quantidade de dados
    $slq = $slg = $sli = 0;
    $cgq = $cgg = $cgi = 0;
    $ttq = $ttg = $tti = 0;
    $slQualiClinica = $cargahrQualiClinica = $tituloQualiClinica = $anexoQualiClinica = array();
    $slGesEnsPesExt = $cargahrGesEnsPesExt = $tituloGesEnsPesExt = $anexoGesEnsPesExt = array();
    $slInovTec = $cargahrInovTec = $tituloInovTec = $anexoInovTec = array();
    foreach ($_POST as $p => $k){
        if($rdQual !== '0' && $rdQual !== ''){
            //slQualiClinica
            $ifslq = substr($p, 0,3);
            if($ifslq === "slQ"){
                $slQualiClinica[$slq] = $k;
                $slq++;        
            }
            //cargahrQualiClinica
            $ifcargahrQ = substr($p, 0,8);
            if($ifcargahrQ === "cargahrQ"){
                $cargahrQualiClinica[$cgq] = $k;
                $cgq++;        
            }
            //tituloQualiClinica
            $iftituloQ = substr($p, 0,7);
            if($iftituloQ === "tituloQ"){
                $tituloQualiClinica[$ttq] = $k;
                $ttq++;        
            }
        }
        if($rdGes !== '0' && $rdGes !== ''){
            $ifslg = substr($p, 0,3);
            if($ifslg === "slG"){
                $slGesEnsPesExt[$slg] = $k;
                $slg++;
            }
            $ifcargahrG = substr($p, 0,8);
            if($ifcargahrG === "cargahrG"){
                $cargahrGesEnsPesExt[$cgg] = $k;
                $cgg++;        
            }
            $iftituloG = substr($p, 0,7);
            if($iftituloG === "tituloG"){
                $tituloGesEnsPesExt[$ttg] = $k;
                $ttg++;        
            }
        }
        if($rdInov !== '0' && $rdInov !== ''){
            $ifsli = substr($p, 0,3);
            if($ifsli === "slI"){
                $slInovTec[$sli] = $k;
                $sli++;
            }
            $ifcargahrI = substr($p, 0,8);
            if($ifcargahrI === "cargahrI"){
                $cargahrInovTec[$cgi] = $k;
                $cgi++;        
            }
            $iftituloI = substr($p, 0,7);
            if($iftituloI === "tituloI"){
                $tituloInovTec[$tti] = $k;
                $tti++;        
            }
        }
    }
    $slqa = $slga = $slia = 0;
    foreach ($_FILES as $f => $k){
//        var_dump($k);
        if($rdQual !== '0' && $rdQual !== ''){
            $fileslq = substr($f, 0,6);
//            var_dump($fileslq);
            if($fileslq === 'anexoQ'){
                $anexoQualiClinica[$slqa] = "";
        //        var_dump($anexoQualiClinica);
                //anexar arquivo PDF de Qualificação Clínica
                if (isset($_FILES["$f"]) && basename($_FILES["$f"]["name"]) != "") {
                    $datahoraArquivo = date('Ymd_His');
                    // Pegando o tipo do arquivo
                    $arquivo = basename($_FILES["$f"]["name"]);
                    $separa = explode(".", $arquivo);
                    $separa = array_reverse($separa);
                    $tipo = $separa[0];
                    // Salvado arquivo com qualquer nome

                    $nomeNovo = $cpf."_".$datahoraArquivo."_".$slqa.".".$tipo;
                    $pasta = "".date('Y_m_d');
                    //criando novo diretório, caso não exista.
                    if (!file_exists("../anexoQC/$pasta")) {
                        mkdir("../anexoQC/$pasta/", 0777, true);
                    }
                    $diretorio = "anexoQC/$pasta/";
                    $target_file = $diretorio . $nomeNovo;
                    $anexoQualiClinica[$slqa] = $target_file;
                    $uploadOk = 1;
                    $msgBool = true;
                    $arquivoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // verifica se o arquivo voucher já existe.
                    if (file_exists($target_file)) {
                        $imagem = $target_file;
                        $uploadOk = 0;
                    }

                    // checando o tamanho máximo do arquivo
                    if ($_FILES["$f"]["size"] > 5000000) {
                        $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Arquivo acima do permitido (até 5.000MB).</strong></small></p>";
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
                        move_uploaded_file($_FILES["$f"]["tmp_name"], "../" . $target_file);
                        $voucherpassagem = $target_file;
                    } else {
                        $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Não salvou o arquivo PDF.</strong></small></p>";
                        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                        URL=\"../index.php\"'>";
                        exit();
                    }
                } else {
                    $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;É necessário anexar o documento no item Qualificação Clínica.</strong></small></p>";
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                        URL=\"../index.php\"'>";
                    exit();
                }
                $slqa++;
            }
        }
        if($rdGes !== '0' && $rdGes !== ''){
            $fileslg = substr($f, 0,6);
            if($fileslg === 'anexoG'){
                $anexoGesEnsPesExt[$slga] = "";
                //anexar arquivo PDF de Gestão, Ensino, Pesquisa e Extensão
                if (isset($_FILES["$f"]) && basename($_FILES["$f"]["name"]) != "") {
                    $datahoraArquivo = date('Ymd_His');
                    // Pegando o tipo do arquivo
                    $arquivo = basename($_FILES["$f"]["name"]);
                    $separa = explode(".", $arquivo);
                    $separa = array_reverse($separa);
                    $tipo = $separa[0];
                    // Salvado arquivo com qualquer nome

                    $nomeNovo = $cpf."_".$datahoraArquivo."_".$slga.".".$tipo;
                    $pasta = "".date('Y_m_d');
                    //criando novo diretório, caso não exista.
                    if (!file_exists("../anexoGEPE/$pasta")) {
                        mkdir("../anexoGEPE/$pasta/", 0777, true);
                    }
                    $diretorio = "anexoGEPE/$pasta/";
                    $target_file = $diretorio . $nomeNovo;
                    $anexoGesEnsPesExt[$slga] = $target_file;
                    $uploadOk = 1;
                    $msgBool = true;
                    $arquivoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // verifica se o arquivo voucher já existe.
                    if (file_exists($target_file)) {
                        $imagem = $target_file;
                        $uploadOk = 0;
                    }

                    // checando o tamanho máximo do arquivo
                    if ($_FILES["$f"]["size"] > 5000000) {
                        $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Arquivo acima do permitido (até 5.000MB).</strong></small></p>";
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
                        move_uploaded_file($_FILES["$f"]["tmp_name"], "../" . $target_file);
                        $voucherpassagem = $target_file;
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
                $slga++;
            }
        }
        if($rdInov !== '0' && $rdInov !== ''){
            $filesli = substr($f, 0,6);
            if($filesli === 'anexoI'){
                $anexoInovTec[$slia] = "";
                //anexar arquivo PDF de Inovação Tecnológica
                if (isset($_FILES["$f"]) && basename($_FILES["$f"]["name"]) != "") {
                    $datahoraArquivo = date('Ymd_His');
                    // Pegando o tipo do arquivo
                    $arquivo = basename($_FILES["$f"]["name"]);
                    $separa = explode(".", $arquivo);
                    $separa = array_reverse($separa);
                    $tipo = $separa[0];
                    // Salvado arquivo com qualquer nome

                    $nomeNovo = $cpf."_".$datahoraArquivo."_".$slia.".".$tipo;
                    $pasta = "".date('Y_m_d');
                    //criando novo diretório, caso não exista.
                    if (!file_exists("../anexoIT/$pasta")) {
                        mkdir("../anexoIT/$pasta/", 0777, true);
                    }
                    $diretorio = "anexoIT/$pasta/";
                    $target_file = $diretorio . $nomeNovo;
                    $anexoInovTec[$slia] = $target_file;
                    $uploadOk = 1;
                    $msgBool = true;
                    $arquivoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // verifica se o arquivo voucher já existe.
                    if (file_exists($target_file)) {
                        $imagem = $target_file;
                        $uploadOk = 0;
                    }

                    // checando o tamanho máximo do arquivo
                    if ($_FILES["$f"]["size"] > 5000000) {
                        $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Arquivo acima do permitido (até 5.000MB).</strong></small></p>";
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
                        move_uploaded_file($_FILES["$f"]["tmp_name"], "../" . $target_file);
                        $voucherpassagem = $target_file;
                    } else {
                        $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Não salvou o arquivo PDF.</strong></small></p>";
                        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                        URL=\"../index.php\"'>";
                        exit();
                    }
                } else {
                    $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;É necessário anexar o documento no item Inovação Tecnológica.</strong></small></p>";
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                        URL=\"../index.php\"'>";
                    exit();
                }
                $slia++;
            }
        }
    }
    //validação dos campos da mesma atividade e inserção dos dados no BD.
    $ctQCli = count($slQualiClinica);
    $ctGEPE = count($slGesEnsPesExt);
    $ctIT = count($slInovTec);
    $dthrcadastro = date('Y-m-d H:i:s');
    if($rdQual === '1'){
        if(count($slQualiClinica) !== count($cargahrQualiClinica) || count($slQualiClinica) !== count($tituloQualiClinica) || count($slQualiClinica) !== count($anexoQualiClinica)){
            $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Preencha os campos corretamente no item Qualificação Clínica.</strong></small></p>";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                    URL=\"../index.php\"'>";
            exit();
        }
    }
    if($rdGes === '1'){
        if(count($slGesEnsPesExt) !== count($cargahrGesEnsPesExt) || count($slGesEnsPesExt) !== count($tituloGesEnsPesExt) || count($slGesEnsPesExt) !== count($anexoGesEnsPesExt)){
            $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Preencha os campos corretamente no item Gestão, Ensino, Pesquisa e Extensão.</strong></small></p>";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                    URL=\"../index.php\"'>";
            exit();
        }
    }
    if($rdInov === '1'){
        if(count($slInovTec) !== count($cargahrInovTec) || count($slInovTec) !== count($tituloInovTec) || count($slInovTec) !== count($anexoInovTec)){
            $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Preencha os campos corretamente no item Inovação Tecnológica.</strong></small></p>";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                    URL=\"../index.php\"'>";
            exit();
        }
    }
    $idaperfprof = null;
//    var_dump($aperfprof);
    foreach ($aperfprof as $ap){
        $idaperfprof = $ap->id;
    }
//    var_dump($idaperfprof);
    if($idaperfprof !== null){
        $ap2 = (new Source\Models\Aperfeicoamentoprofissional())->findById($idaperfprof);
//        var_dump($ap2);
        if($ap2 !== null){
            if($rdativ !== null){
                $ap2->dthrcadastro = $dthrcadastro;
                $ap2->flagativlongduracao = $rdativ;
                $ap2->flagup = '1';
                $ap2->flagparecer = null;
                $ap2->parecer = null;
                $ap2->pareceruser = null;
                $ap2->parecerdthr = null;
                $ap2->flagretorno = '1';
    //            var_dump($ap2);
                $rsaperfprof = $ap2->save();
    //            var_dump($rsaperfprof);
            }
        }
    }
    if($rdQual === '1'){
        $QCup = (new Source\Models\Medico_qualifclinica())->findJQCUp($idaperfprof);
        if ($QCup !== null) {
            foreach ($QCup as $qc) {
                $idqc = $qc->id;
            }
            if ($idqc !== null) {
                $QCup2 = (new Source\Models\Medico_qualifclinica())->findById($idqc);
                if ($QCup2 !== null) {
                    $QCup2->flagup = '1';
                    $QCup2->flagemail = '0';
                    $QCup2->save();
                }
            }
        }
        for($x = 0; $x < $ctQCli; $x++){
            $sQCi = $slQualiClinica[$x];
            $cQCi = $cargahrQualiClinica[$x];
            $tQCi = $tituloQualiClinica[$x];
            $aQCi = $anexoQualiClinica[$x];
//            var_dump($x,$sQCi,$cQCi,$tQCi,$aQCi);
            if($sQCi !== '' && $cQCi !== '' && $tQCi !== '' && $aQCi !== ''){
                $mQC = new \Source\Models\Medico_qualifclinica();
                $mQC->bootstrap($sQCi, $idaperfprof, $tQCi, $cQCi, $aQCi, $dthrcadastro);
                $rsmQC = $mQC->save();
//                var_dump($mQC,$rsmQC);
                if($rsmQC === null){
                    $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Erro no gravação dos dados 2.</strong></small></p>";
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                            URL=\"../index.php\"'>";
                    exit();
                }
                $ap = (new \Source\Models\Aperfeicoamentoprofissional())->findById($idaperfprof);
                if($ap !== null){
                    $ap->flagretorno = 1;
                    $ap->save();
                }
            }else{
                $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Preenchimento obrigatório para todos os campos ativados 1.</strong></small></p>";
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                        URL=\"../index.php\"'>";
                exit();
            }
        }
    }else{
        $apprf = (new \Source\Models\Aperfeicoamentoprofissional())->findById($idaperfprof);
        if($apprf !== null){
            $apprf->flagemail = '0';
            $apprf->save();
        }
        $QCup = (new Source\Models\Medico_qualifclinica())->findJQCUp($idaperfprof);
        if ($QCup !== null) {
            foreach ($QCup as $qc) {
                $idqc = $qc->id;
                $QCup2 = (new Source\Models\Medico_qualifclinica())->findById($idqc);
                if ($QCup2 !== null) {
                    $QCup2->flagemail = '0';
                    $QCup2->save();
                }
            }
        }
    }
    if($rdGes === '1'){
        $GEup = (new Source\Models\Medico_gesenspesext())->findJGepeUp($idaperfprof);
        if ($GEup !== null) {
            foreach ($GEup as $ge) {
                $idge = $ge->id;
            }
            if ($idge !== null) {
                $GEup2 = (new Source\Models\Medico_gesenspesext())->findById($idge);
                if ($GEup2 !== null) {
                    $GEup2->flagup = '1';
                    $GEup2->flagemail = '0';
                    $GEup2->save();
                }
            }
        }
        for($x = 0; $x < $ctGEPE; $x++){
            $sGEi = $slGesEnsPesExt[$x];
            $cGEi = $cargahrGesEnsPesExt[$x];
            $tGEi = $tituloGesEnsPesExt[$x];
            $aGEi = $anexoGesEnsPesExt[$x];
    //        var_dump($x,$sGEi,$cGEi,$tGEi,$aGEi);
            if($sGEi !== '' && $cGEi !== '' && $tGEi !== '' && $aGEi !== ''){
                $mGE = new Source\Models\Medico_gesenspesext();
                $mGE->bootstrap($sGEi, $idaperfprof, $tGEi, $cGEi, $aGEi, $dthrcadastro);
                $rsmGE = $mGE->save();
                if($rsmGE === null){
                    $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Erro no gravação dos dados 3.</strong></small></p>";
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                            URL=\"../index.php\"'>";
                    exit();
                }
                $ap = (new \Source\Models\Aperfeicoamentoprofissional())->findById($idaperfprof);
                if($ap !== null){
                    $ap->flagretorno = 1;
                    $ap->save();
                }
            }else{
                $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Preenchimento obrigatório para todos os campos ativados 2.</strong></small></p>";
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                        URL=\"../index.php\"'>";
                exit();
            }
        }
    }else{
        $apprf = (new \Source\Models\Aperfeicoamentoprofissional())->findById($idaperfprof);
        if($apprf !== null){
            $apprf->flagemail = '0';
            $apprf->save();
        }
        $GEup = (new Source\Models\Medico_gesenspesext())->findJGepeUp($idaperfprof);
        if ($GEup !== null) {
            foreach ($GEup as $ge) {
                $idge = $ge->id;
                $GEup2 = (new Source\Models\Medico_gesenspesext())->findById($idge);
                if ($GEup2 !== null) {
                    $GEup2->flagemail = '0';
                    $GEup2->save();
                }
            }
        }
    }
    //var_dump($ctIT);
    if($rdInov === '1'){
        $ITup = (new Source\Models\Medico_inovtecnologica)->findJItUp($idaperfprof);
        if ($ITup !== null) {
            foreach ($ITup as $it) {
                $idit = $it->id;
            }
            if ($idge !== null) {
                $ITup2 = (new Source\Models\Medico_gesenspesext())->findById($idit);
                if ($ITup2 !== null) {
                    $ITup2->flagup = '1';
                    $ITup2->flagemail = '0';
                    $ITup2->save();
                }
            }
        }
        for($x = 0; $x < $ctIT; $x++){
            $sITi = $slInovTec[$x];
            $cITi = $cargahrInovTec[$x];
            $tITi = $tituloInovTec[$x];
            $aITi = $anexoInovTec[$x];
//            var_dump($x,$sITi,$cITi,$tITi,$aITi);
            
            if($sITi !== '' && $cITi !== '' && $tITi !== '' && $aITi !== ''){
                $mIT = new Source\Models\Medico_inovtecnologica();
                $mIT->bootstrap($sITi, $idaperfprof, $tITi, $cITi, $aITi, $dthrcadastro);
//                var_dump($mIT);
                $rsmIT = $mIT->save();
                if($rsmIT === null){
                    $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Erro no gravação dos dados 4.</strong></small></p>";
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                            URL=\"../index.php\"'>";
                    exit();
                }
                $ap = (new \Source\Models\Aperfeicoamentoprofissional())->findById($idaperfprof);
                if($ap !== null){
                    $ap->flagretorno = 1;
                    $ap->save();
                }
            }else{
                $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Preenchimento obrigatório para todos os campos ativados 3.</strong></small></p>";
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
                        URL=\"../index.php\"'>";
                exit();
            }
        }
    }else{
        $apprf = (new \Source\Models\Aperfeicoamentoprofissional())->findById($idaperfprof);
        if($apprf !== null){
            $apprf->flagemail = '0';
            $apprf->save();
        }
        $ITup = (new Source\Models\Medico_inovtecnologica)->findJItUp($idaperfprof);
        if ($ITup !== null) {
            foreach ($ITup as $it) {
                $idit = $it->id;
                $ITup2 = (new Source\Models\Medico_gesenspesext())->findById($idit);
                if ($ITup2 !== null) {
                    $ITup2->flagemail = '0';
                    $ITup2->save();
                }
            }
        }
    }
    $_SESSION['msg'] = "<p class='text-success bg-light shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Dados cadastrados com sucesso!</strong></small></p>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../index.php\"'>";
    exit();
}else{
    $_SESSION['msg'] = "<p style='background-color: #f3d567;' class='text-dark shadow-sm p-3  border rounded font-weight-bolder'><small><strong><i class='fas fa-hand-point-right'></i> &nbsp;Não consta um cadastro preenchido em nossa base de dados.</strong></small></p>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"../index.php\"'>";
    exit();
}