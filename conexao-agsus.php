<?php
$servidor = "localhost";
<<<<<<< HEAD
$usuario = "u226895969_marcelo_ADAPS";
$senha = "Senha10adaps";
$dbname = "avaliacaodesempenho";
=======
$usuario = "u226895969_aval_tutor";
$senha = "Senha10adaps";
$dbname = "u226895969_desemp_tutor";
>>>>>>> devRicardo

//Criar a conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname) or die("Banco de dados fora do ar");