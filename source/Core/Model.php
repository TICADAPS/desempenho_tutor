<?php

namespace Source\Core;
ini_set('memory_limit', '2048M');
set_time_limit(3000);
/**
 * Class Model
 * @package Source\Models
 */
abstract class Model {

    /** @var object|null */
    protected $data;

    /** @var \PDOException|null */
    protected $fail;

    /** @var Message|null */
    protected $message;

    /**
     * Model constructor.
     */
    public function __construct() {
        $this->message = new Message();
    }

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
     * @return Message|null
     */
    public function message(): ?Message {
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

    protected function sp_tutoria_menor_distancia_50km() {
        try {

            # -- limpa a tabela tb_distancia_nacional
            $delete_nacional = "delete from tb_distancia_nacional;";
            $stmt1 = Connect::getInstance()->prepare($delete_nacional);
            $stmt1->execute();

            # -- limpa a tabela tb_distancia_munic
            $delete_munic = "delete from tb_distancia_munic;";
            $stmt2 = Connect::getInstance()->prepare($delete_munic);
            $stmt2->execute();

            # -- limpa a tabela tb_tutor_munic
            $delete_tutor = "delete from tb_tutor_munic;";
            $stmt7 = Connect::getInstance()->prepare($delete_tutor);
            $stmt7->execute();
            
            # -- limpa a tabela tb_distancia_munic
            $delete_bolsista = "delete from tb_bolsista_munc;";
            $stmt8 = Connect::getInstance()->prepare($delete_bolsista);
            $stmt8->execute();
            
            
            # -- insere os tutores atuais na tabela tb_tutor_munic
            $queryTutor = Connect::getInstance()->prepare("insert into tb_tutor_munic
            select m.idMedico,m.Estado_idEstado,m.Municipio_id,m.latitude,m.longitude from medico m
            inner join tutor_municipio tm on m.idMedico = tm.idTutor
            where m.idCargo = 2 and m.flagInativo = 0 and situacao = 'Trabalhando';");
            $queryTutor->execute();
            
            # -- insere os bolsistas atuais na tabela tb_bolsista_munc
            $queryBolsista = Connect::getInstance()->prepare("insert into tb_bolsista_munc
            select idMedico,Estado_idEstado,Municipio_id,latitude,longitude from medico 
            where idCargo = 1 and flagInativo = 0 and idMedico not in(select idMedico from vaga_tutoria) 
            and idMedico in(select idMedico from medico_bolsista);");
            $queryBolsista->execute();
            
            # Chama procedimento para inserir novos registros na tabela tb_distancia_munic com dados atualizados
            $call_mun = "CALL sp_calcular_distancia_municipio();";
            $stmt3 = Connect::getInstance()->prepare($call_mun);
            $stmt3->execute();

            # Chama procedimento para inserir novos registros na tabela tb_distancia_nacional com dados atualizados
            $call_nacional = "CALL sp_calcular_distancia_nacional();";
            $stmt4 = Connect::getInstance()->prepare($call_nacional);
            $stmt4->execute();

            # Chama o procedimento de distribuição dos bolsistas em vaga_tutoria
            $sql = "call sp_tutoria_menor_distancia_50km();";
            $smt = Connect::getInstance()->prepare($sql);
            $smt->execute();
        } catch (PDOException $erro) {
            echo 'Mensagem de erro: ' . $erro->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $erro->getFile() . "<br>";
            echo 'Linha: ' . $erro->getLine() . "<br>";
        }
    }

    protected function sp_tutoria_menor_distancia_100km() {
        try {
                       
            # Chama o procedimento de distribuição dos bolsistas em vaga_tutoria
            $sql = "call sp_tutoria_menor_distancia_100km();";
            $smt = Connect::getInstance()->prepare($sql);
            $smt->execute();
        } catch (PDOException $erro) {
            echo 'Mensagem de erro: ' . $erro->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $erro->getFile() . "<br>";
            echo 'Linha: ' . $erro->getLine() . "<br>";
        }
    }

    protected function sp_tutoria_menor_distancia_150km() {
        try {
                       
            # Chama o procedimento de distribuição dos bolsistas em vaga_tutoria
            $sql = "call sp_tutoria_menor_distancia_150km();";
            $smt = Connect::getInstance()->prepare($sql);
            $smt->execute();
        } catch (PDOException $erro) {
            echo 'Mensagem de erro: ' . $erro->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $erro->getFile() . "<br>";
            echo 'Linha: ' . $erro->getLine() . "<br>";
        }
    }
    protected function sp_tutoria_menor_distancia_200km() {
        try {                       
            # Chama o procedimento de distribuição dos bolsistas em vaga_tutoria
            $sql = "call sp_tutoria_menor_distancia_200km();";
            $smt = Connect::getInstance()->prepare($sql);
            $smt->execute();
        } catch (PDOException $erro) {
            echo 'Mensagem de erro: ' . $erro->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $erro->getFile() . "<br>";
            echo 'Linha: ' . $erro->getLine() . "<br>";
        }
    }
    protected function sp_tutoria_menor_distancia_300km() {
        try {                       
            # Chama o procedimento de distribuição dos bolsistas em vaga_tutoria
            $sql = "call sp_tutoria_menor_distancia_300km();";
            $smt = Connect::getInstance()->prepare($sql);
            $smt->execute();
        } catch (PDOException $erro) {
            echo 'Mensagem de erro: ' . $erro->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $erro->getFile() . "<br>";
            echo 'Linha: ' . $erro->getLine() . "<br>";
        }
    }

    protected function sp_menor_distancia_nacional_100km() {
        try {
                       
            # Chama o procedimento de distribuição dos bolsistas em vaga_tutoria
            $sql = "call sp_menor_distancia_nacional_100km();";
            $smt = Connect::getInstance()->prepare($sql);
            $smt->execute();
        } catch (PDOException $erro) {
            echo 'Mensagem de erro: ' . $erro->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $erro->getFile() . "<br>";
            echo 'Linha: ' . $erro->getLine() . "<br>";
        }
    }

    protected function sp_menor_distancia_nacional_200km() {
        try {
                        
            # Chama o procedimento de distribuição dos bolsistas em vaga_tutoria
            $sql = "call sp_menor_distancia_nacional_200km();";
            $smt = Connect::getInstance()->prepare($sql);
            $smt->execute();
        } catch (PDOException $erro) {
            echo 'Mensagem de erro: ' . $erro->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $erro->getFile() . "<br>";
            echo 'Linha: ' . $erro->getLine() . "<br>";
        }
    }

    protected function sp_menor_distancia_nacional_300km() {
        try {
            
            # Chama o procedimento de distribuição dos bolsistas em vaga_tutoria
            $sql = "call sp_menor_distancia_nacional_300km();";
            $smt = Connect::getInstance()->prepare($sql);
            $smt->execute();
        } catch (PDOException $erro) {
            echo 'Mensagem de erro: ' . $erro->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $erro->getFile() . "<br>";
            echo 'Linha: ' . $erro->getLine() . "<br>";
        }
    }

    protected function sp_inclui_vaga_tutoria() {
        try {
            # Obtem o último idVaga registrado em vaga_tutoria
            $query = "select * from vaga_tutoria order by idVaga desc limit 1;";
            $stmt = Connect::getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($linha = $stmt->fetch()) {
                    $idLastVaga = $linha->idVaga;
                }
            }
            # Chama o procedimento de distribuição dos bolsistas em vaga_tutoria
            $sql = "call sp_incluiVagaTutoria();";
            $smt = Connect::getInstance()->prepare($sql);
            $smt->execute();

            # consulta e armazena os municípios posterior ao último idVaga informado
            $sql1 = "select idVaga, opcao_escolhida, munic_origem, uf_origem, munic_escolhido, uf_escolhida from vaga_tutoria where idVaga > {$idLastVaga}";
            $stm1 = Connect::getInstance()->prepare($sql1);
            if ($stm1->execute()) {
                while ($row = $stm1->fetchObject()) {
                    $idVaga = $row->idVaga;
                    $opEscolhida = "" . $row->opcao_escolhida;
                    $munic_origem = $row->munic_origem;
                    $uf_origem = $row->uf_origem;
                    $munic_escolhido = $row->munic_escolhido;
                    $uf_escolhida = $row->uf_escolhida;

                    $origem = "$munic_origem $uf_origem";
                    $destino = "$munic_escolhido $uf_escolhida";
                    $distancia = 0.00;
                    if (strlen($opEscolhida) < 7) {
                        //var_dump($origem, $destino);
                        $distancia = $this->kilometragemLocal($origem, $destino);
                        //var_dump($distancia);  
                        if (strpos($distancia, "k") !== false) {
                            $distancia = str_replace(" ", "", $distancia);
                            $distancia = str_replace("k", "", $distancia);
                            $distancia = str_replace("m", "", $distancia);
                            $distancia = str_replace(".", "", $distancia);
                            $distancia = str_replace(",", ".", $distancia);
                            //var_dump($distancia);
                        } else {
                            $distancia = 0.00;
                        }
                    }

                    $sql2 = "update vaga_tutoria set distancia = :distancia where idVaga = :idVaga";
                    $stm2 = Connect::getInstance()->prepare($sql2);
                    $stm2->bindValue(':distancia', $distancia);
                    $stm2->bindValue(':idVaga', $idVaga);
                    $stm2->execute();
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

    protected function sp_Escolhe_tutor($id, $opc1, $opc2, $opc3): ?int {
        try {
            $stmt = Connect::getInstance()->prepare("CALL sp_EscolheTutor(:id,:opc1,:opc2,:opc3)");
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':opc1', $opc1);
            $stmt->bindValue(':opc2', $opc2);
            $stmt->bindValue(':opc3', $opc3);
            $stmt->execute();

            $query = "delete from opc_cidade where idMedico = :id";
            $prepStmt = Connect::getInstance()->prepare($query);
            $prepStmt->bindValue(':id', $id);
            $prepStmt->execute();

            $sql = "select idVaga, opcao_escolhida, munic_origem, uf_origem, munic_escolhido, uf_escolhida from vaga_tutoria where idMedico = :id limit 1";
            $stmt1 = Connect::getInstance()->prepare($sql);
            $stmt1->bindValue(':id', $id);
            if ($stmt1->execute()) {
                while ($row = $stmt1->fetchAll()) {
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
                            //var_dump($origem, $destino);
                            $distancia = $this->kilometragemLocal($origem, $destino);
                            //var_dump($distancia, "k");
                            if (strpos($distancia, "k")) {
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
                        $stm2->execute();
                    }
                }
            } else {
                echo "<script>alert('Não existe em vaga_tutoria')</script>";
            }
            return Connect::getInstance()->lastInsertId();
        } catch (\PDOException $erro) {
            echo 'Mensagem de erro: ' . $erro->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $erro->getFile() . "<br>";
            echo 'Linha: ' . $erro->getLine() . "<br>";
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
                    if ($key == 'limit' || $key == 'offset') {
                        $stmt->bindValue(":{$key}", $value, \PDO::PARAM_INT);
                    } else {
                        $stmt->bindValue(":{$key}", $value, \PDO::PARAM_STR);
                    }
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

    public function updateServicoLogisticaPendenciaModel($idservico, $idlogistica, $flagpendencia): ?bool {
        try {
            if ($idservico != null && $idlogistica != null && $flagpendencia != null) {
                $stmt = Connect::getInstance()->prepare("UPDATE servico_logistica SET flagpendencia = :flagpendencia "
                        . "WHERE idservico = :ids and idlogistica = :idl");
                $stmt->bindValue(':flagpendencia', $flagpendencia);
                $stmt->bindValue(':ids', $idservico);
                $stmt->bindValue(':idl', $idlogistica);
                $stmt->execute();
                return true;
            }
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }
    
    public function updateSis_remanejamento_processo_remanejamento_regras_prioridadeModel($FKprocesso, $FKidremanejamento, $Fkidregra_prioridade, $observacao): ?bool {
        try {
            if ($FKprocesso != null && $FKidremanejamento != null && $Fkidregra_prioridade != null) {
                $stmt = Connect::getInstance()->prepare("UPDATE sis_remanejamento_processo_remanejamento_regras_prioridade SET observacao = :obs "
                        . "WHERE FKprocesso = :idproc and FKidremanejamento = :idrem and Fkidregra_prioridade = :idprio");
                $stmt->bindValue(':obs', $observacao);
                $stmt->bindValue(':idproc', $FKprocesso);
                $stmt->bindValue(':idrem', $FKidremanejamento);
                $stmt->bindValue(':idprio', $Fkidregra_prioridade);
                $stmt->execute();
                return true;
            }
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }
    
    public function updateSis_remanejamento_remanejamento_motivoModel($FKidremanejamento, $FKidmotivo, $outro): ?bool {
        try {
            if ($FKidremanejamento != null && $FKidmotivo != null && $outro != null) {
                $stmt = Connect::getInstance()->prepare("UPDATE sis_remanejamento_remanejamento_motivo SET outro = :outr "
                        . "WHERE FKidremanejamento = :FKidreman and FKidmotivo = :FKidmot");
                $stmt->bindValue(':outr', $outro);
                $stmt->bindValue(':FKidreman', $FKidremanejamento);
                $stmt->bindValue(':FKidmot', $FKidmotivo);
                $stmt->execute();
                return true;
            }
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }
    
    public function updateSis_remanejamentoPermutaMotivoModel($FKidpermuta, $FKidmotivo, $outro): ?bool {
        try {
            if ($FKidpermuta != null && $FKidmotivo != null && $outro != null) {
                $stmt = Connect::getInstance()->prepare("UPDATE sis_remanejamento_permuta_motivo SET outro = :outr "
                        . "WHERE FKidpermuta = :FKidperm and FKidmotivo = :FKidmot");
                $stmt->bindValue(':outr', $outro);
                $stmt->bindValue(':FKidperm', $FKidpermuta);
                $stmt->bindValue(':FKidmot', $FKidmotivo);
                $stmt->execute();
                return true;
            }
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    public function updateDiariaInativoModel($idservico, $idlogistica, $flagInativo): ?bool {
        try {
            if ($idservico != null && $idlogistica != null && $flagInativo != null) {
                $stmt = Connect::getInstance()->prepare("UPDATE diaria SET flagInativo = :flagInativo "
                        . "WHERE idservico = :ids and idlogistica = :idl");
                $stmt->bindValue(':flagInativo', $flagInativo);
                $stmt->bindValue(':ids', $idservico);
                $stmt->bindValue(':idl', $idlogistica);
                $stmt->execute();
                return true;
            }
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    public function updateDiarias($idservico, $idlogistica, $descricao, $valorDiaria, $nrdias, $datahorainclusao,
            $idusuarioincluiu, $flagInativo): ?bool {
//        var_dump($idservico, $idlogistica, $descricao, $valorDiaria, $nrdias, $datahorainclusao, 
//            $idusuarioincluiu, $flagInativo);
        try {
            if (!empty($idservico) && !empty($idlogistica)) {
                $stmt = Connect::getInstance()->prepare("UPDATE diaria SET descricao = :descricao, "
                        . "valordiaria = :valorDiaria, nrdias = :nrdias, datahorainclusao = :datahorainclusao, "
                        . "iduserincluiu = :idusuarioincluiu, flagInativo = :flagInativo "
                        . "WHERE idservico = :ids and idlogistica = :idl");
                $stmt->bindValue(':descricao', $descricao);
                $stmt->bindValue(':valorDiaria', $valorDiaria);
                $stmt->bindValue(':nrdias', $nrdias);
                $stmt->bindValue(':datahorainclusao', $datahorainclusao);
                $stmt->bindValue(':idusuarioincluiu', $idusuarioincluiu);
                $stmt->bindValue(':flagInativo', $flagInativo);
                $stmt->bindValue(':ids', $idservico);
                $stmt->bindValue(':idl', $idlogistica);
                $stmt->execute();
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    public function updateDiariasFlagInativo($idservico, $idlogistica, $flagInativo): ?bool {
//        var_dump($idservico, $idlogistica, $flagInativo);
        try {
            if (!empty($idservico) && !empty($idlogistica)) {
                $stmt = Connect::getInstance()->prepare("UPDATE diaria SET flagInativo = :flagInativo "
                        . "WHERE idservico = :ids and idlogistica = :idl");
                $stmt->bindValue(':flagInativo', $flagInativo);
                $stmt->bindValue(':ids', $idservico);
                $stmt->bindValue(':idl', $idlogistica);
                $stmt->execute();
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    public function updateDeslocamentoInativoModel($idservico, $idlogistica, $flagInativo): ?bool {
        try {
            if ($idservico != null && $idlogistica != null && $flagInativo != null) {
                $stmt = Connect::getInstance()->prepare("UPDATE deslocamentoVeiculo SET flagInativo = :flagInativo "
                        . "WHERE idservico = :ids and idlogistica = :idl");
                $stmt->bindValue(':flagInativo', $flagInativo);
                $stmt->bindValue(':ids', $idservico);
                $stmt->bindValue(':idl', $idlogistica);
                $stmt->execute();
                return true;
            }
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    public function callInsertPassagem($idservicoP, $idlogisticaP, $voucherpassagemP, $datahorainclusaoP, $idusuarioincluiuP,
            $tipotransporteP, $empresaP, $cnpjEmpresaP, $uforigemP, $municipioorigemP, $ufdestinoP, $municipiodestinoP,
            $dataembarqueP, $valordeslocamentoP, $sltipocreditoP, $creditoGeralUsadoP, $creditoMedicoUsadoP, $idMedicoP,
            $txtjustificativaP): ?bool {
        try {
            $stmt = Connect::getInstance()->prepare("call insertPassagem('$idservicoP', '$idlogisticaP', '$voucherpassagemP', '$datahorainclusaoP',"
                    . "'$idusuarioincluiuP', '$tipotransporteP', '$empresaP', '$cnpjEmpresaP', '$uforigemP', '$municipioorigemP', '$ufdestinoP', "
                    . "'$municipiodestinoP', '$dataembarqueP', '$valordeslocamentoP', '$sltipocreditoP','$creditoGeralUsadoP', '$creditoMedicoUsadoP', "
                    . "'$idMedicoP', '$txtjustificativaP');");
            $stmt->execute();
            return true;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    protected function sp_Remaneja_tutoria($id, $opc, $tutor,$usuario) {
        //var_dump($id, $opc, $tutor);
        try {
            $a = $distanciatutoria = 0;
            $idmed = $NomeMedico = $CpfMedico = $DataApresentacao = $fone_zap = $email = $idCargo = $nomecargo = $municipioorigem = $uforigem = "";
            $municipioescolhido = $ufescolhida = $idTutor = $nomeTutor = $cpfTutor = $foneTutor = $emailtutor = "";
            $ccidControle = $ccedicao = $FlagRealizouTutoria = $JustificativaTutoria = $FlagDisponibilidade = $FlagSolicitaPassagem = $FlagDispensaHospedagem = array();
            $FlagTermoResponsabilidade = $FlagCienciaPortaria = $FlagDataCreate = $ctInicial = $ctFinal = array();
            $ccid[0] = $ccedicao[0] = $FlagRealizouTutoria[0] = $JustificativaTutoria[0] = $FlagDisponibilidade[0] = $FlagSolicitaPassagem[0] = $FlagDispensaHospedagem[0] = "";
            $FlagTermoResponsabilidade[0] = $FlagCienciaPortaria[0] = $FlagDataCreate[0] = $ctInicial[0] = $ctFinal[0] = "";

            $sqlh = "Select m.NomeMedico, m.CpfMedico, m.DataApresentacao, m.fone_zap, m.email, m.idCargo, "
                    . "mu.municipio as municipioorigem, e.UF as uforigem from medico m inner join municipio mu on mu.cod_munc = m.Municipio_id "
                    . "inner join estado e on e.cod_uf = mu.Estado_cod_uf where m.idMedico = :id";
            $stm1 = Connect::getInstance()->prepare($sqlh);
            $stm1->bindValue(':id', $id);
            if ($stm1->execute() or die(Connect::getInstance()->errorInfo())) {
                while ($row = $stm1->fetch()) {
                    //var_dump($row);
                    $idmed = $id;
                    $NomeMedico = $row->NomeMedico;
                    $CpfMedico = $row->CpfMedico;
                    $DataApresentacao = $row->DataApresentacao;
                    $fone_zap = $row->fone_zap;
                    $email = $row->email;
                    $idCargo = $row->idCargo;
                    $municipioorigem = $row->municipioorigem;
                    $uforigem = $row->uforigem;

                    if ($idCargo == 1) {
                        $nomecargo = "Medico de Familia e Comunidade";
                    } else {
                        $nomecargo = "Tutor Medico";
                    }
                }
            }
            if ($idCargo == 1) {
                $sqlh = "Select vt.idTutor,mt.NomeMedico,mt.CpfMedico,mt.fone_zap,mt.email,vt.munic_escolhido as municipioescolhido, 
                        vt.uf_escolhida as ufescolhida 
                        from vaga_tutoria vt 
                        inner join medico mt on mt.idMedico = vt.idTutor
                        where vt.idMedico = :id";
                $stm2 = Connect::getInstance()->prepare($sqlh);
                $stm2->bindValue(':id', $id);
                if ($stm2->execute() or die(Connect::getInstance()->errorInfo())) {
                    while ($row2 = $stm2->fetch()) {
                        //var_dump($row2);
                        $nomeTutor = $row2->NomeMedico;
                        $cpfTutor = $row2->CpfMedico;
                        $foneTutor = $row2->fone_zap;
                        $emailtutor = $row2->email;        
                        $municipioescolhido = $row2->municipioescolhido;
                        $ufescolhida = $row2->ufescolhida;
                        $idTutor = $row2->idTutor;
                    }
                }

                $sqlh2 = "Select cc.idControle, cc.Edicao, cc.FlagRealizouTutoria, cc.JustificativaTutoria, cc.FlagDisponibilidade, "
                        . "cc.FlagSolicitaPassagem, cc.FlagDispensaHospedagem, cc.FlagTermoResponsabilidade, cc.FlagCienciaPortaria, "
                        . "cc.DataCreate, ct.PeriodoInicial, ct.PeriodoFinal from ControleCalendario cc inner join CalendarioTutoria ct "
                        . "on cc.idCalendario = ct.idCalendario and cc.Edicao = ct.Edicao where cc.idMedico = :id";
                $stm3 = Connect::getInstance()->prepare($sqlh2);
                $stm3->bindValue(':id', $id);
                if ($stm3->execute() or die(Connect::getInstance()->errorInfo())) {
                    while ($row3 = $stm3->fetchAll()) {
                        //var_dump($row3);
                        foreach ($row3 as $value) {
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
                                . ":fone_zap, :email, :nomecargo, :municipioorigem, :uforigem,"
                                . ":nomeTutor, :cpfTutor, :foneTutor, :emailtutor, :distanciatutoria, :municipioescolhido, "
                                . ":ufescolhida, :ctInicial, :ctFinal, :ccedicao,"
                                . ":FlagRealizouTutoria, :JustificativaTutoria, :FlagDisponibilidade, :FlagSolicitaPassagem, "
                                . ":FlagDispensaHospedagem, :FlagTermoResponsabilidade, :FlagCienciaPortaria, :FlagDataCreate, "
                                . "'Remanejamento de bolsista',4,now(),:user);";
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
                        $stm->bindValue(':nomeTutor', $nomeTutor);
                        $stm->bindValue(':cpfTutor', $cpfTutor);
                        $stm->bindValue(':foneTutor', $foneTutor);
                        $stm->bindValue(':emailtutor', $emailtutor);
                        $stm->bindValue(':distanciatutoria', $distanciatutoria);
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
                        $stm->bindValue(':user', $usuario);
                        $stm->execute()or die(Connect::getInstance()->errorInfo());
                    } else {
                        $sql = "insert into historico values (null, :idmed, :NomeMedico, :CpfMedico, :DataApresentacao,"
                                . ":fone_zap, :email, :nomecargo, :municipioorigem, :uforigem,"
                                . ":nomeTutor, :cpfTutor,:foneTutor, :emailtutor, :distanciatutoria, :municipioescolhido, :ufescolhida, "
                                . "'', '', '', '', '', '', '', '', '', '', '', "
                                . "'Remanejamento de bolsista',4,now(),:user);";
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
                        $stm->bindValue(':nomeTutor', $nomeTutor);
                        $stm->bindValue(':cpfTutor', $cpfTutor);
                        $stm->bindValue(':foneTutor', $foneTutor);
                        $stm->bindValue(':emailtutor', $emailtutor);
                        $stm->bindValue(':distanciatutoria', $distanciatutoria);
                        $stm->bindValue(':municipioescolhido', $municipioescolhido);
                        $stm->bindValue(':ufescolhida', $ufescolhida);                        
                        $stm->bindValue(':user', $usuario);
                        $stm->execute() or die(Connect::getInstance()->errorInfo());
                    }
                }
            } else {
                $sql = "insert into historico values (null, :idmed, :NomeMedico, :CpfMedico, :DataApresentacao,"
                        . ":fone_zap, :email, :nomecargo, :municipioorigem, :uforigem,"
                        . ":nomeTutor, :cpfTutor,:foneTutor,:emailTutor,:distanciaTutoria, :municipioescolhido, :ufescolhida, "
                        . ":ctInicial, :ctFinal, :ccedicao,"
                        . ":FlagRealizouTutoria, :JustificativaTutoria, :FlagDisponibilidade, :FlagSolicitaPassagem, "
                        . ":FlagDispensaHospedagem, :FlagTermoResponsabilidade, :FlagCienciaPortaria, :FlagDataCreate, "
                        . "'Remanejamento de bolsista',4,now(),:user);";

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
                $stm->bindValue(':nomeTutor', $nomeTutor);
                $stm->bindValue(':cpfTutor', $cpfTutor);
                $stm->bindValue(':foneTutor', $foneTutor);
                $stm->bindValue(':emailTutor', $emailTutor);
                $stm->bindValue(':distanciaTutoria', $distanciatutoria);
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
                $stm->bindValue(':user', $usuario);
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

    /**
     * @return bool
     */
    protected function required(): bool {
        $data = (array) $this->data();
        foreach (static::$required as $field) {
            if (empty($data[$field])) {
                return false;
            }
        }
        return true;
    }

    //proc para remover o bolsista da tutoria e enviar os dados para historico
    public function CallProcRemoveBolsistaTutoria($idMedico, $idVaga, $ocorrencia,$usuario): bool {
        try {
            $stm = Connect::getInstance()->prepare("CALL sp_removeBolsistaTutoria(:idMedico,:idVaga,:ocorrencia,:user)");
            $stm->bindValue(':idMedico', $idMedico);
            $stm->bindValue(':idVaga', $idVaga);
            $stm->bindValue(':ocorrencia', $ocorrencia);
            $stm->bindValue(':user', $usuario);
            $stm->execute();
            return true;
        } catch (PDOException $ex) {
            echo 'Mensagem de erro: ' . $ex->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $ex->getFile() . "<br>";
            echo 'Linha: ' . $ex->getLine() . "<br>";
            return false;
        }
    }

    //proc para remover tutor e enviar os dados para historico
    public function CallProcRemoveTutor($idTutor,$usuario): bool {
        try {
            $stm = Connect::getInstance()->prepare("CALL sp_removeTutor(:idTutor,:user)");
            $stm->bindValue(':idTutor', $idTutor);
            $stm->bindValue(':user', $usuario);
            $stm->execute();
            return true;
        } catch (PDOException $ex) {
            echo 'Mensagem de erro: ' . $ex->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $ex->getFile() . "<br>";
            echo 'Linha: ' . $ex->getLine() . "<br>";
            return false;
        }
    }

    //proc para inativar o bolsista e enviar os dados para historico
    public function CallProcInatividadeBolsista($idMedico, $motivo, $usuario): bool {
        try {
            $stm = Connect::getInstance()->prepare("CALL sp_inatividadeBolsista(:idMedico, :motivo,:user)");
            $stm->bindValue(':idMedico', $idMedico);
            $stm->bindValue(':motivo', $motivo);
            $stm->bindValue(':user', $usuario);
            $stm->execute();
            return true;
        } catch (PDOException $ex) {
            echo 'Mensagem de erro: ' . $ex->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $ex->getFile() . "<br>";
            echo 'Linha: ' . $ex->getLine() . "<br>";
            return false;
        }
    }

    //proc para inativar o tutor e retirar seus respectivos bolsistas da tutoria e enviar os dados para historico
    public function CallProcInatividadeTutor($idTutor, $motivo,$usuario): bool {
        try {
            $stm = Connect::getInstance()->prepare("CALL sp_inatividadeTutor(:idTutor, :motivo, :user)");
            $stm->bindValue(':idTutor', $idTutor);
            $stm->bindValue(':motivo', $motivo);
            $stm->bindValue(':user', $usuario);
            $stm->execute();
            return true;
        } catch (PDOException $ex) {
            echo 'Mensagem de erro: ' . $ex->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $ex->getFile() . "<br>";
            echo 'Linha: ' . $ex->getLine() . "<br>";
            return false;
        }
    }

    public function sp_ControlaCalendarioComplemento($edicao, $idCalendario): bool {
        try {
            $stm = Connect::getInstance()->prepare("CALL sp_ControlaCalendarioComplemento(:edicao,:idCalendario)");
            $stm->bindValue(':edicao', $edicao);
            $stm->bindValue(':idCalendario', $idCalendario);
            $stm->execute();
            return true;
        } catch (PDOException $ex) {
            echo 'Mensagem de erro: ' . $ex->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $ex->getFile() . "<br>";
            echo 'Linha: ' . $ex->getLine() . "<br>";
            return false;
        }
    }

    //atualiza controlecalendario limpando os campos FlagRealizouTutoria e JustificativaTutoria a pedido do tutor
    public function retirarJustificativaModel($idControle): bool {
        try {
            $stm = Connect::getInstance()->prepare("update ControleCalendario set FlagRealizouTutoria = null, "
                    . "JustificativaTutoria = null where idControle = :idControle");
            $stm->bindValue(':idControle', $idControle);
            $stm->execute();
            return true;
        } catch (PDOException $ex) {
            echo 'Mensagem de erro: ' . $ex->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $ex->getFile() . "<br>";
            echo 'Linha: ' . $ex->getLine() . "<br>";
            return false;
        }
    }

    public function kilometragemLocal($o, $d) {
        set_time_limit(500);
        try {
            $origem = str_replace(" ", "%20", $o);
            $destino = str_replace(" ", "%20", $d);
            //var_dump($origem,$destino);            
            $link = "https://maps.googleapis.com/maps/api/distancematrix/xml?origins=$origem&destinations=$destino&mode=driving&language=pt-BR&sensor=false&key=AIzaSyAK_RhiP5TiLfA3qK4mBCMGby2yjS_a4is";

            $novolink = curl_init();
            curl_setopt($novolink, CURLOPT_URL, "$link");
            curl_setopt($novolink, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($novolink, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($novolink, CURLOPT_MAXCONNECTS, 10);
            curl_setopt($novolink, CURLOPT_TIMEOUT, 5);
            $output = curl_exec($novolink);
            //var_dump($output);
            curl_close($novolink);

            $output = str_replace("\n", " ", $output);

            preg_match_all("/<origin_address>(.*?)<\/origin_address>/", $output, $a); //origem

            preg_match_all("/<destination_address>(.*?)<\/destination_address>/", $output, $b); //destino

            preg_match_all("/<duration>(.*?)<\/duration>/", $output, $c0);
            preg_match_all("/<text>(.*?)<\/text>/", $c0[1][0], $c);  //duracao

            preg_match_all("/<distance>(.*?)<\/distance>/", $output, $d0);
            preg_match_all("/<text>(.*?)<\/text>/", $d0[1][0], $d);  //distancia
            $orig = $a[1][0];
            $destn = $b[1][0];
            $distanc = $d[1][0];
            $duracion = $c[1][0];
            //var_dump($orig , $destn , $distanc , $duracion );
        } catch (Exception $ex) {
            $distanc = 0;
        }

        return $distanc;
    }

}
