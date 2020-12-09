<?php
namespace controllers\admin;

require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/admin/admin.php';

abstract class BaseAuth extends \controllers\BaseController
{
    protected $noAuthUrl = '\admin';

    protected $viewModel = [
        'preLoadLogo' => false,
        'withJquery' => false
    ];

    protected function getUserRoles()
    {
        return $_SESSION['rolesId'] ?? [];
    }

    abstract protected function getAccessLevels(): array;

    protected function processBefore($params)
    {
        $this -> renewCurrentSession();
        $accessLevels = $this->getAccessLevels();

        if (empty($_SESSION['userId']) && !empty($this -> noAuthUrl))
        {
            \ext\redirectTo($this -> noAuthUrl);
        } elseif (!empty($_SESSION['rolesId']) && sizeof($accessLevels) > 0 && sizeof(array_intersect($_SESSION['rolesId'], $accessLevels)) === 0) {
            http_response_code(403);
            exit();
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
        \ext\redirectTo('/');
    }

    protected function setAuth($userData)
    {
        $_SESSION['userId'] = $userData['id'];
        $_SESSION['rolesId'] = $userData['rolesId'];
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

    protected function getAccessLevels(): array
    {
        return  [];
    }

    protected function processBefore($params)
    {
        parent::processBefore($params);

        if (!empty($params['logoff'])) {
            parent::logOff();
        }

        if (!empty($_SESSION['userId'])) {
            \ext\redirectTo(ADMIN_ORDERS_URL);
        }
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
            $user = \dataAccess\admin\getAuthData($login, $password);
            if (empty($user)) {
                $params['authError'] = true;
                parent::processGet($params);
            } else {
                parent::setAuth([
                    'id' => $user[0]['id'],
                    'rolesId' => array_map(function ($elm) {return $elm['group_id'];}, $user)
                                 ]);
                \ext\redirectTo(ADMIN_ORDERS_URL);
            }
        }
    }
}

abstract class AdminPages extends BaseAuth
{
    protected function showHeader($params)
    {
        $menu = \dataAccess\admin\getAdminMenu();
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
    }
}