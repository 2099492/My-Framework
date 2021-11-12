<?php
use \RedBeanPHP\R as R;

class AuthorsController {
    public function index($authorId) {
        R::setup('mysql:host=localhost;dbname=literatuur', 'root', '');

        R::debug(false);

        if (!ctype_digit($authorId)) {
            $authors = R::getAll('SELECT * FROM authors');
            $convertedAuthors = json_encode($authors);

            var_dump($convertedAuthors);
            return;
        }
        $author = R::getRow('SELECT * FROM authors WHERE id = ?', [$authorId]);
        $convertedAuthor = json_encode($author);
        echo $convertedAuthor;
    }
}