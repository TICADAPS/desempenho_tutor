<?php

abstract class ClassConexao {
    #Realizará a conexão com o banco de dados

    protected function conectaDB() {
        try {
            $Con = new PDO("mysql:host=localhost;dbname=u226895969_desemp_tutor", "u226895969_marcelo_ADAPS", "Senha10adaps");
            return $Con;
        } catch (PDOException $Erro) {
            return $Erro->getMessage();
        }
    }

}
