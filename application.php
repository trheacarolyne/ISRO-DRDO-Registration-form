<?php
require_once 'config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $required = ['full_name','dob','email','mobile','gender','address','organisation','ug_degree','ug_percentage','experience'];
    foreach ($required as $key) if (!isset($_POST[$key]) || trim((string)$_POST[$key]) === '') throw new RuntimeException('Please complete all required fields.');
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) throw new RuntimeException('Please enter a valid email address.');
    if (!preg_match('/^[0-9]{10}$/', $_POST['mobile'])) throw new RuntimeException('Mobile number must contain 10 digits.');
    if (!isset($_FILES['ug_card']) || $_FILES['ug_card']['error'] !== UPLOAD_ERR_OK) throw new RuntimeException('Please upload your UG marks card.');
    $experience = (float)$_POST['experience'];
    if ($experience < 0 || $experience > 99.9) throw new RuntimeException('Enter a valid experience value.');
    $applicationNo = 'APP'.date('Ymd').strtoupper(bin2hex(random_bytes(3)));
    $route = $experience > 5 ? 'interview' : 'verification';
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO applications (application_no,full_name,dob,email,mobile,gender,address,organisation,ug_degree,ug_percentage,pg_degree,pg_percentage,phd_qualification,experience_years,application_status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute([$applicationNo,trim($_POST['full_name']),$_POST['dob'],trim($_POST['email']),trim($_POST['mobile']),$_POST['gender'],trim($_POST['address']),$_POST['organisation'],$_POST['ug_degree'],$_POST['ug_percentage'],($_POST['pg_degree']??'')?:null,($_POST['pg_percentage']??'')!==''?$_POST['pg_percentage']:null,($_POST['phd_qualification']??'')?:null,$experience,'Submitted']);
    $id = (int)$pdo->lastInsertId();
    $uploadDir = __DIR__.'/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir,0775,true);
    $docs = [
      ['field'=>'ug_card','type'=>'UG Marks Card','required'=>true],
      ['field'=>'pg_card','type'=>'PG Marks Card','required'=>false],
      ['field'=>'phd_card','type'=>'PhD Certificate','required'=>false]
    ];
    $docStmt = $pdo->prepare("INSERT INTO application_documents (application_id,document_type,stored_filename,original_filename) VALUES (?,?,?,?)");
    foreach ($docs as $doc) {
      $f = $_FILES[$doc['field']] ?? null;
      if (!$f || $f['error'] === UPLOAD_ERR_NO_FILE) { if ($doc['required']) throw new RuntimeException('UG marks card is required.'); continue; }
      if ($f['error'] !== UPLOAD_ERR_OK) throw new RuntimeException('A document upload failed. Please try again.');
      if ($f['size'] > 5*1024*1024) throw new RuntimeException('Each document must be 5 MB or smaller.');
      $ext = strtolower(pathinfo($f['name'],PATHINFO_EXTENSION));
      if (!in_array($ext,['pdf','jpg','jpeg','png'],true)) throw new RuntimeException('Only PDF, JPG and PNG files are accepted.');
      $stored = bin2hex(random_bytes(16)).'.'.$ext;
      if (!move_uploaded_file($f['tmp_name'],$uploadDir.$stored)) throw new RuntimeException('Could not save uploaded document. Check the uploads folder permission.');
      $docStmt->execute([$id,$doc['type'],$stored,basename($f['name'])]);
    }
    $pdo->commit();
    session_start();
    $_SESSION['application_id']=$id;
    $_SESSION['application_no']=$applicationNo;
    header('Location: '.($route==='interview'?'interview.php':'verification.php'));
    exit;
  } catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    $error = $e->getMessage();
  }
}
$pageTitle='Application Form'; include 'includes/header.php';
?>
<section class="hero"><div class="eyebrow">Application Portal</div><h1>Start Your Application</h1><p>Enter your details carefully. Required fields are marked with an asterisk.</p></section>
<div class="form-panel">
<?php if($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="notice">This is a student project prototype, not an official ISRO or DRDO application form. Upload sample documents only.</div>
<form method="post" enctype="multipart/form-data">
<h2>Personal Details</h2><div class="form-grid">
<div class="field"><label>Full name *</label><input name="full_name" required maxlength="120" value="<?= htmlspecialchars($_POST['full_name']??'') ?>"></div>
<div class="field"><label>Date of birth *</label><input type="date" name="dob" required value="<?= htmlspecialchars($_POST['dob']??'') ?>"></div>
<div class="field"><label>Email address *</label><input type="email" name="email" required value="<?= htmlspecialchars($_POST['email']??'') ?>"></div>
<div class="field"><label>Mobile number *</label><input name="mobile" pattern="[0-9]{10}" maxlength="10" required value="<?= htmlspecialchars($_POST['mobile']??'') ?>"></div>
<div class="field"><label>Gender *</label><select name="gender" required><option value="">Select</option><?php foreach(['Female','Male','Other','Prefer not to say'] as $v): ?><option <?= (($_POST['gender']??'')===$v?'selected':'') ?>><?= $v ?></option><?php endforeach; ?></select></div>
<div class="field"><label>Organisation preference *</label><select name="organisation" required><option value="">Select</option><option <?= (($_POST['organisation']??'')==='ISRO'?'selected':'') ?>>ISRO</option><option <?= (($_POST['organisation']??'')==='DRDO'?'selected':'') ?>>DRDO</option><option <?= (($_POST['organisation']??'')==='ISRO & DRDO'?'selected':'') ?>>ISRO &amp; DRDO</option></select></div>
<div class="field full"><label>Address *</label><textarea name="address" rows="2" required><?= htmlspecialchars($_POST['address']??'') ?></textarea></div>
</div>
<h2>Educational Qualification</h2><div class="form-grid">
<div class="field"><label>Undergraduate degree (mandatory) *</label><select name="ug_degree" required><option value="">Select degree</option><?php foreach(['B.Sc','B.Tech','B.E','BCA','B.Com','Other'] as $v): ?><option <?= (($_POST['ug_degree']??'')===$v?'selected':'') ?>><?= $v ?></option><?php endforeach; ?></select></div>
<div class="field"><label>UG percentage *</label><input type="number" name="ug_percentage" min="0" max="100" step="0.01" required value="<?= htmlspecialchars($_POST['ug_percentage']??'') ?>"></div>
<div class="field full"><label>Upload UG marks card (PDF/JPG/PNG, max 5 MB) *</label><input type="file" name="ug_card" accept=".pdf,.jpg,.jpeg,.png" required></div>
<div class="field"><label>Postgraduate degree (optional)</label><select name="pg_degree"><option value="">Not applicable</option><?php foreach(['M.Sc','M.Tech','M.E','MBA','Other'] as $v): ?><option><?= $v ?></option><?php endforeach; ?></select></div>
<div class="field"><label>PG percentage (optional)</label><input type="number" name="pg_percentage" min="0" max="100" step="0.01"></div>
<div class="field full"><label>Upload PG marks card (optional)</label><input type="file" name="pg_card" accept=".pdf,.jpg,.jpeg,.png"></div>
<div class="field"><label>PhD qualification (optional)</label><input name="phd_qualification" maxlength="150"></div>
<div class="field"><label>Upload PhD certificate (optional)</label><input type="file" name="phd_card" accept=".pdf,.jpg,.jpeg,.png"></div>
</div>
<h2>Work Experience</h2><div class="form-grid"><div class="field"><label>Years of experience *</label><input type="number" name="experience" min="0" max="99.9" step="0.1" required value="<?= htmlspecialchars($_POST['experience']??'') ?>"><span class="muted">5 years or less: verification route. More than 5 years: interview route (project proposal).</span></div></div>
<div class="highlight">By submitting, you confirm that the information entered is for demonstration purposes in this student project.</div>
<button class="btn primary" type="submit">Submit Application &amp; Continue</button>
</form></div>
<?php include 'includes/footer.php'; ?>
