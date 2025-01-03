<?php
session_start();
if(!isset($_SESSION['nome'])){
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"derruba_session.php\"'>";
    exit();
}
if(!isset($_SESSION['ibgeO'])){
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"derruba_session.php\"'>";
    exit();
}
if(!isset($_SESSION['cnes'])){
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"derruba_session.php\"'>";
    exit();
}
if(!isset($_SESSION['ine'])){
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"derruba_session.php\"'>";
    exit();
}
if(!isset($_SESSION['ano'])){
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"derruba_session.php\"'>";
    exit();
}
if(!isset($_SESSION['ciclo'])){
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"derruba_session.php\"'>";
    exit();
}
$_SESSION['nome'] = $_POST['nome'];
$_SESSION['ibgeO'] = $_POST['ibgeO'];
$_SESSION['cnes'] = $_POST['cnes'];
$_SESSION['ine'] = $_POST['ine'];
$_SESSION['ano'] = $_POST['ano'];
$_SESSION['ciclo'] = $_POST['ciclo'];

header("location: ../autoavaliacao/");
exit();