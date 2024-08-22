<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class Aperfeicoamentoprofissional extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["id", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "aperfeicoamentoprofissional";

    /** @var array $required table fileds */
    protected static $required = [
        "cpf",
        "ibge",
        "cnes",
        "ine",
        "ano",
        "ciclo",
        "dthrcadastro",
        "flagativlongduracao"
    ];

    public function bootstrap(
            string $cpf,
            string $ibge,
            string $cnes,
            string $ine,
            string $ano,
            string $ciclo,
            string $dthrcadastro,
            string $flagativlongduracao
    ): ?Aperfeicoamentoprofissional {
        $this->cpf = $cpf;
        $this->ibge = $ibge;
        $this->cnes = $cnes;
        $this->ine = $ine;
        $this->ano = $ano;
        $this->ciclo = $ciclo;
        $this->dthrcadastro = $dthrcadastro;
        $this->flagativlongduracao = $flagativlongduracao;
        
        return $this;
    }

    public function load(int $id, string $columns = "*"): ?Aperfeicoamentoprofissional {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE id = :id", "id={$id}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Aperfeicoamentoprofissional não encontrado para o id informado";
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
    public function find(string $terms, string $params, string $columns = "*"): ?Aperfeicoamentoprofissional {
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
    public function findById(int $id, string $columns = "*"): ?Aperfeicoamentoprofissional {
        return $this->find("id = :id", "id={$id}", $columns);
    }

     /** Save debito */
    public function save(): ?Aperfeicoamentoprofissional {
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
//    public function destroy(): ?Aperfeicoamentoprofissional {
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
//        $this->message = "Aperfeicoamentoprofissional removido com sucesso";
//        $this->data = null;
//        return $this;
//    }

}
