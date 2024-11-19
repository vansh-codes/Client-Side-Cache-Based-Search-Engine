<?php
session_start();
require 'config.php'; // Database connection file

if (!isset($pdo)) {
    die("Database connection not established. Please check db.php.");
}

$action = $_GET['action'] ?? '';

if ($action === 'signup') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Validate inputs
    if (empty($username) || empty($password) || empty($confirmPassword)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: templates/auth/signup.php");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match. Please try again.";
        header("Location: templates/auth/signup.php");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Check if the username already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $_SESSION['error'] = "Username already taken. Please choose another.";
            header("Location: templates/auth/signup.php");
            exit();
        }

        // Insert the new user
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword,
        ]);

        $_SESSION['success'] = "Signup successful! Please log in.";
        header("Location: templates/auth/login.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: templates/auth/signup.php");
        exit();
    }
} elseif ($action === 'login') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Both username and password are required.";
        header("Location: templates/auth/login.php");
        exit();
    }

    try {
        // Fetch the user by username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            session_regenerate_id(true); // Regenerate session ID for security
            $_SESSION['user'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid username or password.";
            header("Location: templates/auth/login.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: templates/auth/login.php");
        exit();
    }
} else {
    header("Location: templates/auth/login.php");
    exit();
}
