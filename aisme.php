<?php
require_once 'config.php'; session_start(); $result=null; $id=(int)($_SESSION['application_id']??0);
if($_SERVER['REQUEST_METHOD']==='POST') { $answers=['q1'=>'1','q2'=>'1','q3'=>'1'];
	$score=0;foreach($answers as $q=>$a)
		if(($_POST[$q]??'')===$a)
			$score++;
	$marks=(int)round($score/3*300);
	$result=['marks'=>$marks,'passed'=>$marks>=120];
	if($id) { $s=$pdo->prepare("INSERT INTO test_results(application_id,test_name,score,maximum_marks,result_status) VALUES(?,?,?,?,?)");
		$s->execute([$id,'AISME Demo Examination',$marks,300,$marks>=120?'Passed':'Not Passed']); } }
$pageTitle='AISME Examination'; include 'includes/header.php'; 
?>
<section class="hero"> <div class="eyebrow">Proposed Examination Concept</div>
	<h1>AISME Examination</h1>
	<p>All India Scientific Merit Examination — a demonstration assessment for this student project.</p></section>
<div class="form-panel"> <h2>About the Examination</h2> 
	<p>AISME is a proposed examination concept created for this student project. It is not an official ISRO or DRDO examination.</p>
<div class="stat-row"><div class="stat">
	<strong>300</strong>Total Marks</div><div class="stat"><strong>40%</strong>Passing Percentage</div><div class="stat"><strong>120</strong>Passing Marks</div>
	<div class="stat"><strong>6</strong>Maximum Attempts (proposal)</div>
</div> <h2>Demo Examination</h2>
<?php if($result): ?><div class="<?= $result['passed']?'success':'error' ?>">Your demo marks: <strong><?= $result['marks'] ?> / 300</strong>. 
	<?= $result['passed']?'Congratulations! You passed the demo examination.':'You did not qualify in this demo examination.' ?></div><?php endif; ?>
<form method="post">
<div class="question"><strong>1. Which organisation works on India's space missions?</strong>
	<label> <input type="radio" name="q1" value="1" required> ISRO</label>
	<label> <input type="radio" name="q1" value="0"> DRDO</label> </div>
<div class="question"><strong>2. What is the full form of DRDO?</strong>
	<label> <input type="radio" name="q2" value="1" required> Defence Research and Development Organisation</label>
	<label> <input type="radio" name="q2" value="0"> Department of Research and Digital Operations</label> </div>
<div class="question"><strong>3. Which is a natural satellite of Earth?</strong>
	<label> <input type="radio" name="q3" value="1" required> Moon</label>
	<label> <input type="radio" name="q3" value="0"> Mars</label> </div>
<button class="btn primary" type="submit">Submit Examination</button> </form>
</div> <?php include 'includes/footer.php'; ?>
