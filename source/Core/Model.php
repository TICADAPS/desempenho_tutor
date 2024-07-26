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

    public function updateMedicoQualificlinicaModel($idservico, $idlogistica, $flagpendencia): ?bool {
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
