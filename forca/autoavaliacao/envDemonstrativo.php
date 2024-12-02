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
    $sqlm = "select distinct m.nome, m.admissao, m.cargo, m.tipologia, m.uf, m.municipio, 
        m.datacadastro, m.cpf, m.ibge, m.cnes, m.ine, cp.flagenvio, cp.flaginativo 
        from medico m inner join competencias_profissionais cp on 
        m.cpf = cp.cpf and m.ibge = cp.ibge and m.cnes = cp.cnes and m.ine = cp.ine 
        where cp.ano = '$ano' and cp.ciclo = '$ciclo' order by m.nome";
    $querym = mysqli_query($conn, $sqlm) or die(mysqli_error($conn));
    $rsm = mysqli_fetch_array($querym);
    if($rsm){
        $auxexcel = 0;
        $html = '';
        do{
            date_default_timezone_set('America/Sao_Paulo');
            $dthrhoje = date('Y-m-d H:i:s');
            $nome = $rsm['nome'];
            $cpf = $rsm['cpf'];
            $cpftratado = str_replace("'", "", $cpf);
            $cpftratado = str_replace("-", "", $cpftratado);
            $cpftratado = str_replace(".", "", $cpftratado);
            $cpftratado = str_replace(".", "", $cpftratado);
            $cpftratado = mask($cpftratado, "###.###.###-##");
            $admissao = $rsm['admissao'];
            $cargo = $rsm['cargo'];
            $tipologia = $rsm['tipologia'];
            $uf = $rsm['uf'];
            $municipio = $rsm['municipio'];
            $ibge = $rsm['ibge'];
            $cnes = $rsm['cnes'];
            $ine = $rsm['ine'];
            $flagenvio = $rsm['flagenvio'];
            $flagenviotxt = "NÃO";
            if($flagenvio !== '1'){
                $flagenvio = '0';
                $flagenviotxt = "SIM";
            }
            $flaginativo = $rsm['flaginativo'];
            $flaginativotxt = "";
            if ($flaginativo === '1'){
                $flaginativotxt = "INATIVO EM COMPETÊNCIAS PROFISSIONAIS";
            }
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
                    $html .= ' <th colspan="11">TUTORES QUE PRECISAM SER CADASTRADOS NA TABELA DEMONSTRATIVO</th>';
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
                    $html .= '  <td>QUALIDADE DA TUTORIA</td>';
                    $html .= '  <td>OBSERVAÇÃO</td>';
                    $html .= ' </tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';
                }
                $auxexcel++;
                $html .= ' <tr>';
                $html .= "  <td>$nome</td>";
                $html .= "  <td>$cpftratado</td>";
                $html .= "  <td>$tipologia</td>";
                $html .= "  <td>$municipio</td>";
                $html .= "  <td>$uf</td>";
                $html .= "  <td>$ibge</td>";
                $html .= "  <td>$cnes</td>";
                $html .= "  <td>$ine</td>";
                $html .= "  <td>$flagenviotxt</td>";
                $html .= "  <td></td>";
                $html .= "  <td>$flaginativotxt</td>";
                $html .= " </tr>";
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
            echo "Dados atualizados.";
        }
    }else{
        echo "Erro: $querym";
    }
}else{
    echo "ano e ciclo vazios";
}
