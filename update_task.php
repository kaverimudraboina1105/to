<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION["user_id"]) || !isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit();
}

$task_id = $_GET["id"];
$conn->query("UPDATE tasks SET completed=1 WHERE id=$task_id");
header("Location: completed.php");
?>
