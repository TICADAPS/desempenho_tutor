<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class Medico_qualifclinica extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["id", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "medico_qualifclinica";

    /** @var array $required table fileds */
    protected static $required = [
        "idqualifclinica",
        "idaperfprof",
        "titulo",
        "cargahr",
        "anexo",
        "dthrcadastro"
    ];

    public function bootstrap(
            string $idqualifclinica,
            string $idaperfprof,
            string $titulo,
            string $cargahr,
            string $anexo,
            string $dthrcadastro
    ): ?Medico_qualifclinica {
        $this->idqualifclinica = $idqualifclinica;
        $this->idaperfprof = $idaperfprof;
        $this->titulo = $titulo;
        $this->cargahr = $cargahr;
        $this->anexo = $anexo;
        $this->dthrcadastro = $dthrcadastro;
        
        return $this;
    }

    public function load(int $id, string $columns = "*"): ?Medico_qualifclinica {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE id = :id", "id={$id}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Medico_qualifclinica não encontrado para o id informado";
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
    public function find(string $terms, string $params, string $columns = "*"): ?Medico_qualifclinica {
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
    public function findById(int $id, string $columns = "*"): ?Medico_qualifclinica {
        return $this->find("id = :id", "id={$id}", $columns);
    }

     /** Save debito */
    public function save(): ?Medico_qualifclinica {
        if (empty($this->id)) {
            $id = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }
        /** User Update */
        if (!empty($this->id)) {
            $id = $this->id;

            $this->update(self::$entity, $this->safe(), "id = :id", "id={$id}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }
        
        $this->data = ($this->findById($id))->data();
        return $this;
    }
    
    /**
     * @return null|User
     */
//    public function destroy(): ?Medico_qualifclinica {
//        if (!empty($this->id)) {
//            $id = $this->id;
//            $id = (int)$id;            
//            $this->delete(self::$entity, "id=:id", "id={$id}");
//        }
//
//        if ($this->fail()) {
//            $this->message = "Não foi possível remover o registro";
//            return null;
//        }
//
//        $this->message = "Medico_qualifclinica removido com sucesso";
//        $this->data = null;
//        return $this;
//    }

}
