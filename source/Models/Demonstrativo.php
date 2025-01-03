<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class Demonstrativo extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["iddemonstrativo", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "demonstrativo";

    /** @var array $required table fileds */
    protected static $required = [
        "ano",
        "ciclo",
        "qualidade",
        "fkcpf",
        "fkibge",
        "fkcnes",
        "fkine",
        "fkincentivo",
        "fkperiodo"
    ];

    public function bootstrap(
            string $ano,
            string $ciclo,
            string $qualidade,
            string $fkcpf,
            string $fkibge,
            string $fkcnes,
            string $fkine,
            string $fkincentivo,
            string $fkperiodo
    ): ?Demonstrativo {
        $this->ano = $ano;
        $this->ciclo = $ciclo;
        $this->qualidade = $qualidade;
        $this->fkcpf = $fkcpf;
        $this->fkibge = $fkibge;
        $this->fkcnes = $fkcnes;
        $this->fkine = $fkine;
        $this->fkincentivo = $fkincentivo;
        $this->fkperiodo = $fkperiodo;
        
        return $this;
    }

    public function load(int $iddemonstrativo, string $columns = "*"): ?Demonstrativo {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE iddemonstrativo = :iddemonstrativo", "iddemonstrativo={$iddemonstrativo}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Demonstrativo não encontrado para o iddemonstrativo informado";
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
    public function find(string $terms, string $params, string $columns = "*"): ?Demonstrativo {
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
     * @param int $iddemonstrativo
     * @param string $columns
     * @return null|User
     */
    public function findById(int $iddemonstrativo, string $columns = "*"): ?Demonstrativo {
        return $this->find("iddemonstrativo = :iddemonstrativo", "iddemonstrativo={$iddemonstrativo}", $columns);
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
    public function save(): ?Demonstrativo {
        if (empty($this->iddemonstrativo)) {
            $iddemonstrativo = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }
        /** User Update */
        if (!empty($this->iddemonstrativo)) {
            $iddemonstrativo = $this->iddemonstrativo;

            $this->update(self::$entity, $this->safe(), "iddemonstrativo = :iddemonstrativo", "iddemonstrativo={$iddemonstrativo}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }
        
        $this->data = ($this->findById($iddemonstrativo))->data();
        return $this;
    }
    
    /**
     * @return null|User
     */
//    public function destroy(): ?Demonstrativo {
//        if (!empty($this->iddemonstrativo)) {
//            $iddemonstrativo = $this->iddemonstrativo;
//            $iddemonstrativo = (int)$iddemonstrativo;            
//            $this->delete(self::$entity, "iddemonstrativo=:iddemonstrativo", "iddemonstrativo={$iddemonstrativo}");
//        }
//
//        if ($this->fail()) {
//            $this->message = "Não foi possível remover o registro";
//            return null;
//        }
//
//        $this->message = "Demonstrativo removiddemonstrativoo com sucesso";
//        $this->data = null;
//        return $this;
//    }

}
