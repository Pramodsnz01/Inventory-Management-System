<?php
// Start session
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
$_SESSION['table'] = 'users';
$_SESSION['redirect_to'] = 'users-add.php';

$show_table = 'users';
$users = include('database/show.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User- Inventory Management System</title>
    <?php include('partials/app-header-scripts.php'); ?>
</head>

<body>
    <div id="dashboardmainContainer">
        <!-- sidebar -->
        <?php include('partials/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <!-- topnav -->
            <?php include('live-search.php') ?>
            <?php include('partials/app-topnav.php') ?>
            <div class="dashboard_content">
                <?php if (in_array('user_create', $user['permissions'])) { ?>

                    <div class="dashboardContent_main">
                        <div class="row">
                            <div class="column column-12">
                                <h1 class="section_header"><i class="fa fa-plus"></i> Create User</h1>
                                <div class="useraddFormContainer">
                                    <form action="database/add.php" method="POST" class="appForm"
                                        onsubmit="return validateForm()">

                                        <div class="appFormInputContainer">
                                            <label for="first_name">First Name</label>
                                            <input type="text" id="first_name" class="appFormInput" name="first_name"
                                                required />
                                            <span id="first_name_error" class="error-message"></span>
                                        </div>
                                        <div class="appFormInputContainer">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" id="last_name" class="appFormInput" name="last_name"
                                                required />
                                            <span id="last_name_error" class="error-message"></span>
                                        </div>
                                        <div class="appFormInputContainer">
                                            <label for="email">Email</label>
                                            <input type="text" id="email" class="appFormInput" name="email" required />
                                            <span id="email_error" class="error-message"></span>
                                        </div>
                                        <div class="appFormInputContainer">
                                            <label for="password">Password</label>
                                            <input type="password" id="password" class="appFormInput" name="password"
                                                required />
                                        </div>

                                        <input type="hidden" id="permission_el" name="permissions">

                                        <?php include('partials/permissions.php'); ?>
                                        <button type="submit" class="appbtn"><i class="fa fa-plus"></i>Add User</button>
                                    </form>
                                    <?php
                                    if (isset($_SESSION['response'])) {
                                        $response_message = $_SESSION['response']['message'];
                                        $is_success = $_SESSION['response']['success'];
                                        ?>
                                        <div class="responseMessage">
                                            <p
                                                class="responseMessage <?= $is_success ? 'responseMessage__success' : 'responseMessage__error' ?> ">
                                                <?= $response_message ?>
                                            </p>
                                        </div>
                                        <?php unset($_SESSION['response']);
                                    } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div id="errorMessage">You do not have permission to view this page.</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php include('partials/app-scripts.php'); ?>

    <script>
        function validateForm() {
            let isValid = true;

            // Get form inputs
            let firstName = document.getElementById("first_name").value.trim();
            let lastName = document.getElementById("last_name").value.trim();
            let email = document.getElementById("email").value.trim();

            // Validation patterns
            let namePattern = /^[A-Za-z]{2,}$/;
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Reset error messages
            document.getElementById("first_name_error").innerText = "";
            document.getElementById("last_name_error").innerText = "";
            document.getElementById("email_error").innerText = "";

            // Validate First Name
            if (!namePattern.test(firstName)) {
                document.getElementById("first_name_error").innerText = "First name must contain only letters and be at least 2 characters long.";
                isValid = false;
            }

            // Validate Last Name
            if (!namePattern.test(lastName)) {
                document.getElementById("last_name_error").innerText = "Last name must contain only letters and be at least 2 characters long.";
                isValid = false;
            }

            // Validate Email
            if (!emailPattern.test(email)) {
                document.getElementById("email_error").innerText = "Please enter a valid email address.";
                isValid = false;
            }

            return isValid;
        }

        // Permissions
        function loadScript() {
            this.permissions = [];

            this.initialize = function () {
                this.registerEvents();
            },
                this.registerEvents = function () {

                    //click
                    document.addEventListener('click', function (e) {
                        let target = e.target;

                        //check if class name moduleFunc is clicked
                        if (target.classList.contains('moduleFunc')) {
                            //get the value
                            let permissionName = target.dataset.value;
                            //set the active class
                            if (target.classList.contains('permissionActive')) {
                                target.classList.remove('permissionActive');

                                //remove from the array
                                script.permissions = script.permissions.filter((name) => {
                                    return name !== permissionName;
                                });
                            } else {
                                target.classList.add('permissionActive');
                                script.permissions.push(permissionName);
                            }
                            // Update the hidden element
                            document.getElementById('permission_el').value = script.permissions.join(',');
                        }
                    });
                }
        }
        var script = new loadScript();
        script.initialize();
    </script>
</body>

</html>