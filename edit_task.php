<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$message = ""; // Variable to store messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET name=?, password=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $password, $user_id);
    
    if ($stmt->execute()) {
        $message = "<p class='success'>Profile updated successfully! Redirecting to dashboard...</p>
                    <a href='dashboard.php' class='dashboard-btn'>Go to Dashboard</a>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'dashboard.php';
                }, 3000);
              </script>";
    } else {
        $message = "<p class='error'>Error: " . $conn->error . "</p>";
    }
}

$result = $conn->query("SELECT * FROM users WHERE id=$user_id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
            background: url('https://st2.depositphotos.com/1006269/50485/i/450/depositphotos_504854622-stock-photo-purple-closed-notebook-mockup-isolated.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Edit Container */
        .edit-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 400px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        /* Form Inputs */
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Button */
        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #0056b3;
        }

        /* Success & Error Messages */
        .success, .error {
            font-weight: bold;
            text-align: center;
            margin-top: 15px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        /* Dashboard Button */
        .dashboard-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
        }

        .dashboard-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="edit-container">
    <h1>Edit Profile</h1>
    <form method="post">
        <input type="text" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>" required>
        <input type="password" name="password" placeholder="New Password" required>
        <button type="submit">Update</button>
    </form>
</div>

<!-- Message and Dashboard Button Below the Container -->
<div>
    <?php echo $message; ?>
</div>

</body>
</html>
