<?php
require_once 'config.php'; session_start(); $result=null; $id=(int)($_SESSION['application_id']??0);
if($_SERVER['REQUEST_METHOD']==='POST'){
 $answers=['q1'=>'1','q2'=>'1','q3'=>'1']; $score=0; foreach($answers as $q=>$a) if(($_POST[$q]??'')===$a)$score++;
 $marks=(int)round($score/3*100); $result=['marks'=>$marks,'passed'=>$marks>=70];
 if($id){$s=$pdo->prepare("INSERT INTO test_results(application_id,test_name,score,maximum_marks,result_status) VALUES(?,?,?,?,?)");$s->execute([$id,'Scientific Screening Demo',$marks,100,$marks>=70?'Passed':'Not Passed']);}
}
$pageTitle='Scientific Screening Test'; include 'includes/header.php';
?>
<section class="hero"><div class="eyebrow">Assessment</div><h1>Scientific Screening Test</h1><p>Demonstration assessment to explore basic science and organisational knowledge.</p></section>
<div class="form-panel">
<div class="notice"><strong>Instructions:</strong> Proposed full screening test: 100 marks. Proposed passing marks: 70. This is a short three-question demonstration quiz.</div>
<?php if($result): ?><div class="<?= $result['passed']?'success':'error' ?>">Your score: <strong><?= $result['marks'] ?>/100</strong> — <?= $result['passed']?'Congratulations! You passed the demo test.':'You did not reach the proposed passing mark.' ?></div><?php endif; ?>
<form method="post">
<div class="question"><strong>1. What does ISRO stand for?</strong><?php foreach(['Indian Science Research Organisation','Indian Space Research Organisation','International Space Research Office'] as $i=>$v): ?><label><input type="radio" name="q1" value="<?= $i===1?'1':'0' ?>" required> <?= $v ?></label><?php endforeach; ?></div>
<div class="question"><strong>2. What does DRDO mainly focus on?</strong><?php foreach(['Defence research and development','Banking services','Tourism'] as $i=>$v): ?><label><input type="radio" name="q2" value="<?= $i===0?'1':'0' ?>" required> <?= $v ?></label><?php endforeach; ?></div>
<div class="question"><strong>3. Which planet is known as the Red Planet?</strong><?php foreach(['Mars','Venus','Jupiter'] as $i=>$v): ?><label><input type="radio" name="q3" value="<?= $i===0?'1':'0' ?>" required> <?= $v ?></label><?php endforeach; ?></div>
<button class="btn primary" type="submit">Submit Test</button> <a class="btn" href="aisme.php">Continue to AISME</a>
</form></div>
<?php include 'includes/footer.php'; ?>
