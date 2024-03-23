<?php

namespace Source\Models;

use Source\Core\Model;

class Empresahospedagem extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["idempresahospedagem", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "empresahospedagem";

    /** @var array $required table fileds */
    protected static $required = [
        "nomeempresahospedagem",
        "cnpj",
    ];

    public function bootstrap(
            string $nomeempresahospedagem,
            string $cnpj
    ): ?Empresahospedagem {
        $this->nomeempresahospedagem = $nomeempresahospedagem;
        $this->cnpj = $cnpj;
        return $this;
    }

    /**
     * @param string $terms
     * @param string $params
     * @param string $columns
     * @return null|User
     */
    public function find(string $terms, string $params, string $columns = "*"): ?Empresahospedagem {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchObject(__CLASS__);
    }

    public function findById(int $id, string $columns = "*"): ?Empresahospedagem {
        return $this->find("idempresahospedagem = :id", "id={$id}", $columns);
    }
    
    public function findHospedagem(): ?array {
        $all = $this->read("SELECT * FROM empresahospedagem order by nomeempresahospedagem");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findByNomeEmpresa($nomeempresa, string $columns = "*"): ?Empresahospedagem {
        return $this->find("nomeempresa = :nome", "nome={$nomeempresa}", $columns);
    }
    
    public function findByCnpjHospedagem($cnpj, string $columns = "*"): ?Empresahospedagem {
        return $this->find("cnpj = :cnpj", "cnpj={$cnpj}", $columns);
    }
    
    public function findAllByCnpjHospedagem($cnpj): ?Empresahospedagem {
        $find = $this->read("SELECT * FROM " . self::$entity . " WHERE cnpj = '$cnpj'");
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
    
    public function findAll(): ?array {
        $all = $this->read("SELECT e.idempresahospedagem, e.nomeempresahospedagem, e.cnpj "
                . "FROM empresahospedagem e order by e.nomeempresahospedagem");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    /** Save passagem */
    public function save(): ?Empresahospedagem {
        if (empty($this->idempresahospedagem)) {
            $idempresahospedagem = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }
        /** User Update */
        if (!empty($this->idempresahospedagem)) {
            $idempresahospedagem = $this->idempresahospedagem;

            $this->update(self::$entity, $this->safe(), "idempresahospedagem = :id", "id={$idempresahospedagem}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }
        
        $this->data = ($this->findById($idempresahospedagem))->data();
        return $this;
    }
}
