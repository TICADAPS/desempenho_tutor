<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class Qualifclinica extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["idqualifclinica", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "qualifclinica";

    /** @var array $required table fileds */
    protected static $required = [
        "descricao"
    ];

    public function bootstrap(
            string $descricao
            
    ): ?Qualifclinica {
        $this->descricao = $descricao;
        
        return $this;
    }

    public function load(int $id, string $columns = "*"): ?Qualifclinica {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idqualifclinica = :id", "id={$id}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Qualifclinica não encontrado para o id informado";
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
    public function find(string $terms, string $params, string $columns = "*"): ?Qualifclinica {
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
    public function findById(int $id, string $columns = "*"): ?Qualifclinica {
        return $this->find("idqualifclinica = :id", "id={$id}", $columns);
    }

     /** Save debito */
    public function save(): ?Qualifclinica {
        if (empty($this->idqualifclinica)) {
            $idqualifclinica = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }
        /** User Update */
        if (!empty($this->idqualifclinica)) {
            $idqualifclinica = $this->idqualifclinica;

            $this->update(self::$entity, $this->safe(), "idqualifclinica = :id", "id={idqualifclinica}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }
        
        $this->data = ($this->findById($idqualifclinica))->data();
        return $this;
    }
    
    /**
     * @return null|User
     */
    public function destroy(): ?Qualifclinica {
        if (!empty($this->idqualifclinica)) {
            $idqualifclinica = $this->idqualifclinica;
            $idqualifclinica = (int)$idqualifclinica;            
            $this->delete(self::$entity, "idqualifclinica=:id", "id={$idqualifclinica}");
        }

        if ($this->fail()) {
            $this->message = "Não foi possível remover o registro";
            return null;
        }

        $this->message = "Qualifclinica removido com sucesso";
        $this->data = null;
        return $this;
    }

}
