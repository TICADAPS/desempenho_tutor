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
            ++$a;
            if($a <= 1){
                continue;
            }
            //captura cada item separado por vírgula na sequência
            $cpf = trim(utf8_encode($dados[0]));
            $nome = trim(utf8_encode($dados[1]));
            $admissao = trim(utf8_encode($dados[2]));
            $cargo = trim(utf8_encode($dados[3]));
            $tipologia = trim(utf8_encode($dados[4]));
            $ibge = trim(utf8_encode($dados[5]));
            $cnes = trim(utf8_encode($dados[6]));
            $ine = trim(utf8_encode($dados[7]));
            $ivs = trim(utf8_encode($dados[8]));
            
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
            
            $cpf = str_replace("'", "", $cpf);
            $admissao = str_replace("'", "", $admissao);
            $cargo = strtoupper($cargo);
            $cargo = str_replace("'", "", $cargo);
            $cargo = str_replace("'", "", $cargo);
            $cargo = str_replace("Á", "A", $cargo);
            $cargo = str_replace("É", "E", $cargo);
            $cargo = str_replace("Í", "I", $cargo);
            $cargo = str_replace("Ó", "O", $cargo);
            $cargo = str_replace("Ú", "U", $cargo);
            $cargo = str_replace("Ç", "C", $cargo);
            $cargo = str_replace("Ü", "U", $cargo);
            $cargo = str_replace("/", "", $cargo);
            $cargo = str_replace("-", "", $cargo);
            
            $cnes = str_replace("'", "", $cnes);
            $ine = str_replace("'", "", $ine);
            $ibge = str_replace("'", "", $ibge);
            $ivs = str_replace("'", "", $ivs);

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
//            echo "$a,$cpftratado,$nome,$admissao,$cargo,$tipologia,$uf,$municipio,$cnes,$ine,$ibge,
//                    $prenatal_consultas,$prenatal_sifilis_hiv,$cobertura_citopatologico,
//                    $hipertensao,$diabetes,2024,24,$datahoje<br>";
           
            $sql = "select * from medico where cpf = '$cpftratado' and ibge = '$ibge' and cnes = '$cnes' and ine = '$ine' limit 1";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $rs = mysqli_fetch_array($query);
            $nrrs = mysqli_num_rows($query);
            if($nrrs==0){
                $sqlmun = "select * from municipio m inner join estado e on m.Estado_cod_uf = e.cod_uf where cod_munc = '$ibge'";
                $qmun = mysqli_query($conn, $sqlmun) or die(mysqli_errno($conn));
                $rsmun = mysqli_fetch_array($qmun);
                if($rsmun){
                    do{
                        $mun = $rsmun['Municipio'];
                        $uf = $rsmun['UF'];
                    }while($rsmun = mysqli_fetch_array($qmun));
                }
                $sql2 = "insert into medico values ('$cpftratado','$ibge','$cnes','$ine','$ivs','$nome','$admissao','$cargo','$tipologia','$uf','$mun','$datahoje', null, null)";
                mysqli_query($conn, $sql2) or die(mysqli_error($conn));
                echo "$cpftratado - $nome - $ibge - $cnes - $ine - Cadastrado<br>";
            }else{
                do{
                    if($ivs !== '' && $ivs !== null){
                        $sql2 = "update medico set fkivs = '$ivs', admissao = '$admissao', tipologia = '$tipologia'  where cpf = '$cpftratado' and ibge = '$ibge' and cnes = '$cnes' and ine = '$ine'";
                        mysqli_query($conn, $sql2) or die(mysqli_error($conn));
                    }else{
                        $sql2 = "update medico set admissao = '$admissao', tipologia = '$tipologia'  where cpf = '$cpftratado' and ibge = '$ibge' and cnes = '$cnes' and ine = '$ine'";
                        mysqli_query($conn, $sql2) or die(mysqli_error($conn));
                    }
                    
                }while ($rs = mysqli_fetch_array($query));
            }
        }
    }
}else{
    echo "Selecione o arquivo desejado.";
    header ("Location: importPlanilhaMedicos.php");
}

