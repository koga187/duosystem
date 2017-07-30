<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 11:10 AM
 */

namespace Duosystem\Router;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class TaskRouter implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $routeFactory = $app['controllers_factory'];

        $routeFactory->get('/cadastrar', 'Duosystem\Controller\TaskController::cadastroAction')->bind('cadastroAtividade');
        $routeFactory->post('/cadastrar', 'Duosystem\Controller\TaskController::salvarAction')->bind('salvarAtividade');

        $routeFactory->get('/alterar/{id}', 'Duosystem\Controller\TaskController::readAction')->bind('alterarAtividade');
        $routeFactory->post('/alterar/{id}', 'Duosystem\Controller\TaskController::updateAction')->bind('salvarAlteracaoAtividade');

        $routeFactory->get('/{page}', 'Duosystem\Controller\TaskController::listaAction')->bind('listaAtividade');

        return $routeFactory;
    }
}