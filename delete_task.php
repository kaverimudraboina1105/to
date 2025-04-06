<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION["user_id"]) || !isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit();
}

$task_id = $_GET["id"];
$conn->query("DELETE FROM tasks WHERE id=$task_id");
header("Location: dashboard.php");
?>
