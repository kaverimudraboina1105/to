<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
include("db_connect.php");

$user_id = $_SESSION["user_id"];
$result = $conn->query("SELECT * FROM tasks WHERE user_id=$user_id AND completed=0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - To-Do List</title>
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
            background: url('https://png.pngtree.com/thumb_back/fh260/background/20231211/pngtree-christmas-mosk-up-wish-list-on-purple-background-notebook-todo-list-image_15497116.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Main Container */
        .container {
            max-width: 800px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* Heading */
        h1 {
            color: #333;
            margin-bottom: 10px;
        }

        h2 {
            color: #007bff;
            margin-top: 20px;
            text-decoration: underline;
        }

        /* Navigation Links */
        .nav {
            margin-bottom: 20px;
        }

        .nav a {
            text-decoration: none;
            font-size: 16px;
            color: #007bff;
            margin: 0 15px;
            transition: 0.3s;
        }

        .nav a:hover {
            text-decoration: underline;
        }

        /* Task Form */
        form {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }

        input, button {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        input[type="text"], input[type="datetime-local"] {
            width: 48%;
        }

        button {
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #1c7430;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
        }

        /* Task Actions */
        .task-actions a {
            text-decoration: none;
            font-size: 14px;
            padding: 8px 12px;
            border-radius: 5px;
            margin: 3px;
            display: inline-block;
            transition: 0.3s;
        }

        .edit { color: #ffc107; }
        .delete { color: #dc3545; }
        .complete { color: #28a745; }

        .edit:hover { text-decoration: underline; }
        .delete:hover { text-decoration: underline; }
        .complete:hover { text-decoration: underline; }

    </style>
</head>
<body>

<div class="container">
    <h1>Welcome, <?php echo $_SESSION["name"]; ?>!</h1>

    <!-- Navigation Links -->
    <div class="nav">
        <a href="profile.php">Profile</a>
        <a href="completed.php">Completed Tasks</a>
        <a href="logout.php">Logout</a>
    </div>

    <h2>To-Do List</h2>

    <!-- Task Form -->
    <form method="post" action="add_task.php">
        <input type="text" name="title" placeholder="Task Title" required>
        <input type="datetime-local" name="due_date" required>
        <button type="submit">Add Task</button>
    </form>

    <h2>Tasks</h2>

    <!-- Task Table -->
    <table>
        <tr>
            <th>Title</th>
            <th>Due Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['due_date']; ?></td>
                <td class="task-actions">
                    <a href="edit_task.php?id=<?php echo $row['id']; ?>" class="edit">Edit</a> |
                    <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="delete">Delete</a> |
                    <a href="update_task.php?id=<?php echo $row['id']; ?>" class="complete">Mark Completed</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</div>

</body>
</html>
