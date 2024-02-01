<?php
//session_start();
include_once './conexao-agsus.php';

function validateCPF($cpf) {

    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}
//verifica se o arquivo não está vazio e captura o nome do arquivo e a extensão
if (!empty($_FILES["arquivo"]["tmp_name"])) {
    $arquivo = $_FILES["arquivo"]["tmp_name"];
    $nomearquivo = $_FILES["arquivo"]["name"];

    $ext = explode(".", $nomearquivo);

    $extensao = end($ext);

    //verifica se a extensão é csv
    if ($extensao !== "csv") {
        echo "<h6 class='mt-2 text-danger'>Extensão inválida!</h6>";
    } else {
        //Lê cada linha do arquivo
        $a=0;
        $objeto = fopen($arquivo, 'r');
        while(($dados = fgetcsv($objeto, 10000,","))!==FALSE){
            $a++;
            //captura cada item separado por vírgula na sequência
            $cpf = trim(utf8_encode($dados[0]));
            $nome = trim(utf8_encode($dados[1]));
            $notasenior = trim(utf8_encode($dados[3]));
            $notasispmb = trim(utf8_encode($dados[4]));
            $autosimnao = trim(utf8_encode($dados[5]));
            
            $nome = strtoupper($nome);
            $nome = str_replace("'", "", $nome);
            $nome = str_replace("Á", "A", $nome);
            $nome = str_replace("É", "E", $nome);
            $nome = str_replace("Í", "I", $nome);
            $nome = str_replace("Ó", "O", $nome);
            $nome = str_replace("Ú", "U", $nome);
            $nome = str_replace("Ç", "C", $nome);
            $nome = str_replace("Ü", "U", $nome);
            $nome = str_replace("/", "", $nome);
            $nome = str_replace("-", "", $nome);

            //formata a máscara do cpf (caso venha ou não com a máscara)
            $cpftratado = str_replace("-", "", $cpf);
            $cpftratado = str_replace(".", "", $cpftratado);
            $cpftratado = str_replace(".", "", $cpftratado);
            if (is_numeric($cpftratado)) {
                $qtdNr = 11 - (strlen($cpftratado));
                //echo "$cpf - ";
                if ($qtdNr > 0) {
                    for ($x = 0; $x < $qtdNr; $x++) {
                        $cpftratado = substr_replace($cpftratado, "0", 0, 0);
                    }
                }
//                $cpftratado = substr_replace($cpftratado, "-", 9, 0);
//                $cpftratado = substr_replace($cpftratado, ".", 6, 0);
//                $cpftratado = substr_replace($cpftratado, ".", 3, 0);
            } else {
                echo "<h6 class='mt-2'>Na linha $a, coluna 1: o conteúdo <label class='text-primary'>$cpftratado</label> deve ser CPF.</h6>";
                return;
            }
            date_default_timezone_set('America/Sao_Paulo');
            $datahoje = date('Y-m-d');
            $validaCpf = validateCPF($cpftratado);
            if($validaCpf === false){
                echo "<h6 class='mt-2'>Na linha $a, coluna 1: o conteúdo <label class='text-primary'>$cpftratado</label> inválido.</h6>";
                return;
            }
            
            $notasenior = str_replace(",", ".", $notasenior);
            $notasispmb = str_replace(",", ".", $notasispmb);
            if($autosimnao === 'Sim'){
                $autosimnao = 1;  
            }else{
                 $autosimnao = 0;  
            }
               
//            var_dump($a,$cpftratado,$nome,$notasenior,$notasispmb,$autosimnao);
//            var_dump($a,$cpftratado,$nome,$admissao,$cargo,$tipologia,$uf,$municipio,$cnes,$ine,$ibge,
//                    $prenatal_consultas,$prenatal_sifilis_hiv,$cobertura_citopatologico,
//                    $hipertensao,$diabetes,$ano,$periodo,$datahoje);
                        
            $sql = "select * from medico where cpf = '$cpftratado' limit 1";
            $query = mysqli_query($conn, $sql) or die(mysql0i_error($conn));
            $nrrs = mysqli_num_rows($query);
            if($nrrs > 0){
                echo "$a - passou aqui <br>";
                $linha = mysqli_fetch_array($query);
                do{
                    $cnes=$linha['cnes'];
                    $ibge=$linha['ibge'];
                    $ine=$linha['ine'];
                    $sqlq = "select * from qualidade where FKcpf = '$cpftratado' and FKibge = '$ibge' and FKcnes = '$cnes' and FKine = '$ine' limit 1";
                    $queryq = mysqli_query($conn, $sqlq) or die(mysqli_error($conn));
                    $nrrsq = mysqli_num_rows($queryq);
                    if($nrrsq === 0){
                        $sqliq = "insert into qualidade values (null, '$notasispmb', '$cpftratado','$ibge','$cnes','$ine','2024','1')";
                        mysqli_query($conn, $sqliq) or die(mysqli_error($conn));
                    }
                    $sqla = "select * from aperfeicoamento where medico_cpf = '$cpftratado' and medico_ibge = '$ibge' and medico_cnes = '$cnes' and medico_ine = '$ine' limit 1";
                    $querya = mysqli_query($conn, $sqla) or die(mysqli_error($conn));
                    $nrrsa = mysqli_num_rows($querya);
                    if($nrrsa === 0){
                        $sqlia = "insert into aperfeicoamento values (null, '$notasenior', '$cpftratado','$ibge','$cnes','$ine','2024','1')";
                        mysqli_query($conn, $sqlia) or die(mysqli_error($conn));
                    }
                    $sqlc = "select * from competencias where medico_cpf = '$cpftratado' and medico_ibge = '$ibge' and medico_cnes = '$cnes' and medico_ine = '$ine' limit 1";
                    $queryc = mysqli_query($conn, $sqlc) or die(mysqli_error($conn));
                    $nrrsc = mysqli_num_rows($queryc);
                    if($nrrsc === 0){
                        $sqlci = "insert into competencias values (null, '$autosimnao', '$cpftratado','$ibge','$cnes','$ine','2024','1')";
                        mysqli_query($conn, $sqlci) or die(mysqli_error($conn));
                    }
                }while($linha = mysqli_fetch_array($query));
            }
        }
    }
}else{
    echo "Selecione o arquivo desejado.";
    header ("Location: importPlanilhaMedicos.php");
}

