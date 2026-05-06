<?php
/**
 * Configuration Checker
 * Diagnose common setup issues
 */

echo "<h1>🔍 Aarunya Configuration Checker</h1>";
echo "<p>Checking your system configuration...</p>";

// Check PHP version
echo "<h3>PHP Configuration</h3>";
echo "PHP Version: " . PHP_VERSION;
if (version_compare(PHP_VERSION, '7.4.0', '>=')) {
    echo " ✅<br>";
} else {
    echo " ❌ (Requires PHP 7.4+)<br>";
}

// Check required extensions
$requiredExtensions = ['pdo', 'pdo_mysql', 'json', 'session'];
echo "<h4>Required Extensions:</h4>";
foreach ($requiredExtensions as $ext) {
    echo "$ext: " . (extension_loaded($ext) ? "✅" : "❌") . "<br>";
}

// Check file permissions
echo "<h3>File Permissions</h3>";
$directories = ['uploads/', 'uploads/profile_photos/', 'uploads/doctor_photos/'];
foreach ($directories as $dir) {
    if (is_dir($dir)) {
        echo "$dir: " . (is_writable($dir) ? "✅ Writable" : "❌ Not writable") . "<br>";
    } else {
        echo "$dir: ❌ Directory doesn't exist<br>";
    }
}

// Check database connection
echo "<h3>Database Connection</h3>";
try {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'aarunya_db';
    
    // Test MySQL connection
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    echo "MySQL Server: ✅ Connected<br>";
    
    // Test database exists
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    echo "Database '$dbname': ✅ Exists<br>";
    
    // Check tables
    $tables = ['users', 'admins', 'doctors', 'appointments'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        echo "Table '$table': " . ($stmt->rowCount() > 0 ? "✅" : "❌") . "<br>";
    }
    
    // Check default users
    echo "<h4>Default Users:</h4>";
    
    // Check admin
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute(['admin@aarunya.com']);
    $admin = $stmt->fetch();
    echo "Admin (admin@aarunya.com): " . ($admin ? "✅" : "❌") . "<br>";
    
    if ($admin) {
        $passwordCheck = password_verify('admin123', $admin['password']);
        echo "Admin password check: " . ($passwordCheck ? "✅" : "❌") . "<br>";
    }
    
    // Check test user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute(['test@example.com']);
    $user = $stmt->fetch();
    echo "Test User (test@example.com): " . ($user ? "✅" : "❌") . "<br>";
    
    if ($user) {
        $passwordCheck = password_verify('test123', $user['password']);
        echo "User password check: " . ($passwordCheck ? "✅" : "❌") . "<br>";
    }
    
} catch (PDOException $e) {
    echo "Database Connection: ❌ " . $e->getMessage() . "<br>";
}

// Check application files
echo "<h3>Application Files</h3>";
$criticalFiles = [
    'server/config/database.php',
    'server/config/config.php',
    'server/includes/auth.php',
    'server/handlers/login_handler.php',
    'client/login.php',
    'client/dashboard.php',
    'admin/pages/dashboard.php'
];

foreach ($criticalFiles as $file) {
    echo "$file: " . (file_exists($file) ? "✅" : "❌") . "<br>";
}

// Check session configuration
echo "<h3>Session Configuration</h3>";
echo "Session save path: " . session_save_path() . "<br>";
echo "Session save path writable: " . (is_writable(session_save_path()) ? "✅" : "❌") . "<br>";

// Test session
session_start();
$_SESSION['test'] = 'working';
echo "Session test: " . (isset($_SESSION['test']) ? "✅" : "❌") . "<br>";

echo "<h3>🔧 Troubleshooting Tips</h3>";
echo "<div style='background: #e7f3ff; border: 1px solid #b3d9ff; padding: 15px; border-radius: 5px;'>";
echo "<h4>If you're having login issues:</h4>";
echo "<ol>";
echo "<li><strong>Run setup.php first:</strong> <a href='setup.php'>Click here to run setup</a></li>";
echo "<li><strong>Check database credentials:</strong> Verify MySQL username/password in server/config/database.php</li>";
echo "<li><strong>Clear browser cache:</strong> Clear cookies and cache for the site</li>";
echo "<li><strong>Check error logs:</strong> Look for PHP errors in your server logs</li>";
echo "<li><strong>Verify XAMPP/WAMP:</strong> Make sure Apache and MySQL are running</li>";
echo "</ol>";
echo "</div>";

echo "<h3>📋 Quick Actions</h3>";
echo "<p>";
echo "<a href='setup.php' style='background: #F472B6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>Run Setup</a>";
echo "<a href='client/login.php' style='background: #6366f1; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>Test Login</a>";
echo "<a href='client/index.html' style='background: #10b981; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>View Landing Page</a>";
echo "</p>";
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    line-height: 1.6;
}
h1 { color: #F472B6; }
h3 { color: #333; margin-top: 30px; }
h4 { color: #666; margin-top: 20px; }
</style>