<?php

namespace Source\Models;

use Source\Core\Model;

class Diaria extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "diaria";

    /** @var array $required table fileds */
    protected static $required = [
        "idservico",
        "idlogistica",
        "descricao",
        "valordiaria",
        "nrdias",
        "datahorainclusao",
        "iduserincluiu",
        "flagInativo"
    ];

    public function bootstrap(
            string $idservico,
            string $idlogistica,
            string $descricao,
            string $valordiaria,
            string $nrdias,
            string $datahorainclusao,
            string $iduserincluiu,
            string $flagInativo
    ): ?Diaria {
        $this->idservico = $idservico;
        $this->idlogistica = $idlogistica;
        $this->descricao = $descricao;
        $this->valordiaria = $valordiaria;
        $this->nrdias = $nrdias;
        $this->datahorainclusao = $datahorainclusao;
        $this->iduserincluiu = $iduserincluiu;
        $this->flagInativo = $flagInativo;
        return $this;
    }

    public function load(int $id, string $columns = "*"): ?Diaria {
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
    public function find(string $terms, string $params, string $columns = "*"): ?Diaria {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchObject(__CLASS__);
    }

    public function findPorIdservicoIdlogistica($idservico, $idlogistica): ?Diaria {
        $find = $this->read("SELECT * FROM " . self::$entity . " WHERE idservico = $idservico and idlogistica = $idlogistica");

        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchObject(__CLASS__);
    }
    
    public function findPorIdservicoIdlogisticaAtivo($idservico, $idlogistica): ?Diaria {
        $find = $this->read("SELECT * FROM " . self::$entity . " WHERE idservico = $idservico and idlogistica = $idlogistica and flagInativo = 0");

        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchObject(__CLASS__);
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

    public function allIdlogisticaIdservico(int $idservico, int $idlogistica): ?array {
        $all = $this->read("SELECT * FROM " . self::$entity . " WHERE idservico = $idservico and  idlogistica = $idlogistica");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    /** Save diaria */
    public function save(): ?bool {
        $this->create(self::$entity, $this->safe());
        if ($this->fail()) {
            $this->message->error("Erro ao cadastrar, verifique os dados");
//            return $this->message;
            $resp = false;
        }else{
            $resp = true;
        }
        return $resp;
    }  
    
    public function updateDiaria(){
        $resp = false;
//        var_dump($this);
        if(!empty($this->idservico) && !empty($this->idlogistica)){
            $idservico = $this->idservico;
            $idlogistica = $this->idlogistica;
            $descricao = $this->descricao;
            $valordiaria = $this->valordiaria;
            $nrdias = $this->nrdias;
            $datahorainclusao = $this->datahorainclusao;
            $iduserincluiu = $this->iduserincluiu;
            $flagInativo = $this->flagInativo;
//            var_dump($idservico, $idlogistica, $descricao, $valordiaria, $nrdias, $datahorainclusao, 
//            $iduserincluiu, $flagInativo);
            $resp = $this->updateDiarias($idservico, $idlogistica, $descricao, $valordiaria, $nrdias, $datahorainclusao, 
            $iduserincluiu, $flagInativo);
//            var_dump($resp);
        }
        return $resp;
    }
    
     public function updateDiariaFlagInativo(){
        $resp = false;
//        var_dump($this);
        if(!empty($this->idservico) && !empty($this->idlogistica)){
            $idservico = $this->idservico;
            $idlogistica = $this->idlogistica;
            $flagInativo = $this->flagInativo;
//            var_dump($idservico, $idlogistica, $flagInativo);
            $resp = $this->updateDiariasFlagInativo($idservico, $idlogistica, $flagInativo);
//            var_dump($resp);
        }
        return $resp;
    }

    /**
     * @return null|User
     */
    public function destroy(): ?Diaria {
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
