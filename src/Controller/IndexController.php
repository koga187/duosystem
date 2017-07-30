<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 11:07 AM
 */

namespace Duosystem\Controller;


use Silex\Application;

class IndexController
{
    /**
     * @param Application $app
     * @return Response
     */
    public function indexAction(Application $app)
    {
        return $app['twig']->render('index/index.html.twig');
    }
}