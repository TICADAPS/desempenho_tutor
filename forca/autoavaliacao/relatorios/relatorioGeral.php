<?php
include '../../../conexao-agsus.php';
include '../../../Controller_agsus/maskCpf.php';
include '../../../Controller_agsus/fdatas.php';
require __DIR__ . "/../../../source/autoload.php";

ini_set('memory_limit', '4096M');
set_time_limit(1000);

$ano = $_GET['a'];
$ciclo = $_GET['c'];
$sql = "select distinct m.nome, m.admissao, m.cargo, m.tipologia, m.uf, m.municipio, m.datacadastro, m.cpf, m.ibge, m.cnes,
 m.ine, ivs.descricao as ivs from medico m left join ivs on m.fkivs = ivs.idivs inner join competencias_profissionais cp on 
m.cpf = cp.cpf and m.ibge = cp.ibge and m.cnes = cp.cnes and m.ine = cp.ine where cp.ano = '$ano' and cp.ciclo = '$ciclo' order by m.nome";
$query = mysqli_query($conn, $sql);
$nrrs = mysqli_num_rows($query);
$rs = mysqli_fetch_array($query);

$piformatado = vemdata($pi);
$pfformatado =  vemdata($pf);
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Passagem</title>
        
    </head>
    <body>
<?php
// nome do arquivo que será exportado
$arquivo = "RelatorioPassagem_$piformatado\_a\_$pfformatado.xlsx";
$x = $y = 0;
$valorTotal = 0;
$somaDebitos = 0;
$somaTotal = 0;
$html = '<table border=1>';
$html .= '<tr>';
$html .= "<th colspan='3'>Tutoria - Período $piformatado a $pfformatado</th>";
$html .= "<th colspan='17' rowspan='3'></th>";
$html .= '</tr>';
$html .= '<tr>';
$html .= "<th colspan='3'>Pagamento de Passagens</th>";
$html .= '</tr>';
$html .= '<tr>';
$html .= "<th colspan='3'>Pagamento realizado em </th>";
$html .= '</tr>';
$html .= '<tr>';
$html .= "<th colspan='19'>Relatório de Passagens Referente ao Período $piformatado a $pfformatado</th>";
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Nr</th>';
$html .= '<th>Médico Bolsista</th>';
$html .= '<th>CPF Bolsista</th>';
$html .= '<th>Município de Origem</th>';
$html .= '<th>Municícpio de Tutoria</th>';
$html .= '<th>Período de Tutoria(Início e Fim)</th>';
$html .= '<th>Participou?</th>';
$html .= '<th>Justificativa</th>';
$html .= '<th>Data Embarque</th>';
$html .= '<th>Trecho de Origem</th>';
$html .= '<th>Trecho de Destino</th>';
$html .= '<th>Modal de Transporte</th>';
$html .= '<th>Empresa de Transporte</th>';
$html .= '<th>Valor da Passagem por trecho (R$)</th>';
$html .= '<th>Abatimento de Crédito (R$)</th>';
$html .= '<th>Tipo de Crédito</th>';
$html .= '<th>Referente ao período</th>';
$html .= '<th>Data/hora utilização</th>';
$html .= '<th>Usuário que cadastrou</th>';
$html .= '<th>Deslocamento por meios próprios pagos pela ADAPS (trechos de origem e destino)</th>';
$html .= '</tr>';

$result_transacoes = "select l.idlogistica, m.NomeMedico,concat(m1.Municipio,' - ',e1.UF) as Origem, concat(m2.Municipio,' - ',e2.UF) as Destino,
concat(date_format(l.PeriodoInicial,'%d-%m-%Y'),' a ', date_format(l.PeriodoFinal,'%d-%m-%Y')) as PeriodoDeTutoria,
l.FlagRealizouTutoria, l.JustificativaTutoria,
m.CpfMedico,p.municipioorigem,p.uforigem,p.dataembarque,p.municipiodestino,p.ufdestino,p.tipotransporte,p.empresa,p.valordeslocamento,
de.valordebitado,tc.tipo as tipocredito,de.datahoradebito,u.nome_user
from medico m
inner join logistica l on l.idMedico = m.idMedico
inner join municipio m1 on l.origemibge = m1.cod_munc 
inner join estado e1 on m1.Estado_cod_uf = e1.cod_uf
inner join municipio m2 on l.destinoibge = m2.cod_munc
inner join estado e2 on m2.Estado_cod_uf = e2.cod_uf
inner join passagem p on p.idlogistica = l.idlogistica
left join debito de on de.idpassagem = p.idpassagem
left join usuarios u on u.id_user = de.idusuariodebitado
left join credito c on c.idcredito = de.idcredito
left join tipocredito tc on c.idtipocredito = tc.idtipocredito
where l.PeriodoInicial = '$pi' and l.PeriodoFinal = '$pf' and p.flaginativo = 0 order by m.NomeMedico, p.dataembarque;";

$query = mysqli_query($conn, $result_transacoes) or die(mysqli_errno($conn));
while ($row_transacoes = mysqli_fetch_assoc($query)) {
    $idlogistica = $row_transacoes['idlogistica'];
    $x++;
    $html .= '<tr>';
    $html .= '<td>' . $x . "</td>";
    $html .= '<td>' . $row_transacoes['NomeMedico'] . "</td>";
    $html .= '<td>' . $row_transacoes['CpfMedico'] . "</td>";
    $html .= '<td>' . $row_transacoes['Origem'] . "</td>";
    $html .= '<td>' . $row_transacoes['Destino'] . "</td>";
    $html .= '<td>' . $row_transacoes['PeriodoDeTutoria']. "</td>";
    $html .= '<td>' . $row_transacoes['FlagRealizouTutoria'] . "</td>";
    $html .= '<td>' . $row_transacoes['JustificativaTutoria'] . "</td>";
    $html .= '<td>' . vemdata($row_transacoes['dataembarque']) . "</td>";
    $html .= '<td>' . $row_transacoes['municipioorigem'].'-'.$row_transacoes['uforigem'] . "</td>";
    $html .= '<td>' . $row_transacoes['municipiodestino'].'-'.$row_transacoes['ufdestino'] . "</td>";
    $html .= '<td>' . $row_transacoes['tipotransporte'] . "</td>";
    $html .= '<td>' . $row_transacoes['empresa'] . "</td>";
    $html .= '<td>' . str_replace('.', ',', number_format($row_transacoes['valordeslocamento'], 2, '.', '')). "</td>";
    $html .= '<td>' . str_replace('.', ',', number_format($row_transacoes['valordebitado'], 2, '.', '')) . "</td>";
    $html .= '<td>' . $row_transacoes['tipocredito'] . "</td>";
    $pic = $pfc = null;
    if($row_transacoes['valordebitado'] !== null || !empty($row_transacoes['valordebitado'])){
        $idcreditoorigem = $row_transacoes['idcreditoorigem'];
        $sqlcredito = "select PeriodoInicial, PeriodoFinal from logistica inner join credito on credito.idlogistica = logistica.idlogistica"
                . " where credito.idcredito =  '$idcreditoorigem'";
        $querycredito = mysqli_query($conn, $sqlcredito);
        while($row_credito = mysqli_fetch_assoc($querycredito)){
            $pic = vemdata($row_credito['PeriodoInicial']);
            $pfc = vemdata($row_credito['PeriodoFinal']);
        }
    }
    if($pic !== null){
        $html .= "<td>$pic a $pfc</td>";
    }else{
        $html .= "<td></td>";
    }
    $html .= '<td>' . $row_transacoes['datahoradebito'] . "</td>";
    $html .= '<td>' . $row_transacoes['nome_user'] . "</td>";
    $sqlDeslocamento = "select * from deslocamentoveiculo where idlogistica = '$idlogistica' and flagInativo = 0";
    $queryDeslocamento = mysqli_query($conn, $sqlDeslocamento) or die(mysqli_errno($conn));
    $nrlinhasDes = mysqli_num_rows($queryDeslocamento);
    $rsDeslocamento = mysqli_fetch_array($queryDeslocamento);
    $trechoDeslocamento = "";
    if($nrlinhasDes > 0){
        if($nrlinhasDes === 1){
            do{
                $trechoDeslocamento = $rsDeslocamento['municipioorigem']."-".$rsDeslocamento['uforigem']." a ".$rsDeslocamento['municipiodestino']."-".$rsDeslocamento['ufdestino'];
            }while ($rsDeslocamento = mysqli_fetch_array($queryDeslocamento));
        }else{
            do{
                $trechoDeslocamento .= $rsDeslocamento['municipioorigem']."-".$rsDeslocamento['uforigem']." a ".$rsDeslocamento['municipiodestino']."-".$rsDeslocamento['ufdestino'].PHP_EOL."; ";
            }while ($rsDeslocamento = mysqli_fetch_array($queryDeslocamento));
        }
    }
    $html .= '<td>' . $trechoDeslocamento . "</td>";
    $html .= '</tr>';
    $valorTotal = $row_transacoes['valordeslocamento'] + $valorTotal;
    $somaTotal += $row_transacoes['valordeslocamento'];
    if($row_transacoes['valordebitado'] !== null || !empty($row_transacoes['valordebitado'])){
        $valorTotal -= $row_transacoes['valordebitado'];
        $somaDebitos += $row_transacoes['valordebitado'];
    }
    $valorTotaltxt = "".$valorTotal;
}
$html .= '<td colspan="11"><b>VALOR TOTAL DAS PASSAGENS</b></td>';
$html .= '<td><b>'.str_replace('.', ',', number_format($somaTotal, 2, '.', ''))."</b></td>";
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="12"><b>VALOR TOTAL DE CRÉDITOS UTILIZADOS</b></td>';
$html .= '<td><b>'.str_replace('.', ',', number_format($somaDebitos, 2, '.', ''))."</b></td>";
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="11"><b>VALOR TOTAL DAS PASSAGENS</b></td>';
$html .= '<td><b>'.str_replace('.', ',', number_format($valorTotal, 2, '.', ''))."</b></td>";
$html .= '</tr>';
$html .= '</table>';

$html .= '<table border=0>';
$html .= '<tr>';
$html .= '<td><td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td><td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td><td>';
$html .= '</tr>';
$html .= '</table>';
$html .= '<table border=1>';
$html .= '<tr>';
$html .= "<th colspan='18'>BOLSISTAS QUE ESTAVAM NA FATURA, MAS FORAM RETIRADOS</th>";
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Nr</th>';
$html .= '<th>Médico Bolsista</th>';
$html .= '<th>CPF Bolsista</th>';
$html .= '<th>Município de Origem</th>';
$html .= '<th>Municícpio de Tutoria</th>';
$html .= '<th>Período de Tutoria(Início e Fim)</th>';
$html .= '<th>Participou?</th>';
$html .= '<th>Justificativa</th>';
$html .= '<th>Trecho de Origem</th>';
$html .= '<th>Data Embarque</th>';
$html .= '<th>Trecho de Destino</th>';
$html .= '<th>Modal de Transporte</th>';
$html .= '<th>Empresa de Transporte</th>';
$html .= '<th>Valor da Passagem (R$)</th>';
$html .= '<th>Participou?</th>';
$html .= '<th>Justificativa do Tutor</th>';
$html .= '<th>Pendência Lançada</th>';
$html .= '<th>Observação inserida na Pendência</th>';
$html .= '<th>Resposta da Pendência</th>';
$html .= '</tr>';

$result_t2 = "select l.idlogistica, m.NomeMedico,concat(m1.Municipio,' - ',e1.UF) as Origem, concat(m2.Municipio,' - ',e2.UF) as Destino,
concat(date_format(l.PeriodoInicial,'%d-%m-%Y'),' a ', date_format(l.PeriodoFinal,'%d-%m-%Y')) as PeriodoDeTutoria,
l.FlagRealizouTutoria, l.JustificativaTutoria,
m.CpfMedico,p.municipioorigem,p.uforigem,p.dataembarque,p.municipiodestino,p.ufdestino,p.tipotransporte,p.empresa,p.valordeslocamento, 
sl.situacao, l.FlagRealizouTutoria as flagR, l.JustificativaTutoria as justif, lsas.idlsas, lsas.observacao, 
rls.resposta
from medico m
inner join logistica l on l.idMedico = m.idMedico
inner join municipio m1 on l.origemibge = m1.cod_munc 
inner join estado e1 on m1.Estado_cod_uf = e1.cod_uf
inner join municipio m2 on l.destinoibge = m2.cod_munc
inner join estado e2 on m2.Estado_cod_uf = e2.cod_uf
inner join passagem p on p.idlogistica = l.idlogistica 
inner join logisticaservicoareasituacao lsas on lsas.idlogistica = l.idlogistica 
inner join situacaologistica sl on sl.idsituacaologistica = lsas.idsituacaologistica 
left join respostalsas as rls on rls.idlsas = lsas.idlsas
where l.PeriodoInicial = '$pi' and l.PeriodoFinal = '$pf' and p.flaginativo = 1 
and l.FlagRealizouTutoria = 'Não' and (p.onus is null and p.onusposterior is null) order by m.NomeMedico;";

$query2 = mysqli_query($conn, $result_t2) or die(mysqli_errno($conn));
while ($row_t = mysqli_fetch_assoc($query2)) {
    $y++;
    $html .= '<tr>';
    $html .= '<td>' . $y . "</td>";
    $html .= '<td>' . $row_t['NomeMedico'] . "</td>";
    $html .= '<td>' . $row_t['CpfMedico'] . "</td>";
    $html .= '<td>' . $row_t['Origem'] . "</td>";
    $html .= '<td>' . $row_t['Destino'] . "</td>";
    $html .= '<td>' . $row_t['PeriodoDeTutoria']. "</td>";
    $html .= '<td>' . $row_t['FlagRealizouTutoria'] . "</td>";
    $html .= '<td>' . $row_t['JustificativaTutoria'] . "</td>";
    $html .= '<td>' . $row_t['municipioorigem'].'-'.$row_t['uforigem'] . "</td>";
    $html .= '<td>' . vemdata($row_t['dataembarque']) . "</td>";
    $html .= '<td>' . $row_t['municipiodestino'].'-'.$row_t['ufdestino'] . "</td>";
    $html .= '<td>' . $row_t['tipotransporte'] . "</td>";
    $html .= '<td>' . $row_t['empresa'] . "</td>";
    $html .= '<td>' . str_replace('.', ',', number_format($row_t['valordeslocamento'], 2, '.', '')). "</td>";
    $html .= '<td>' . $row_t['FlagRealizouTutoria'] . "</td>";
    $html .= '<td>' . $row_t['JustificativaTutoria'] . "</td>";
    $html .= '<td>' . $row_t['situacao'] . "</td>";
    $html .= '<td>' . $row_t['observacao'] . "</td>";
    $idlsas = $row_t['idlsas'];
    $respAll = (new Source\Models\RespostaLSAS())->findPorIdlsas($idlsas);
    $resp = "";
    if($respAll !== null){
        foreach ($respAll as $re){
            $resp = $re->resposta." ";
        }
    }
    $html .= '<td>' . $resp . "</td>";
    $html .= '</tr>';
}
$html .= '</table>';

    // configurações header para forçar o download
    header("Expires: Mon, 30 Out 2099 10:00:00 GMT");
    header("Last-Modified: ". gmdate("D,d M YH:i:s")." GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-type: application/x-msexcel");
    header("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
    header("Content-Description: PHP Generated Data" );
      
    // envia o conteúdo do arquivo
    echo $html;
    exit;
?>
    </body>
</html>