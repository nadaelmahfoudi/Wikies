<?php
session_start();
$_SESSION['role'] = 'author';
// session_write_close();
include "Router.php";
(new Router)->route();
