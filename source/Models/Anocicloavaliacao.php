<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class Anocicloavaliacao extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["id", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "anocicloavaliacao";

    /** @var array $required table fileds */
    protected static $required = [
        "ano",
        "ciclo",
        "descricao",
        "dtinicio",
        "dtfim",
        "flagativo"
    ];

    public function bootstrap(
            string $ano,
            string $ciclo,
            string $descricao,
            string $dtinicio,
            string $dtfim,
            string $flagativo
    ): ?Anocicloavaliacao {
        $this->ano = $ano;
        $this->ciclo = $ciclo;
        $this->descricao = $descricao;
        $this->dtinicio = $dtinicio;
        $this->dtfim = $dtfim;
        $this->flagativo = $flagativo;
        
        return $this;
    }

    public function load(int $id, string $columns = "*"): ?Anocicloavaliacao {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE id = :id", "id={$id}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Anocicloavaliacao não encontrado para o id informado";
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
    public function find(string $terms, string $params, string $columns = "*"): ?Anocicloavaliacao {
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
    public function findById(int $id, string $columns = "*"): ?Anocicloavaliacao {
        return $this->find("id = :id", "id={$id}", $columns);
    }
    
    public function findAnoCiclo($ano, $ciclo): ?array
    {
        $all = $this->read("SELECT * from " . self::$entity . " WHERE ano = '$ano' and ciclo = '$ciclo'");

        if ($this->fail() ||!$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    public function findAnoCicloAtivo($ano, $ciclo): ?array
    {
        $all = $this->read("SELECT * from " . self::$entity . " WHERE ano = '$ano' and ciclo = '$ciclo' and flagativo = 1");

        if ($this->fail() ||!$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    public function findTudo(): ?array
    {
        $all = $this->read("SELECT * from " . self::$entity);

        if ($this->fail() ||!$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

     /** Save debito */
    public function save(): ?Anocicloavaliacao {
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
    public function destroy(): ?Anocicloavaliacao {
        if (!empty($this->id)) {
            $id = $this->id;
            $id = (int)$id;            
            $this->delete(self::$entity, "id=:id", "id={$id}");
        }

        if ($this->fail()) {
            $this->message = "Não foi possível remover o registro";
            return null;
        }

        $this->message = "Anocicloavaliacao removido com sucesso";
        $this->data = null;
        return $this;
    }

}
