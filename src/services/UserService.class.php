<?php
use \RedBeanPHP\R as R;

class UserService {
    public function validateLoggedIn() {
        R::setup('mysql:host=localhost;dbname=literatuur', 'root', '');

        R::debug(false);

        $sessions = R::getAll('SELECT * FROM sessions');
        $convertedSessions = R::convertToBeans('sessions', $sessions);

        foreach ($convertedSessions as $session) {
            if ($session->token === $_SESSION['token']) {
                return;
            }
        }
        header('Location: http://localhost/user/login');
    }
}