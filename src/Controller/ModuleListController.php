<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModuleListController extends AbstractController
{
    #[Route('/modulelist', name: 'app_module_list')]
    public function index(): Response
    {
        // Assuming your JSON content is stored in a file named 'data.json'.
        $jsonFilePath = '../config.json';

        // Read the JSON file
        $jsonContent = file_get_contents($jsonFilePath);

        // Decode the JSON content into a PHP array
        $dataArray = json_decode($jsonContent, true);

        // Prepare an array to hold the filtered modules
        $filteredModules = [];

        // Check if the decoding was successful and the 'modules' key exists
        if ($dataArray && isset($dataArray['modules'])) {
            foreach ($dataArray['modules'] as $module) {
                // Check if the module is active
                if (isset($module['active']) && $module['active']) {
                    // Prepare a new module entry excluding the 'active' key
                    $filteredModule = [
                        'name' => $module['name'],
                        'location' => $module['location']
                    ];
                    // Add the filtered module to the array
                    $filteredModules[] = $filteredModule;
                }
            }

            // Output the filtered modules array in the desired format
            $response = new Response(
                json_encode(['modules' => $filteredModules], JSON_PRETTY_PRINT),
                Response::HTTP_OK,
                ['content-type' => 'application/json']
            );
        } else {
            $response = new Response(
                "Malformed Module Configuration File",
                500,
                ['content-type' => 'text/plain']
            );
        }
        
        return $response;
    }
}
