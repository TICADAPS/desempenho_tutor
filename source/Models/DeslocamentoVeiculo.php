<?php

namespace Source\Models;

use Source\Core\Model;

class DeslocamentoVeiculo extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["iddeslocamento","created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "deslocamentoveiculo";

    /** @var array $required table fileds */
    protected static $required = [
        "idservico",
        "idlogistica",
        "valor",
        "uforigem",
        "municipioorigem",
        "ufdestino",
        "municipiodestino",
        "distancia",
        "datahorainclusao",
        "iduserincluiu",
        "flagInativo"
    ];

    public function bootstrap(
            string $idservico,
            string $idlogistica,
            string $valor,
            string $uforigem,
            string $municipioorigem,
            string $ufdestino,
            string $municipiodestino,
            string $distancia,
            string $datahorainclusao,
            string $iduserincluiu,
            string $flagInativo
    ): ?DeslocamentoVeiculo {
        $this->idservico = $idservico;
        $this->idlogistica = $idlogistica;
        $this->valor = $valor;
        $this->uforigem = $uforigem;
        $this->municipioorigem = $municipioorigem;
        $this->ufdestino = $ufdestino;
        $this->municipiodestino = $municipiodestino;
        $this->distancia = $distancia;
        $this->datahorainclusao = $datahorainclusao;
        $this->iduserincluiu = $iduserincluiu;
        $this->flagInativo = $flagInativo;
        return $this;
    }

    public function load(int $id, string $columns = "*"): ?DeslocamentoVeiculo {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idCalendario = :id", "id={$id}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Calendário não encontrado para o id informado";
            return null;
        }
        return $load->fetchObject(__CLASS__);
    }

    /**
     * @param string $terms
     * @param string $params
     * @param string $columns
     * @return null|User
     */
    public function find(string $terms, string $params, string $columns = "*"): ?DeslocamentoVeiculo {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchObject(__CLASS__);
    }
    
    public function findById($id, string $columns = "*"): ?DeslocamentoVeiculo {
        return $this->find("iddeslocamento = :id", "id={$id}", $columns);
    }

    public function findPorIdservicoIdlogistica($idservico, $idlogistica): ?array {
        $find = $this->read("SELECT * FROM " . self::$entity . " WHERE idservico = {$idservico} and idlogistica = {$idlogistica}");

        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findDeslocamentoAtivo($idservico, $idlogistica): ?array {
        $find = $this->read("SELECT * FROM " . self::$entity . " WHERE idservico = {$idservico} and idlogistica = {$idlogistica} and flagInativo = 0");

        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findDeslocamentoInAtivo($idservico, $idlogistica): ?array {
        $find = $this->read("SELECT * FROM " . self::$entity . " WHERE idservico = {$idservico} and idlogistica = {$idlogistica} and flagInativo = 1");

        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $columns
     * @return array|null
     */
    public function all(int $limit = 30, int $offset = 0, string $columns = "*"): ?array {
        $all = $this->read("SELECT {$columns} FROM " . self::$entity . " order by PeriodoInicial LIMIT :limit OFFSET :offset",
                "limit={$limit}&offset={$offset}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function allIdlogisticaIdservico($idservico, $idlogistica): ?array {
        $all = $this->read("SELECT * FROM " . self::$entity . " WHERE idservico = {$idservico} and  idlogistica = {$idlogistica}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    /** Save DeslocamentoVeiculo */
    public function save(): ?DeslocamentoVeiculo {
        if (empty($this->iddeslocamento)) {
            $iddeslocamento = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }
        /** User Update */
        if (!empty($this->iddeslocamento)) {
            $iddeslocamento = $this->iddeslocamento;

            $this->update(self::$entity, $this->safe(), "iddeslocamento = :id", "id={$iddeslocamento}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }
        
        $this->data = ($this->findById($iddeslocamento))->data();
        return $this;
    }  

    /**
     * @return null|User
     */
    public function destroy(): ?DeslocamentoVeiculo {
        if (!empty($this->id)) {
            $this->delete(self::$entity, "idMedico = :id", "id={$this->id}");
        }

        if ($this->fail()) {
            $this->message = "Não foi possível remover o usuário";
            return null;
        }

        $this->message = "Usuário removido com sucesso";
        $this->data = null;
        return $this;
    }

}
