<?php
session_start(); // Start the session
require('./Read.php'); // Ensure Read.php includes necessary database connection and query

// Ensure that the session variable 'username' is set before accessing it
if (!isset($_SESSION['username'])) {
    echo '<script>alert("You must log in first!"); window.location.href = "/gomez/login.php";</script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        /* General styling */
        body {
            min-height: 100vh;
            display: flex;
            margin: 0;
            background-color: #F3F6FC;
        }

        /* Sidebar styling */
        .sidebar {
            min-width: 200px;
            background: #343a40; /* Dark gray color */
            color: #fff; /* White text */
            padding: 15px;
            position: fixed;
            height: 100%;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            color: white;
            font-size: 1.5rem;
            margin: 0;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Main content styling */
        .main-content {
            margin-left: 220px; /* Space for sidebar */
            padding: 30px;
            flex-grow: 1;
            background-color: #ffffff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            transition: transform 0.3s;
        }

        .main-content:hover {
            transform: translateY(-2px);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                min-width: 100%;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    

    <!-- Sidebar -->
    <nav class="sidebar">
        <h2>SYSTEM</h2>
        <div class="welcome-message">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</div>
        <ul>
           
            <li><a href="Email.php"><span class=""></span> Email</a></li>
            
            <li><a href="upload.php"><span class=""></span> Upload</a></li>
            <li><a href="changepass.php"><span class=""></span> Change Password</a></li>
            <li><a href="dashboard.php"><span class=""></span> Dashboard</a></li>
            <li><a href="login.php"><span class=""></span> Logout</a></li>
            
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <center><h1>RECORD LIST</h1></center>
        <br>

        <!-- User Creation Form -->
        <form action="Create.php" method="post" class="form-horizontal">
            <h3>FORM USER</h3>
            <div class="form-group">
                <label for="Fname" class="col-sm-2 control-label">Firstname</label>
                <div class="col-sm-10">
                    <input type="text" name="Fname" class="form-control" placeholder="Enter your Firstname" required>
                </div>
            </div>
            <div class="form-group">
                <label for="Mname" class="col-sm-2 control-label">Middlename</label>
                <div class="col-sm-10">
                    <input type="text" name="Mname" class="form-control" placeholder="Enter your Middlename" required>
                </div>
            </div>
            <div class="form-group">
                <label for="Lname" class="col-sm-2 control-label">Lastname</label>
                <div class="col-sm-10">
                    <input type="text" name="Lname" class="form-control" placeholder="Enter your Lastname" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" name="create" value="ENTER" class="btn btn-primary">
                </div>
            </div>
        </form>

        <div class="container">
        <!-- User Records Table -->
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr class="info">
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($results = mysqli_fetch_array($sqlAccounts)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($results['id']); ?></td>
                        <td><?php echo htmlspecialchars($results['Firstname']); ?></td>
                        <td><?php echo htmlspecialchars($results['Middlename']); ?></td>
                        <td><?php echo htmlspecialchars($results['Lastname']); ?></td>
                        <td>
                            <form action="edit.php" method="post" style="display:inline;">
                                <input type="submit" name="edit" value="EDIT" class="btn btn-info btn-xs">
                                <input type="hidden" name="editID" value="<?php echo htmlspecialchars($results['id']); ?>">
                                <input type="hidden" name="editF" value="<?php echo htmlspecialchars($results['Firstname']); ?>">
                                <input type="hidden" name="editM" value="<?php echo htmlspecialchars($results['Middlename']); ?>">
                                <input type="hidden" name="editL" value="<?php echo htmlspecialchars($results['Lastname']); ?>">
                            </form>
                            <form action="Delete.php" method="post" style="display:inline;">
                                <input type="submit" name="delete" value="DELETE" class="btn btn-danger btn-xs">
                                <input type="hidden" name="deleteID" value="<?php echo htmlspecialchars($results['id']); ?>">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button id="printButton" class="btn btn-primary" style="float: right;" onclick="window.print()">Print</button>
    </div>
</body>

        <!-- User Records Table -->
        <!-- Add your user records table here -->

    </div>
</body>
</html>
