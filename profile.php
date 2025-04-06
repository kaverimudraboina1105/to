<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$result = $conn->query("SELECT * FROM users WHERE id=$user_id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        /* Body Styling */
        body {
            background: url('https://img.freepik.com/premium-photo/list-icon-notebook-with-completed-todo-list-3d-render_471402-428.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            height: 100vh;
        }

        /* Profile Container (Larger size, still Top-Left) */
        .profile-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            width: 40%; /* Increased width */
            text-align: center;
            position: absolute;
            top: 30px;
            left: 30px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 26px;
        }

        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 12px;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            margin: 10px;
            padding: 12px 18px;
            font-size: 16px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s;
        }

        .edit-btn {
            background: #007bff;
        }

        .edit-btn:hover {
            background: #0056b3;
        }

        .back-btn {
            background: #28a745;
        }

        .back-btn:hover {
            background: #1c7430;
        }

        .delete-btn {
            background: #dc3545;
        }

        .delete-btn:hover {
            background: #a71d2a;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h1>Profile</h1>
    <p><strong>Name:</strong> <?php echo $user["name"]; ?></p>
    <p><strong>Email:</strong> <?php echo $user["email"]; ?></p>

    <a href="edit_profile.php" class="btn edit-btn">Edit Profile</a>
    <a href="dashboard.php" class="btn back-btn">Back to Dashboard</a>
    <a href="delete_account.php" class="btn delete-btn">Delete Account</a>
</div>

</body>
</html>
