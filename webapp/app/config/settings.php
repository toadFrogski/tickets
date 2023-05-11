<?php

set_include_path(BASEDIR . '/app/resources/templates');

$database_settings = [
    'host' => '127.0.0.1',
    'database' => 'tickets',
    'username' => 'tickets',
    'password' => 'ticketsPwd!'
];

if (isset($_SESSION['admin'])) {
    ini_set('file_uploads', 'On');
}