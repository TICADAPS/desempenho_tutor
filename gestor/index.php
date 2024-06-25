<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação de desempenho do médico tutor</title>
    <link rel="shortcut icon" href="./../img_agsus/iconAdaps.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-4 mt-4 pl-5">
                <img src="../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
            </div>
            <div class="col-12 col-md-8 mt-4 ">
                <h4 class="mb-4 font-weight-bold text-center">Evolução da Qualidade Assistencial</h4>
                <h4 class="mb-4 font-weight-bold text-center">Programa de Avaliação de Desempenho do Médico Tutor</h4>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col">
                <h4>Selecione o Estado</h4>
                <hr>
                <select id="select_estado" class="form-select w-50">
                    <option value="0">[--SELECIONE--]</option>
                </select>

                <div id="municipio_posts"></div>
                <p class="text-center d-none mt-3 opacity-50" id="no_posts">Não existe município nesta opção.</p>

                <div id="medico_posts"></div>
                <p class="text-center d-none mt-3 opacity-50" id="no_posts_medico">Não existe médico neste município.</p>
                <div id="btnAvaliacao"></div>
            </div>
        </div>
    </div>
    <br>
    <br><br>
    <?php include '../includes/footer.php' ?>
    <script src="app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>