<?php
include("db_connect.php");

$message = ""; // Store success or error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $phone = trim($_POST["phone"]);
    $dob = $_POST["dob"];
    $language = $_POST["language"];
    $age = $_POST["age"];

    // Backend Validation
    if (strlen($name) < 3) {
        $message = "<p class='error'>Name must be at least 3 characters long!</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<p class='error'>Invalid email format!</p>";
    } elseif ($password !== $confirm_password) {
        $message = "<p class='error'>Passwords do not match!</p>";
    } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/", $password)) {
        $message = "<p class='error'>Password must be at least 6 characters long, contain a number, a special character, and a letter!</p>";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $message = "<p class='error'>Invalid phone number! Must be 10 digits.</p>";
    } elseif ($age < 18) {
        $message = "<p class='error'>You must be at least 18 years old!</p>";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, dob, language, age) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $name, $email, $hashed_password, $phone, $dob, $language, $age);

        if ($stmt->execute()) {
            $message = "<p class='success'>Registration successful! <a href='login.php'>Login here</a></p>";
        } else {
            $message = "<p class='error'>Error: " . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add background image */
        body {
            background: url('https://png.pngtree.com/thumb_back/fh260/background/20230630/pngtree-conceptual-3d-daily-organizer-and-to-do-list-scheduler-image_3695554.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        /* Form Container */
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            width: 40%;
            text-align: center;
            position: relative;
        }

        /* Message Styling - Appear inside container after form */
        .message {
            margin-top: 15px;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            color: green;
            background: #eaf9ea;
        }

        .error {
            color: red;
            background: #f9eaea;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Register</h2>
    <form method="post" onsubmit="return validateForm()">
        <input type="text" name="name" id="name" placeholder="Enter Name" required>
        <input type="email" name="email" id="email" placeholder="Enter Email" required>
        <input type="password" name="password" id="password" placeholder="Enter Password" required>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
        <input type="text" name="phone" id="phone" placeholder="Enter Phone Number" required>
        <input type="date" name="dob" id="dob" required>
        <select name="language" required>
            <option value="">Select Language</option>
            <option value="English">English</option>
            <option value="Spanish">Spanish</option>
            <option value="French">French</option>
            <option value="German">German</option>
        </select>
        <input type="number" name="age" id="age" placeholder="Enter Age" required>
        <button type="submit">Register</button>
    </form>

    <!-- Message Display - Appears right after form inside container -->
    <?php if (!empty($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
</div>

<script>
function validateForm() {
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm_password").value;
    let phone = document.getElementById("phone").value.trim();
    let age = document.getElementById("age").value;

    let namePattern = /^[A-Za-z\s]{3,}$/;
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    let phonePattern = /^[0-9]{10}$/;
    let passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;

    if (!namePattern.test(name)) {
        alert("Name must be at least 3 characters long and contain only letters and spaces.");
        return false;
    }

    if (!emailPattern.test(email)) {
        alert("Invalid email format!");
        return false;
    }

    if (!passwordPattern.test(password)) {
        alert("Password must be at least 6 characters long, contain a number, a special character, and a letter!");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return false;
    }

    if (!phonePattern.test(phone)) {
        alert("Invalid phone number! Must be 10 digits.");
        return false;
    }

    if (age < 18) {
        alert("You must be at least 18 years old!");
        return false;
    }

    return true;
}
</script>

</body>
</html>
