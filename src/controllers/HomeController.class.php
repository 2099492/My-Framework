<?php
use \RedBeanPHP\R as R;

class HomeController {
    public function index() {
        $html = file_get_contents('/opt/lampp/htdocs/src/views/HomeIndex.html.twig');
        $loader = new Twig_Loader_String();

        $twig = new Twig_Environment($loader);

        R::setup('mysql:host=localhost;dbname=literatuur', 'root', '');

        R::debug(false);

        $books2 = R::getAll("SELECT * FROM books");
        $convertedBooks = R::convertToBeans("books", $books2);

        echo $twig->render($html, [
            'name' => 'Laurens',
            'books' => $convertedBooks,
        ]);
    }
}