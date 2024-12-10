<?php
session_start();
require 'db.php';

// Signup Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $farm_id = $_POST['farm_id'];

    // Check if username exists
    $query = "SELECT * FROM Users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Username already exists!";
        exit();
    }

    // Hash password and insert new user
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO Users (username, password_hash, farm_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $username, $password_hash, $farm_id);
    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error during signup.";
    }
}

// Login Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verify username and password
    $query = "SELECT * FROM Users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['farm_id'] = $user['farm_id'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit();
    } else {
        // Redirect back to login with error message
        header("Location: login.php?error=Invalid username or password");
        exit();
    }
}
?>
