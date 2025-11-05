<?php
    session_start();
    if(!isset($_SESSION['user']) || !isset($_SESSION['token']) || !isset($_SESSION['project_id']) || $_SESSION['project_id'] !== '965766'){
        header('location:/PDT0/app/auth/login.php');
    }