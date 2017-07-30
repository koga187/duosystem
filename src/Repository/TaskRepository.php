<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 1:39 PM
 */

namespace Duosystem\Repository;


use Duosystem\Entity\TaskEntity;

class TaskRepository
{
    const tableName = 'task';

    public static function insertNewTask() {
        return 'INSERT INTO ' . self::tableName . ' (name, description, situation, dt_begin, dt_end, dt_created, task_status_idtask) VALUES 
          ( :name, :description, :situation, :dt_begin, :dt_end, :dt_created, :task_status_idtask);';
    }

    public static function selectTaskById() {
        return 'SELECT idtask, name, description, situation, dt_begin, dt_end, dt_created, deleted, dt_deleted, task_status_idtask 
          FROM ' . self::tableName . ' WHERE idtask = :idtask;';
    }

    public static function selectAllTasks(array $filter = null, $paginate) {
        $where = self::getFilter($filter);

        return 'SELECT idtask, name, description, situation, dt_begin, dt_end, dt_created, deleted, dt_deleted, task_status_idtask 
                FROM ' . self::tableName . $where . ' ORDER BY idtask ASC LIMIT ' . $paginate['start_from'] . ', ' . $paginate['limit'] . ';';
    }

    public static function selectTotalTasks(array $filter = null) {
        $where = self::getFilter($filter);

        return 'SELECT COUNT(1) as total FROM ' . self::tableName . ' ' . $where . ';';
    }

    public static function updateTask() {
        return 'UPDATE ' . self::tableName . ' SET name = :name, description = :description, situation = :situation, dt_begin = :dt_begin, dt_end = :dt_end, dt_created = :dt_created, task_status_idtask = :task_status_idtask 
            WHERE idtask = :idtask';
    }

    public static function getFilter(array $filter = null) {
        $where = '';

        if (!is_null($filter)) {
            foreach ($filter as $nameField => $filterField) {
                if (!is_null($filterField)  && (!empty($filterField) || (count(trim($filterField)) > 0  && $filterField === '0'))) {
                    $where .= (trim($where) == '') ? " WHERE $nameField = :$nameField " : " AND $nameField = :$nameField";
                }
            }
        }

        return $where;
    }

    public static function getArgs(array $filter = null) {
        $arrayArgs = [];
        $teste = '0';

        if (!is_null($filter)) {
            foreach ($filter as $nameField => $filterField) {
                if (!is_null($filterField) && (!empty($filterField) || (count(trim($filterField)) > 0  && $filterField === '0'))) {
                    $arrayArgs[$nameField] = $filterField;
                }
            }
        }

        return $arrayArgs;
    }
}