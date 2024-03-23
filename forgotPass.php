<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

if (isset($_POST['key']) && $_POST['email'] !== "") {

    $email = $_POST["email"];
    $token = uniqid();
    $subject = "Pedido de troca de senha";
    require_once "./validacao-acesso/config.php";

    $query = "SELECT * FROM medico WHERE email = :email AND flagInativo = 0";
    if ($stmt = $pdo->prepare($query)) {
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            $sql = 'INSERT INTO forgot_pass (user_email, user_token) VALUES (?, ?)';
            $stm = $pdo->prepare($sql);
            $stm->bindParam(1, $email, PDO::PARAM_STR);
            $stm->bindParam(2, $token, PDO::PARAM_STR);
            $stm->execute();
            $id = $pdo->lastInsertId();


            $href = "http://localhost/sistema-adaps/changePass.php?ID=$id&token=$token";

            $body = "<h2>Procedimento para troca de senha</h2>";
            $body .= "<hr>";
            $body .= "<p>Olá! Recebemos uma solicitação de troca de senha do seu usuário</p>";
            $body .= "<p>Para efetuar o cadastro na nova senha, clique no link a seguir:</p>";
            $body .= "<p><a href='$href'>$href</a></p>";
            $body .= "<br><br>";
            $body .= "<p>Caso não tenha sido você que fez a solicitação, desconsidere esta mensagem</p>";
            $body .= "<p>Atenciosamente: Agsus</p>";
           
            $altBody = "Recebemos uma solicitação para troca de senha em sua conta. Se foi você que fez a solicitação acesse o endereço $href para efetuar a mudança. Caso contrário, desconsidere esta mensagem";

            $mail = new PHPMailer(true);

            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'noreply@agenciasus.org.br';
                $mail->Password   = 'uouz prjq becy ovfd';
                $mail->SMTPSecure = 'tls'; //PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 587;

                //Recipients
                $mail->setFrom('noreply@agenciasus.org.br', 'AgSUS');
                $mail->addAddress($email, 'Usuário do Sistema');
                //$mail->addAddress('ellen@example.com');
                $mail->addReplyTo('noreply@agenciasus.org.br', 'AgSUS');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                //Attachments se vai enviar algum arquivo junto com a mensagem
                //$mail->addAttachment('/var/tmp/file.tar.gz');
                $mail->addAttachment('img/AgSUS_2023.png', 'logo_agsus');

                //Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $body;
                $mail->AltBody = $altBody;

                $mail->send();
                $message = "<b>E-mail enviado com sucesso</b>";
            } catch (Exception $e) {
                $message = "Não foi possível enviar o e-mail. Erro informado: {$mail->ErrorInfo}";
            }
        } else {
            $message = "E-mail não cadastrado na base de dados. Tente outro E-mail...";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Esqueci a senha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="./css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="shortcut icon" href="img/icone_agsus_2023.png" />
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="./js/script.js" type="text/javascript"></script>
</head>

<body>

    <div class="container h-100 mt-5">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="./img/AgSUS_2023.png" class="brand_logo img-fluid" alt="Logo">
                    </div>
                </div>
                <div class="justify-content-center form_container">
                    <h3 class="text-light text-center mb-3">Esqueci a senha</h3>
                    <div class="input-group mb-2">
                        <p class="text-light text-center"><i>Entre com seu E-mail cadastrado e receberá um e-mail com um link de recuperação de senha.</i></p>
                    </div>
                    <?php
                    if (isset($message)) {
                        echo "<p class='alert alert-warning text-center px-3 mx-2'>$message</p></p>";
                    }
                    ?>
                    <form action="./forgotPass.php" method="post" id="form">
                        <div class="input-group mb-3 mx-1">
                            <div class="input-group-append bg-primary">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control input_user" id="email" value="" placeholder="Informe seu E-mail">
                        </div>

                        <div class="justify-content-center mt-3 login_container">
                            <button type="submit" id="Send" name="Send" class="btn btn-lg login_btn">Enviar</button>
                        </div>
                        <input type="hidden" name="key" value="sendMail">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>