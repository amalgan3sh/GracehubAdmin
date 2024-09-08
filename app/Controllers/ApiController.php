<?php

namespace App\Controllers;

use CodeIgniter\HTTP\CURLRequest;

class ApiController extends BaseController
{
    public function registerUser()
    {
        // Initialize CURLRequest
        $client = \Config\Services::curlrequest();

        // Prepare the data to send
        $data = [
            'username' => 'test',
            'password' => 'test_pass',
        ];

        // Make the POST request
        $response = $client->post('https://sanctifyapi.onrender.com/Auth/register', [
            'headers' => [
                'accept' => '*/*',
                'Content-Type' => 'application/json',
            ],
            'json' => $data, // This will convert the array into JSON format
        ]);

        // Check the response status code and output the result
        if ($response->getStatusCode() === 200) {
            // Assuming a successful response, get the response body
            return $response->getBody();
        } else {
            // Handle error, return the status code and reason
            return 'Error: ' . $response->getStatusCode() . ' - ' . $response->getReason();
        }
    }
}