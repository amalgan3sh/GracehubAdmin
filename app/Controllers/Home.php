<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // Logic to determine whether to show the loader
        $showLoader = true;  // or false based on your logic
            
        // Pass data to the view
        $data = [
            'showLoader' => $showLoader,
        ];
        return view('public/login',$data);
    }

    public function SelectDashboard(): string
    {
        $session = session();
        $data = [
            'user_id' => $session->get('user_id'),
            'username' => $session->get('username'),
            'role' => $session->get('role'),
        ];

        return view('public/select_dashboard',$data);
    }
}
