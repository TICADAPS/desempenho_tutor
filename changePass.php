<?php

require_once "./validacao-acesso/config.php";

if(isset($_GET["ID"]) && $_GET["token"] !== "") {

    $id = $_GET["ID"];
    $token = $_GET["token"];

    $sql = "SELECT user_email FROM forgot_pass WHERE id = ? AND user_token = ?";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(1, $id);
    $stm->bindValue(2, $token);
    $stm->execute();
    $row = $stm->rowCount();
    if($row === 1) {
        $user_email = $stm->fetch(PDO::FETCH_ASSOC)["user_email"];
        $sql = "DELETE FROM forgot_pass WHERE id = ?";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(1, $id);
        $stm->execute();

        include './newPass.php';
    } else {
        $message = "Não foi encontrado nenhum dado com as informações enviadas";
        include './forgotPass.php';
    }

} else {
    $message = "Estão faltando informações para utilizar este recurso";
    include './login_new_2.php';
}
