<?php
require_once 'config.php'; session_start(); $message=''; $error='';
$id=(int)($_SESSION['application_id']??0);
if($_SERVER['REQUEST_METHOD']==='POST'){
 try{
  if(!$id) 
   throw new RuntimeException('Please submit an application first.');
  foreach(['mode','city','date','time'] as $k) if(empty($_POST[$k])) 
   throw new RuntimeException('Please complete all interview details.');
   $d=DateTime::createFromFormat('Y-m-d',$_POST['date']); 
  if(!$d || $d->format('Y-m-d')!==$_POST['date'] || $_POST['date']<date('Y-m-d')) 
   throw new RuntimeException('Please choose a valid future date.');
  $s=$pdo->prepare("INSERT INTO interview_bookings(application_id,interview_mode,city,interview_date,interview_time) VALUES(?,?,?,?,?)");
  $s->execute([$id,$_POST['mode'],$_POST['city'],$_POST['date'],$_POST['time']]); $message='Your demo interview request has been saved successfully.';
 } catch(Throwable $e){$error=$e->getMessage(); }
}
$pageTitle='Interview Booking'; include 'includes/header.php';
?>
<section class="hero"> <div class="eyebrow">Candidate Scheduling</div>
 <h1>Interview Slot Booking</h1><p>Choose your preferred interview mode, location and timing.</p></section>
<div class="form-panel">
<?php if($message): ?><div class="success"><?= htmlspecialchars($message) ?></div>
 <?php endif; ?><?php if($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<?php if(!$id): ?><div class="notice">This route is intended for applicants with more than five years of experience. Submit an application first to enable booking.</div><?php endif; ?>
<form method="post"><div class="form-grid">
<div class="field"><label>Interview mode *</label> <select name="mode" required>
 <option value="">Choose mode</option>
 <option>Online (10 Minutes)</option>
 <option>Offline</option></select></div>
<div class="field"><label>Select city *</label> <select name="city" required>
 <option value="">Choose city</option>
<?php foreach(['Bengaluru','Chennai','Mysuru','Kochi','Hyderabad','Delhi'] as $c): ?>
 <option><?= $c ?></option><?php endforeach; ?></select></div>
<div class="field"><label>Select date *</label>
  <input type="date" name="date" min="<?= date('Y-m-d') ?>" required></div>
<div class="field"><label>Select time *</label>
 <select name="time" required><option value="">Choose time</option>
 <?php foreach(['09:00 AM','10:00 AM','11:00 AM','12:00 PM','01:00 PM','02:00 PM','03:00 PM','04:00 PM'] as $t): ?>
 <option><?= $t ?></option><?php endforeach; ?></select></div>
</div><button class="btn primary" type="submit" <?= !$id?'disabled':'' ?>>Confirm Booking</button></form></div>
<?php include 'includes/footer.php'; ?>
