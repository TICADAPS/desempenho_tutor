<?php

namespace Source\Models;

use Source\Core\Model;

class Credito extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["idcredito", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "credito";

    /** @var array $required table fileds */
    protected static $required = [
        "idtipocredito",
        "idservico",
        "idlogistica",
        "valorcreditado",
        "valoronus",
        "datahoraentrada",
        "idusuarioentrada",
        "valordebitado",
        "valorrestante"
    ];

    public function bootstrap(
            string $idtipocredito,
            string $idservico,
            string $idlogistica,
            string $valorcreditado,
            string $valoronus,
            string $datahoraentrada,
            string $idusuarioentrada,
            string $valordebitado,
            string $valorrestante
    ): ?Credito {
        $this->idtipocredito = $idtipocredito;
        $this->idservico = $idservico;
        $this->idlogistica = $idlogistica;
        $this->valorcreditado = $valorcreditado;
        $this->valoronus = $valoronus;
        $this->datahoraentrada = $datahoraentrada;
        $this->idusuarioentrada = $idusuarioentrada;
        $this->valordebitado = $valordebitado;
        $this->valorrestante = $valorrestante;
        return $this;
    }

    public function load(int $id, string $columns = "*"): ?Credito {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idCalendario = :id", "id={$id}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Calendário não encontrado para o id informado";
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
    public function find(string $terms, string $params, string $columns = "*"): ?Credito {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchObject(__CLASS__);
    }

    public function findById($id, string $columns = "*"): ?Credito {
        return $this->find("idcredito = :id", "id={$id}", $columns);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $columns
     * @return array|null
     */
    public function all(int $limit = 30, int $offset = 0, string $columns = "*"): ?array {
        $all = $this->read("SELECT {$columns} FROM " . self::$entity . " order by datalimite LIMIT :limit OFFSET :offset",
                "limit={$limit}&offset={$offset}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function findIdtipocreditoIdservicoIdlogistica(int $idtipocredito,  int $idservico, int $idlogistica): ?array {
        $all = $this->read("SELECT * FROM " . self::$entity . " c inner join tipocredito tc on tc.idtipocredito = "
            . "c.idtipocredito WHERE idtipocredito = $idtipocredito and idlogistica = $idlogistica and idservico = $idservico");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findReembolsoPassagem($idlogistica): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, p.cnpjempresa 
            FROM tipocredito tc inner join credito c on tc.idtipocredito = 
            c.idtipocredito inner join passagem p on p.idpassagem = c.idpassagem 
            WHERE c.idtipocredito = 1 and c.idservico = 3 and c.idlogistica = {$idlogistica}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findValorDevidoPassagem($idlogistica): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, p.cnpjempresa 
            FROM tipocredito tc inner join credito c on tc.idtipocredito = 
            c.idtipocredito inner join passagem p on p.idpassagem = c.idpassagem 
            WHERE c.idtipocredito = 4 and c.idservico = 3 and c.idlogistica = {$idlogistica}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findReembolsoHospedagem($idlogistica): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, h.cnpjempresa FROM 
            tipocredito tc inner join credito c on tc.idtipocredito = 
            c.idtipocredito inner join hospedagem h on h.idhospedagem = c.idhospedagem 
            WHERE c.idtipocredito = 1 and c.idservico = 2 and c.idlogistica = {$idlogistica}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findValorDevidoHospedagem($idlogistica): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, h.cnpjempresa FROM 
            tipocredito tc inner join credito c on tc.idtipocredito = 
            c.idtipocredito inner join hospedagem h on h.idhospedagem = c.idhospedagem 
            WHERE c.idtipocredito = 4 and c.idservico = 2 and c.idlogistica = {$idlogistica}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findIdCreditoGeralPassagem($cnpj): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valoronusposterior, c.valorrestante, p.cnpjempresa 
            FROM tipocredito tc inner join credito c on tc.idtipocredito = 
            c.idtipocredito inner join passagem p on p.idpassagem = c.idpassagem 
            WHERE c.idtipocredito = 2 and c.idservico = 3 and p.cnpjempresa = {$cnpj} and c.valorrestante > 0");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findIdCreditoDiarias($idlogistica): ?array {
        $all = $this->read("SELECT c.idcredito, c.idlogistica, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valorrestante FROM tipocredito tc 
            inner join credito c on tc.idtipocredito = c.idtipocredito 
            WHERE c.idtipocredito = 3 and c.idservico = 1 and c.idlogistica = {$idlogistica}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    public function findIdCreditoDiariasAtiva($idlogistica): ?array {
        $all = $this->read("SELECT c.idcredito, c.datahoraentrada, c.idlogistica, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valorrestante FROM tipocredito tc 
            inner join credito c on tc.idtipocredito = c.idtipocredito 
            WHERE c.idtipocredito = 3 and c.idservico = 1 and c.idlogistica = {$idlogistica} and (flaginativo = 0 or flaginativo is null)");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findIdCreditoDeslocamentoAtivo($idlogistica): ?array {
        $all = $this->read("SELECT c.idcredito, c.idlogistica, c.datahoraentrada, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valorrestante FROM tipocredito tc 
            inner join credito c on tc.idtipocredito = c.idtipocredito 
            WHERE c.idtipocredito = 3 and c.idservico = 4 and c.idlogistica = {$idlogistica} and (flaginativo = 0 or flaginativo is null)");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findAllCreditoGeralPassagemComSaldo(): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valoronusposterior, c.valorrestante,  p.cnpjempresa, p.empresa FROM tipocredito tc inner join credito c on tc.idtipocredito = 
            c.idtipocredito inner join passagem p on p.idpassagem = c.idpassagem 
            WHERE c.idtipocredito = 2 and c.idservico = 3 and c.valorrestante > 0.00 and (c.datalimite >= current_date() or c.datalimite is null)");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findIdCreditoGeralPassagemComSaldo($cnpj): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valoronusposterior, c.valorrestante,  p.cnpjempresa, p.empresa, 
            l.PeriodoInicial, l.PeriodoFinal FROM tipocredito tc inner join credito c on tc.idtipocredito = 
            c.idtipocredito inner join passagem p on p.idpassagem = c.idpassagem inner join logistica l on l.idlogistica = c.idlogistica
            WHERE c.idtipocredito = 2 and c.idservico = 3 and p.cnpjempresa = {$cnpj} and c.valorrestante > 0.00 and (c.datalimite >= current_date() or c.datalimite is null)");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findIdCreditoMedicoPassagem($cnpj, $idmedico): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valoronusposterior, c.valorrestante, p.cnpjempresa, 
            l.PeriodoInicial, l.PeriodoFinal FROM tipocredito tc inner join credito c on tc.idtipocredito = 
            c.idtipocredito inner join passagem p on p.idpassagem = c.idpassagem inner join logistica l on l.idlogistica = p.idlogistica 
            WHERE c.idtipocredito = 3 and c.idservico = 3 and p.cnpjempresa = {$cnpj} and l.idMedico = {$idmedico}  and c.valorrestante > 0");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findAllCreditoNominalComSaldo(): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valoronusposterior, c.valorrestante,  p.cnpjempresa, p.empresa FROM tipocredito tc inner join credito c on tc.idtipocredito = 
            c.idtipocredito inner join passagem p on p.idpassagem = c.idpassagem 
            WHERE c.idtipocredito = 3 and c.idservico = 3 and c.valorrestante > 0.00 and (c.datalimite >= current_date() or c.datalimite is null)");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findIdCreditoNominalPassagem($cnpj, $idmedico): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valoronusposterior, c.valorrestante, p.cnpjempresa, p.empresa, 
            l.PeriodoInicial, l.PeriodoFinal FROM tipocredito tc inner join credito c on tc.idtipocredito = 
            c.idtipocredito inner join passagem p on p.idpassagem = c.idpassagem inner join logistica l on l.idlogistica = p.idlogistica 
            WHERE c.idtipocredito = 3 and c.idservico = 3 and p.cnpjempresa = {$cnpj} and l.idMedico = {$idmedico} and c.valorrestante > 0.00 and (c.datalimite >= current_date() or c.datalimite is null)");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findIdCreditoNominalHospedagem($cnpj, $idmedico): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valorrestante, h.cnpjempresa, h.nomehospedagem,
            l.PeriodoInicial, l.PeriodoFinal FROM tipocredito tc inner join credito c on tc.idtipocredito = 
            c.idtipocredito inner join hospedagem h on h.idhospedagem = c.idhospedagem inner join logistica l on l.idlogistica = h.idlogistica 
            WHERE c.idtipocredito = 3 and c.idservico = 2 and h.cnpjempresa = {$cnpj} and l.idMedico = {$idmedico} and c.valorrestante > 0.00 and (c.datalimite >= current_date() or c.datalimite is null)");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findIdCreditoNominalDeslocamento($idmedico): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valorrestante, l.PeriodoInicial, l.PeriodoFinal 
            FROM tipocredito tc inner join credito c on tc.idtipocredito = 
            c.idtipocredito inner join deslocamentoveiculo dv on dv.iddeslocamento = c.iddeslocamento inner join logistica l on l.idlogistica = dv.idlogistica 
            WHERE c.flaginativo is null and c.idtipocredito = 3 and c.idservico = 4 and l.idMedico = {$idmedico} and c.valorrestante > 0.00 and (c.datalimite >= current_date() or c.datalimite is null)");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
     public function findIdCreditoNominalDiaria($idmedico): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valorrestante, l.PeriodoInicial, l.PeriodoFinal FROM tipocredito tc inner join credito c on tc.idtipocredito = 
            c.idtipocredito inner join diaria di on c.idlogistica = di.idlogistica and c.idservico = di.idservico inner join logistica l on l.idlogistica = di.idlogistica
            WHERE c.flaginativo is null and c.idtipocredito = 3 and c.idservico = 1 and l.idMedico = {$idmedico} and c.valorrestante > 0.00 and (c.datalimite >= current_date() or c.datalimite is null)");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findIdCreditoMedicoHospedagem($cnpj, $idmedico): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valorrestante, h.cnpjempresa, l.PeriodoInicial, l.PeriodoFinal
            FROM tipocredito tc inner join credito c on tc.idtipocredito = c.idtipocredito inner join hospedagem h on h.idhospedagem = c.idhospedagem 
            inner join logistica l on l.idlogistica = h.idlogistica 
            WHERE c.idtipocredito = 3 and c.idservico = 2 and h.cnpjempresa = {$cnpj} and l.idMedico = {$idmedico}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findIdCreditoGeralHospedagem($cnpj): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valorrestante, h.cnpjempresa 
            FROM tipocredito tc inner join credito c on tc.idtipocredito = c.idtipocredito inner join hospedagem h on h.idhospedagem = c.idhospedagem 
            WHERE c.idtipocredito = 2 and c.idservico = 2 and h.cnpjempresa = {$cnpj}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findIdCreditoGeralHospedagemComSaldo($cnpj): ?array {
        $all = $this->read("SELECT c.idcredito, c.datalimite, c.valordebitado, c.valorcreditado, c.valoronus, c.valorrestante, h.cnpjempresa, h.nomehospedagem  
            FROM tipocredito tc inner join credito c on tc.idtipocredito = c.idtipocredito inner join hospedagem h on h.idhospedagem = c.idhospedagem 
            WHERE c.idtipocredito = 2 and c.idservico = 2 and h.cnpjempresa = {$cnpj} and c.valorrestante > 0.00 and (c.datalimite >= current_date() or c.datalimite is null)");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findHospedagemIdMedico(int $idmedio): ?array {
        $all = $this->read("SELECT * FROM credito c inner join tipocredito tc on tc.idtipocredito = "
            . "c.idtipocredito inner join logistica l on l.idlogistica = c.idlogistica inner join "
                . "servico_logistica sl on sl.idservico = c.idservico inner join "
                . "hospedagem h on h.idhospedagem = c.idservicocreditado WHERE l.idmedio = $idmedio and idservico = 2");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findPassagemIdMedico(int $idmedio): ?array {
        $all = $this->read("SELECT * FROM credito c inner join tipocredito tc on tc.idtipocredito = "
            . "c.idtipocredito inner join logistica l on l.idlogistica = c.idlogistica inner join "
                . "servico_logistica sl on sl.idservico = c.idservico inner join "
                . "passagem p on p.idpassagem = c.idservicocreditado WHERE l.idmedio = $idmedio and idservico = 3");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findDeslocamentoIdMedico(int $idmedio): ?array {
        $all = $this->read("SELECT * FROM credito c inner join tipocredito tc on tc.idtipocredito = "
            . "c.idtipocredito inner join logistica l on l.idlogistica = c.idlogistica inner join "
                . "servico_logistica sl on sl.idservico = c.idservico inner join "
                . "deslocamento desl on desl.iddeslocamento = c.idservicocreditado WHERE l.idmedio = $idmedio and idservico = 4");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    /** Save credito */
    public function save(): ?Credito {
        if (empty($this->idcredito)) {
            $idcredito = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }
        /** User Update */
        if (!empty($this->idcredito)) {
            $idcredito = $this->idcredito;

            $this->update(self::$entity, $this->safe(), "idcredito = :id", "id={$idcredito}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }
        
        $this->data = ($this->findById($idcredito))->data();
        return $this;
    }
    

    /**
     * @return null|User
     */
    public function destroy(): ?Credito {
        if (!empty($this->id)) {
            $this->delete(self::$entity, "idMedico = :id", "id={$this->id}");
        }

        if ($this->fail()) {
            $this->message = "Não foi possível remover o usuário";
            return null;
        }

        $this->message = "Usuário removido com sucesso";
        $this->data = null;
        return $this;
    }

}
