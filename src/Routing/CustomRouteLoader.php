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

        // Load the global configuration
        $config = json_decode(file_get_contents(__DIR__ . '/../../config.json'), true);

        foreach ($config['modules'] as $module) {
            if ($module['active']) {
                // Adjust the path to point to the correct module directory
                $moduleManifestPath = __DIR__ . '/../../Modules/' . $module['name'] . '/manifest.json';
                if (!file_exists($moduleManifestPath)) {
                    continue; // Skip if manifest does not exist
                }

                $moduleManifest = json_decode(file_get_contents($moduleManifestPath), true);

                // Assuming namespace base for modules follows Modules\{ModuleName}\Controllers convention
                $namespaceBase = 'Modules\\' . str_replace('/', '\\', $module['name']) . '\\Controllers\\';

                foreach ($moduleManifest['routes'] as $routeInfo) {
                    // Determine the path for the route
                    $routePath = rtrim($module['location'], '/') . $routeInfo['path'];
                
                    // Construct the full class name for the controller
                    $controllerClass = $namespaceBase . str_replace('/', '\\', $routeInfo['controller']);
                
                    // Define the route with the constructed controller class
                    $route = new Route(
                        $routePath,
                        ['_controller' => $controllerClass]
                    );
                
                    $routes->add($module['subroute'] . $routeInfo['name'], $route);
                }
            }
        }

        $this->isLoaded = true;

        return $routes;
    }

    public function supports($resource, $type = null): bool
    {
        return $type === 'custom';
    }
}