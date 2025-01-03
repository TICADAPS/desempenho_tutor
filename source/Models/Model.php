<?php

namespace Source\Models;

use Source\Database\Connect;

/**
 * Class Model
 * @package Source\Models
 */
abstract class Model {

    /** @var object|null */
    protected $data;

    /** @var \PDOException|null */
    protected $fail;

    /** @var string|null */
    protected $message;

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value) {
        if (empty($this->data)) {
            $this->data = new \stdClass();
        }

        $this->data->$name = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name) {
        return isset($this->data->$name);
    }

    /**
     * @param $name
     * @return null
     */
    public function __get($name) {
        return ($this->data->$name ?? null);
    }

    /**
     * @return null|object
     */
    public function data(): ?object {
        return $this->data;
    }

    /**
     * @return \PDOException
     */
    public function fail(): ?\PDOException {
        return $this->fail;
    }

    /**
     * @return null|string
     */
    public function message(): ?string {
        return $this->message;
    }

    /**
     * @param string $entity
     * @param array $data
     * @return int|null
     */
    protected function create(string $entity, array $data): ?int {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = Connect::getInstance()->prepare("INSERT INTO {$entity} ({$columns}) VALUES ({$values})");
            $stmt->execute($this->filter($data));

            return Connect::getInstance()->lastInsertId();
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @param string $select
     * @param string|null $params
     * @return null|\PDOStatement
     */
    protected function read(string $select, string $params = null): ?\PDOStatement {
        try {
            $stmt = Connect::getInstance()->prepare($select);
            if ($params) {
                parse_str($params, $params);
                foreach ($params as $key => $value) {
                    $type = (is_numeric($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
                    $stmt->bindValue(":{$key}", $value, $type);
                }
            }

            $stmt->execute();
            return $stmt;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @param string $entity
     * @param array $data
     * @param string $terms
     * @param string $params
     * @return int|null
     */
    protected function update(string $entity, array $data, string $terms, string $params): ?int {
        try {
            $dateSet = [];
            foreach ($data as $bind => $value) {
                $dateSet[] = "{$bind} = :{$bind}";
            }
            $dateSet = implode(", ", $dateSet);
            parse_str($params, $params);

            $stmt = Connect::getInstance()->prepare("UPDATE {$entity} SET {$dateSet} WHERE {$terms}");
            $stmt->execute($this->filter(array_merge($data, $params)));
            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    

    protected function sp_Remaneja_tutoria($id, $opc, $tutor): ?int {
        //var_dump($id, $opc, $tutor);
        try {
            $a = 0;
            $idmed = $NomeMedico = $CpfMedico = $DataApresentacao = $fone_zap = $email = $idCargo = $nomecargo = $municipioorigem = $uforigem = "";
            $municipioescolhido = $ufescolhida = $idTutor = $nomeTutor = $cpfTutor = $cpfGestor = $nomeGestor = "";
            $ccidControle = $ccedicao = $FlagRealizouTutoria = $JustificativaTutoria = $FlagDisponibilidade = $FlagSolicitaPassagem = $FlagDispensaHospedagem = array();
            $FlagTermoResponsabilidade = $FlagCienciaPortaria = $FlagDataCreate = $ctInicial = $ctFinal = array();
            $ccid[0] = $ccedicao[0] = $FlagRealizouTutoria[0] = $JustificativaTutoria[0] = $FlagDisponibilidade[0] = $FlagSolicitaPassagem[0] = $FlagDispensaHospedagem[0] = "";
            $FlagTermoResponsabilidade[0] = $FlagCienciaPortaria[0] = $FlagDataCreate[0] = $ctInicial[0] = $ctFinal[0] = "";

            $sqlh = "Select m.NomeMedico, m.CpfMedico, m.DataApresentacao, m.fone_zap, m.email, m.idCargo, m.cpfGestor,"
                    . "mu.municipio as municipioorigem, e.UF as uforigem from medico m inner join municipio mu on mu.cod_munc = m.Municipio_id inner join "
                    . "estado e on e.cod_uf = mu.Estado_cod_uf where m.idMedico = :id";
            $stm1 = Connect::getInstance()->prepare($sqlh);
            $stm1->bindValue(':id', $id);
            if ($stm1->execute() or die(Connect::getInstance()->errorInfo())) {
                while ($row = $stm1->fetchAll()) {
                    //var_dump($row);
                    $idmed = $id;
                    foreach ($row as $value) {
                        $NomeMedico = $value->NomeMedico;
                        $CpfMedico = $value->CpfMedico;
                        $DataApresentacao = $value->DataApresentacao;
                        $fone_zap = $value->fone_zap;
                        $email = $value->email;
                        $idCargo = $value->idCargo;
                        $municipioorigem = $value->municipioorigem;
                        $uforigem = $value->uforigem;
                        $cpfGestor = $value->cpfGestor;
                    }
                    if ($idCargo == 1) {
                        $nomecargo = "Medico de Familia e Comunidade";
                    } else {
                        $nomecargo = "Tutor Medico";
                    }
                    //var_dump($cpfGestor);
                    $sqlg = "Select NomeGestor from gestor where CpfGestor = :cpfG";
                    $stmg = Connect::getInstance()->prepare($sqlg);
                    $stmg->bindValue(':cpfG', $cpfGestor);
                    if ($stmg->execute() or die(Connect::getInstance()->errorInfo())) {
                        while ($rowg = $stmg->fetchAll()) {
                            foreach ($rowg as $value) {
                                $nomeGestor = $value->NomeGestor;
                            }
                            //var_dump($nomeGestor);
                        }
                    }
                }
            }
            if ($idCargo == 1) {
                $sqlh = "Select vt.idTutor, vt.munic_escolhido as municipioescolhido, vt.uf_escolhida as ufescolhida from vaga_tutoria vt "
                        . " where vt.idMedico = :id";
                $stm1 = Connect::getInstance()->prepare($sqlh);
                $stm1->bindValue(':id', $id);
                if ($stm1->execute() or die(Connect::getInstance()->errorInfo())) {
                    while ($row = $stm1->fetchAll()) {
                        //var_dump($row);
                        foreach ($ccid as $value) {
                            $municipioescolhido = $value->municipioescolhido;
                            $ufescolhida = $value->ufescolhida;
                            $idTutor = $value->idTutor;
                        }

                        $sqlt = "Select NomeMedico, CpfMedico from medico where idMedico = '$idTutor'";
                        $stmt = Connect::getInstance()->prepare($sqlt);
                        $stmt->bindValue(':id', $id);
                        if ($stmt->execute()) {
                            while ($rowt = $stmt->fetchAll()) {
                                //var_dump($rowt);
                                foreach ($rowt as $value) {
                                    $nomeTutor = $rowt->NomeMedico;
                                    $cpfTutor = $rowt->CpfMedico;
                                }
                            }
                        }
                    }
                }

                $sqlh2 = "Select cc.idControle, cc.Edicao, cc.FlagRealizouTutoria, cc.JustificativaTutoria, cc.FlagDisponibilidade, "
                        . "cc.FlagSolicitaPassagem, cc.FlagDispensaHospedagem, cc.FlagTermoResponsabilidade, cc.FlagCienciaPortaria, "
                        . "cc.DataCreate, ct.PeriodoInicial, ct.PeriodoFinal from ControleCalendario cc inner join CalendarioTutoria ct "
                        . "on cc.idCalendario = ct.idCalendario and cc.Edicao = ct.Edicao where cc.idMedico = :id";
                $stm2 = Connect::getInstance()->prepare($sqlh2);
                $stm2->bindValue(':id', $id);
                if ($stm2->execute() or die(Connect::getInstance()->errorInfo())) {
                    while ($row2 = $stm2->fetchAll()) {
                        //var_dump($row2);
                        foreach ($row2 as $value) {
                            $ccidControle[$a] = $value->idControle;
                            $ccedicao[$a] = $value->Edicao;
                            $FlagRealizouTutoria[$a] = $value->FlagRealizouTutoria;
                            $JustificativaTutoria[$a] = $value->JustificativaTutoria;
                            $FlagDisponibilidade[$a] = $value->FlagDisponibilidade;
                            $FlagSolicitaPassagem[$a] = $value->FlagSolicitaPassagem;
                            $FlagDispensaHospedagem[$a] = $value->FlagDispensaHospedagem;
                            $FlagTermoResponsabilidade[$a] = $value->FlagTermoResponsabilidade;
                            $FlagCienciaPortaria[$a] = $value->FlagCienciaPortaria;
                            $FlagDataCreate[$a] = $value->DataCreate;
                            $ctInicial[$a] = $value->PeriodoInicial;
                            $ctFinal[$a] = $value->PeriodoFinal;
                            $a++;
                        }
                    }
                }
            }

            //var_dump($a);
            if ($a > 0) {
                $a--;
                for ($x = 0; $x <= $a; $x++) {
                    //var_dump($x);
                    if (array_key_exists($x, $ctInicial)) {
                        $sql = "insert into historico values (null, :idmed, :NomeMedico, :CpfMedico, :DataApresentacao,"
                                . ":fone_zap, :email, :nomecargo, :municipioorigem, :uforigem, :nomeGestor, :cpfGestor,"
                                . ":nomeTutor, :cpfTutor, :municipioescolhido, :ufescolhida, :ctInicial, :ctFinal, :ccedicao,"
                                . ":FlagRealizouTutoria, :JustificativaTutoria, :FlagDisponibilidade, :FlagSolicitaPassagem, "
                                . ":FlagDispensaHospedagem, :FlagTermoResponsabilidade, :FlagCienciaPortaria, :FlagDataCreate, "
                                . "'Remanejamento de bolsista',now())";
                        $stm = Connect::getInstance()->prepare($sql);
                        $stm->bindValue(':idmed', $idmed);
                        $stm->bindValue(':NomeMedico', $NomeMedico);
                        $stm->bindValue(':CpfMedico', $CpfMedico);
                        $stm->bindValue(':DataApresentacao', $DataApresentacao);
                        $stm->bindValue(':fone_zap', $fone_zap);
                        $stm->bindValue(':email', $email);
                        $stm->bindValue(':nomecargo', $nomecargo);
                        $stm->bindValue(':municipioorigem', $municipioorigem);
                        $stm->bindValue(':uforigem', $uforigem);
                        $stm->bindValue(':nomeGestor', $nomeGestor);
                        $stm->bindValue(':cpfGestor', $cpfGestor);
                        $stm->bindValue(':nomeTutor', $nomeTutor);
                        $stm->bindValue(':cpfTutor', $cpfTutor);
                        $stm->bindValue(':municipioescolhido', $municipioescolhido);
                        $stm->bindValue(':ufescolhida', $ufescolhida);

                        $ctIni = "" . $ctInicial[$x];
                        $ctFin = "" . $ctFinal[$x];
                        $ccedi = "" . $ccedicao[$x];

                        $stm->bindValue(':ctInicial', $ctIni);
                        $stm->bindValue(':ctFinal', $ctFin);
                        $stm->bindValue(':ccedicao', $ccedi);

                        $FlagRealizou = "" . $FlagRealizouTutoria[$x];

                        $Justificativa = "" . $JustificativaTutoria[$x];

                        if ($FlagDisponibilidade[$x] == 0)
                            $FlagDisponib = "Não";
                        else
                            $FlagDisponib = "Sim";

                        if ($FlagSolicitaPassagem[$x] == 0)
                            $FlagSolicitaP = "Não";
                        else
                            $FlagSolicitaP = "Sim";

                        if ($FlagDispensaHospedagem[$x] == 0)
                            $FlagDispensaH = "Não";
                        else
                            $FlagDispensaH = "Sim";

                        if ($FlagTermoResponsabilidade[$x] == 0)
                            $FlagTermoR = "Não";
                        else
                            $FlagTermoR = "Sim";

                        if ($FlagCienciaPortaria[$x] == 0)
                            $FlagCienciaP = "Não";
                        else
                            $FlagCienciaP = "Sim";
                        $FlagDataC = "" . $FlagDataCreate[$x];
                        $stm->bindValue(':FlagRealizouTutoria', $FlagRealizou);
                        $stm->bindValue(':JustificativaTutoria', $Justificativa);
                        $stm->bindValue(':FlagDisponibilidade', $FlagDisponib);
                        $stm->bindValue(':FlagSolicitaPassagem', $FlagSolicitaP);
                        $stm->bindValue(':FlagDispensaHospedagem', $FlagDispensaH);
                        $stm->bindValue(':FlagTermoResponsabilidade', $FlagTermoR);
                        $stm->bindValue(':FlagCienciaPortaria', $FlagCienciaP);
                        $stm->bindValue(':FlagDataCreate', $FlagDataC);
                        $stm->execute()or die(Connect::getInstance()->errorInfo());
                    } else {
                        $sql = "insert into historico values (null, :idmed, :NomeMedico, :CpfMedico, :DataApresentacao,"
                                . ":fone_zap, :email, :nomecargo, :municipioorigem, :uforigem, :nomeGestor, :cpfGestor,"
                                . ":nomeTutor, :cpfTutor, :municipioescolhido, :ufescolhida, '', '', '', '', '', '', '', '', '', '', '', "
                                . "'Remanejamento de bolsista',now())";
                        $stm = Connect::getInstance()->prepare($sql);
                        $stm->bindValue(':idmed', $idmed);
                        $stm->bindValue(':NomeMedico', $NomeMedico);
                        $stm->bindValue(':CpfMedico', $CpfMedico);
                        $stm->bindValue(':DataApresentacao', $DataApresentacao);
                        $stm->bindValue(':fone_zap', $fone_zap);
                        $stm->bindValue(':email', $email);
                        $stm->bindValue(':nomecargo', $nomecargo);
                        $stm->bindValue(':municipioorigem', $municipioorigem);
                        $stm->bindValue(':uforigem', $uforigem);
                        $stm->bindValue(':nomeGestor', $nomeGestor);
                        $stm->bindValue(':cpfGestor', $cpfGestor);
                        $stm->bindValue(':nomeTutor', $nomeTutor);
                        $stm->bindValue(':cpfTutor', $cpfTutor);
                        $stm->bindValue(':municipioescolhido', $municipioescolhido);
                        $stm->bindValue(':ufescolhida', $ufescolhida);
                        $stm->execute() or die(Connect::getInstance()->errorInfo());
                    }
                }
            } else {
                $sql = "insert into historico values (null, :idmed, :NomeMedico, :CpfMedico, :DataApresentacao,"
                        . ":fone_zap, :email, :nomecargo, :municipioorigem, :uforigem, :nomeGestor, :cpfGestor,"
                        . ":nomeTutor, :cpfTutor, :municipioescolhido, :ufescolhida, :ctInicial, :ctFinal, :ccedicao,"
                        . ":FlagRealizouTutoria, :JustificativaTutoria, :FlagDisponibilidade, :FlagSolicitaPassagem, "
                        . ":FlagDispensaHospedagem, :FlagTermoResponsabilidade, :FlagCienciaPortaria, :FlagDataCreate, "
                        . "'Remanejamento de bolsista',now())";
                $stm = Connect::getInstance()->prepare($sql);
                $stm->bindValue(':idmed', $idmed);
                $stm->bindValue(':NomeMedico', $NomeMedico);
                $stm->bindValue(':CpfMedico', $CpfMedico);
                $stm->bindValue(':DataApresentacao', $DataApresentacao);
                $stm->bindValue(':fone_zap', $fone_zap);
                $stm->bindValue(':email', $email);
                $stm->bindValue(':nomecargo', $nomecargo);
                $stm->bindValue(':municipioorigem', $municipioorigem);
                $stm->bindValue(':uforigem', $uforigem);
                $stm->bindValue(':nomeGestor', $nomeGestor);
                $stm->bindValue(':cpfGestor', $cpfGestor);
                $stm->bindValue(':nomeTutor', $nomeTutor);
                $stm->bindValue(':cpfTutor', $cpfTutor);
                $stm->bindValue(':municipioescolhido', $municipioescolhido);
                $stm->bindValue(':ufescolhida', $ufescolhida);
                $ctIni = "" . $ctInicial[0];
                $ctFin = "" . $ctFinal[0];
                $ccedi = "" . $ccedicao[0];
                $stm->bindValue(':ctInicial', $ctIni);
                $stm->bindValue(':ctFinal', $ctFin);
                $stm->bindValue(':ccedicao', $ccedi);

                $FlagRealizou = "" . $FlagRealizouTutoria[0];
                $Justificativa = "" . $JustificativaTutoria[0];

                if ($FlagDisponibilidade[0] == 0)
                    $FlagDisponib = "Não";
                else
                    $FlagDisponib = "Sim";

                if ($FlagSolicitaPassagem[0] == 0)
                    $FlagSolicitaP = "Não";
                else
                    $FlagSolicitaP = "Sim";

                if ($FlagDispensaHospedagem[0] == 0)
                    $FlagDispensaH = "Não";
                else
                    $FlagDispensaH = "Sim";

                if ($FlagTermoResponsabilidade[0] == 0)
                    $FlagTermoR = "Não";
                else
                    $FlagTermoR = "Sim";

                if ($FlagCienciaPortaria[0] == 0)
                    $FlagCienciaP = "Não";
                else
                    $FlagCienciaP = "Sim";

                $FlagDataC = "" . $FlagDataCreate[0];

                //var_dump($ctIni,$ctFin,$ccedi,$FlagRealizou,$Justificativa,$FlagDisponib,$FlagSolicitaP,$FlagSolicitaP,$FlagDispensaH,$FlagTermoR,$FlagCienciaP,$FlagDataC);

                $stm->bindValue(':FlagRealizouTutoria', $FlagRealizou);
                $stm->bindValue(':JustificativaTutoria', $Justificativa);
                $stm->bindValue(':FlagDisponibilidade', $FlagDisponib);
                $stm->bindValue(':FlagSolicitaPassagem', $FlagSolicitaP);
                $stm->bindValue(':FlagDispensaHospedagem', $FlagDispensaH);
                $stm->bindValue(':FlagTermoResponsabilidade', $FlagTermoR);
                $stm->bindValue(':FlagCienciaPortaria', $FlagCienciaP);
                $stm->bindValue(':FlagDataCreate', $FlagDataC);
                $stm->execute() or die(Connect::getInstance()->errorInfo());
            }
            //var_dump($id,$opc, $tutor);
            //Remanejamento (troca de tutoria)
            $sql = "CALL sp_RemanejaBolsista (:id,:opc,:tutor)";
            $stm = Connect::getInstance()->prepare($sql);
            //$stm->bindValue(1,$nome);
            $stm->bindValue(':id', $id);
            $stm->bindValue(':opc', $opc);
            $stm->bindValue(':tutor', $tutor);

            $stm->execute() or die(Connect::getInstance()->errorInfo());

            //exclui do Controle Calendário os dados anteriores
            if (count($ccidControle) > 0) {
                for ($x = 0; $x < count($ccidControle); $x++) {
                    $sql = "delete from ControleCalendario where idControle = :ccid";
                    $stm = Connect::getInstance()->prepare($sql);
                    $stm->bindValue(':ccid', $ccidControle[$x]);
                    $stm->execute() or die(Connect::getInstance()->errorInfo());
                }
            }

            $sql1 = "select idVaga, opcao_escolhida, munic_origem, uf_origem, munic_escolhido, uf_escolhida from vaga_tutoria where idMedico = :id limit 1";
            $stm1 = Connect::getInstance()->prepare($sql1);
            $stm1->bindValue(':id', $id);
            if ($stm1->execute()) {
                while ($row = $stm1->fetchAll()) {
                    foreach ($row as $value) {
                        $idVaga = $value->idVaga;
                        $opEscolhida = "" . $value->opcao_escolhida;
                        $munic_origem = $value->munic_origem;
                        $uf_origem = $value->uf_origem;
                        $munic_escolhido = $value->munic_escolhido;
                        $uf_escolhida = $value->uf_escolhida;

                        $origem = "$munic_origem $uf_origem";
                        $destino = "$munic_escolhido $uf_escolhida";
                        $distancia = 0.00;

                        if (strlen($opEscolhida) < 7) {
                            $distancia = $this->kilometragemLocal($origem, $destino);
                            if (strpos($distancia, "k") !== false) {
                                $distancia = str_replace(" ", "", $distancia);
                                $distancia = str_replace("k", "", $distancia);
                                $distancia = str_replace("m", "", $distancia);
                                $distancia = str_replace(".", "", $distancia);
                                $distancia = str_replace(",", ".", $distancia);
                            } else {
                                $distancia = 0.00;
                            }
                        }

                        $sql2 = "update vaga_tutoria set distancia = :distancia where idVaga = :idVaga";
                        $stm2 = Connect::getInstance()->prepare($sql2);
                        $stm2->bindValue(':distancia', $distancia);
                        $stm2->bindValue(':idVaga', $idVaga);
                        $stm2->execute() or die(Connect::getInstance()->errorInfo());
                    }
                }
            } else {
                echo "<script>alert('Não existe em vaga_tutoria')</script>";
            }
        } catch (PDOException $erro) {
            echo 'Mensagem de erro: ' . $erro->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $erro->getFile() . "<br>";
            echo 'Linha: ' . $erro->getLine() . "<br>";
        }
    }

    /**
     * @param string $entity
     * @param string $terms
     * @param string $params
     * @return int|null
     */
    protected function delete(string $entity, string $terms, string $params): ?int {
        try {
            $stmt = Connect::getInstance()->prepare("DELETE FROM {$entity} WHERE {$terms}");
            parse_str($params, $params);
            $stmt->execute($params);
            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @return array|null
     */
    protected function safe(): ?array {
        $safe = (array) $this->data;
        foreach (static::$safe as $unset) {
            unset($safe[$unset]);
        }
        return $safe;
    }

    /**
     * @param array $data
     * @return array|null
     */
    private function filter(array $data): ?array {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS));
        }
        return $filter;
    }

}
