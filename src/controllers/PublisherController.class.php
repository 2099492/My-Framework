<?php
use \RedBeanPHP\R as R;

class PublisherController {
    public function index() {
        $html = file_get_contents('/opt/lampp/htdocs/src/views/PublisherIndex.html.twig');
        $loader = new Twig_Loader_String();

        $twig = new Twig_Environment($loader);

        R::setup('mysql:host=localhost;dbname=literatuur', 'root', '');

        R::debug(false);

        $publishers = R::getAll("SELECT * FROM publishers");
        $convertedPublishers = R::convertToBeans("publishers", $publishers);

        echo $twig->render($html, [
            'name' => 'Laurens',
            'publishers' => $convertedPublishers,
        ]);
    }
    public function add() {
        $html = file_get_contents('/opt/lampp/htdocs/src/views/PublisherAdd.html.twig');
        $loader = new Twig_Loader_String();

        $twig = new Twig_Environment($loader);

        echo $twig->render($html, []);

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];

            $newPublisher = R::dispense('publishers');
            $newPublisher->name = $name;

            R::store($newPublisher);
        }

        $UserService = new UserService();

        $UserService->validateLoggedIn();
    }
}