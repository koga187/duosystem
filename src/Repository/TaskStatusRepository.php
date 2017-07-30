<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 1:39 PM
 */

namespace Duosystem\Repository;


class TaskStatusRepository
{
    const tableName = 'task_status';

    public static function selectActiveStatus() {
        return 'SELECT idtaskstatus, name FROM ' . self::tableName . ' WHERE deleted IS NULL;';
    }
}