<?php

namespace app\core\models\dao\base;

interface InterfaceDao{

    /**
     * Devuelve un registro especifico desde la base de datos.
     * @param int $id Identificador del registro.
     * @return array Resultados de la búsqueda.
     */
    public function load(int $id): array;

    /**
     * Persiste los datos de la BD.
     * @param array $data Datos a guardar, previamente validados.
     */
    public function save(array $data): void;

    /**
     * Actualiza los datos de registro en base de datos.
     * @param array $data Datos a actualizar, previamente validados.
     */
    public function update(array $data): void;

    /**
     * Eliminar un registro de la base de datos.
     * @param int $id Identificador del registro a eliminar.
     */
    public function delete(int $id): void;

    /**
     * Devuelve un listado de registros según las coincidencias encontradas.
     * @param array $filters Filtros que se aplicarán en la búsqueda.
     * @return array Resultados de la búsqueda.
     */
    public function list(array $filters): array;

}