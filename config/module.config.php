<?php
/**
 * @package Stagem_Pool
 * @author Vlad Kozak <vk@stagem.com.ua>
 * @datetime: 15.08.2016 13:41
 */

namespace Stagem\ZfcPool;

use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    //'assetic_configuration' => require 'assets.config.php',

    /*'dependencies' => [
        'aliases' => [
            'PoolService' => Service\PoolService::class,
            'PoolGrid' => Block\Grid\PoolGrid::class, // only for GridFactory
        ],
        'factories' => [
            Service\PoolService::class => Service\Factory\PoolServiceFactory::class,
        ],
    ],*/

    'view_manager' => [
        /*'template_path_stack' => [
            __NAMESPACE__ => __DIR__ . '/../view',
        ],*/
        'prefix_template_path_stack' => [
            'grid-assets::' => __DIR__ . '/../view',
        ],
    ],

];