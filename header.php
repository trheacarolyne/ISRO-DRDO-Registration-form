<?php
$pageTitle = $pageTitle ?? 'ISRO & DRDO Recruitment Portal';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle) ?></title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="site-header">
  <div class="brand-mark">✦</div>
  <div class="brand-copy"><strong>ISRO <span>&amp;</span> DRDO</strong><small>RESEARCH CAREERS PORTAL</small></div>
  <div class="header-note">SCIENCE • INNOVATION • SERVICE</div>
</header>
<nav class="main-nav">
  <a href="index.php">Home</a>
  <a href="application.php">Apply</a>
  <a href="verification.php">Verification</a>
  <a href="interview.php">Interview</a>
  <a href="screening.php">Screening Test</a>
  <a href="aisme.php">AISME Exam</a>
  <a href="about.php">About Us</a>
  <button type="button" class="theme-toggle" onclick="toggleTheme()">Light / Dark</button>
</nav>
<main>
