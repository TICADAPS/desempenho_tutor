<?php
require __DIR__ . "/../../vendor/autoload.php";
include '../../conexao-agsus.php';
include '../../conexao_agsus_2.php';
include '../../mask.php';

//var_dump($_POST);
$ano = isset($_POST['ano']) ? $_POST['ano'] : '';
$ciclo = isset($_POST['ciclo']) ? $_POST['ciclo'] : '';
//var_dump($_POST);
// Verificar se os dados foram recebidos corretamente
if ($ano !== '' && $ciclo !== '') {
    $sqlm = "select cpf, ibge, cnes, ine, flagenvio, flaginativo from competencias_profissionais where ano = '$ano' and ciclo = '$ciclo'";
    $querym = mysqli_query($conn, $sqlm) or die(mysqli_error($conn));
    $rsm = mysqli_fetch_array($querym);
    if($rsm){
        $auxexcel = 0;
        $html = '';
        do{
            date_default_timezone_set('America/Sao_Paulo');
            $dthrhoje = date('Y-m-d H:i:s');
            $cpf = $rsm['cpf'];
            $ibge = $rsm['ibge'];
            $cnes = $rsm['cnes'];
            $ine = $rsm['ine'];
            $flagenvio = $rsm['flagenvio'];
            if($flagenvio !== '1'){
                $flagenvio = '0';
            }
            $flaginativo = $rsm['flaginativo'];
            $sqld = "select * from demonstrativo where ano = '$ano' and ciclo = '$ciclo' and fkcpf = '$cpf' and fkibge = '$ibge' and fkcnes = '$cnes' and fkine = '$ine'";
            $queryd = mysqli_query($conn, $sqld) or die(mysqli_error($conn));
            $nrrsd = mysqli_num_rows($queryd);
            $rsd = mysqli_fetch_array($queryd);
            if($nrrsd > 0){
                do{
                    $iddemonstrativo = $rsd['iddemonstrativo'];
                    //update
                    if($flaginativo === '1'){
                        $sqlup = "update demonstrativo set competencias = '$flagenvio', flaginativo = 1 where iddemonstrativo = '$iddemonstrativo'";
                        $queryup = mysqli_query($conn, $sqlup) or die(mysqli_error($conn));
                    }else{
                        $sqlup = "update demonstrativo set competencias = '$flagenvio', flaginativo = null where iddemonstrativo = '$iddemonstrativo'";
                        $queryup = mysqli_query($conn, $sqlup) or die(mysqli_error($conn));
                    }
                }while($rsd = mysqli_fetch_array($queryd));
            }else{ 
                if($auxexcel === 0){
                    $html .= '<table>';
                    $html .= '<thead>';
                    $html .= ' <tr>';
                    $html .= ' <th colspan="10">TUTORES QUE PRECISAM SER CADASTRADOS NA TABELA DEMONSTRATIVO</th>';
                    $html .= ' </tr>';
                    $html .= ' <tr>';
                    $html .= '  <td>TUTOR</td>';
                    $html .= '  <td>CPF</td>';
                    $html .= '  <td>TIPOLOGIA</td>';
                    $html .= '  <td>MUNICÍPIO</td>';
                    $html .= '  <td>UF</td>';
                    $html .= '  <td>IBGE</td>';
                    $html .= '  <td>CNES</td>';
                    $html .= '  <td>INE</td>';
                    $html .= '  <td>AUTOAVALIAÇÃO REALIZADA?</td>';
                    $html .= '  <td>OBSERVAÇÃO</td>';
                    $html .= ' </tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';
                }
                $auxexcel++;
                $sql = "select distinct m.nome, m.admissao, m.cargo, m.tipologia, m.uf, m.municipio, 
                    m.datacadastro, m.cpf, m.ibge, m.cnes, m.ine, cp.flagenvio, cp.flaginativo 
                from medico m inner join competencias_profissionais cp on 
                m.cpf = cp.cpf and m.ibge = cp.ibge and m.cnes = cp.cnes and m.ine = cp.ine 
                where m.cpf = '$cpf' and m.ibge = '$ibge' and m.cnes = '$cnes' and m.ine = '$ine';";
                $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $nrrs = mysqli_num_rows($query);
                $rs = mysqli_fetch_array($query);
                if ($nrrs > 0) {
                    do {
                        $nome = $rs['nome'];
                        $cpftratado = $rs['cpf'];
                        $cpftratado = str_replace("-", "", $cpftratado);
                        $cpftratado = str_replace(".", "", $cpftratado);
                        $cpftratado = str_replace(".", "", $cpftratado);
                        $cpf = mask($cpftratado, "###.###.###-##");
                        $ibge = $rs['ibge'];
                        $admissao = $rs['admissao'];
                        $cargo = $rs['cargo'];
                        $tipologia = $rs['tipologia'];
                        $uf = $rs['uf'];
                        $municipio = $rs['municipio'];
                        $cnes = $rs['cnes'];
                        $ine = $rs['ine'];
                        $flagenvio = $rs['flagenvio'];
                        $flaginativo = $rs['flaginativo'];
                        $flagenviotxt = "NÃO";
                        if($flagenvio === '1'){
                            $flagenviotxt = "SIM";
                        }
                        $flaginativotxt = "";
                        if($flaginativo === '1'){
                            $flaginativotxt = "INATIVO EM COMPETÊNCIAS PROFISSIONAIS";
                        }
                        $html .= ' <tr>';
                        $html .= "  <td>$nome</td>";
                        $html .= "  <td>$cpf</td>";
                        $html .= "  <td>$tipologia</td>";
                        $html .= "  <td>$municipio</td>";
                        $html .= "  <td>$uf</td>";
                        $html .= "  <td>$ibge</td>";
                        $html .= "  <td>$cnes</td>";
                        $html .= "  <td>$ine</td>";
                        $html .= "  <td>$flagenviotxt</td>";
                        $html .= "  <td>$flaginativotxt</td>";
                        $html .= " </tr>";
                    } while ($rs = mysqli_fetch_array($query));
//                    echo "$nome, $cpf, $ibge, $cnes, $ine, $flaginativotxt \n";
                }
            }
        }while($rsm = mysqli_fetch_array($querym));
        if ($auxexcel > 0) {
            $html .= '</tbody>';
            $html .= '</table>';
            ini_set('memory_limit', '4096M');
            set_time_limit(1000);
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=arquivo.xlsx");
            header("Cache-Control: max-age=0");
            echo $html;
            exit;
        }else{
            echo "";
        }
    }else{
        echo "Erro: $querym";
    }
}else{
    echo "ano e ciclo vazios";
}
