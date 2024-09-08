<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        $showLoader = true;  // or false based on your logic
        
        // Pass data to the view
        $data = [
            'showLoader' => $showLoader,
        ];
        // Display the login form
        return view('auth/login', $data);
    }

    public function verifyLogin()
    {
        // Get the username and password from the POST request
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
    
        // Validate the form data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required',
            'password' => 'required',
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    
        // Prepare data to send to the API
        $data = [
            'username' => $username,
            'password' => $password,
        ];
    
        // Initialize CURLRequest service
        $client = \Config\Services::curlrequest();
    
        try {
            // Send POST request to the Sanctify API
            $response = $client->post('https://sanctifyapi.onrender.com/Auth/login', [
                'headers' => [
                    'accept' => '*/*',
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,  // Send the data as JSON
            ]);
    
            // Check the status code of the response
            $statusCode = $response->getStatusCode();
    
            // Handle the response based on the status code
            if ($statusCode === 200) {
                $result = json_decode($response->getBody(), true);
    
                if (isset($result['message']) && $result['message'] === 'Success') {
                    return redirect()->to('/super_admin_dashboard');
                } elseif (isset($result['message']) && $result['message'] === 'Invalid username or password') {
                    return redirect()->back()->with('error', 'Invalid username or password');
                }
            } elseif ($statusCode === 401) {
                // Handle unauthorized (401) error
                return redirect()->back()->with('error', 'Invalid username or password.');
            } else {
                // Handle other status codes
                return redirect()->back()->with('error', 'Unexpected error occurred. Please try again.');
            }
        } catch (\Exception $e) {
            // Catch any cURL errors and handle them
            return redirect()->back()->with('error', 'An error occurred while connecting to the API. Please try again.');
        }
    }

    public function adminDashboard()
    {
        // Load the view for the admin dashboard
        return view('super_admin/admin_dashboard');
    }

    private function getUserByUsername($username)
    {
        $userModel = new UserModel();
        return $userModel->where('username', $username)->first();
    }

    private function verifyPlainPassword($inputPassword, $storedPassword)
    {
        // Directly compare the plain-text password with the stored password
        return $inputPassword === $storedPassword;
    }

    private function isSuperAdmin($user)
    {
        return $user['role'] === 'super_admin';
    }

    private function setUserSession($user)
    {
        $session = session();
        $sessionData = [
            'user_id' => $user['user_id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'logged_in' => true,
            'active' => true  // Assuming you want to set the 'active' status here
        ];
        $session->set($sessionData);
    }

    private function jsonResponse($data)
    {
        return $this->response->setJSON($data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function register()
    {
        // Display the registration form
        return view('public/auth-register');
    }

    
  
}