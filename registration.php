<?php
require('./database.php'); // Include the database connection

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to insert the user data
    $sql = "INSERT INTO registration (username, password, email) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connection, $sql);
    
    // Bind the parameters (hashed password)
    mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $email);

    if (mysqli_stmt_execute($stmt)) {
        echo '<script>alert("Registration successful!")</script>';
        echo '<script>window.location.href = "/gomez/login.php"</script>'; // Redirect to login page
    } else {
        echo '<script>alert("Error: ' . mysqli_error($connection) . '")</script>';
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connection); // Close the database connection
}
?>

<!DOCTYPE html>
<html lang="tl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #6dd5ed, #2193b0); /* Updated background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .container {
            background: #ffffff; /* Container background color */
            padding: 40px; /* Increased padding */
            border-radius: 15px; /* Slightly adjusted border radius */
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.3); /* Adjusted shadow */
            max-width: 400px;
            width: 100%;
            transition: all 0.3s ease, transform 0.6s ease;
            animation: float 3s ease-in-out infinite;
        }
        .container:hover {
            box-shadow: 0 15px 60px rgba(0, 0, 0, 0.4); /* Enhanced shadow on hover */
        }
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px); /* Reduced float height */
            }
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 14px;
            color: #666;
            margin-bottom: 6px;
        }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: border-color 0.3s;
        }
        input:focus {
            border-color: #2193b0; /* Focus border color */
            outline: none;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #2193b0; /* Button background color */
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background: #6dd5ed; /* Button hover color */
        }
        p {
            text-align: center;
            color: #666;
        }
        a {
            color: #2193b0; /* Link color */
            text-decoration: none;
            transition: color 0.3s;
        }
        a:hover {
            color: #6dd5ed; /* Link hover color */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="registration.php" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <button type="submit" name="register">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Log in</a></p>
    </div>
</body>
</html>
