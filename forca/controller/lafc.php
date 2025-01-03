<?php
session_start();

if(!isset($_SESSION['perfil'])){
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"derruba_session.php\"'>";
    exit();
}
if(!isset($_SESSION['nivel'])){
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
        URL=\"derruba_session.php\"'>";
    exit();
}
$_SESSION['ano'] = $_POST['ano'];
$_SESSION['ciclo'] = $_POST['ciclo'];

header("location: ../abertura_ciclo/");
exit();
