<?php
session_start();
include '../conexao-agsus.php';

$uf = $_GET['uf'];
$html = "";
?>
<!--<!DOCTYPE html>
<html>
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
    <body>-->
<?php
if($uf !== null && $uf !== ''){
    $sql = "SELECT distinct m.cod_munc, m.Municipio FROM municipio m inner join desempenho d on substr(d.ibge,1,6) = m.cod_munc where m.Estado_cod_uf = '$uf'";
    $query = mysqli_query($conn, $sql);
    $rs = mysqli_fetch_array($query);
    if($rs){
        do{
            $municipio = $rs['Municipio'];
            $cod_munc = $rs['cod_munc'];
            $html .= '<option value="'. $cod_munc .'">'. $municipio .'</option>';
        }while($rs = mysqli_fetch_array($query));
    }
}
?>
        <!-- Bootstrap core JavaScript-->
<!--    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

     Core plugin JavaScript
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

     Custom scripts for all pages
    <script src="../js/sb-admin-2.min.js"></script>

     Page level plugins 
    <script src="../vendor/chart.js/Chart.min.js"></script>-->
<?php
echo $html;
