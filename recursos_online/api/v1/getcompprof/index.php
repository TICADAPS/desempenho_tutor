<?php

require_once('../config.php');
require_once('../../libs/Database.php');

$mysql_options = [
    'host' => MYSQL_HOST,
    'database' => MYSQL_DATABASE,
    'username' => MYSQL_USERNAME,
    'password' => MYSQL_PASSWORD,
];

$ano = $_GET['a'];
$ciclo = $_GET['c'];

$db = new Database($mysql_options);
$results = $db->execute_query("select distinct cp.id, cp.flagenvemail, DATE_FORMAT(cp.dthrenvemail, '%d-%m-%Y %H:%i:%s') as dthrenvemail, 
m.nome, m.admissao, m.cargo, m.tipologia, m.uf, m.municipio, m.datacadastro, m.cpf, m.ibge, m.cnes,
m.ine, ivs.descricao as ivs, cp.flagenvio from medico m left join ivs on m.fkivs = ivs.idivs inner join competencias_profissionais cp on 
m.cpf = cp.cpf and m.ibge = cp.ibge and m.cnes = cp.cnes and m.ine = cp.ine where cp.ano = '$ano' and cp.ciclo = '$ciclo' order by m.nome");

echo json_encode($results, 128);