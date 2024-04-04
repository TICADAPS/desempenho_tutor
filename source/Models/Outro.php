<?php

namespace Source\Models;

use Source\Core\Model;

class Outro extends Model {

    /** @var array $safe no update or create */
    protected static $safe = ["iddebito", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "debito";

    /** @var array $required table fileds */
    protected static $required = [
        "idcredito",
        "valordebitado",
        "idusuariodebitado",
        "datahoradebito",
        "idlogisticasaida",
        "idservico",
        "flaginativo"
    ];

    public function bootstrap(
            string $idcredito,
            string $valordebitado,
            string $idusuariodebitado,
            string $datahoradebito,
            string $idlogisticasaida,
            string $idservico,
            string $flaginativo
    ): ?Outro {
        $this->idcredito = $idcredito;
        $this->valordebitado = $valordebitado;
        $this->idusuariodebitado = $idusuariodebitado;
        $this->datahoradebito = $datahoradebito;
        $this->idlogisticasaida = $idlogisticasaida;
        $this->idservico = $idservico;
        $this->flaginativo = $flaginativo;
        return $this;
    }

    public function load(int $id, string $columns = "*"): ?Outro {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE iddebito = :id", "id={$id}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Débito não encontrado para o id informado";
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
    public function find(string $terms, string $params, string $columns = "*"): ?Outro {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
        if ($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchObject(__CLASS__);
    }

    public function findById($id, string $columns = "*"): ?Outro {
        return $this->find("iddebito = :id", "id={$id}", $columns);
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
    
    public function findOutroIdcredito($idcredito): ?array{
        $all = $this->read("SELECT * FROM debito WHERE idcredito = {$idcredito};");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findOutroIdcreditoAtivo($idcredito): ?array{
        $all = $this->read("SELECT * FROM debito WHERE idcredito = {$idcredito} and flaginativo = 0;");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findOutroPassagemIdpassagem($idpassagem): ?array{
        $all = $this->read("SELECT d.iddebito, d.idcredito, d.valordebitado, d.flaginativo FROM debito d "
                . "WHERE d.idpassagem = {$idpassagem} and d.idservico = 3;");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findOutroPassagemIdlogistica($idlogistica): ?array{
        $all = $this->read("SELECT d.iddebito, d.idcredito, d.valordebitado, d.flaginativo, p.valordeslocamento, l.PeriodoInicial, l.PeriodoFinal FROM debito d "
                . "inner join logistica l on d.idlogisticasaida = l.idlogistica inner join passagem p on l.idlogistica = p.idlogistica "
                . "inner join servico s on s.idservico = p.idservico "
                . "WHERE d.idlogisticasaida = $idlogistica and d.idservico = 3;");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function debitoCreditoIdlogisticaIdservicoPassagem($idlogistica, $idpassagem): ?array {
        $all = $this->read("select p.idpassagem, p.valordeslocamento, p.idlogistica, d.valordebitado, d.idcredito, d.idpassagem from debito d "
                . "inner join passagem p on p.idpassagem = d.idpassagem and p.idlogistica = d.idlogisticasaida "
                . "where d.idservico = 3 and idlogisticasaida = {$idlogistica} and d.idpassagem = {$idpassagem};");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function debitoCreditoIdlogisticaIdservicoHospedagem($idlogistica, $idhospedagem): ?array {
        $all = $this->read("select h.idhospedagem, h.valordiaria, h.nrpernoites, h.idlogistica, d.valordebitado, d.idcredito, d.idhospedagem from debito d "
                . "inner join hospedagem h on h.idhospedagem = d.idhospedagem and h.idlogistica = d.idlogisticasaida "
                . "where d.idservico = 2 and d.idlogisticasaida = {$idlogistica} and  d.idhospedagem = {$idhospedagem};");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findIdOutroGeralPassagem($cnpj): ?array {
        $all = $this->read("SELECT c.iddebito, c.valorcreditado, c.valorrestante,  p.cnpjempresa FROM tipodebito tc inner join debito c on tc.idtipodebito = 
            c.idtipodebito inner join passagem p on p.idpassagem = c.idpassagem 
            WHERE c.idtipodebito = 2 and c.idservico = 3 and p.cnpjempresa = {$cnpj}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findIdOutroOutroPassagem($cnpj, $idmedico): ?array {
        $all = $this->read("SELECT c.iddebito, c.valorcreditado, c.valorrestante, p.cnpjempresa FROM tipodebito tc inner join debito c on tc.idtipodebito = 
            c.idtipodebito inner join passagem p on p.idpassagem = c.idpassagem inner join logistica l on l.idlogistica = p.idlogistica 
            WHERE c.idtipodebito = 3 and c.idservico = 3 and p.cnpjempresa = {$cnpj} and l.idmedico = {$idmedico}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findOutroHospedagemIdlogistica($idlogistica): ?array{
        $all = $this->read("SELECT d.iddebito, d.idcredito, d.valordebitado, d.flaginativo, h.valordiaria, h.nrpernoite, l.PeriodoInicial, l.PeriodoFinal FROM debito d "
                . "inner join logistica l on d.idlogisticasaida = l.idlogistica inner join hospedagem h on l.idlogistica = h.idlogistica "
                . "inner join servico s on s.idservico = h.idservico "
                . "WHERE d.idlogisticasaida = $idlogistica and d.idservico = 2;");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findOutroHospedagemIdhospedagem($idhospedagem): ?array{
        $all = $this->read("SELECT d.iddebito, d.idcredito, d.valordebitado, d.flaginativo FROM debito d "
                . "WHERE d.idhospedagem = {$idhospedagem} and d.idservico = 2;");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findHospedagemIdOutro(int $idmedio): ?array {
        $all = $this->read("SELECT * FROM debito c inner join tipodebito tc on tc.idtipodebito = "
            . "c.idtipodebito inner join logistica l on l.idlogistica = c.idlogistica inner join "
                . "servico_logistica sl on sl.idservico = c.idservico inner join "
                . "hospedagem h on h.idhospedagem = c.idservicocreditado WHERE l.idmedio = $idmedio and idservico = 2");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findPassagemIdOutro(int $idmedio): ?array {
        $all = $this->read("SELECT * FROM debito c inner join tipodebito tc on tc.idtipodebito = "
            . "c.idtipodebito inner join logistica l on l.idlogistica = c.idlogistica inner join "
                . "servico_logistica sl on sl.idservico = c.idservico inner join "
                . "passagem p on p.idpassagem = c.idservicocreditado WHERE l.idmedio = $idmedio and idservico = 3");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findOutroDiariaIdlogisticaAtv($idlogistica): ?array{
        $all = $this->read("SELECT * FROM debito WHERE idlogistica = $idlogistica and idservico = '1' and flaginativo = 0");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findOutroDeslocamentoIdDeslocamento($iddeslocamento): ?array{
        $all = $this->read("SELECT * FROM debito WHERE iddeslocamento = $iddeslocamento and idservico = '4'");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findOutroDeslocamentoIdDeslocamentoAtivo($iddeslocamento): ?array{
        $all = $this->read("SELECT * FROM debito WHERE iddeslocamento = $iddeslocamento and idservico = '4' and flaginativo = '0'");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findOutroDeslocamentoIdlogisticaAtivo($idlogistica): ?array{
        $all = $this->read("SELECT d.iddebito, d.idcredito, d.valordebitado, dv.valor, l.PeriodoInicial, l.PeriodoFinal FROM debito d "
                . "inner join logistica l on d.idlogisticasaida = l.idlogistica inner join deslocamentoveiculo dv on l.idlogistica = dv.idlogistica "
                . "inner join servico s on s.idservico = dv.idservico "
                . "WHERE d.idlogisticasaida = $idlogistica and d.idservico = 4 and dv.flaginativo = 0 and d.flaginativo = 0;");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findOutroDeslocamentoIdlogistica($idlogistica): ?array{
        $all = $this->read("SELECT d.iddebito, d.idcredito, d.valordebitado, dv.valor, d.flaginativo, l.PeriodoInicial, l.PeriodoFinal FROM debito d "
                . "inner join logistica l on d.idlogisticasaida = l.idlogistica inner join deslocamentoveiculo dv on l.idlogistica = dv.idlogistica "
                . "inner join servico s on s.idservico = dv.idservico "
                . "WHERE d.idlogisticasaida = {$idlogistica} and d.idservico = 4;");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findOutroDiariaIdlogisticaAtivo($idlogistica): ?array{
        $all = $this->read("SELECT d.iddebito, d.idcredito, d.valordebitado, l.PeriodoInicial, l.PeriodoFinal FROM debito d inner join logistica l "
                . "on d.idlogisticasaida = l.idlogistica inner join servico s on s.idservico = d.idservico WHERE d.idlogisticasaida = {$idlogistica} "
                . "and d.idservico = 1 and d.flaginativo = 0;");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    public function findDeslocamentoIdOutro(int $idmedico): ?array {
        $all = $this->read("SELECT * FROM debito c inner join tipodebito tc on tc.idtipodebito = "
            . "c.idtipodebito inner join logistica l on l.idlogistica = c.idlogistica inner join "
                . "servico_logistica sl on sl.idservico = c.idservico inner join "
                . "deslocamento desl on desl.iddeslocamento = c.idservicocreditado WHERE l.idOutro = $idmedico and idservico = 4");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    
    
    /** Save debito */
    public function save(): ?Outro {
        if (empty($this->iddebito)) {
            $iddebito = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }
        /** User Update */
        if (!empty($this->iddebito)) {
            $iddebito = $this->iddebito;

            $this->update(self::$entity, $this->safe(), "iddebito = :id", "id={$iddebito}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }
        
        $this->data = ($this->findById($iddebito))->data();
        return $this;
    }
    

    /**
     * @return null|User
     */
    public function destroy(): ?Outro {
        if (!empty($this->id)) {
            $this->delete(self::$entity, "idOutro = :id", "id={$this->id}");
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
