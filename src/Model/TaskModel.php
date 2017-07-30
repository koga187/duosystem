<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 1:29 PM
 */

namespace Duosystem\Model;

use Duosystem\Core\DatabaseConnection;
use Duosystem\Entity\TaskEntity;
use Duosystem\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Request;
use Respect\Validation\Validator as v;

class TaskModel
{
    /**
     * @var TaskEntity
     */
    private $entity;

    private $paginationLimit = 10;

    /**
     * @param Request $request
     * @return TaskEntity
     * @throws ValidationException
     */
    public function popEntityWithFormInfo(Request $request): TaskEntity
    {

        $this->entity = (new TaskEntity())
            ->setDtBegin(new \DateTime($request->request->get('task_dt_begin')))
            ->setDtEnd(new \DateTime($request->request->get('task_dt_end')))
            ->setSituation($request->request->get('task_situation'))
            ->setTaskStatus($request->request->get('task_status'))
            ->setName($request->request->get('task_name'))
            ->setId((!is_null($request->request->get('task_id')) ? intval($request->request->get('task_id')) : null))
            ->setDescription($request->request->get('task_description'))
            ->setDtCreated(new \DateTime('now'));

        self::validateFormInfo();

        return $this->entity;
    }

    /**
     * @return bool
     */
    public function validateFormInfo()
    {
        return v::attribute('situation', v::intVal()->setTemplate('A situação precisa estar preenchida'))
            ->attribute('dtBegin', v::date()->setTemplate('A situação precisa estar preenchida'))
            ->attribute('dtEnd', v::optional(v::date())->setTemplate('A situação precisa estar preenchida'))
            ->attribute('taskStatus', v::intVal()->length(1, 1)->setTemplate('A situação precisa estar preenchida'))
            ->attribute('name', v::stringType()->length(1, 255)->setTemplate('A situação precisa estar preenchida'))
            ->attribute('description', v::stringType()->length(1, 600)->setTemplate('A situação precisa estar preenchida'))
            ->attribute('dtCreated', v::date()->setTemplate('A situação precisa estar preenchida'))
            ->assert($this->entity);
    }

    /**
     * @param DatabaseConnection $databaseConnection
     * @return TaskEntity
     * @throws \ErrorException
     */
    public function saveTask(DatabaseConnection $databaseConnection)
    {
        if (!is_null($this->entity)) {
            try {
                self::validateInsertInfo();
                $databaseConnection->query(TaskRepository::insertNewTask(), [
                    ':name' => $this->entity->getName(),
                    ':description' => $this->entity->getDescription(),
                    ':situation' => $this->entity->getSituation(),
                    ':dt_begin' => $this->entity->getDtBegin()->format('Y-m-d'),
                    ':dt_end' => (!is_null($this->entity->getDtEnd())) ? $this->entity->getDtEnd()->format('Y-m-d') : NULL,
                    ':dt_created' => $this->entity->getDtCreated()->format('Y-m-d'),
                    ':task_status_idtask' => $this->entity->getTaskStatus(),
                ]);

                $this->entity->setId($databaseConnection->getLastInsertId());

                return $this->entity;

            } catch (\ErrorException $e) {
                if($e->getCode() == 456) {
                    throw new \ErrorException($e->getMessage(), 600, 1, __FILE__, __LINE__);
                }

                throw new \ErrorException('Ocorreu algum erro na inserção dos valores no banco, por favor contate o administrador.', 600, 1, __FILE__, __LINE__);
            }

        } else {
            throw new \ErrorException('Você precisa usar a função popEntityWithFormInfo para popular a entidade.', 564, 1, __FILE__, __LINE__);
        }
    }

    /**
     * @return array
     */
    public static function getFormParams() {
        $taskStatus = TaskStatusModel::getActiveStatus(DatabaseConnection::getInstance());
        $taskSituation = (new TaskSituationModel)->getValues();

        return [
            'taskStatus' => $taskStatus,
            'taskSituation' => $taskSituation
        ];
    }

    /**
     * @param DatabaseConnection $databaseConnection
     * @param int $id
     * @return array
     * @throws \ErrorException
     */
    public static function getTaskById(DatabaseConnection $databaseConnection, int $id): array {
        try {
            $stmt = $databaseConnection->query(TaskRepository::selectTaskById(), [':idtask' => $id]);

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\ErrorException $e) {
            throw new \ErrorException('Ocorreu algum erro na seleção dos valores entre em contato com o administrador do sistema.', 600, 1, __FILE__, __LINE__);
        }
    }

    public function getTaskList(DatabaseConnection $databaseConnection, int $page = 1, array $filter = null) {
        try {
            $limit = $this->paginationLimit;
            $start_from = ($page - 1) * $this->paginationLimit;
            $stmt = $databaseConnection->query(
                TaskRepository::selectAllTasks($filter, [
                    'start_from' => $start_from,
                    'limit'      => $limit
                ]),
                TaskRepository::getArgs($filter)
            );
            $stmtTotal = $databaseConnection->query(TaskRepository::selectTotalTasks($filter), TaskRepository::getArgs($filter));

            $total = $stmtTotal->fetch(\PDO::FETCH_ASSOC)['total'];
            $totalPaginas = ceil($total / $this->paginationLimit);

            return [
                'lista' => $stmt->fetchAll(\PDO::FETCH_ASSOC),
                'totalPages' => $totalPaginas,
                'totalTasks' => $total
            ];

        } catch (\ErrorException $e) {
            throw new \ErrorException('Ocorreu algum erro na seleção dos valores entre em contato com o administrador do sistema.', 600, 1, __FILE__, __LINE__);
        }
    }

    public function updateTask(DatabaseConnection $databaseConnection) {
        if (!is_null($this->entity)) {
            try {
                self::validateUpdateInfo($databaseConnection);
                self::validateInsertInfo();
                $databaseConnection->query(TaskRepository::updateTask(), [
                    ':idtask' => $this->entity->getId(),
                    ':name' => $this->entity->getName(),
                    ':description' => $this->entity->getDescription(),
                    ':situation' => $this->entity->getSituation(),
                    ':dt_begin' => $this->entity->getDtBegin()->format('Y-m-d'),
                    ':dt_end' => (!is_null($this->entity->getDtEnd())) ? $this->entity->getDtEnd()->format('Y-m-d') : NULL,
                    ':dt_created' => $this->entity->getDtCreated()->format('Y-m-d'),
                    ':task_status_idtask' => $this->entity->getTaskStatus(),
                ]);

                return $this->entity;

            } catch (\ErrorException $e) {
                if($e->getCode() == 456) {
                    throw new \ErrorException($e->getMessage(), 600, 1, __FILE__, __LINE__);
                }

                throw new \ErrorException('Ocorreu algum erro na alteração dos valores no banco, por favor contate o administrador.', 600, 1, __FILE__, __LINE__);
            }

        } else {
            throw new \ErrorException('Você precisa usar a função popEntityWithFormInfo para popular a entidade.', 564, 1, __FILE__, __LINE__);
        }
    }

    /**
     * @param DatabaseConnection $databaseConnection
     * @throws \ErrorException
     */
    public function validateUpdateInfo(DatabaseConnection $databaseConnection) {

        $stmt = $databaseConnection->query(TaskRepository::selectTaskById(), [':idtask' => $this->entity->getId()]);

        $arrayTaskDataBase = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($arrayTaskDataBase['task_status_idtask'] == 4) {
            throw new \ErrorException('Esta tarefa não pode ser alterada, esta ação será reportada.', 456, 999);
        }
    }

    public function validateInsertInfo() {
        if ($this->entity->getTaskStatus() == 4 && is_null($this->entity->getDtEnd())) {
            throw new \ErrorException('Você precisa preencher a data final se quiser alterar o status para conluido.', 456, 999);
        }
        if (is_null($this->entity->getName()) || empty($this->entity->getName())) {
            throw new \ErrorException('Você precisa preencher o nome da tarefa.', 456, 999);
        }
        if (is_null($this->entity->getDescription()) || empty($this->entity->getDescription())) {
            throw new \ErrorException('Você precisa preencher a descrição da tarefa.', 456, 999);
        }
        if (is_null($this->entity->getDtBegin()) || empty($this->entity->getDtBegin())) {
            throw new \ErrorException('Você precisa preencher a data inicial da tarefa.', 456, 999);
        }
    }
}