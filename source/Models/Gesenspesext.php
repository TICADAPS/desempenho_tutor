<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class Gesenspesext extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["idgesenspesext", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "gesenspesext";

    /** @var array $required table fileds */
    protected static $required = [
        "descricao"
    ];

    public function bootstrap(
            string $descricao
            
    ): ?Gesenspesext {
        $this->descricao = $descricao;
        
        return $this;
    }

    public function load(int $id, string $columns = "*"): ?Gesenspesext {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idgesenspesext = :id", "id={$id}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Gesenspesext não encontrado para o id informado";
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
    public function find(string $terms, string $params, string $columns = "*"): ?Gesenspesext {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchObject(__CLASS__);
    }

    public function findAll(string $terms, string $params, string $columns = "*"): ?array {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * @param int $id
     * @param string $columns
     * @return null|User
     */
    public function findById(int $id, string $columns = "*"): ?Gesenspesext {
        return $this->find("idgesenspesext = :id", "id={$id}", $columns);
    }

     /** Save debito */
    public function save(): ?Gesenspesext {
        if (empty($this->idgesenspesext)) {
            $idgesenspesext = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }
        /** User Update */
        if (!empty($this->idgesenspesext)) {
            $idgesenspesext = $this->idgesenspesext;

            $this->update(self::$entity, $this->safe(), "idgesenspesext = :id", "id={idgesenspesext}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }
        
        $this->data = ($this->findById($idgesenspesext))->data();
        return $this;
    }
    
    /**
     * @return null|User
     */
    public function destroy(): ?Gesenspesext {
        if (!empty($this->idgesenspesext)) {
            $idgesenspesext = $this->idgesenspesext;
            $idgesenspesext = (int)$idgesenspesext;            
            $this->delete(self::$entity, "idgesenspesext=:id", "id={$idgesenspesext}");
        }

        if ($this->fail()) {
            $this->message = "Não foi possível remover o registro";
            return null;
        }

        $this->message = "Gesenspesext removido com sucesso";
        $this->data = null;
        return $this;
    }

}
