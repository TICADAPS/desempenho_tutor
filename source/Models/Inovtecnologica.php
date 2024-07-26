<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class Inovtecnologica extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["idinovtecnologica", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "inovtecnologica";

    /** @var array $required table fileds */
    protected static $required = [
        "descricao"
    ];

    public function bootstrap(
            string $descricao
            
    ): ?Inovtecnologica {
        $this->descricao = $descricao;
        
        return $this;
    }

    public function load(int $id, string $columns = "*"): ?Inovtecnologica {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idinovtecnologica = :id", "id={$id}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Inovtecnologica não encontrado para o id informado";
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
    public function find(string $terms, string $params, string $columns = "*"): ?Inovtecnologica {
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
    public function findById(int $id, string $columns = "*"): ?Inovtecnologica {
        return $this->find("idinovtecnologica = :id", "id={$id}", $columns);
    }

     /** Save debito */
    public function save(): ?Inovtecnologica {
        if (empty($this->idinovtecnologica)) {
            $idinovtecnologica = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }
        /** User Update */
        if (!empty($this->idinovtecnologica)) {
            $idinovtecnologica = $this->idinovtecnologica;

            $this->update(self::$entity, $this->safe(), "idinovtecnologica = :id", "id={idinovtecnologica}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }
        
        $this->data = ($this->findById($idinovtecnologica))->data();
        return $this;
    }
    
    /**
     * @return null|User
     */
    public function destroy(): ?Inovtecnologica {
        if (!empty($this->idinovtecnologica)) {
            $idinovtecnologica = $this->idinovtecnologica;
            $idinovtecnologica = (int)$idinovtecnologica;            
            $this->delete(self::$entity, "idinovtecnologica=:id", "id={$idinovtecnologica}");
        }

        if ($this->fail()) {
            $this->message = "Não foi possível remover o registro";
            return null;
        }

        $this->message = "Inovtecnologica removido com sucesso";
        $this->data = null;
        return $this;
    }

}
