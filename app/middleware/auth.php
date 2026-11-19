<?php

function require_login()
{
    if (empty($_SESSION['admin_id'])) {
        header('Location: ?page=login');
        exit;
    }
}