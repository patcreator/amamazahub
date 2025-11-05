<?php
require '../config/db.php'; // Your DB connection
require 'db_helper.php'; // Your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blog = $_POST['blog_id'];
    $parent = $_POST['parent_comment'] ?: null;
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    executeQuery(
        "INSERT INTO blog_comments (blog, parent_comment, firstname, lastname, Email, message) VALUES (?,?,?,?,?,?)",
        [$blog, $parent, $firstname, $lastname, $email, $message]
    );

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
