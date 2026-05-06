<?php
/**
 * Aarunya Setup Script
 * Run this script to set up the project on a new system
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🌸 Aarunya Setup Script</h1>";
echo "<p>Setting up your maternal care system...</p>";

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'aarunya_db';

try {
    // Step 1: Connect to MySQL server (without database)
    echo "<h3>Step 1: Connecting to MySQL server...</h3>";
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected to MySQL server<br>";

    // Step 2: Create database if it doesn't exist
    echo "<h3>Step 2: Creating database...</h3>";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Database '$dbname' created/verified<br>";

    // Step 3: Connect to the specific database
    echo "<h3>Step 3: Connecting to database...</h3>";
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected to database '$dbname'<br>";

    // Step 4: Create tables
    echo "<h3>Step 4: Creating tables...</h3>";
    
    // Users table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL UNIQUE,
            `password` varchar(255) NOT NULL,
            `age` int(11) DEFAULT NULL,
            `blood_group` varchar(10) DEFAULT NULL,
            `pregnancy_week` int(11) DEFAULT NULL,
            `due_date` date DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Users table created<br>";

    // Admins table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `admins` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL UNIQUE,
            `password` varchar(255) NOT NULL,
            `role` varchar(50) NOT NULL DEFAULT 'admin',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Admins table created<br>";

    // Doctors table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `doctors` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL UNIQUE,
            `phone` varchar(20) DEFAULT NULL,
            `specialization` varchar(255) NOT NULL,
            `experience` int(11) DEFAULT NULL,
            `qualifications` text DEFAULT NULL,
            `availability` text DEFAULT NULL,
            `profile_image` varchar(255) DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Doctors table created<br>";

    // Appointments table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `appointments` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `doctor_id` int(11) NOT NULL,
            `appointment_date` date NOT NULL,
            `appointment_time` time NOT NULL,
            `status` enum('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
            `notes` text DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`),
            KEY `doctor_id` (`doctor_id`),
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
            FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Appointments table created<br>";

    // Step 5: Create default admin user
    echo "<h3>Step 5: Creating default users...</h3>";
    
    // Check if admin exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE email = ?");
    $stmt->execute(['admin@aarunya.com']);
    $adminExists = $stmt->fetchColumn() > 0;

    if (!$adminExists) {
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admins (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Admin User', 'admin@aarunya.com', $adminPassword, 'admin']);
        echo "✅ Default admin created (admin@aarunya.com / admin123)<br>";
    } else {
        echo "✅ Admin user already exists<br>";
    }

    // Check if test user exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute(['test@example.com']);
    $userExists = $stmt->fetchColumn() > 0;

    if (!$userExists) {
        $userPassword = password_hash('test123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, age, pregnancy_week, due_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute(['Test User', 'test@example.com', $userPassword, 28, 24, '2024-08-15']);
        echo "✅ Default test user created (test@example.com / test123)<br>";
    } else {
        echo "✅ Test user already exists<br>";
    }

    // Step 6: Add sample doctors
    echo "<h3>Step 6: Adding sample doctors...</h3>";
    
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM doctors");
    $stmt->execute();
    $doctorCount = $stmt->fetchColumn();

    if ($doctorCount < 5) {
        $sampleDoctors = [
            [
                'name' => 'Dr. Priya Sharma',
                'email' => 'priya.sharma@aarunya.com',
                'phone' => '+91-9876543210',
                'specialization' => 'Gynecology',
                'experience' => 12,
                'qualifications' => 'MBBS, MD (Gynecology), Fellowship in Maternal-Fetal Medicine',
                'availability' => 'Mon-Fri: 9:00 AM - 5:00 PM, Sat: 9:00 AM - 1:00 PM'
            ],
            [
                'name' => 'Dr. Rajesh Kumar',
                'email' => 'rajesh.kumar@aarunya.com',
                'phone' => '+91-9876543211',
                'specialization' => 'Obstetrics',
                'experience' => 15,
                'qualifications' => 'MBBS, MS (Obstetrics & Gynecology), DNB',
                'availability' => 'Mon-Sat: 10:00 AM - 6:00 PM'
            ],
            [
                'name' => 'Dr. Anita Desai',
                'email' => 'anita.desai@aarunya.com',
                'phone' => '+91-9876543212',
                'specialization' => 'Maternal-Fetal Medicine',
                'experience' => 10,
                'qualifications' => 'MBBS, MD, Fellowship in High-Risk Pregnancy',
                'availability' => 'Tue-Sat: 8:00 AM - 4:00 PM'
            ],
            [
                'name' => 'Dr. Suresh Patel',
                'email' => 'suresh.patel@aarunya.com',
                'phone' => '+91-9876543213',
                'specialization' => 'Pediatrics',
                'experience' => 8,
                'qualifications' => 'MBBS, MD (Pediatrics), IAP Fellowship',
                'availability' => 'Mon-Fri: 11:00 AM - 7:00 PM'
            ],
            [
                'name' => 'Dr. Meera Reddy',
                'email' => 'meera.reddy@aarunya.com',
                'phone' => '+91-9876543214',
                'specialization' => 'Nutrition & Wellness',
                'experience' => 6,
                'qualifications' => 'MBBS, MSc (Clinical Nutrition), Certified Lactation Consultant',
                'availability' => 'Mon-Wed-Fri: 2:00 PM - 8:00 PM'
            ]
        ];

        $stmt = $pdo->prepare("
            INSERT INTO doctors (name, email, phone, specialization, experience, qualifications, availability) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        foreach ($sampleDoctors as $doctor) {
            $stmt->execute([
                $doctor['name'],
                $doctor['email'],
                $doctor['phone'],
                $doctor['specialization'],
                $doctor['experience'],
                $doctor['qualifications'],
                $doctor['availability']
            ]);
        }
        echo "✅ Sample doctors added<br>";
    } else {
        echo "✅ Doctors already exist<br>";
    }

    // Step 7: Test database connection with the application
    echo "<h3>Step 7: Testing application database connection...</h3>";
    
    require_once 'server/config/database.php';
    $testDB = getDB();
    
    // Test admin login
    $stmt = $testDB->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute(['admin@aarunya.com']);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify('admin123', $admin['password'])) {
        echo "✅ Admin login test successful<br>";
    } else {
        echo "❌ Admin login test failed<br>";
    }
    
    // Test user login
    $stmt = $testDB->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute(['test@example.com']);
    $user = $stmt->fetch();
    
    if ($user && password_verify('test123', $user['password'])) {
        echo "✅ User login test successful<br>";
    } else {
        echo "❌ User login test failed<br>";
    }

    echo "<h3>🎉 Setup Complete!</h3>";
    echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h4>Login Credentials:</h4>";
    echo "<strong>Admin Login:</strong><br>";
    echo "Email: admin@aarunya.com<br>";
    echo "Password: admin123<br><br>";
    echo "<strong>Test User Login:</strong><br>";
    echo "Email: test@example.com<br>";
    echo "Password: test123<br>";
    echo "</div>";
    
    echo "<p><strong>Next Steps:</strong></p>";
    echo "<ol>";
    echo "<li>Visit <a href='client/index.html'>Landing Page</a></li>";
    echo "<li>Try <a href='client/login.php'>User Login</a></li>";
    echo "<li>Try <a href='client/login.php'>Admin Login</a> (switch to Admin tab)</li>";
    echo "</ol>";

} catch (PDOException $e) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h4>❌ Database Error:</h4>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Common Solutions:</strong></p>";
    echo "<ul>";
    echo "<li>Make sure MySQL/XAMPP is running</li>";
    echo "<li>Check if MySQL is running on port 3306</li>";
    echo "<li>Verify MySQL username is 'root' with no password</li>";
    echo "<li>If using different credentials, update server/config/database.php</li>";
    echo "</ul>";
    echo "</div>";
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h4>❌ Setup Error:</h4>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
}
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
a { color: #F472B6; }
</style>