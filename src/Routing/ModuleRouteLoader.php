<?php
namespace App\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class CustomRouteLoader extends Loader
{
    private $isLoaded = false;

    public function load($resource, $type = null): RouteCollection
    {
        if ($this->isLoaded) {
            throw new \RuntimeException('Do not add the "custom" loader twice');
        }

        $routes = new RouteCollection();

        // Here you would fetch your module configurations. For simplicity, we'll hardcode it.
        $modules = [
            // Example module configuration
            ['name' => 'module1', 'path' => '/api/module1', 'controller' => 'App\Controller\Api\ModuleController::module1'],
            // Add more modules as needed
        ];

        foreach ($modules as $module) {
            $routeName = sprintf('api_%s', $module['name']); // e.g., api_module1
            $routePath = $module['path']; // e.g., /api/module1
            $routeDefaults = ['_controller' => $module['controller']];

            $route = new Route($routePath, $routeDefaults);
            $routes->add($routeName, $route);
        }

        $this->isLoaded = true;

        return $routes;
    }

    public function supports($resource, $type = null): bool
    {
        return $type === 'custom';
    }
}
