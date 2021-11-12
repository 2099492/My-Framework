<?php
class TestController {
    public function testGet() {
        setcookie('test', 'dit is een test cookie');
        echo $_COOKIE['test'];
    }
}