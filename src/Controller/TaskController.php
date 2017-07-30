<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 11:07 AM
 */

namespace Duosystem\Controller;


use Duosystem\Core\DatabaseConnection;
use Duosystem\Model\TaskModel;
use Respect\Validation\Exceptions\ValidationException;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController
{
    /**
     * @param Application $app
     * @return mixed
     */
    public function listaAction(Application $app, Request $request)
    {
        $arrayList = [];

        try {
            $formparams = TaskModel::getFormParams();
            $taskStatus = [];
            foreach ($formparams['taskStatus'] as $valueStatus) {
                $taskStatus[$valueStatus['idtaskstatus']] = $valueStatus['name'];
            }
            $taskSituation = [];
            foreach ($formparams['taskSituation'] as $valueSituation) {
                $taskSituation[$valueSituation['id']] = $valueSituation['name'];
            }

            $arrayList = (new TaskModel())->getTaskList(DatabaseConnection::getInstance(), $request->get('page'), [
                'task_status_idtask' => $request->get('taskStatusFilter'),
                'situation' => $request->get('taskSituationFilter')
            ]);
        } catch (\ErrorException $e) {
            $app['session']->getFlashBag()->add('warning', $e->getMessage());
        } catch (\Exception $e ) {
            $app['session']->getFlashBag()->add('danger', 'Erro inesperado entre em contato com o administrador do sistema.');
        } finally {
            if (isset($arrayList['lista']) && isset($arrayList['totalPages'])) {
                return $app['twig']->render('atividade/lista.html.twig', [
                    'taskList' => $arrayList['lista'],
                    'totalPages' => $arrayList['totalPages'],
                    'total' => $arrayList['totalTasks'],
                    'pageNow' => $request->get('page'),
                    'taskStatus' => $taskStatus,
                    'taskSituation' => $taskSituation,
                    'taskSituationFilter' => $request->get('taskSituationFilter'),
                    'taskStatusFilter' => $request->get('taskStatusFilter')
                ]);
             } else {
                return $app['twig']->render('atividade/lista.html.twig', [
                    'taskList' => [],
                    'totalPages' => [],
                    'total' => 0,
                    'pageNow' => $request->get('page'),
                    'taskStatus' => $taskStatus,
                    'taskSituation' => $taskSituation,
                    'taskSituationFilter' => $request->get('taskSituationFilter'),
                    'taskStatusFilter' => $request->get('taskStatusFilter')
                ]);
            }
        }
    }

    /**
     * @param Application $app
     * @return Response
     */
    public function cadastroAction(Application $app)
    {
        $formparams = TaskModel::getFormParams();

        return $app['twig']->render('atividade/cadastrar.html.twig', ['taskStatus' => $formparams['taskStatus'], 'taskSituation' => $formparams['taskSituation'], 'disabled' => '']);
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function salvarAction(Application $app, Request $request)
    {
        $taskModel = new TaskModel();

        try {
            $taskModel->popEntityWithFormInfo($request);
            $taskEntity = $taskModel->saveTask(DatabaseConnection::getInstance());

            $app['session']->getFlashBag()->add('success', 'A tarefa foi salva! =D');
        } catch (\ErrorException $e) {
            $app['session']->getFlashBag()->add('warning', $e->getMessage());
        } catch (ValidationException $e) {
            $app['session']->getFlashBag()->add('warning', 'Verifique o formulário há campos preenchidos de forma errada ou em branco.');
        } catch (\Exception $e ) {
            $app['session']->getFlashBag()->add('danger', 'Erro inesperado entre em contato com o administrador do sistema.');
        } finally {
            if (isset($taskEntity) && !is_null($taskEntity->getId())) {
                return $app->redirect($app['url_generator']->generate('alterarAtividade', ['id' => $taskEntity->getId()]), 302);
            }

            return $app->redirect($app['url_generator']->generate('cadastroAtividade'), 302);
        }
    }

    /**
     * @param Application $app
     */
    public function readAction(Application $app, Request $request)
    {
        $arrayTask = [];
        $formparams = [];
        $disabled = '';

        try {
            $formparams = TaskModel::getFormParams();
            $arrayTask = taskModel::getTaskById(DatabaseConnection::getInstance(), intval($request->get('id')));
            $disabled = ($arrayTask['task_status_idtask'] == 4) ? 'disabled' : '';

        } catch (\ErrorException $e) {
            $app['session']->getFlashBag()->add('warning', $e->getMessage());
        } catch (\Exception $e) {
            $app['session']->getFlashBag()->add('danger', 'Erro inesperado entre em contato com o administrador do sistema.');
        } finally {
            $taskStatus = (isset($formparams['taskStatus'])) ? $formparams['taskStatus'] : [];
            $taskSituation = (isset($formparams['taskSituation'])) ? $formparams['taskSituation'] : [];

            return $app['twig']->render('atividade/cadastrar.html.twig', ['taskStatus' => $taskStatus, 'taskSituation' => $taskSituation, 'taskData' => $arrayTask, 'disabled' => $disabled]);
        }
    }

    /**
     * @param Application $app
     */
    public function updateAction(Application $app, Request $request)
    {
        $taskModel = new TaskModel();

        try {
            $taskModel->popEntityWithFormInfo($request);
            $taskModel->updateTask(DatabaseConnection::getInstance());
            $app['session']->getFlashBag()->add('success', 'A tarefa foi alterada! =D');
        }  catch (\ErrorException $e) {
            $app['session']->getFlashBag()->add('warning', $e->getMessage());
        } catch (\Exception $e ) {
            $app['session']->getFlashBag()->add('danger', 'Erro inesperado entre em contato com o administrador do sistema.');
        } finally {
            return $app->redirect($app['url_generator']->generate('alterarAtividade', ['id' => intval($request->request->get('task_id'))]), 302);
        }
    }
}