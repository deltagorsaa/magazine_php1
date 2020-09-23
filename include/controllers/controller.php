<?php

namespace controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/root.php';

abstract class Controller
{
    protected $viewModel = [
        'title' => 'Fashion'
    ];

    public final function execute($params)
    {
        $this -> processBefore($params);

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this -> processGet($params);
                break;
            case 'POST':
                $this -> processPost($params);
                break;
            case 'DELETE':
                $this -> processDelete($params);
        }
    }

    private function processGet($params)
    {
        if (empty($_GET['part'])) {
            require $_SERVER['DOCUMENT_ROOT'] . '/templates/rootHeader.php';
            $this -> showHeader($params);
        }

        $this -> showContent($params);

        if (empty($_GET['part'])) {
            $this -> showFooter($params);
            require $_SERVER['DOCUMENT_ROOT'] . '/templates/rootFooter.php';
        }
    }

    protected function processBefore($params){}

    protected function processPost($params){}
    protected function processDelete($params){}

    protected abstract function showHeader($params);
    protected abstract function showFooter($params);
    protected abstract function showContent($params);
}

abstract class BaseController extends Controller
{
    protected $menu = null;

    public function __construct()
    {
        $this -> menu = \dataAccess\root\getMenu();
    }

    protected function showHeader($params)
    {
        $menu = $this -> menu;
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
    }

    protected function showFooter($params)
    {
        $menu = $this -> menu;
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
    }
}
