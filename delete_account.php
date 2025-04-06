<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $confirm_delete = $_POST["confirm_delete"];

    if ($confirm_delete === "YES") {
        // Delete user account
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            session_destroy(); // Destroy session after account deletion
            header("Location: index.php?message=Account deleted successfully.");
            exit();
        } else {
            echo "Error deleting account: " . $conn->error;
        }
    } else {
        echo "Account deletion canceled.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Delete Account</h2>
        <p>⚠️ Are you sure you want to delete your account? This action **cannot be undone.**</p>
        
        <form method="post">
            <label>Type **YES** to confirm deletion:</label>
            <input type="text" name="confirm_delete" required>
            <button type="submit" class="delete-btn">Delete Account</button>
            <a href="profile.php" class="cancel-btn">Cancel</a>
        </form>
    </div>
</body>
</html>
