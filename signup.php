<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Farm Management System</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1>Create Account</h1>
            <p>Sign up to get started</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="auth.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required 
                       maxlength="50" pattern="[A-Za-z0-9_]+" 
                       title="Username can only contain letters, numbers, and underscores">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required 
                       minlength="8" 
                       title="Password must be at least 8 characters long">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="form-group">
                <label for="farm_id">Farm ID</label>
                <input type="number" id="farm_id" name="farm_id" required 
                       min="1" 
                       title="Please enter a valid Farm ID">
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required class="form-control">
                    <option value="Admin">Admin</option>
                    <option value="Vet">Veterinarian</option>
                    <option value="Manager">Manager</option>
                </select>
            </div>

            <button type="submit" name="signup" class="submit-btn">Create Account</button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html> 