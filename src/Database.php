<?php
use \RedBeanPHP\R as R;

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

$idA = R::store($stdA);
$idB = R::store($stdB);
$idC = R::store($stdC);
$idD = R::store($stdD);

