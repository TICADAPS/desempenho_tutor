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
            $uf = trim(utf8_encode($dados[5]));
            $municipio = trim(utf8_encode($dados[6]));
            $cnes = trim(utf8_encode($dados[7]));
            $ine = trim(utf8_encode($dados[8]));
            $ibge = trim(utf8_encode($dados[9]));
            $prenatal_consultas = trim(utf8_encode($dados[10]));
            $prenatal_sifilis_hiv= trim(utf8_encode($dados[11]));
            $cobertura_citopatologico = trim(utf8_encode($dados[12]));
            $hipertensao = trim(utf8_encode($dados[13]));
            $diabetes = trim(utf8_encode($dados[14]));
            $ano = trim(utf8_encode($dados[15]));
            $periodo = trim(utf8_encode($dados[16]));
            
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
            
            $municipio = str_replace("'", "", $municipio);
            $municipio = strtoupper($municipio);
            $municipio = str_replace("Á", "A", $municipio);
            $municipio = str_replace("É", "E", $municipio);
            $municipio = str_replace("Í", "I", $municipio);
            $municipio = str_replace("Ó", "O", $municipio);
            $municipio = str_replace("Ú", "U", $municipio);
            $municipio = str_replace("Ç", "C", $municipio);
            $municipio = str_replace("Ü", "U", $municipio);
            $municipio = str_replace("/", "", $municipio);
            $municipio = str_replace("-", "", $municipio);
            
            $uf = str_replace("'", "", $uf);
            $uf = strtoupper($uf);
            
            $tipologia = str_replace("'", "", $tipologia);
            $tipologia = strtoupper($tipologia);
            $tipologia = str_replace("Á", "A", $tipologia);
            $tipologia = str_replace("É", "E", $tipologia);
            $tipologia = str_replace("Í", "I", $tipologia);
            $tipologia = str_replace("Ó", "O", $tipologia);
            $tipologia = str_replace("Ú", "U", $tipologia);
            $tipologia = str_replace("Ç", "C", $tipologia);
            $tipologia = str_replace("Ü", "U", $tipologia);
            $tipologia = str_replace("/", "", $tipologia);
            $tipologia = str_replace("-", "", $tipologia);
            
            $cnes = str_replace("'", "", $cnes);
            $ine = str_replace("'", "", $ine);
            $ibge = str_replace("'", "", $ibge);
            $prenatal_consultas = str_replace("'", "", $prenatal_consultas);
            $prenatal_sifilis_hiv = str_replace("'", "", $prenatal_sifilis_hiv);
            $cobertura_citopatologico = str_replace("'", "", $cobertura_citopatologico);
            $hipertensao = str_replace("'", "", $hipertensao);
            $diabetes = str_replace("'", "", $diabetes);

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
//                    $hipertensao,$diabetes,$ano,$periodo,$datahoje<br>";
           
            $sql = "select * from medico where cpf = '$cpftratado' and ibge = '$ibge' and cnes = '$cnes' and ine = '$ine' limit 1";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $nrrs = mysqli_num_rows($query);
            if($nrrs==0){
                $sql2 = "insert into medico (cpf,ibge,cnes,ine,nome,admissao,cargo,tipologia,uf,municipio,datacadastro) "
                        . "values ('$cpftratado','$ibge','$cnes','$ine','$nome','$admissao','$cargo','$tipologia','$uf','$municipio','$datahoje')";
                mysqli_query($conn, $sql2) or die(mysqli_error($conn));
            }
            $sql4 = "select iddesempenho from desempenho where cpf = '$cpftratado' and ibge = '$ibge' and cnes = '$cnes' and ine = '$ine' and ano = '$ano' and idperiodo = '$periodo' limit 1";
            $query3 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));
            $nrrs3 = mysqli_num_rows($query3); 
            if($nrrs3 == 0){
                $sql2 = "insert into desempenho (ano,idperiodo,prenatal_consultas,prenatal_sifilis_hiv,cobertura_citopatologico,hipertensao,diabetes,cpf,ibge,cnes,ine,demonstrativo_ano,demonstrativo_ciclo) "
                        . "values ('$ano','$periodo','$prenatal_consultas','$prenatal_sifilis_hiv','$cobertura_citopatologico','$hipertensao','$diabetes','$cpftratado','$ibge','$cnes','$ine','$ano','2')";
                mysqli_query($conn, $sql2) or die(mysqli_error($conn));
            }else{
                echo "$cpftratado - $nome - $ibge - $cnes - $ine - Ano $ano e período $periodo cadastrado anteriormente<br>";
            }
        }
    }
}else{
    echo "Selecione o arquivo desejado.";
    header ("Location: importPlanilhaMedicos.php");
}

