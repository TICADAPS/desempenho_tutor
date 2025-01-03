<?php
session_start();
include '../conexao-agsus.php';
//if (!isset($_SESSION['cpf'])) {
//   header("Location: derruba_session.php"); exit();
//}
//$cpf = $_SESSION['cpf'];
//$cpf = '001.417.733-16';
date_default_timezone_set('America/Sao_Paulo');
$anoAtual = date('Y');
$ibge = $_GET['ibge'];
//$cpftratado = str_replace("-", "", $cpf);
//$cpftratado = str_replace(".", "", $cpftratado);
//$cpftratado = str_replace(".", "", $cpftratado);
//$sql = "select * from medico m inner join desempenho d on m.cpf = d.cpf and m.ibge = d.ibge"
//        . " inner join periodo p on p.idperiodo = d.idperiodo where m.cpf = '$cpftratado' and ano = '$anoAtual';";
//$query = mysqli_query($conn, $sql);
//$nrrs = mysqli_num_rows($query);
//$rs = mysqli_fetch_array($query);
//$rscpf = false;
//if ($nrrs > 0) {
//    $rscpf = true;
//}
?>
<!--<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>AGSUS - Avaliação de Desempenho</title>

         Custom fonts for this template
        <link rel="shortcut icon" href="../img_agsus/iconAdaps.png"/>
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

         Custom styles for this template
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    </head>

    <body>-->
        <?php
        //variáveis para média dos indicadores do 1o quadrimestre.
        $mediaPreCons1q = $mediaPreSif1q = $mediaCitop1q = $mediaHiper1q = $mediaDiab1q = $somaPreCons1q = $somaPreSif1q = $somaCitop1q = $somaHiper1q = $somaDiab1q = 0;
        $qtdMetaPreCons1q = $qtdMetaPreSif1q = $qtdMetaCitop1q = $qtdMetaHiper1q = $qtdMetaDiab1q = $metaPreCons1q = $metaPreSif1q = $metaCitop1q = $metaHiper1q = $metaDiab1q = 0;
        $ctPreCons1q = $ctPreSif1q = $ctCitop1q = $ctHiper1q = $ctDiab1q = 0;
        //média dos indicadores do 1o quadrimestre
        $sql1q = "SELECT * FROM medico m inner join desempenho d on d.cpf = m.cpf and d.ibge = m.ibge and m.cnes = m.cnes and d.ine = m.ine where ano = '$anoAtual' and d.idperiodo = 23 and substr(d.ibge,1,6) = '$ibge'";
        $q1q = mysqli_query($conn, $sql1q);
        $rows1q = mysqli_num_rows($q1q);

        $sqlInd1q = "SELECT * FROM `desempenho` where ano = '$anoAtual' and idperiodo = 23 and substr(ibge,1,6) = '$ibge'";
        $queryInd1q = mysqli_query($conn, $sqlInd1q);
        $rowsInd1q = mysqli_num_rows($queryInd1q);
        $rsInd1q = mysqli_fetch_array($queryInd1q);
        if ($rsInd1q) {
            do {
                $somaPreCons1q += $rsInd1q['prenatal_consultas'];
                $somaPreSif1q += $rsInd1q['prenatal_sifilis_hiv'];
                $somaCitop1q += $rsInd1q['cobertura_citopatologico'];
                $somaHiper1q += $rsInd1q['hipertensao'];
                $somaDiab1q += $rsInd1q['diabetes'];
                $ctPreCons1q++;
                $ctPreSif1q++;
                $ctCitop1q++;
                $ctHiper1q++;
                $ctDiab1q++;
                if ($rsInd1q['prenatal_consultas'] > 45.00) {
                    $qtdMetaPreCons1q++;
                }
                if ($rsInd1q['prenatal_sifilis_hiv'] > 60.00) {
                    $qtdMetaPreSif1q++;
                }
                if ($rsInd1q['cobertura_citopatologico'] > 40.00) {
                    $qtdMetaCitop1q++;
                }
                if ($rsInd1q['hipertensao'] > 50.00) {
                    $qtdMetaHiper1q++;
                }
                if ($rsInd1q['diabetes'] > 50.00) {
                    $qtdMetaDiab1q++;
                }
            } while ($rsInd1q = mysqli_fetch_array($queryInd1q));
            $mediaPreCons1q = round(($somaPreCons1q / $rowsInd1q), 2);
            $mediaPreSif1q = round(($somaPreSif1q / $rowsInd1q), 2);
            $mediaCitop1q = round(($somaCitop1q / $rowsInd1q), 2);
            $mediaHiper1q = round(($somaHiper1q / $rowsInd1q), 2);
            $mediaDiab1q = round(($somaDiab1q / $rowsInd1q), 2);
            $metaPreCons1q = round(($qtdMetaPreCons1q / $ctPreCons1q) * 100, 2);
            $metaPreSif1q = round(($qtdMetaPreSif1q / $ctPreSif1q) * 100, 2);
            $metaCitop1q = round(($qtdMetaCitop1q / $ctCitop1q) * 100, 2);
            $metaHiper1q = round(($qtdMetaHiper1q / $ctHiper1q) * 100, 2);
            $metaDiab1q = round(($qtdMetaDiab1q / $ctDiab1q) * 100, 2);
        }

        //variáveis para média dos indicadores do 2o quadrimestre.
        $mediaPreCons2q = $mediaPreSif2q = $mediaCitop2q = $mediaHiper2q = $mediaDiab2q = $somaPreCons2q = $somaPreSif2q = $somaCitop2q = $somaHiper2q = $somaDiab2q = 0;
        $qtdMetaPreCons2q = $qtdMetaPreSif2q = $qtdMetaCitop2q = $qtdMetaHiper2q = $qtdMetaDiab2q = $metaPreCons2q = $metaPreSif2q = $metaCitop2q = $metaHiper2q = $metaDiab2q = 0;
        $ctPreCons2q = $ctPreSif2q = $ctCitop2q = $ctHiper2q = $ctDiab2q = 0;
        //média dos indicadores do 1o quadrimestre
        $sql2q = "SELECT * FROM medico m inner join desempenho d on d.cpf = m.cpf and d.ibge = m.ibge and m.cnes = m.cnes and d.ine = m.ine where ano = '$anoAtual' and d.idperiodo = 24 and substr(d.ibge,1,6) = '$ibge'";
        $q2q = mysqli_query($conn, $sql2q);
        $rows2q = mysqli_num_rows($q2q);

        $sqlInd2q = "SELECT * FROM `desempenho` where ano = '$anoAtual' and idperiodo = 24 and substr(ibge,1,6) = '$ibge'";
        $queryInd2q = mysqli_query($conn, $sqlInd2q);
        $rowsInd2q = mysqli_num_rows($queryInd2q);
        $rsInd2q = mysqli_fetch_array($queryInd2q);
        if ($rsInd2q) {
            do {
                $somaPreCons2q += $rsInd2q['prenatal_consultas'];
                $somaPreSif2q += $rsInd2q['prenatal_sifilis_hiv'];
                $somaCitop2q += $rsInd2q['cobertura_citopatologico'];
                $somaHiper2q += $rsInd2q['hipertensao'];
                $somaDiab2q += $rsInd2q['diabetes'];
                $ctPreCons2q++;
                $ctPreSif2q++;
                $ctCitop2q++;
                $ctHiper2q++;
                $ctDiab2q++;
                if ($rsInd2q['prenatal_consultas'] > 45.00) {
                    $qtdMetaPreCons2q++;
                }
                if ($rsInd2q['prenatal_sifilis_hiv'] > 60.00) {
                    $qtdMetaPreSif2q++;
                }
                if ($rsInd2q['cobertura_citopatologico'] > 40.00) {
                    $qtdMetaCitop2q++;
                }
                if ($rsInd2q['hipertensao'] > 50.00) {
                    $qtdMetaHiper2q++;
                }
                if ($rsInd2q['diabetes'] > 50.00) {
                    $qtdMetaDiab2q++;
                }
            } while ($rsInd2q = mysqli_fetch_array($queryInd2q));
            $mediaPreCons2q = round(($somaPreCons2q / $rowsInd2q), 2);
            $mediaPreSif2q = round(($somaPreSif2q / $rowsInd2q), 2);
            $mediaCitop2q = round(($somaCitop2q / $rowsInd2q), 2);
            $mediaHiper2q = round(($somaHiper2q / $rowsInd2q), 2);
            $mediaDiab2q = round(($somaDiab2q / $rowsInd2q), 2);
            $metaPreCons2q = round(($qtdMetaPreCons2q / $ctPreCons2q) * 100, 2);
            $metaPreSif2q = round(($qtdMetaPreSif2q / $ctPreSif2q) * 100, 2);
            $metaCitop2q = round(($qtdMetaCitop2q / $ctCitop2q) * 100, 2);
            $metaHiper2q = round(($qtdMetaHiper2q / $ctHiper2q) * 100, 2);
            $metaDiab2q = round(($qtdMetaDiab2q / $ctDiab2q) * 100, 2);
        }

        //variáveis para média dos indicadores do 3o quadrimestre.
        $mediaPreCons3q = $mediaPreSif3q = $mediaCitop3q = $mediaHiper3q = $mediaDiab3q = $somaPreCons3q = $somaPreSif3q = $somaCitop3q = $somaHiper3q = $somaDiab3q = 0;
        $qtdMetaPreCons3q = $qtdMetaPreSif3q = $qtdMetaCitop3q = $qtdMetaHiper3q = $qtdMetaDiab3q = $metaPreCons3q = $metaPreSif3q = $metaCitop3q = $metaHiper3q = $metaDiab3q = 0;
        $ctPreCons3q = $ctPreSif3q = $ctCitop3q = $ctHiper3q = $ctDiab3q = 0;
        //média dos indicadores do 1o quadrimestre
        $sql3q = "SELECT * FROM medico m inner join desempenho d on d.cpf = m.cpf and d.ibge = m.ibge and m.cnes = m.cnes and d.ine = m.ine where ano = '$anoAtual' and d.idperiodo = 25 and substr(d.ibge,1,6) = '$ibge'";
        $q3q = mysqli_query($conn, $sql3q);
        $rows3q = mysqli_num_rows($q3q);

        $sqlInd3q = "SELECT * FROM `desempenho` where ano = '$anoAtual' and idperiodo = 25 and substr(ibge,1,6) = '$ibge'";
        $queryInd3q = mysqli_query($conn, $sqlInd3q);
        $rowsInd3q = mysqli_num_rows($queryInd3q);
        $rsInd3q = mysqli_fetch_array($queryInd3q);
        if ($rsInd3q) {
            do {
                $somaPreCons3q += $rsInd3q['prenatal_consultas'];
                $somaPreSif3q += $rsInd3q['prenatal_sifilis_hiv'];
                $somaCitop3q += $rsInd3q['cobertura_citopatologico'];
                $somaHiper3q += $rsInd3q['hipertensao'];
                $somaDiab3q += $rsInd3q['diabetes'];
                $ctPreCons3q++;
                $ctPreSif3q++;
                $ctCitop3q++;
                $ctHiper3q++;
                $ctDiab3q++;
                if ($rsInd3q['prenatal_consultas'] > 45.00) {
                    $qtdMetaPreCons3q++;
                }
                if ($rsInd3q['prenatal_sifilis_hiv'] > 60.00) {
                    $qtdMetaPreSif3q++;
                }
                if ($rsInd3q['cobertura_citopatologico'] > 40.00) {
                    $qtdMetaCitop3q++;
                }
                if ($rsInd3q['hipertensao'] > 50.00) {
                    $qtdMetaHiper3q++;
                }
                if ($rsInd3q['diabetes'] > 50.00) {
                    $qtdMetaDiab3q++;
                }
            } while ($rsInd3q = mysqli_fetch_array($queryInd3q));
            $mediaPreCons3q = round(($somaPreCons3q / $rowsInd3q), 2);
            $mediaPreSif3q = round(($somaPreSif3q / $rowsInd3q), 2);
            $mediaCitop3q = round(($somaCitop3q / $rowsInd3q), 2);
            $mediaHiper3q = round(($somaHiper3q / $rowsInd3q), 2);
            $mediaDiab3q = round(($somaDiab3q / $rowsInd3q), 2);
            $metaPreCons3q = round(($qtdMetaPreCons3q / $ctPreCons3q) * 100, 2);
            $metaPreSif3q = round(($qtdMetaPreSif3q / $ctPreSif3q) * 100, 2);
            $metaCitop3q = round(($qtdMetaCitop3q / $ctCitop3q) * 100, 2);
            $metaHiper3q = round(($qtdMetaHiper3q / $ctHiper3q) * 100, 2);
            $metaDiab3q = round(($qtdMetaDiab3q / $ctDiab3q) * 100, 2);
        }
        $html = "";
        $html .= '<div class="col-md-4 shadow rounded mt-3 pt-2 pr-3 pl-3">';
        $html .= '<div class="row mt-2 pl-1">';
        $html .= '    <div class="col-md-12">';
        $html .= '        <h6 class="text-dark small font-weight-bold btn-sm">1º Quadrimestre: '. $rows1q .' Tutores.</h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<hr style="margin-top: -2%;">';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-12">';
        $html .= '       <h6 class="text-secondary small font-weight-bold text-center">Indicadores</h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd1">Pré-Natal  (6 consultas): ';
        $html .= '            <label ';
                        if ($mediaPreCons1q < 18.00) {
        $html .= '          class="text-danger font-weight-bold"';
                        } elseif ($mediaPreCons1q < 31.00) {
        $html .= '          class="text-warning font-weight-bold"';
                        } elseif ($mediaPreCons1q < 45.00) { 
        $html .= '          class="text-success font-weight-bold"';
                        } else {
        $html .= '          class="text-primary font-weight-bold"';
                        }
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $mediaPreCons1q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                        if ($qtdMetaPreCons1q > 0) {
        $html .= '         class="text-primary font-weight-bold"';
                        } else {
        $html .= '         class="text-danger font-weight-bold"';
                        }
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $metaPreCons1q) .'% atingiram a meta</label></h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd2">Pré-Natal (Sífilis e HIV): ';
        $html .= '           <label ';
                    if ($mediaPreSif1q < 24.00) {
        $html .= '            class="text-danger font-weight-bold"';
                    } elseif ($mediaPreSif1q < 42.00) {
        $html .= '            class="text-warning font-weight-bold"';
                    } elseif ($mediaPreSif1q < 60.00) {
        $html .= '            class="text-success font-weight-bold"';
                    } else {
        $html .= '            class="text-primary font-weight-bold"';
                    }
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $mediaPreSif1q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                    if ($qtdMetaPreSif1q > 0) {
        $html .= '            class="text-primary font-weight-bold"';
                    } else {
        $html .= '            class="text-danger font-weight-bold"';
                    }
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $metaPreSif1q) .'% atingiram a meta</label></h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd3">Cobertura Citopatológico: ';
        $html .= '            <label ';
                    if ($mediaCitop1q < 16.00) {
        $html .= '            class="text-danger font-weight-bold"';
                    } elseif ($mediaCitop1q < 28.00) {
        $html .= '            class="text-warning font-weight-bold"';
                    } elseif ($mediaCitop1q < 40.00) { 
        $html .= '            class="text-success font-weight-bold"';
                    } else {
        $html .= '            class="text-primary font-weight-bold"';
                    }
        $html .= '            >';
        $html .= '           '. str_replace(".", ",", $mediaCitop1q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                    if ($qtdMetaCitop1q > 0) { 
        $html .= '            class="text-primary font-weight-bold"';
                    } else { 
        $html .= '            class="text-danger font-weight-bold"';
                    }
        $html .= '            >';
        $html .= '          '. str_replace(".", ",", $metaCitop1q) .'% atingiram a meta</label></h6>';
        $html .= '   </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd4">Hipertensão (PA Aferida): ';
        $html .= '            <label ';
                        if ($mediaHiper1q < 20.00) { 
        $html .= '            class="text-danger font-weight-bold"';
                        } elseif ($mediaHiper1q < 35.00) { 
        $html .= '            class="text-warning font-weight-bold"';
                        } elseif ($mediaHiper1q < 50.00) {
        $html .= '            class="text-success font-weight-bold"';
                        } else { 
        $html .= '            class="text-primary font-weight-bold"';
                        } 
        $html .= '            >';
        $html .= '          '. str_replace(".", ",", $mediaHiper1q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                        if ($qtdMetaHiper1q > 0) { 
        $html .= '            class="text-primary font-weight-bold"';
                        } else {
        $html .= '            class="text-danger font-weight-bold"';
                        } 
        $html .= '            >';
        $html .= '          '. str_replace(".", ",", $metaHiper1q) .'% atingiram a meta</label></h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd5">Diabetes (Hemoglobina Glicada): ';
        $html .= '            <label ';
                    if ($mediaDiab1q < 20.00) {
        $html .= '            class="text-danger font-weight-bold"';
                    } elseif ($mediaDiab1q < 35.00) { 
        $html .= '            class="text-warning font-weight-bold"';
                    } elseif ($mediaDiab1q < 50.00) { 
        $html .= '            class="text-success font-weight-bold"';
                    } else { 
        $html .= '            class="text-primary font-weight-bold"';
                    }
        $html .= '            >';
        $html .= '     '. str_replace(".", ",", $mediaDiab1q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                    if ($qtdMetaDiab1q > 0) { 
        $html .= '            class="text-primary font-weight-bold"';
                    } else { 
        $html .= '            class="text-danger font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $metaDiab1q) .'% atingiram a meta</label></h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-4 shadow rounded mt-3 pt-2 pr-3 pl-3">';
        $html .= '<div class="row mt-3 pl-1">';
        $html .= '<div class="col-md-12">';
        $html .= '  <h6 class="text-dark small font-weight-bold">2º Quadrimestre: '. $rows2q .' Tutores.</h6>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<hr style="margin-top: -1%;">';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-12">';
        $html .= '        <h6 class="text-secondary small font-weight-bold text-center">Indicadores</h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd1">Pré-Natal  (6 consultas): ';
        $html .= '            <label ';
                    if ($mediaPreCons2q < 18.00) { 
        $html .= '            class="text-danger font-weight-bold"';
                    } elseif ($mediaPreCons2q < 31.00) { 
        $html .= '            class="text-warning font-weight-bold"';
                    } elseif ($mediaPreCons2q < 45.00) { 
        $html .= '            class="text-success font-weight-bold"';
                    } else { 
        $html .= '            class="text-primary font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $mediaPreCons2q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                    if ($qtdMetaPreCons2q > 0) { 
        $html .= '            class="text-primary font-weight-bold"';
                    } else { 
        $html .= '            class="text-danger font-weight-bold"';
                    } 
        $html .= '           >';
        $html .= '      '. str_replace(".", ",", $metaPreCons2q) .'% atingiram a meta</label></h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd2">Pré-Natal (Sífilis e HIV): ';
        $html .= '            <label ';
                    if ($mediaPreSif2q < 24.00) { 
        $html .= '            class="text-danger font-weight-bold"';
                    } elseif ($mediaPreSif2q < 42.00) { 
        $html .= '            class="text-warning font-weight-bold"';
                    } elseif ($mediaPreSif2q < 60.00) { 
        $html .= '            class="text-success font-weight-bold"';
                    } else { 
        $html .= '            class="text-primary font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '.str_replace(".", ",", $mediaPreSif2q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                    if ($qtdMetaPreSif2q > 0) {
        $html .= '            class="text-primary font-weight-bold"';
                    } else { 
        $html .= '            class="text-danger font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '.str_replace(".", ",", $metaPreSif2q) .'% atingiram a meta</label></h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd3">Cobertura Citopatológico: ';
        $html .= '            <label ';
                if ($mediaCitop2q < 16.00) { 
        $html .= '            class="text-danger font-weight-bold"';
                } elseif ($mediaCitop2q < 28.00) { 
        $html .= '            class="text-warning font-weight-bold"';
                } elseif ($mediaCitop2q < 40.00) { 
        $html .= '            class="text-success font-weight-bold"';
                } else { 
        $html .= '            class="text-primary font-weight-bold"';
                } 
        $html .= '        >';
        $html .= '      '. str_replace(".", ",", $mediaCitop2q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                    if ($qtdMetaCitop2q > 0) {
        $html .= '            class="text-primary font-weight-bold"';
                    } else { 
        $html .= '            class="text-danger font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $metaCitop2q) .'% atingiram a meta</label></h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd4">Hipertensão (PA Aferida): ';
        $html .= '            <label ';
                    if ($mediaHiper2q < 20.00) { 
        $html .= '            class="text-danger font-weight-bold"';
                    } elseif ($mediaHiper2q < 35.00) { 
        $html .= '            class="text-warning font-weight-bold"';
                    } elseif ($mediaHiper2q < 50.00) { 
        $html .= '            class="text-success font-weight-bold"';
                    } else { 
        $html .= '            class="text-primary font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $mediaHiper2q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                    if ($qtdMetaHiper2q > 0) { 
        $html .= '            class="text-primary font-weight-bold"';
                    } else { 
        $html .= '            class="text-danger font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $metaHiper2q) .'% atingiram a meta</label></h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd5">Diabetes (Hemoglobina Glicada): ';
        $html .= '            <label ';
                    if ($mediaDiab2q < 20.00) { 
        $html .= '            class="text-danger font-weight-bold"';
                    } elseif ($mediaDiab2q < 35.00) { 
        $html .= '            class="text-warning font-weight-bold"';
                    } elseif ($mediaDiab2q < 50.00) { 
        $html .= '            class="text-success font-weight-bold"';
                    } else { 
        $html .= '            class="text-primary font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $mediaDiab2q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                    if ($qtdMetaDiab2q > 0) {
        $html .= '            class="text-primary font-weight-bold"';
                    } else { 
        $html .= '            class="text-danger font-weight-bold"';
                    } 
        $html .= '           >';
        $html .= '      '. str_replace(".", ",", $metaDiab2q) .'% atingiram a meta</label></h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '  <div class="col-md-4 shadow rounded mt-3 pt-2 pr-3 pl-3">';
        $html .= '  <div class="row mt-3 pl-1">';
        $html .= '    <div class="col-md-12">';
        $html .= '        <h6 class="text-dark small font-weight-bold">3º Quadrimestre: '. $rows3q .' Tutores.</h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<hr style="margin-top: -1%;">';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-12">';
        $html .= '        <h6 class="text-secondary small font-weight-bold text-center">Indicadores</h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '   <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd1">Pré-Natal  (6 consultas): ';
        $html .= '            <label ';
                    if ($mediaPreCons3q < 18.00) { 
        $html .= '            class="text-danger font-weight-bold"';
                    } elseif ($mediaPreCons3q < 31.00) { 
        $html .= '            class="text-warning font-weight-bold"';
                    } elseif ($mediaPreCons3q < 45.00) { 
        $html .= '            class="text-success font-weight-bold"';
                    } else { 
        $html .= '            class="text-primary font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $mediaPreCons3q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                    if ($qtdMetaPreCons3q > 0) { 
        $html .= '            class="text-primary font-weight-bold"';
                    } else { 
        $html .= '            class="text-danger font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $metaPreCons3q) .'% atingiram a meta</label></h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd2">Pré-Natal (Sífilis e HIV): ';
        $html .= '            <label ';
                    if ($mediaPreSif3q < 24.00) { 
        $html .= '            class="text-danger font-weight-bold"';
                    } elseif ($mediaPreSif3q < 42.00) { 
        $html .= '            class="text-warning font-weight-bold"';
                    } elseif ($mediaPreSif3q < 60.00) { 
        $html .= '            class="text-success font-weight-bold"';
                    } else { 
        $html .= '            class="text-primary font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $mediaPreSif3q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                    if ($qtdMetaPreSif3q > 0) { 
        $html .= '            class="text-primary font-weight-bold"';
                    } else { 
        $html .= '            class="text-danger font-weight-bold"';
                    }
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $metaPreSif3q) .'% atingiram a meta</label></h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd3">Cobertura Citopatológico: ';
        $html .= '            <label ';
                    if ($mediaCitop3q < 16.00) { 
        $html .= '            class="text-danger font-weight-bold"';
                    } elseif ($mediaCitop3q < 28.00) { 
        $html .= '            class="text-warning font-weight-bold"';
                    } elseif ($mediaCitop3q < 40.00) { 
        $html .= '            class="text-success font-weight-bold"';
                    } else { 
        $html .= '            class="text-primary font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $mediaCitop3q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                    if ($qtdMetaCitop3q > 0) { 
        $html .= '            class="text-primary font-weight-bold"';
                    } else { 
        $html .= '            class="text-danger font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $metaCitop3q) .'% atingiram a meta</label></h6>';
        $html .= '   </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd4">Hipertensão (PA Aferida): ';
        $html .= '           <label ';
                    if ($mediaHiper3q < 20.00) {
        $html .= '            class="text-danger font-weight-bold"';
                    } elseif ($mediaHiper3q < 35.00) { 
        $html .= '            class="text-warning font-weight-bold"';
                    } elseif ($mediaHiper3q < 50.00) { 
        $html .= '            class="text-success font-weight-bold"';
                    } else { 
        $html .= '            class="text-primary font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $mediaHiper3q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                    if ($qtdMetaHiper3q > 0) { 
        $html .= '            class="text-primary font-weight-bold"';
                    } else { 
        $html .= '            class="text-danger font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '.  str_replace(".", ",", $metaHiper3q) .'% atingiram a meta</label></h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '<div class="row pl-1">';
        $html .= '    <div class="col-md-7">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;" data-toggle="modal" data-target=".qd5">Diabetes (Hemoglobina Glicada): ';
        $html .= '            <label ';
                    if ($mediaDiab3q < 20.00) { 
        $html .= '            class="text-danger font-weight-bold"';
                    } elseif ($mediaDiab3q < 35.00) { 
        $html .= '            class="text-warning font-weight-bold"';
                    } elseif ($mediaDiab3q < 50.00) { 
        $html .= '            class="text-success font-weight-bold"';
                    } else {
        $html .= '           class="text-primary font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $mediaDiab3q) .'%</label></h6>';
        $html .= '    </div>';
        $html .= '    <div class="col-md-5">';
        $html .= '        <h6 class="btn btn-light btn-sm form-control" style="font-size: 0.6em;">';
        $html .= '            <label ';
                    if ($qtdMetaDiab3q > 0) { 
        $html .= '            class="text-primary font-weight-bold"';
                    } else { 
        $html .= '            class="text-danger font-weight-bold"';
                    } 
        $html .= '            >';
        $html .= '      '. str_replace(".", ",", $metaDiab3q) .'% atingiram a meta</label></h6>';
        $html .= '    </div>';
        $html .= '</div>';
        $html .= '</div>';
        
    ?>
    <!-- Bootstrap core JavaScript-->
<!--    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

     Core plugin JavaScript
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

     Custom scripts for all pages
    <script src="../js/sb-admin-2.min.js"></script>

     Page level plugins 
    <script src="../vendor/chart.js/Chart.min.js"></script>
</body>
</html>-->
<?php echo $html; ?>