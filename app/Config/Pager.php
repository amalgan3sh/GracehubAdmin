<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    | Pagination links are rendered using views to configure their appearance.
    | You can use built-in templates by specifying their names, or create
    | your own templates and specify the view name here.
    |
    | Within each template, the Pager object will be available as $pager,
    | and the group as $pagerGroup.
    |
    */
    public $templates = [
        'default_full'   => 'CodeIgniter\Pager\Views\default_full',
        'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
        'default_head'   => 'CodeIgniter\Pager\Views\default_head',
        'bootstrap_pagination' => 'App\Views\pagination\bootstrap_pagination',
    ];

    /*
    |--------------------------------------------------------------------------
    | Items Per Page
    |--------------------------------------------------------------------------
    |
    | The default number of results shown in a single page.
    |
    */
    public $perPage = 20;
}