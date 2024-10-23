<?php
session_start();
require __DIR__ . "/../../../vendor/autoload.php";
include '../../../conexao-agsus.php';
include '../../../Controller_agsus/fdatas.php';
include '../../../Controller_agsus/maskCpf.php';

//referenciar o DomPDF com namespace
use Dompdf\Dompdf;
use Dompdf\Options;

// Configurações do DomPDF
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true); // Permitir carregamento de recursos remotos

$dompdf = new Dompdf($options);
//if (!isset($_SESSION['perfil'])) {
//    header("Location: ../derruba_session.php");
//    exit();
//}
//if (!isset($_SESSION['nivel'])) {
//    header("Location: ../derruba_session.php");
//    exit();
//}
//if($_SESSION['perfil'] !== '3'){
//    header("Location: ../derruba_session.php");
//    exit();
//}
ini_set('memory_limit', '4096M');
set_time_limit(1000);

$id = $_REQUEST['id'];
$perfil = '3';
$nivel = '1';
$cp = (new Source\Models\Competencias_profissionais())->findById($id);

$ano=$ciclo=$cpf=$ibge=$cnes=$ine='';
if($cp !== null){
    $ano = $cp->ano;
    $ciclo = $cp->ciclo;
    $cpf = $cp->cpf;
    $ibge = $cp->ibge;
    $cnes = $cp->cnes;
    $ine = $cp->ine;
    
    $p1_1 = $cp->p1_1;
    $p1_2 = $cp->p1_2;
    $p1_3 = $cp->p1_3;
    $p1_4 = $cp->p1_4;
    $p1_5 = $cp->p1_5;
    $p2_1 = $cp->p2_1;
    $p2_2 = $cp->p2_2;
    $p2_3 = $cp->p2_3;
    $p2_4 = $cp->p2_4;
    $p2_5 = $cp->p2_5;
    $p3_1 = $cp->p3_1;
    $p3_2 = $cp->p3_2;
    $p3_3 = $cp->p3_3;
    $p4_1 = $cp->p4_1;
    $p4_2 = $cp->p4_2;
    $p4_3 = $cp->p4_3;
    $p4_4 = $cp->p4_4;
    $p5_1 = $cp->p5_1;
    $p5_2 = $cp->p5_2;
    $p5_3 = $cp->p5_3;
    $p5_4 = $cp->p5_4;
    $p6_1 = $cp->p6_1;
    $p6_2 = $cp->p6_2;
    $p6_3 = $cp->p6_3;
    $p7_1 = $cp->p7_1;
    $p7_2 = $cp->p7_2;
    $p7_3 = $cp->p7_3;
    $p7_4 = $cp->p7_4;
    $p7_5 = $cp->p7_5;
    $p8_1 = $cp->p8_1;
    $p8_2 = $cp->p8_2;
    $p8_3 = $cp->p8_3;
    $p8_4 = $cp->p8_4;
    $p9_1 = $cp->p9_1;
    $p9_2 = $cp->p9_2;
    $p9_3 = $cp->p9_3;
    $p9_4 = $cp->p9_4;
    $r1_1 = $cp->r1_1;
    $r1_2 = $cp->r1_2;
    $r1_3 = $cp->r1_3;
    $r1_4 = $cp->r1_4;
    $r1_5 = $cp->r1_5;
    $r2_1 = $cp->r2_1;
    $r2_2 = $cp->r2_2;
    $r2_3 = $cp->r2_3;
    $r2_4 = $cp->r2_4;
    $r2_5 = $cp->r2_5;
    $r3_1 = $cp->r3_1;
    $r3_2 = $cp->r3_2;
    $r3_3 = $cp->r3_3;
    $r4_1 = $cp->r4_1;
    $r4_2 = $cp->r4_2;
    $r4_3 = $cp->r4_3;
    $r4_4 = $cp->r4_4;
    $r5_1 = $cp->r5_1;
    $r5_2 = $cp->r5_2;
    $r5_3 = $cp->r5_3;
    $r5_4 = $cp->r5_4;
    $r6_1 = $cp->r6_1;
    $r6_2 = $cp->r6_2;
    $r6_3 = $cp->r6_3;
    $r7_1 = $cp->r7_1;
    $r7_2 = $cp->r7_2;
    $r7_3 = $cp->r7_3;
    $r7_4 = $cp->r7_4;
    $r7_5 = $cp->r7_5;
    $r8_1 = $cp->r8_1;
    $r8_2 = $cp->r8_2;
    $r8_3 = $cp->r8_3;
    $r8_4 = $cp->r8_4;
    $r9_1 = $cp->r9_1;
    $r9_2 = $cp->r9_2;
    $r9_3 = $cp->r9_3;
    $r9_4 = $cp->r9_4;
    $dthrenvio = $cp->dthrenvio;
    $dthrenvemail = $cp->dthrenvemail;
    $flagenvemail = $cp->flagenvemail;
    $flagenvio = $cp->flagenvio;
}
if($flagenvio !== null && $flagenvio !== '' && $flagenvio === '1'){
    $dthrenvio = vemdata($dthrenvio).", às ". hora2($dthrenvio);
}
if($flagenvemail !== null && $flagenvemail !== '' && $flagenvemail === '1'){
    $dthrenvemail = "E-Mail enviado: ".vemdata($dthrenvemail).", às ". hora2($dthrenvemail);
}
$cpfmask = mask($cpf, "###.###.###-##");
$sql = "select m.nome, m.admissao, m.cargo, mun.Municipio, e.UF, ivs.descricao 
    from medico m inner join competencias_profissionais cp on m.cpf = cp.cpf and 
    m.ibge = cp.ibge and m.cnes = cp.cnes and m.ine = cp.ine 
    inner join municipio mun on mun.cod_munc = m.ibge 
    inner join estado e on mun.Estado_cod_uf = e.cod_uf 
    left join ivs on ivs.idivs = m.fkivs 
    where m.cpf = '$cpf' and m.ibge = '$ibge' and m.cnes = '$cnes' and m.ine = '$ine' "
        . "and cp.ano = '$ano' and cp.ciclo='$ciclo'";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$nrrs = mysqli_num_rows($query);
$rs = mysqli_fetch_array($query);
$municipioO = $ufO = $flagemail = $dthremail = "";
if($rs){
    do{
        $medico = $rs['nome'];
        $admissao = $rs['admissao'];
        $cargo = $rs['cargo'];
        $municipioO = $rs['Municipio'];
        $ufO = $rs['UF'];
        $ivs = $rs['descricao'];
    }while ($rs = mysqli_fetch_array($query));
}
$path = './../../../img_agsus/Logo_400x200.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$agsus = 'data:image/' . $type . ';base64,' . base64_encode($data);

$arquivo = "RelatorioCP.xlsx";
$html = '<!doctype html>';
$html .= '<html lang="pt-br">';
$html .= '    <head>';
$html .= '        <title>AGSUS - Competências Profissionais</title>';
$html .= '        <meta charset="utf-8">';
$html .= '    <style>';            
$html .= '      footer {';
$html .= '        position: fixed; ';
$html .= '        bottom: -60px; ';
$html .= '        left: 0px; ';
$html .= '        right: 0px;';
$html .= '        height: 50px; ';
$html .= '        background-color: #03a9f4;';
$html .= '        color: white;';
$html .= '        text-align: center;';
$html .= '        line-height: 35px;';
$html .= '      }';
$html .= '    </style>';            
$html .= '    </head>';
$html .= '    <body>';
            if($nrrs > 0){
            $html .= '<p style="background-color: #4BA439; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;">';
            $html .= '  <b>Dados do Tutor</b>';
            $html .= '</p>';
            $html .= '<table style="padding: 6px 10px 6px 10px;">';
                $html .= '<tr>';
                    $html .= '<td style="padding: 6px 10px 6px 10px;">';
                        $html .= '<b>Nome: </b>'.$medico;
                    $html .= '</td>';
                    $html .= '<td style="padding: 6px 10px 6px 10px;">';
                        $html .= '<b>CPF: </b>'.$cpfmask;
                    $html .= '</td>';
                    $html .= '</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td style="padding: 6px 10px 6px 10px;">';
                        $html .= '<b>Cargo: </b>'.$cargo;
                    $html .= '</td>';
                    $html .= '<td style="padding: 6px 10px 6px 10px;">';
                        $html .= '<b>Admissão: </b>'.$admissao;
                    $html .= '</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td style="padding: 6px 10px 6px 10px;">';
                        $html .= '<b>Munic. Origem: </b>'.$municipioO .'-'. $ufO;
                    $html .= '</td>';
                    $html .= '<td style="padding: 6px 10px 6px 10px;">';
                        $html .= '<b>CNES: </b>'.$cnes;
                    $html .= '</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td style="padding: 6px 10px 6px 10px;">';
                        $html .= '<b>INE: </b>'.$ine;
                    $html .= '</td>';
                    $html .= '<td style="padding: 6px 10px 6px 10px;">';
                        $html .= '<b>IVS: </b>'.$ivs;
                    $html .= '</td>';
                $html .= '</tr>';
            $html .= '</table>';
            if($nrrs > 0 && $flagenvio === '1'){
                $html .= '<p style="background-color: #4BA439; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;">';
                    $html .= '<b>Competências Profissionais - Autoavaliação</b>';
                $html .= '</p>';
                $html .= '<p style="background-color: #000; color: #fff; border-radius: 4px; padding: 6px 10px 6px 10px;">1.0 - PROFISSIONALISMO</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;">' . $p1_1 . '</p>';
                switch ($r1_1) {
                    case '1': $r1_1 = "1- Não atendo";
                        break;
                    case '2': $r1_1 = "2- Atendo parcialmente";
                        break;
                    case '3': $r1_1 = "3- Atendo satisfatoriamente";
                        break;
                    case '4': $r1_1 = "4- Atendo plenamente";
                        break;
                    case '5': $r1_1 = "5- Supero as expectativas";
                        break;
                }
                $html .= '<p style="color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '.$r1_1.'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p1_2.'</p>';
                                          switch($r1_2){
                                            case '1': $r1_2 = "1- Não atendo"; break;
                                            case '2': $r1_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r1_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r1_2 = "4- Atendo plenamente"; break;
                                            case '5': $r1_2 = "5- Supero as expectativas"; break;
                                          }
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r1_2 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p1_3 .'</p>';
                                          switch($r1_3){
                                            case '1': $r1_3 = "1- Não atendo"; break;
                                            case '2': $r1_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r1_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r1_3 = "4- Atendo plenamente"; break;
                                            case '5': $r1_3 = "5- Supero as expectativas"; break;
                                          }
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '.$r1_3.'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p1_4 .'</p>';
                                          switch($r1_4){
                                            case '1': $r1_4 = "1- Não atendo"; break;
                                            case '2': $r1_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r1_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r1_4 = "4- Atendo plenamente"; break;
                                            case '5': $r1_4 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '.$r1_4 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p1_5.'</p>';
                                          
                                          switch($r1_5){
                                            case '1': $r1_5 = "1- Não atendo"; break;
                                            case '2': $r1_5 = "2- Atendo parcialmente"; break;
                                            case '3': $r1_5 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r1_5 = "4- Atendo plenamente"; break;
                                            case '5': $r1_5 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r1_5 .'</p>';
                $html .= '<p style="background-color: #000; color: #fff; border-radius: 4px; padding: 6px 10px 6px 10px;">2.0 - COMUNICAÇÃO</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '. $p2_1 .'</p>';
                                          
                                          switch($r2_1){
                                            case '1': $r2_1 = "1- Não atendo"; break;
                                            case '2': $r2_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r2_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r2_1 = "4- Atendo plenamente"; break;
                                            case '5': $r2_1 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r2_1 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p2_2 .'</p>';
                                          
                                          switch($r2_2){
                                            case '1': $r2_2 = "1- Não atendo"; break;
                                            case '2': $r2_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r2_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r2_2 = "4- Atendo plenamente"; break;
                                            case '5': $r2_2 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r2_2 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '. $p2_3 .'</p>';
                                          
                                          switch($r2_3){
                                            case '1': $r2_3 = "1- Não atendo"; break;
                                            case '2': $r2_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r2_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r2_3 = "4- Atendo plenamente"; break;
                                            case '5': $r2_3 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r2_3 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p2_4 .'</p>';
                                          
                                          switch($r2_4){
                                            case '1': $r2_4 = "1- Não atendo"; break;
                                            case '2': $r2_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r2_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r2_4 = "4- Atendo plenamente"; break;
                                            case '5': $r2_4 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r2_4 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p2_5 .'</p>';
                                          
                                          switch($r2_5){
                                            case '1': $r2_5 = "1- Não atendo"; break;
                                            case '2': $r2_5 = "2- Atendo parcialmente"; break;
                                            case '3': $r2_5 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r2_5 = "4- Atendo plenamente"; break;
                                            case '5': $r2_5 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r2_5 .'</p>';
                $html .= '<p style="background-color: #000; color: #fff; border-radius: 4px; padding: 6px 10px 6px 10px;">3.0 - LIDERANÇA</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p3_1 .'</p>';
                                          
                                          switch($r3_1){
                                            case '1': $r3_1 = "1- Não atendo"; break;
                                            case '2': $r3_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r3_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r3_1 = "4- Atendo plenamente"; break;
                                            case '5': $r3_1 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r3_1 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '. $p3_2 .'</p>';
                                          
                                          switch($r3_2){
                                            case '1': $r3_2 = "1- Não atendo"; break;
                                            case '2': $r3_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r3_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r3_2 = "4- Atendo plenamente"; break;
                                            case '5': $r3_2 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r3_2 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p3_3 .'</p>';
                                          
                                          switch($r3_3){
                                            case '1': $r3_3 = "1- Não atendo"; break;
                                            case '2': $r3_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r3_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r3_3 = "4- Atendo plenamente"; break;
                                            case '5': $r3_3 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r3_3 .'</p>';
                $html .= '<p style="background-color: #000; color: #fff; border-radius: 4px; padding: 6px 10px 6px 10px;">4.0 - GOVERNANÇA CLÍNICA</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p4_1 .'</p>';
                                          
                                          switch($r4_1){
                                            case '1': $r4_1 = "1- Não atendo"; break;
                                            case '2': $r4_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r4_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r4_1 = "4- Atendo plenamente"; break;
                                            case '5': $r4_1 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r4_1 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p4_2 .'</p>';
                                          
                                          switch($r4_2){
                                            case '1': $r4_2 = "1- Não atendo"; break;
                                            case '2': $r4_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r4_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r4_2 = "4- Atendo plenamente"; break;
                                            case '5': $r4_2 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r4_2 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p4_3 .'</p>';
                                          
                                          switch($r4_3){
                                            case '1': $r4_3 = "1- Não atendo"; break;
                                            case '2': $r4_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r4_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r4_3 = "4- Atendo plenamente"; break;
                                            case '5': $r4_3 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r4_3 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p4_4 .'</p>';
                                          
                                          switch($r4_4){
                                            case '1': $r4_4 = "1- Não atendo"; break;
                                            case '2': $r4_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r4_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r4_4 = "4- Atendo plenamente"; break;
                                            case '5': $r4_4 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r4_4 .'</p>';
                $html .= '<p style="background-color: #000; color: #fff; border-radius: 4px; padding: 6px 10px 6px 10px;">5.0 - ADVOCACIA PELA SAÚDE</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p5_1 .'</p>';
                                          
                                          switch($r5_1){
                                            case '1': $r5_1 = "1- Não atendo"; break;
                                            case '2': $r5_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r5_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r5_1 = "4- Atendo plenamente"; break;
                                            case '5': $r5_1 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r5_1 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p5_2 .'</p>';
                                          
                                          switch($r5_2){
                                            case '1': $r5_2 = "1- Não atendo"; break;
                                            case '2': $r5_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r5_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r5_2 = "4- Atendo plenamente"; break;
                                            case '5': $r5_2 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r5_2 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '. $p5_3 .'</p>';
                                          
                                          switch($r5_3){
                                            case '1': $r5_3 = "1- Não atendo"; break;
                                            case '2': $r5_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r5_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r5_3 = "4- Atendo plenamente"; break;
                                            case '5': $r5_3 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r5_3 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p5_4 .'</p>';
                                          
                                          switch($r5_4){
                                            case '1': $r5_4 = "1- Não atendo"; break;
                                            case '2': $r5_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r5_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r5_4 = "4- Atendo plenamente"; break;
                                            case '5': $r5_4 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r4_4 .'</p>';
                $html .= '<p style="background-color: #000; color: #fff; border-radius: 4px; padding: 6px 10px 6px 10px;">6.0 - DEDICAÇÃO ACADÊMICA</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p6_1 .'</p>';
                                          
                                          switch($r6_1){
                                            case '1': $r6_1 = "1- Não atendo"; break;
                                            case '2': $r6_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r6_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r6_1 = "4- Atendo plenamente"; break;
                                            case '5': $r6_1 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r6_1 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p6_2 .'</p>';
                                          
                                          switch($r6_2){
                                            case '1': $r6_2 = "1- Não atendo"; break;
                                            case '2': $r6_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r6_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r6_2 = "4- Atendo plenamente"; break;
                                            case '5': $r6_2 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r6_2 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p6_3 .'</p>';
                                          
                                          switch($r6_3){
                                            case '1': $r6_3 = "1- Não atendo"; break;
                                            case '2': $r6_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r6_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r6_3 = "4- Atendo plenamente"; break;
                                            case '5': $r6_3 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r6_3 .'</p>';
                $html .= '<p style="background-color: #000; color: #fff; border-radius: 4px; padding: 6px 10px 6px 10px;">7.0 - COLABORAÇÃO</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p7_1 .'</p>';
                                          
                                          switch($r7_1){
                                            case '1': $r7_1 = "1- Não atendo"; break;
                                            case '2': $r7_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r7_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r7_1 = "4- Atendo plenamente"; break;
                                            case '5': $r7_1 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r7_1 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p7_2 .'</p>';
                                          
                                          switch($r7_2){
                                            case '1': $r7_2 = "1- Não atendo"; break;
                                            case '2': $r7_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r7_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r7_2 = "4- Atendo plenamente"; break;
                                            case '5': $r7_2 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r7_2 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p7_3 .'</p>';
                                          
                                          switch($r7_3){
                                            case '1': $r7_3 = "1- Não atendo"; break;
                                            case '2': $r7_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r7_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r7_3 = "4- Atendo plenamente"; break;
                                            case '5': $r7_3 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r7_3 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p7_4 .'</p>';
                                          
                                          switch($r7_4){
                                            case '1': $r7_4 = "1- Não atendo"; break;
                                            case '2': $r7_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r7_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r7_4 = "4- Atendo plenamente"; break;
                                            case '5': $r7_4 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r7_4 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p7_5 .'</p>';
                                          
                                          switch($r7_5){
                                            case '1': $r7_5 = "1- Não atendo"; break;
                                            case '2': $r7_5 = "2- Atendo parcialmente"; break;
                                            case '3': $r7_5 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r7_5 = "4- Atendo plenamente"; break;
                                            case '5': $r7_5 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r7_5 .'</p>';
                $html .= '<p style="background-color: #000; color: #fff; border-radius: 4px; padding: 6px 10px 6px 10px;">8.0 - CONDUTA ÉTICA E RESPEITOSA</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p8_1 .'</p>';
                                          
                                          switch($r8_1){
                                            case '1': $r8_1 = "1- Não atendo"; break;
                                            case '2': $r8_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r8_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r8_1 = "4- Atendo plenamente"; break;
                                            case '5': $r8_1 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #fff; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r8_1 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p8_2 .'</p>';
                                          
                                          switch($r8_2){
                                            case '1': $r8_2 = "1- Não atendo"; break;
                                            case '2': $r8_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r8_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r8_2 = "4- Atendo plenamente"; break;
                                            case '5': $r8_2 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r8_2 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p8_3 .'</p>';
                                          
                                          switch($r8_3){
                                            case '1': $r8_3 = "1- Não atendo"; break;
                                            case '2': $r8_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r8_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r8_3 = "4- Atendo plenamente"; break;
                                            case '5': $r8_3 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r8_3 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p8_4 .'</p>';
                                          
                                          switch($r8_4){
                                            case '1': $r8_4 = "1- Não atendo"; break;
                                            case '2': $r8_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r8_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r8_4 = "4- Atendo plenamente"; break;
                                            case '5': $r8_4 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r8_4 .'</p>';
                $html .= '<p style="background-color: #000; color: #fff; border-radius: 4px; padding: 6px 10px 6px 10px;">9.0 - ADERÊNCIA AO MODELO DE ATENÇÃO</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p9_1 .'</p>';
                                          
                                          switch($r9_1){
                                            case '1': $r9_1 = "1- Não atendo"; break;
                                            case '2': $r9_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r9_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r9_1 = "4- Atendo plenamente"; break;
                                            case '5': $r9_1 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r9_1 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p9_2 .'</p>';
                                          
                                          switch($r9_2){
                                            case '1': $r9_2 = "1- Não atendo"; break;
                                            case '2': $r9_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r9_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r9_2 = "4- Atendo plenamente"; break;
                                            case '5': $r9_2 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r9_2 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p9_3 .'</p>';
                                          
                                          switch($r9_3){
                                            case '1': $r9_3 = "1- Não atendo"; break;
                                            case '2': $r9_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r9_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r9_3 = "4- Atendo plenamente"; break;
                                            case '5': $r9_3 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r9_3 .'</p>';
                $html .= '<p style="background-color: #ddd; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"> '.$p9_4 .'</p>';
                                          
                                          switch($r9_4){
                                            case '1': $r9_4 = "1- Não atendo"; break;
                                            case '2': $r9_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r9_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r9_4 = "4- Atendo plenamente"; break;
                                            case '5': $r9_4 = "5- Supero as expectativas"; break;
                                          }
                                          
                $html .= '<p style="background-color: #fff; color: #000; border-radius: 4px; padding: 6px 10px 6px 10px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; R: '. $r9_4 .'</p>';
                         }
            }
        $html .= '<br><hr>';    
        $html .= '</body>';
        $html .= '</html>';

        // (Opcional) Definir o tamanho do papel e a orientação
        $dompdf->setPaper('A4', 'portrait');
        // Carrega seu HTML
        $dompdf->load_html('
                                <h2 style="text-align: center;"><img src="'.$agsus.'" style="border-radius:6px;" width="25%"></h2>
                                <h2 style="text-align: center;">AGSUS - Competências Profissionais - Autoavaliação</h2>
                                <h3 style="text-align: center;">Ano:  '.$ano.'  &nbsp;-&nbsp;  '.$ciclo.'º Ciclo</h3>' . $html . '
                        ');

        //Renderizar o html
        $dompdf->render();
        // Adiciona o script para a numeração de páginas
        $canvas = $dompdf->getCanvas();
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "Página $pageNumber de $pageCount";
            $font = $fontMetrics->get_font('Time News Roman', 'normal');
            $size = 10; // Tamanho da fonte
            $width = $fontMetrics->getTextWidth($text, $font, $size);
            $canvas->text(270 - ($width / 2), 804, $text, $font, $size); // Centralizar o texto
        });
        //Exibibir a página
        $dompdf->stream(
                "relatorioCP_agsus.pdf", array(
            "Attachment" => false //Para realizar o download somente alterar para true
                )
        );

        
 
