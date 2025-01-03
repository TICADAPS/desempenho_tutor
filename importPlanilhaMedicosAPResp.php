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
            $ibge = trim(utf8_encode($dados[1]));
            $cnes = trim(utf8_encode($dados[2]));
            $ine = trim(utf8_encode($dados[3]));
            $ano = trim(utf8_encode($dados[4]));
            $ciclo = trim(utf8_encode($dados[5]));
            
            $cpf = str_replace("'", "", $cpf);
            $ibge = str_replace("'", "", $ibge);
            $cnes = str_replace("'", "", $cnes);
            $ine = str_replace("'", "", $ine);
            $ano = str_replace("'", "", $ano);
            $ciclo = str_replace("'", "", $ciclo);

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
            $dthrhoje = date('Y-m-d H:i:s');
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
            $nrrs = mysqli_num_rows($query);
            if($nrrs==0){
                echo "$cpftratado - $nome - $ibge - $cnes - $ine - NÃO CADASTRADO NA TABELA MEDICO<br>";
            }
            $sql4 = "select id from aperfeicoamentoprofissional where cpf = '$cpftratado' and ibge = '$ibge' and cnes = '$cnes' and ine = '$ine' and ano = '$ano' and ciclo = '$ciclo' limit 1";
            $query3 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));
            $nrrs3 = mysqli_num_rows($query3); 
            if($nrrs3 === 0){
                $sql2 = "insert into aperfeicoamentoprofissional (cpf,ibge,cnes,ine,ano,ciclo,dthrcadastro) "
                        . "values ('$cpftratado','$ibge','$cnes','$ine','$ano','$ciclo','$dthrhoje')";
                mysqli_query($conn, $sql2) or die(mysqli_error($conn));
            }else{
                echo "$cpftratado - $ibge - $cnes - $ine - Ano $ano e ciclo $ciclo cadastrado anteriormente<br>";
            }
        }
    }
}else{
    echo "Selecione o arquivo desejado.";
    header ("Location: importPlanilhaMedicosAP.php");
}

