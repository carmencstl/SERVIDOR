<?php

namespace Blogify\Interfaces;

/**
 * Interfaz para la gestión de la base de datos
 */
interface DatabaseInterface
{
    /**
     * Obtiene la instancia única de la clase (Singleton)
     * @return Database
     */
    public static function getInstance();
    
    /**
     * Obtiene la conexión PDO
     * @return \PDO
     */
    public function getConnection();
    
    /**
     * Ejecuta una consulta preparada
     * @param string $sql Consulta SQL
     * @param array $params Parámetros para bindear
     * @return \PDOStatement
     */
    public function query($sql, $params = []);
    
    /**
     * Inserta un registro en la tabla especificada
     * @param string $table Nombre de la tabla
     * @param array $data Datos a insertar (clave => valor)
     * @return int ID del registro insertado
     */
    public function insert($table, $data);
    
    /**
     * Actualiza registros en la tabla especificada
     * @param string $table Nombre de la tabla
     * @param array $data Datos a actualizar
     * @param string $where Condición WHERE
     * @param array $whereParams Parámetros para la condición
     * @return int Número de filas afectadas
     */
    public function update($table, $data, $where, $whereParams = []);
    
    /**
     * Elimina registros de la tabla especificada
     * @param string $table Nombre de la tabla
     * @param string $where Condición WHERE
     * @param array $whereParams Parámetros para la condición
     * @return int Número de filas eliminadas
     */
    public function delete($table, $where, $whereParams = []);
    
    /**
     * Selecciona registros de la tabla especificada
     * @param string $table Nombre de la tabla
     * @param string $where Condición WHERE (opcional)
     * @param array $whereParams Parámetros para la condición
     * @return array Registros encontrados
     */
    public function select($table, $where = '', $whereParams = []);
}
