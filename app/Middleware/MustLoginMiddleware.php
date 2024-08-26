<?php

namespace laundry\Middleware;

use laundry\App\View;
use laundry\Config\Database;
use laundry\Repository\SessionRepository;
use laundry\Repository\UserRepository;
use laundry\Service\SessionService;

class MustLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    function before(): void
    {
        $user = $this->sessionService->current();
        if ($user == null) {

            View::redirect('/users/login');
        }
    }
}