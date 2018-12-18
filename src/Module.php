<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Serhii Popov
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Popov
 * @package Popov_<package>
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcR;

use Zend\Mvc\MvcEvent;
use Zend\Http\Request as HttpRequest;
use Zend\Session\Container as Session;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class Module
{
    public function getConfig()
    {
        $config = include __DIR__ . '/../config/module.config.php';
        #$config['service_manager'] = $config['dependencies'];
        unset($config['dependencies']);

        return $config;
    }

    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $container = $app->getServiceManager();
        $eventManager = $app->getEventManager();
        $sharedEvents = $eventManager->getSharedManager();

        // Set session ID before SessionManager initialization.
        // To do the same in GraphQLMiddleware is to late.
        #$request = $e->getRequest();
        /*if ($request instanceof HttpRequest && ($header = $request->getHeaders()->get('authorization'))) {
            $sessionId = trim(str_replace('Bearer', '', $header->getFieldValue()));
            $sessionManager = Session::getDefaultManager();
            // Start session with new session ID
            $sessionManager->setId($sessionId);
        }*/

        // Register the event listener method.
        $sharedEvents->attach(AbstractController::class, MvcEvent::EVENT_RENDER, function(MvcEvent $mvcEvent) {
            // The ZfcCurrent module is adapted for ZF3 MVC and ZF3 Expressive
            // such well as support ZF3+Middleware combination.
            // Keep in mind if you use ZF3+Middleware combination you will get Zend\Mvc\Controller\MiddlewareController
            // in "defaultContext" of Current object on MvcEvent::EVENT_DISPATCH such as it is initialized before
            // Middleware Action will be created.
            // After Middleware Action will be recognized and created in Stagem\ZfcAction\Page\ConnectivePage
            // the "defaultContext" will be replaced with relative Middleware Action object.

            /** @var RouteMatch $route */
            #$controller = $mvcEvent->getTarget();
            $route = $mvcEvent->getRouteMatch();

            $viewModel = $mvcEvent->getViewModel();
            $viewModel->addChild((new ViewModel())->setTemplate('grid-assets::widget/grid-assets.phtml'));
        });
    }
}