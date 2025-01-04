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
    $query = 'SELECT * FROM users WHERE email = :email AND password = :password';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Fetch user data and store in session
        $_SESSION['user'] = $stmt->fetch(PDO::FETCH_ASSOC);

        // Redirect to dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        $error_message = 'Please make sure that username and password are correct.';
    }
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
            <strong>Error:</strong> <?= $error_message ?>
        </div>
    <?php } ?>
    <div class="container">
        <div class="loginHeader">
            <h1>IMS</h1>
            <p>Inventory Management System</p>
        </div>
        <div class="loginBody">
            <form action="login.php" method="POST">
                <div class="loginInputContainer">
                    <label for="username">Username:</label>
                    <input type="email" placeholder="Username" id="username" name="username" required>
                </div>
                <div class="loginInputContainer">
                    <label for="password">Password:</label>
                    <input type="password" placeholder="Password" id="password" name="password" required>
                </div>
                <div class="loginButtonContainer">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
