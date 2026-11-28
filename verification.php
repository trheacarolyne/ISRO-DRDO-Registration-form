<?php
require_once 'config.php'; session_start();
$id = (int)($_SESSION['application_id'] ?? $_GET['id'] ?? 0);
$app = null;
if ($id > 0) { $q=$pdo->prepare("SELECT * FROM applications WHERE id=?"); $q->execute([$id]); $app=$q->fetch(); }
$pageTitle='Resident Verification'; include 'includes/header.php';
?>
<section class="hero"><div class="eyebrow">Next Step</div>
  <h1>Resident Verification</h1>
    <p>Confirm your residency category to continue through the demonstration process.</p></section>
<div class="form-panel">
<?php if($app): ?><div class="success">Application saved successfully. Your application number is
  <strong> <?= htmlspecialchars($app['application_no']) ?> </strong>.</div><div class="panel">
  <h2>Application Summary</h2>
    <p><strong>Name:</strong> <?= htmlspecialchars($app['full_name']) ?></p>
    <p><strong>Organisation:</strong> <?= htmlspecialchars($app['organisation']) ?></p>
    <p><strong>Experience:</strong> <?= htmlspecialchars($app['experience_years']) ?> years</p></div>
  <?php else: ?><div class="notice">No application was loaded. You can still explore the verification demo, or 
  <a href="application.php">submit an application</a> first.</div><?php endif; ?>
<form action="screening.php" method="get">
<h2>Verify Your Residency</h2><div class="field"><label>Select residency *</label>
  <select name="residency" required><option value="">Select</option>
    <option value="Indian Resident">Indian Resident</option>
    <option value="Non-Indian Resident">Non-Indian Resident</option></select></div>
<p class="muted">This prototype does not collect government ID or passport numbers. Do not upload sensitive identity documents.</p>
<button class="btn primary" type="submit">Continue to Screening Test</button>
</form></div>
<?php include 'includes/footer.php'; ?>
