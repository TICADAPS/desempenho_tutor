<?php
$servidor = "localhost";
$usuario = "u226895969_marcelo_ADAPS";
$senha = "Senha10adaps";
$dbname = "avaliacaodesempenho";

//Criar a conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname) or die("Banco de dados fora do ar");