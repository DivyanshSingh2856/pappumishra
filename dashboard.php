<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command Center - Operation Digital Sentry</title>
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
            <h1>🎖️ COMMAND CENTER</h1>
            <p class="tagline">Operative Dashboard - Operation Digital Sentry</p>
            <p class="mission-brief">Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        </header>

        <div class="dashboard-container">
            <div class="flag-container">
                <div class="flag-box">
                    <span class="flag-label">🎯 AUTHENTICATION FLAG_LEVEL_2:</span>
                    <code class="flag">_4SS1GNM3NT_PR1V1L3G3</code>
                </div>
            </div>

            <div class="nav-tabs">
                <a href="#" class="nav-tab active">Overview</a>
                <?php if ($is_admin): ?>
                    <a href="admin.php" class="nav-tab" style="background: #ff9933; color: #000; font-weight: bold;">🔐 Admin Panel</a>
                <?php endif; ?>
            </div>

            <div class="info-card">
                <h3>📊 Operative Status</h3>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                <p><strong>Operative ID:</strong> #<?php echo htmlspecialchars($_SESSION['user_id']); ?></p>
                <p><strong>Security Level:</strong> <?php echo $is_admin ? '<span style="color: #ff9933;">HIGH COMMAND</span>' : '<span style="color: #00d9ff;">Standard Operative</span>'; ?></p>
                <p><strong>Session Status:</strong> <span style="color: #00ff00;">ACTIVE</span></p>
            </div>

            <?php if (!$is_admin): ?>
            <div class="info-card" style="border-left-color: #ffaa33;">
                <h3>💡 Intelligence Report</h3>
                <p>Your current security clearance is <strong>Standard Operative</strong>.</p>
                <p style="margin-top: 10px;">High Command access requires elevated privileges.</p>
            </div>
            <?php endif; ?>

            <div class="info-card">
                <h3>🇮🇳 Independence Day 2026</h3>
                <p style="font-style: italic; color: #ff9933;">"The strength of the nation is in the hands of those who protect it in both physical and digital realms."</p>
                <p style="margin-top: 10px;">This cyber defense exercise demonstrates the importance of security awareness in protecting our digital infrastructure.</p>
            </div>

            <form action="logout.php" method="POST">
                <button type="submit" class="btn logout-btn">🚪 Logout</button>
            </form>
        </div>


<!-- Don't you think to esclate priviledges? -->
        <footer class="archive-footer">
            <p>🎖️ Independence Day 2026 - Cyber Security Exercise 🎖️</p>
            <p>Indian Cyber Command - Training Division</p>
        </footer>
    </div>
</body>
</html>