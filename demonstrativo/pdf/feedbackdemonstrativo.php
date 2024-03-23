<?php
include_once("../../conexao-agsus.php");
ini_set('memory_limit', '1024M');
set_time_limit(200);

$nome = $_GET['nome'];
$ano = $_GET['ano'];
$qatext = $_GET['qa'];
$qnotatext = $_GET['qnota'];
$anotatext = $_GET['anota'];
$mftext = $_GET['mftext'];
//referenciar o DomPDF com namespace
use Dompdf\Dompdf;

// include autoloader
require_once("./../../vendor/autoload.php");

//Criando a Instancia
$dompdf = new DOMPDF();
$dompdf->setPaper('A4', 'landscape'); //Paisagem
$path = './../../img_agsus/Logo_400x200.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

$html = "";
$html .= "<div style='margin-bottom: 30px; text-align: center;'><img src='$base64' width='300' /></div>";
$html .= "<h3 style='text-align: center; margin-top: 30px; margin-bottom:40px;'>PROGRAMA DE AVALIAÇÃO DE DESEMPENHO TUTOR MÉDICO $ano</h3>";
$html .= "<p>Prezado(a) Tutor(a) $nome,</p>";
$html .= "<p style='text-align: justify;'>Parabéns pelo seu primeiro ano de dedicação ao Programa Médicos pelo Brasil! A partir de agora, sua atuação como tutor será avaliada continuamente.</p>";
$html .= "<p style='text-align: justify;'>Apresentamos o resultado individual da sua Avaliação de Desempenho Individual, referente ao 1º Ciclo  de 2023, que compreendeu o período de julho a dezembro de 2023. Essa avaliação se constituiu como uma importante ferramenta para avaliar o desempenho dos empregados desta Agência, reconhecendo pontos fortes e identificando oportunidades de aprimoramento.</p>";
$html .= "<p style='text-align: justify;'>A avaliação foi conduzida com base nos critérios previamente definidos na Portaria n.º 26, de 28 de fevereiro de 2023, que institui o Programa de Avaliação de Desempenho para o cargo de Tutor Médico.</p>";
$html .= "<p style='text-align: justify;'>Importante ressaltar que a Avaliação de Desempenho é uma expressão do nosso compromisso em promover uma cultura de gestão focada no desempenho profissional, visando fortalecer a Atenção Primária à Saúde (APS) no Brasil. Este processo está vinculado a incentivos financeiros variáveis, reconhecendo seu desempenho individual e incentivando a contínua melhoria nos serviços de saúde prestados à população.</p>";
$html .= "<p style='text-align: justify;'>Sendo assim, a Avaliação de Desempenho é estruturada em dois eixos principais: Avaliação de Resultados e Avaliação de Competências, subdivididos em domínios que abrangem tanto as especificidades técnicas profissionais relacionadas às atividades do cargo, quanto às características comportamentais relacionadas à interação com a equipe, gestão municipal, ambiente de trabalho e instituição, neste contexto você alcançou a Nota Geral <label style='color: red;'>$mftext</label>.</p>";
$html .= "<p>Domínios avaliados e resultados:</p>";
$html .= "<dl>1. Eixo I - Avaliação de Resultados";
$html .= "  <dt>1. Qualidade Assistencial: </dt>";
$html .= "      <dd>1. Foi mensurado por de indicadores de boa performance na assistência à população, incluem a realização de no mínimo:";
$html .= "          <br><ddd>1.1. Seis consultas pré-natal com gestantes, </ddd>";
$html .= "          <br><ddd>1.2. Pedidos proporcionais de exames para sífilis e HIV, </ddd>";
$html .= "          <br><ddd>1.3. Proporção de mulheres com coleta de Citopatológico, </ddd>";
$html .= "          <br><ddd>1.4. Proporção de consultas relacionadas a pessoas com diabetes e solicitação de hemoglobina glicada e </ddd>";
$html .= "          <br><ddd>1.5. Proporção de pessoas com hipertensão, com consulta e pressão arterial aferida no semestre. </ddd>";
$html .= "      <dd style='text-align: justify;'>Os indicadores têm como unidade de análise o indivíduo e avaliam aspectos do cuidado em saúde dispensado de forma individualizada. É sabido que a responsabilidade pela realização das ações de saúde pela equipe é compartilhada com a gestão municipal, pois a mesma atua na manutenção dos recursos necessários e suporte para o adequado funcionamento da estrutura assistencial na qual o empregado está inserido. No entanto, considera-se que a escolha desse conjunto de indicadores, por ser fruto de processo de pactuação tripartite, pressupõe a implicação e compromisso da gestão municipal na busca por resultados</dd>";
$html .= "      <dd style='text-align: justify;'>2. O seu resultado nesse domínio alcançou a Nota <label style='color: red;'>$qatext</label>, você poderá obter de forma detalhada a mensuração de cada indicador acessando o link https://agsusbrasil.org/sistema-integrado/login.php onde terá a evolução dos indicadores ao longo dos três quadrimestres de 2023.</dd>";
$html .= "  <dt>2. Qualidade da Tutoria:</dt>";
$html .= "      <dd style='text-align: justify;'>1. A tutoria será avaliada a partir da verificação de um conjunto de evidências relacionadas às atribuições do Tutor Médico no processo de realização do estágio experimental remunerado. Consiste, portanto, na opinião do bolsista em relação às vivências de tutoria clínica. Ter uma tutoria clínica efetiva e com a qualidade esperada é fundamental para o desenvolvimento das competências necessárias para o trabalho na APS. A aferição da qualidade da tutoria foi feita com base em dados fornecidos pelos bolsistas vinculados e assistidos por cada tutor.</dd>";
$html .= "      <dd style='text-align: justify;'>2. A mensuração deste domínio com base na avaliação dos bolsistas vinculados foi <label style='color: red;'>$qnotatext</label>.</dd>";
$html .= "  <dt>3. Aperfeiçoamento Profissional:</dt>";
$html .= "      <dd style='text-align: justify;'>1. O domínio aperfeiçoamento profissional está conectado com as atividades do Plano de Educação Continuada. O PEC organiza, por meio de um sistema de créditos, o estímulo ao desenvolvimento contínuo de competências técnicas e comportamentais desses empregados, a partir da realização de atividades de qualificação clínica e de gestão, ensino, pesquisa, extensão e inovação tecnológica. Para tanto adotou-se o sistema de créditos como base para a verificação e julgamento do desempenho esperado. Os critérios e pesos das atividades de curta duração estão divulgados na Instrução Normativa nº 002/2023 - Plano de Educação Continuada para os Médicos da Adaps.</dd>";
$html .= "      <dd style='text-align: justify;'>2. Com base na creditação atribuída aos documentos que você inseriu na plataforma sênior, você alcançou a pontuação de <label style='color: red;'>$anotatext</label>.</dd>";
$html .= "</dl>";
$html .= "<dl>2. Eixo II - Avaliação de Competências:";
$html .= "  <dt>1. Competências Profissionais</dt>";
$html .= "      <dd style='text-align: justify;'>1. Trata de um conjunto de características e capacidades que podem ajudar o empregado a alcançar com maior facilidade as entregas esperadas pela instituição. O instrumento para avaliação de competências é composto de nove domínios que dão conta de aspectos técnicos, que permeiam a execução das atividades clínicas do médico na APS, mas também de aspectos transversais que correspondem aos comportamentos e atitudes ligadas ao contexto de trabalho.</dd>";
$html .= "</dl>";
$html .= "<p style='text-align: right; margin-top: 40px;'>Agência Brasileira de Apoio à Gestão do Sistema Único de Saúde - AgSUS</p>";


// Carrega seu HTML
$dompdf->load_html('<h3 style="text-align: center;"></h3>' . $html);

//Renderizar o html
$dompdf->render();

//Exibibir a página
$dompdf->stream(
    "relatorio_agsus.pdf", array(
        "Attachment" => false //Para realizar o download somente alterar para true
    )
);
