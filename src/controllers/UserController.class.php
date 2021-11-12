<?php
use \RedBeanPHP\R as R;

class UserController {
    public function login() {
        $html = file_get_contents('/opt/lampp/htdocs/src/views/UserLogin.html.twig');
        $loader = new Twig_Loader_String();

        $twig = new Twig_Environment($loader);

        echo $twig->render($html, [
            'test' => 'test',
        ]);

        if (isset($_POST['submit'])) {
            $this->loginPOST($_POST['username'], $_POST['password']);
        }
    }
    public function loginPOST($username, $password) {
        R::setup('mysql:host=localhost;dbname=literatuur', 'root', '');

        R::debug(false);

        R::wipe("users");

        $newUser = R::dispense('users');
        $newUser->username = 'Laurens';
        $newUser->password = password_hash('admin', PASSWORD_DEFAULT);
        R::store($newUser);

        $users = R::getAll('SELECT * FROM users');
        $convertedUsers = R::convertToBeans('users', $users);

        $token = bin2hex(random_bytes(50));

        foreach($convertedUsers as $user) {
            if ($user->username === $username
                && password_verify($password, $user->password)) {
                $session = R::dispense('sessions');
                $session->token = $token;
                $session->username = $username;

                R::store($session);

                $_SESSION['token'] = $token;
                $_SESSION['user'] = $username;

                header('Location: http://localhost');
                return;
            }
        }
        echo 'Incorrect username or password';
    }

    public function logout() {
        R::setup('mysql:host=localhost;dbname=literatuur', 'root', '');

        R::debug(false);

        R::exec('DELETE FROM sessions WHERE token = ?', [$_SESSION['token']]);

        echo 'You are logged out';
        session_destroy();
    }
}