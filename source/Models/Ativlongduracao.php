<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class Ativlongduracao extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["idativlongduracao", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "ativlongduracao";

    /** @var array $required table fileds */
    protected static $required = [
        "descricao"
    ];

    public function bootstrap(
            string $descricao
            
    ): ?Ativlongduracao {
        $this->descricao = $descricao;
        
        return $this;
    }

    public function load(int $id, string $columns = "*"): ?Ativlongduracao {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idativlongduracao = :id", "id={$id}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Ativlongduracao não encontrado para o id informado";
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
    public function find(string $terms, string $params, string $columns = "*"): ?Ativlongduracao {
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
    public function findById(int $id, string $columns = "*"): ?Ativlongduracao {
        return $this->find("idativlongduracao = :id", "id={$id}", $columns);
    }

     /** Save debito */
    public function save(): ?Ativlongduracao {
        if (empty($this->idativlongduracao)) {
            $idativlongduracao = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }
        /** User Update */
        if (!empty($this->idativlongduracao)) {
            $idativlongduracao = $this->idativlongduracao;

            $this->update(self::$entity, $this->safe(), "idativlongduracao = :id", "id={idativlongduracao}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }
        
        $this->data = ($this->findById($idativlongduracao))->data();
        return $this;
    }
    
    /**
     * @return null|User
     */
    public function destroy(): ?Ativlongduracao {
        if (!empty($this->idativlongduracao)) {
            $idativlongduracao = $this->idativlongduracao;
            $idativlongduracao = (int)$idativlongduracao;            
            $this->delete(self::$entity, "idativlongduracao=:id", "id={$idativlongduracao}");
        }

        if ($this->fail()) {
            $this->message = "Não foi possível remover o registro";
            return null;
        }

        $this->message = "Ativlongduracao removido com sucesso";
        $this->data = null;
        return $this;
    }

}
