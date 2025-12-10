<?php

namespace Blogify\Database;

use Blogify\Interfaces\DatabaseInterface;
use PDO;
use PDOException;

/**
 * Clase para gestionar la conexión y operaciones con la base de datos
 * Implementa el patrón Singleton
 */
class Database implements DatabaseInterface
{
    private static $instance = null;
    private $connection;

    private $host = 'db';
    private $dbname = 'Blogify';
    private $username = 'root';
    private $password = 'root';
    
    /**
     * Constructor privado para evitar instanciación directa
     */
    private function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    /**
     * Previene la clonación del objeto
     */
    private function __clone() {}
    
    /**
     * Previene la deserialización del objeto
     */
    public function __wakeup()
    {
        throw new \Exception("No se puede deserializar un singleton");
    }
    
    /**
     * Obtiene la instancia única de la clase (Singleton)
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Obtiene la conexión PDO
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }
    
    /**
     * Ejecuta una consulta preparada
     * @param string $sql Consulta SQL
     * @param array $params Parámetros para bindear
     * @return \PDOStatement
     */
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Error en query: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Inserta un registro en la tabla especificada
     * @param string $table Nombre de la tabla
     * @param array $data Datos a insertar (clave => valor)
     * @return int ID del registro insertado
     */
    public function insert($table, $data)
    {
        $campos = array_keys($data);
        $placeholders = [];
        
        foreach ($campos as $campo) {
            $placeholders[] = ":{$campo}";
        }
        
        $sql = "INSERT INTO {$table} (" . implode(', ', $campos) . ") 
                VALUES (" . implode(', ', $placeholders) . ")";
        
        $stmt = $this->connection->prepare($sql);
        
        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":{$campo}", $valor);
        }
        
        $stmt->execute();
        return $this->connection->lastInsertId();
    }
    
    /**
     * Actualiza registros en la tabla especificada
     * @param string $table Nombre de la tabla
     * @param array $data Datos a actualizar
     * @param string $where Condición WHERE
     * @param array $whereParams Parámetros para la condición
     * @return int Número de filas afectadas
     */
    public function update($table, $data, $where, $whereParams = [])
    {
        $campos = [];
        
        foreach ($data as $campo => $valor) {
            $campos[] = "{$campo} = :{$campo}";
        }
        
        $sql = "UPDATE {$table} SET " . implode(', ', $campos) . " WHERE {$where}";
        $stmt = $this->connection->prepare($sql);
        
        foreach ($data as $campo => $valor) {
            $stmt->bindValue(":{$campo}", $valor);
        }
        
        foreach ($whereParams as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    /**
     * Elimina registros de la tabla especificada
     * @param string $table Nombre de la tabla
     * @param string $where Condición WHERE
     * @param array $whereParams Parámetros para la condición
     * @return int Número de filas eliminadas
     */
    public function delete($table, $where, $whereParams = [])
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $this->connection->prepare($sql);
        
        foreach ($whereParams as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    /**
     * Selecciona registros de la tabla especificada
     * @param string $table Nombre de la tabla
     * @param string $where Condición WHERE (opcional)
     * @param array $whereParams Parámetros para la condición
     * @return array Registros encontrados
     */
    public function select($table, $where = '', $whereParams = [])
    {
        $sql = "SELECT * FROM {$table}";
        
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        
        $stmt = $this->connection->prepare($sql);
        
        foreach ($whereParams as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
