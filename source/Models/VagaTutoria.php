<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class VagaTutoria extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["idVaga", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "vaga_tutoria";

    /** @var array $required table fileds */
    protected static $required = [
        "idMedico",
        "opcao1",
        "opcao2",
        "opcao3",
        "opcao_escolhida",
        "idTutor",
        "munic_origem",
        "uf_origem",
        "munic_escolhido",
        "uf_escolhida",
        "distancia",
        "cpf",
        "distancia_nova",
        "data_hora_lancamento",
    ];

    public function bootstrap(
            int $idMedico,
            int $opcao1,
            int $opcao2,
            int $opcao3,
            int $opcao_escolhida,
            int $idTutor,
            string $munic_origem,
            string $uf_origem,
            string $munic_escolhido,
            string $uf_escolhida,
            int $distancia,
            int $cpf,
            int $distancia_nova,
            int $data_hora_lancamento
    ): ?VagaTutoria {
        $this->idMedico = $idMedico;
        $this->opcao1 = $opcao1;
        $this->opcao2 = $opcao2;
        $this->opcao3 = $opcao3;
        $this->opcao_escolhida = $opcao_escolhida;
        $this->idTutor = $idTutor;
        $this->munic_origem = $munic_origem;
        $this->uf_origem = $uf_origem;
        $this->munic_escolhido = $munic_escolhido;
        $this->uf_escolhida = $uf_escolhida;
        $this->distancia = $distancia;
        $this->cpf = $cpf;
        $this->distancia_nova = $distancia_nova;
        $this->data_hora_lancamento = $data_hora_lancamento;
        return $this;
    }

    public function load(int $id, string $columns = "*"): ?VagaTutoria {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idVaga = :id", "id={$id}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Usuário não encontrado para o id informado";
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
    public function find(string $terms, string $params, string $columns = "*"): ?VagaTutoria {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchObject(__CLASS__);
    }
    public function qntdMedicoComTutor(): ?VagaTutoria {
        $find = $this->read("SELECT count(0) as qntd FROM vaga_tutoria vt;");
        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchObject(__CLASS__);
    }

    public function findById(int $id, string $columns = "*"): ?VagaTutoria {
        return $this->find("idVaga = :id", "id={$id}", $columns);
    }
    
    public function findByIdMedico(int $id, string $columns = "*"): ?VagaTutoria {
        return $this->find("idMedico = :id", "id={$id}", $columns);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $columns
     * @return array|null
     */
    public function all(int $limit = 30, int $offset = 0, string $columns = "*"): ?array {
        $all = $this->read("SELECT {$columns} FROM " . self::$entity . " LIMIT :limit OFFSET :offset",
                "limit={$limit}&offset={$offset}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function bolsistas(int $idTutor): ?array {
        $all = $this->read("SELECT nome_medico from medico_bolsista mb 
        INNER JOIN vaga_tutoria vt ON vt.idMedico = mb.idMedico
        WHERE vt.idTutor = $idTutor; ");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function bolsistaComTutor(): ?array {
        $all = $this->read("SELECT DISTINCT vt.idMedico,md.NomeMedico, vt.uf_origem as UF, vt.munic_origem as Municipio, vt.munic_escolhido as opcaoEscolhida, vt.uf_escolhida as destino
            FROM vaga_tutoria vt
            INNER JOIN medico md ON vt.idMedico = md.idMedico   
            INNER JOIN municipio opc on opc.cod_munc = vt.opcao_escolhida
            INNER JOIN tutor_municipio tm ON tm.cod_munc = opc.cod_munc
            INNER JOIN estado et on et.cod_uf = tm.codUf
            ORDER BY md.NomeMedico;");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * @return null|User
     */
    public function save(): ?VagaTutoria {
         /** User Create */
        if (empty($this->idVaga)) {
            $userId = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }
        
        /** User Update */
        if (!empty($this->idVaga)) {
            $idVaga = $this->idVaga;

            $this->update(self::$entity, $this->safe(), "idVaga = :id", "id={$idVaga}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }

        $this->data = ($this->findById($idVaga))->data();
        return $this;
    }

    /**
     * @return null|User
     */
    public function destroy(): ?VagaTutoria {
        if (!empty($this->idVaga)) {
            $this->delete(self::$entity, "idVaga = :id", "id={$this->idVaga}");
        }

        if ($this->fail()) {
            $this->message = "Não foi possível remover o usuário";
            return null;
        }

        $this->message = "Usuário removido com sucesso";
        $this->data = null;
        return $this;
    }

# deleta todos os tutores de vagaTutoria

    public function destroyTutor(): ?VagaTutoria {
        if (!empty($this->idTutor)) {
            $this->delete(self::$entity, "idTutor = :id", "id={$this->idTutor}");
        }

        if ($this->fail()) {
            $this->message = "Não foi possível remover o usuário";
            return null;
        }

        $this->message = "Usuário removido com sucesso";
        $this->data = null;
        return $this;
    }
    
    /**
     * remove bolsista da tutoria e joga as informações em historico
     */
    public function removeBolsistaTutoria($idMedico,$idVaga,$usuario): bool {
        if (!empty($idVaga)) {
            $this->CallProcRemoveBolsistaTutoria($idMedico, $idVaga, "Remoção dos dados de Bolsista",$usuario);
        }

        if ($this->fail()) {
            $this->message = "Não foi possível remover o bolsista";
            return false;
        }

        $this->message = "Bolsista removido com sucesso";
        return true;
    }

}
