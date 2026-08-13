<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Check if user is admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    http_response_code(403);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Access Denied</title>
        <link rel="stylesheet" href="assets/style.css">
    </head>
    <body>
        <div class="container">
            <header class="archive-header">
                <h1>🚫 ACCESS DENIED</h1>
                <p class="tagline">High Command - Restricted Area</p>
            </header>
            <div class="dashboard-container">
                <div class="error">
                    <h3>⛔ Insufficient Privileges</h3>
                    <p>You do not have the required security clearance to access this area.</p>
                    <p style="margin-top: 10px;"><strong>Your Status:</strong> Standard Operative</p>
                </div>
                <div class="info-card" style="border-left-color: #ffaa33;">
                    <h3>💡 Privilege Escalation Required</h3>
                    <p>To gain access to the High Command panel, you need to escalate your privileges.</p>
                </div>
                <a href="dashboard.php" class="btn">← Back to Dashboard</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>High Command - Operation Digital Sentry</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header class="archive-header">
            <div class="flag-stripe saffron"></div>
            <div class="flag-stripe white">
                <div class="ashoka-chakra"></div>
            </div>
            <div class="flag-stripe green"></div>
            <h1>🔐 HIGH COMMAND</h1>
            <p class="tagline">Administrative Control Panel</p>
            <p class="mission-brief">Clearance Level: MAXIMUM</p>
        </header>

        <div class="dashboard-container">
            <div class="flag-container">
                <div class="flag-box" style="border-left-color: #00ff00; box-shadow: 0 5px 30px rgba(0, 255, 0, 0.4);">
                    <span class="flag-label">🏆 HIGH COMMAND FLAG_LEVEL_3 (FINAL):</span>
                    <code class="flag" style="font-size: 1.2em;">_3SC4L4T10N_M4ST3R}</code>
                </div>
            </div>

            <div class="success" style="margin: 30px 0;">
                <h3>🎉 MISSION ACCOMPLISHED!</h3>
                <p><strong>Congratulations, High Command Operative!</strong></p>
                <p style="margin-top: 10px;">You have successfully completed all objectives of Operation Digital Sentry:</p>
                <ul style="margin-left: 20px; margin-top: 10px;">
                    <li>✓ Reconnaissance and intelligence gathering</li>
                    <li>✓ API credential discovery and exploitation</li>
                    <li>✓ Authentication system bypass</li>
                    <li>✓ Mass assignment vulnerability exploitation</li>
                    <li>✓ Privilege escalation to High Command</li>
                </ul>
            </div>

            <div class="nav-tabs">
                <a href="dashboard.php" class="nav-tab">← Command Center</a>
                <a href="#" class="nav-tab active">Admin Panel</a>
            </div>

            <div class="info-card">
                <h3>👤 Administrator Profile</h3>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                <p><strong>Operative ID:</strong> #<?php echo htmlspecialchars($_SESSION['user_id']); ?></p>
                <p><strong>Security Clearance:</strong> <span style="color: #ff9933; font-weight: bold;">HIGH COMMAND</span></p>
                <p><strong>Admin Status:</strong> <span style="color: #00ff00; font-weight: bold;">ACTIVE ✓</span></p>
            </div>


            <div class="info-card" style="border-left-color: #ff9933;">
                <h3>🇮🇳 Independence Day 2026 - Cyber Defense Message</h3>
                <p style="font-style: italic; color: #ff9933; font-size: 1.1em;">"Jai Hind! Satyameva Jayate"</p>
                <p style="margin-top: 15px;">As we celebrate 77 years of our Independence, we must remain vigilant in protecting our nation's digital infrastructure. The skills you've demonstrated today are crucial for defending India in the cyber realm.</p>
                <p style="margin-top: 10px;">This exercise highlights the importance of:</p>
                <ul style="margin-left: 20px; margin-top: 10px;">
                    <li>Continuous security awareness training</li>
                    <li>Proactive vulnerability assessment</li>
                    <li>Strong authentication mechanisms</li>
                    <li>Defense against common web vulnerabilities</li>
                </ul>
                <p style="margin-top: 15px; font-weight: bold; color: #138808;">Together, we build a stronger, safer digital India! 🇮🇳</p>
            </div>

            <form action="logout.php" method="POST">
                <button type="submit" class="btn logout-btn">🚪 Logout</button>
            </form>
        </div>

        <footer class="archive-footer">
            <p>🎖️ Independence Day 2026 - Cyber Security Exercise 🎖️</p>
            <p>Indian Cyber Command - Training Division</p>
            <p style="margin-top: 10px; color: #ff9933;">Jai Hind! 🇮🇳</p>
        </footer>
    </div>
</body>
</html>