<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 10:13 AM
 */

require_once __DIR__.'/../bootstrap.php';

$app['url'] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];


$app->error(function (\Exception $e, \Symfony\Component\HttpFoundation\Request $request, $code) use ($app) {
    switch ($code) {
        case 404:
            $message = 'Página não encontrada, por favor utilize o menu.';
            break;
        default:
            $message = 'Alguma coisa deu errado por favor não se preocupe e tente novamente.';
    }

    return $app['twig']->render('erro.html.twig', ['erro_message' => $message, 'exception' => $e->getMessage()]);
});

$app->mount('/atividades', new Duosystem\Router\TaskRouter());
$app->mount('/', new Duosystem\Router\IndexRouter());

$app->run();