<?php
session_start();
if(!isset($_SESSION['msg'])){
    $_SESSION['msg']="";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Médicos - RH</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="css/estilo.css">
        <link rel="shortcut icon" href="./img/iconAdaps.png"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="shortcut icon" href="./img_agsus/iconAdaps.png"/>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/script.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-4 col-sm-6">
                    <img src="./img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-8 col-sm-6 mt-5 ">
                    <h3 class="mb-4">Cadastro de Médicos - Planilha do RH</h3>
                </div>
            </div>
            <div class="container bg-light mt-4 p-5 mx-auto col-md-8 col-sm-6">
                <div class="row">
                    <div class="col-12 col-md-8 col-sm-6 mx-auto">
                        <h5 class="mt-2"><a class="text-justify">*Importa a planilha e insere os dados na base de dados</a></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-8 col-sm-6 mx-auto">
                        <form method="post" enctype="multipart/form-data" action="importPlanilhaMedicosResp.php">
                            <h5 class="mt-2">Arquivo CSV:</h5>
                            <input type="file" class="form-control form-control-lg mb-2" name="arquivo">
                            <input type="submit" class="form-control form-control-lg mb-2 bnt btn-success" name="enviar" value="Enviar">
                        </form>
                    </div>
                    <div class="col-12 col-md-8 col-sm-6 mx-auto">
                        <?php
                        if($_SESSION['msg']!=""){
                            echo $_SESSION['msg'];
                            echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"2;
                                URL='importPlanilhaMedicosRH.php'\">";
                            $_SESSION['msg']="";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

