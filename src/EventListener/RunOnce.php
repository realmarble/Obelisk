<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Dotenv\Dotenv;

class RunOnce
{
    private $dotenv;
    private $entityManager;
    private $Executed = false;
    public function __construct(EntityManagerInterface $entityManager) {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');
        $this->entityManager = $entityManager;
    }
    private function ExecuteTableMigrations(EntityManagerInterface $entityManager){
    $rundb = getenv('RUN_DATABASE_CREATION');
    if (!$rundb) { // if env says to not run the db creator, then don't
        return;
    }
    $connection = $this->entityManager->getConnection();
    $config = json_decode(file_get_contents(__DIR__ . '/../../config.json'), true);

        foreach ($config['modules'] as $module) {
            if ($module['active']) {
                // Adjust the path to point to the correct module directory
                $moduleManifestPath = __DIR__ . '/../../Modules/' . $module['name'] . '/manifest.json';
                if (!file_exists($moduleManifestPath)) {
                    continue; // Skip if manifest does not exist
                }

                $moduleManifest = json_decode(file_get_contents($moduleManifestPath), true);

                // Assuming namespace base for modules follows Modules\{ModuleName} convention
                $namespaceBase = 'Modules\\' . str_replace('/', '\\', $module['name']) . '\\';

                foreach ($moduleManifest['tables'] as $Table) {                
                    // Construct the full class name for the controller
                    $AssemblyClass = $namespaceBase . str_replace('/', '\\', $Table);
                    $Assembly = new $AssemblyClass();
                    $connection->executeStatement($Assembly->up());
                }
            }
        }
    }
    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        } //if not the main request, return
        if (!$this->Executed) {
            try {
                $this->ExecuteTableMigrations($this->entityManager);
            } catch (\Throwable $th) {
                //throw $th;
            }
            $this->Executed = true;
        }
    }

}