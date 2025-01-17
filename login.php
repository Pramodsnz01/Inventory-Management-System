<?php
// Start session
session_start();

// Redirect to dashboard if user is already logged in
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit();
}

// Initialize error message
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('database/connection.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use a prepared statement to prevent SQL injection
    // $query = 'SELECT * FROM users WHERE email = :email AND password = :password';
    // $stmt = $conn->prepare($query);
    // $stmt->bindParam(':email', $username);
    // $stmt->bindParam(':password', $password);
    // $stmt->execute();

    // if ($stmt->rowCount() > 0) {
    //     // Fetch user data and store in session
    //     $_SESSION['user'] = $stmt->fetch(PDO::FETCH_ASSOC);

    //     // Redirect to dashboard
    //     header('Location: dashboard.php');
    //     exit();
    // } else {
    //     $error_message = 'Please make sure that username and password are correct.';
    // }

    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $users = $stmt->fetchAll();

    $user_exists = false;

    foreach ($users as $user) {
        $upass = $user['password'];

        if (password_verify($password, $upass)) {
            $user_exists = true;
            $user['permissions'] = explode(',', $user['permissions']);
            $_SESSION['user'] = $user;
            break;
        }
    }

    if ($user_exists)
        header('Location: dashboard.php');
    else
        $error_message = 'Please make sure that username and password are correct.';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS Login- Inventory Management System</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body id="loginBody">
    <?php if (!empty($error_message)) { ?>
        <div id="errorMessage">
            <span>Error: Please make sure that username and password are correct.</span>
            <button class="close-btn" onclick="closeErrorMessage()">×</button>
        </div>
    <?php } ?>
    <div class="container">
        <div class="loginHeader">
            <p>Inventory Management System</p>
        </div>
        <div class="wrapper">
            <form action="login.php" method="POST">
                <h2>Login</h2>
                <div class="input-field loginInputContainer">
                    <input type="email" id="username" name="username" required>
                    <label for="username">Enter your email</label>
                </div>
                <div class="input-field loginInputContainer">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Enter your password</label>
                </div>
                <button type="submit">Log In</button>
            </form>
        </div>
    </div>
    <script>
        function closeErrorMessage() {
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.style.display = 'none'; // Hide the error message
        }
    </script>
</body>

</html>