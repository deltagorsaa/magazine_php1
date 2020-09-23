<?php
namespace controllers;
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/admin.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/controllers/controller.php';

abstract class BaseAuth extends BaseController
{
    protected $noAuthUrl = '\admin';

    protected $viewModel = [
        'preLoadLogo' => false,
        'withJquery' => false
    ];

    protected function processBefore($params)
    {
        $this -> renewCurrentSession();

        if (empty($_SESSION['userId']) && !empty($this -> noAuthUrl))
        {
            \ext\redirectTo($this -> noAuthUrl);
        }
    }

    private function startAuthSession()
    {
        session_name(PHP_SESSION_NAME);

        session_cache_expire(PHP_SESSION_EXPIRE_MIN);

        session_start(['cookie_lifetime' => PHP_SESSION_COOKIE_LIFETIME_MIN * 60]);
    }

    private function renewSessionCookie($time)
    {
        setcookie(session_name(), session_id(), $time, '/');
    }

    private function renewCurrentSession()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            $this -> startAuthSession();
            $this -> renewSessionCookie(strtotime('+'. PHP_SESSION_COOKIE_LIFETIME_MIN . ' minutes'));
        }
    }

    protected function logOff()
    {
        unset($_SESSION['userLogin']);
        $this -> renewSessionCookie(1);
        session_destroy();
    }
}

final class Admin extends BaseAuth
{
    protected $noAuthUrl = null;

    public function __construct()
    {
        parent::__construct();
        $this -> viewModel['title'] = 'Авторизация';
    }

    protected function showContent($params)
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/admin/authorization.php';
    }

    protected function processPost($params)
    {
        $login = htmlspecialchars($_POST['login']) ?? null;
        $password = htmlspecialchars($_POST['password']) ?? null;
        if (isset($login) && isset($password)) {
            $this -> setAuth(5);
            \ext\redirectTo('\admin\orders');
        }
    }

    private function setAuth(int $userId)
    {
        $_SESSION['userId'] = $userId;
    }
}
