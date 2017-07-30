<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 1:41 PM
 */

namespace Duosystem\Model;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use Duosystem\Core\DatabaseConnection;
use Duosystem\Repository\TaskStatusRepository;

class TaskStatusModel
{
    public static  function getActiveStatus(DatabaseConnection $databaseConnection) {

        $stmt = $databaseConnection->query(TaskStatusRepository::selectActiveStatus());

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}