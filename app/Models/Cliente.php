<?php

namespace App\Models;

use App\Core\Database;
use PDOException;

class Cliente {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Lista todos os clientes cadastrados
     * @return array
     */
    public function listarTodos() {
        try {
            $sql = "SELECT * FROM clientes ORDER BY nome ASC";
            return $this->db->query($sql)->fetchAll();
        } catch (\Exception $e) {
            error_log("Erro ao listar clientes: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Busca um cliente pelo ID
     * @param int $id ID do cliente
     * @return array|false
     */
    public function buscarPorId($id) {
        try {
            $sql = "SELECT * FROM clientes WHERE id = :id";
            $params = [':id' => $id];
            return $this->db->query($sql, $params)->fetch();
        } catch (\Exception $e) {
            error_log("Erro ao buscar cliente por ID: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Verifica se já existe um cliente com o mesmo nome e telefone
     * @param string $nome Nome do cliente
     * @param string $telefone Telefone do cliente
     * @param int|null $ignorarId ID do cliente a ser ignorado na verificação (usado em atualizações)
     * @return bool
     */
    public function existeClienteComMesmosDados($nome, $telefone, $ignorarId = null) {
        try {
            // Remove caracteres não numéricos do telefone
            $telefone = preg_replace('/[^0-9]/', '', $telefone);
            
            $sql = "SELECT COUNT(*) FROM clientes WHERE nome = :nome AND telefone = :telefone";
            $params = [':nome' => $nome, ':telefone' => $telefone];

            if ($ignorarId) {
                $sql .= " AND id != :id";
                $params[':id'] = $ignorarId;
            }

            error_log("Verificando duplicata - SQL: " . $sql);
            error_log("Parâmetros: " . json_encode($params));

            $count = $this->db->query($sql, $params)->fetchColumn();
            error_log("Resultado da verificação de duplicata: " . $count);
            
            return $count > 0;
        } catch (\Exception $e) {
            error_log("Erro ao verificar duplicata: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Cria um novo cliente
     * @param array $dados Dados do cliente
     * @return bool
     */
    public function criar($dados) {
        try {
            error_log("Iniciando criação de cliente: " . json_encode($dados));
            
            // Formata o telefone antes de verificar duplicatas
            $telefone = preg_replace('/[^0-9]/', '', $dados['telefone']);
            
            // Verifica se já existe um cliente com os mesmos dados
            if ($this->existeClienteComMesmosDados($dados['nome'], $telefone)) {
                throw new \Exception("Já existe um cliente cadastrado com este nome e telefone.");
            }

            $this->db->beginTransaction();

            // Remove campos vazios e formata dados
            $dados = array_filter($dados, function($value) {
                return $value !== null && $value !== '';
            });

            // Garante que o telefone está formatado
            $dados['telefone'] = $telefone;

            $campos = array_keys($dados);
            $valores = array_map(function($campo) {
                return ':' . $campo;
            }, $campos);

            $sql = "INSERT INTO clientes (" . implode(', ', $campos) . ") 
                    VALUES (" . implode(', ', $valores) . ")";

            error_log("SQL gerado: " . $sql);

            $params = array_combine($valores, array_values($dados));
            error_log("Parâmetros: " . json_encode($params));
            
            $stmt = $this->db->query($sql, $params);
            
            if ($stmt) {
                $this->db->commit();
                error_log("Cliente criado com sucesso!");
                return true;
            } else {
                $this->db->rollback();
                error_log("Erro ao executar query de inserção");
                return false;
            }
        } catch (PDOException $e) {
            $this->db->rollback();
            error_log("Erro PDO ao criar cliente: " . $e->getMessage());
            error_log("Código do erro: " . $e->getCode());
            
            // Se for violação de chave única
            if ($e->getCode() == '23000') {
                throw new \Exception("Já existe um cliente cadastrado com este nome e telefone.");
            }
            
            throw new \Exception("Erro ao salvar o cliente no banco de dados: " . $e->getMessage());
        } catch (\Exception $e) {
            $this->db->rollback();
            error_log("Erro ao criar cliente: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Atualiza os dados de um cliente
     * @param int $id ID do cliente
     * @param array $dados Dados do cliente
     * @return bool
     */
    public function atualizar($id, $dados) {
        try {
            error_log("Iniciando atualização do cliente {$id}: " . json_encode($dados));
            
            // Formata o telefone antes de verificar duplicatas
            $telefone = preg_replace('/[^0-9]/', '', $dados['telefone']);
            
            // Verifica se já existe um cliente com os mesmos dados
            if ($this->existeClienteComMesmosDados($dados['nome'], $telefone, $id)) {
                throw new \Exception("Já existe um cliente cadastrado com este nome e telefone.");
            }

            $this->db->beginTransaction();

            // Remove campos vazios e formata dados
            $dados = array_filter($dados, function($value) {
                return $value !== null && $value !== '';
            });

            // Garante que o telefone está formatado
            $dados['telefone'] = $telefone;

            $sets = array_map(function($campo) {
                return "$campo = :$campo";
            }, array_keys($dados));

            $sql = "UPDATE clientes SET " . implode(', ', $sets) . " WHERE id = :id";
            error_log("SQL gerado: " . $sql);
            
            $params = array_combine(
                array_map(function($campo) { return ':' . $campo; }, array_keys($dados)),
                array_values($dados)
            );
            $params[':id'] = $id;
            error_log("Parâmetros: " . json_encode($params));

            $stmt = $this->db->query($sql, $params);
            
            if ($stmt) {
                $this->db->commit();
                error_log("Cliente atualizado com sucesso!");
                return true;
            } else {
                $this->db->rollback();
                error_log("Erro ao executar query de atualização");
                return false;
            }
        } catch (PDOException $e) {
            $this->db->rollback();
            error_log("Erro PDO ao atualizar cliente: " . $e->getMessage());
            error_log("Código do erro: " . $e->getCode());
            
            // Se for violação de chave única
            if ($e->getCode() == '23000') {
                throw new \Exception("Já existe um cliente cadastrado com este nome e telefone.");
            }
            
            throw new \Exception("Erro ao atualizar o cliente no banco de dados: " . $e->getMessage());
        } catch (\Exception $e) {
            $this->db->rollback();
            error_log("Erro ao atualizar cliente: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Exclui um cliente
     * @param int $id ID do cliente
     * @return bool
     */
    public function excluir($id) {
        try {
            $this->db->beginTransaction();

            $sql = "DELETE FROM clientes WHERE id = :id";
            $params = [':id' => $id];
            
            $stmt = $this->db->query($sql, $params);
            
            if ($stmt) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollback();
                return false;
            }
        } catch (\Exception $e) {
            $this->db->rollback();
            error_log("Erro ao excluir cliente: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Verifica se um cliente já existe pelo CNPJ
     * @param string $cnpj CNPJ do cliente
     * @param int|null $ignorarId ID do cliente a ser ignorado na verificação (usado em atualizações)
     * @return bool
     */
    public function existeCNPJ($cnpj, $ignorarId = null) {
        try {
            // Remove caracteres não numéricos do CNPJ
            $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
            
            $sql = "SELECT COUNT(*) FROM clientes WHERE cnpj = :cnpj";
            $params = [':cnpj' => $cnpj];

            if ($ignorarId) {
                $sql .= " AND id != :id";
                $params[':id'] = $ignorarId;
            }

            $count = $this->db->query($sql, $params)->fetchColumn();
            return $count > 0;
        } catch (\Exception $e) {
            error_log("Erro ao verificar CNPJ: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Conta o total de clientes ativos
     * @return int Total de clientes ativos
     */
    public function contarAtivos() {
        try {
            $sql = "SELECT COUNT(*) FROM clientes WHERE status = 'ativo'";
            return (int) $this->db->query($sql)->fetchColumn();
        } catch (\Exception $e) {
            error_log("Erro ao contar clientes ativos: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Retorna os últimos clientes cadastrados
     * @param int $limite Número máximo de clientes a retornar
     * @return array Lista dos últimos clientes
     */
    public function buscarUltimos($limite = 5) {
        try {
            $sql = "SELECT * FROM clientes ORDER BY id DESC LIMIT :limite";
            return $this->db->query($sql, [':limite' => $limite])->fetchAll();
        } catch (\Exception $e) {
            error_log("Erro ao buscar últimos clientes: " . $e->getMessage());
            return [];
        }
    }
}
