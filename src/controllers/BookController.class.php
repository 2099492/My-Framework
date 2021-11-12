<?php
use \RedBeanPHP\R as R;

class BookController {
    public function index() {
        R::setup('mysql:host=localhost;dbname=literatuur', 'root', '');

        R::debug(false);

        function CleanAllTables() {
            $tables = R::getCol(' show tables ');
            foreach ($tables as $table) {
                R::wipe($table);
            }
        }
        CleanAllTables();

        $stdA = R::dispense('books');
        $stdA->title = 'Lord of the Rings';
        $stdA->author = 'J. R. R. Tolkien';
        $stdA->publisher = 'Allen & Unwin';
        $stdB = R::dispense('books');
        $stdB->title = '12 Rules for life';
        $stdB->author = 'Jordan Peterson';
        $stdB->publisher = 'Ethan Van Sciver';
        $stdC = R::dispense('publishers');
        $stdC->name = 'van Dalen';
        $stdD = R::dispense('authors');
        $stdD->name = 'Jordan Peterson';

        R::store($stdA);
        R::store($stdB);
        R::store($stdC);
        R::store($stdD);


        $books2 = R::getAll("SELECT * FROM books");
        $convertedBooks = R::convertToBeans("books", $books2);

        $authors = R::getAll("SELECT * FROM authors");
        $convertedAuthors = R::convertToBeans("authors", $authors);

        $publishers = R::getAll("SELECT * FROM publishers");
        $convertedPublishers = R::convertToBeans("publishers", $publishers);


        $html = file_get_contents('/opt/lampp/htdocs/src/views/BooksIndex.html.twig');
        $loader = new Twig_Loader_String();

        $twig = new Twig_Environment($loader);

        echo $twig->render($html, [
            'books' => $convertedBooks,
            'authors' => $convertedAuthors,
            'publishers' => $convertedPublishers,
        ]);

    }
}