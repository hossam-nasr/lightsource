<script type="text/javascript" src="/js/profile.js"></script>


<?php if ($_SESSION["id"] == $_GET["id"]) : ?>
<div id="edit-dp-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div id="edit-dp-modal-content" class="modal-content">
    
      <div id="edit-dp-modal-header" class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit profile picture</h4>
      </div>
      <div id="edit-dp-modal-body" class="modal-body">
      	<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-cloud-upload"></span> Upload image</button>
      	<button type="button" id="edit-dp-url" class="btn btn-default"><span class="glyphicon glyphicon-link"></span> Use URL</button>
      </div>
      <div id="edit-dp-modal-footer" class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      
    </div>
  </div>
</div>
<?php endif ?>

<div class="row border-bottom">
	<div class="col-md-3">
		<img src="<?= $dp ?>" class="img-responsive img-circle center-block" alt="Profile Picture" height="200px" width="200px" id="dp">
		<?php if ($_SESSION["id"] == $_GET["id"]) : ?>
			<div class="links text-center">
				<br>
				<a id="edit-dp-button" href="#edit-dp-modal" data-target="#edit-dp-modal" data-toggle="modal"> <span class="glyphicon glyphicon-pencil"></span> Edit profile picture</a>
			</div>
		<?php endif ?>
	</div>
	<div class="col-md-9">
		<h1><b><?= $username ?></b></h1>
		<div>
        	<ul class="links text-left">
             	<li><h1><a href="#medals">Medals</a></h1></li>
             	<li><h1><a href="#stats">Stats</a></h1></li>
            </ul>
            <br>
            <br>
            <br>
			<br>
        </div>
	</div>
</div> <!-- row -->

<div class="row border-bottom" id="medals">	
	<h1 class="text-left"><b>Medals</b></h1>
	<br>
	<?php for ($i = 0; $i < $datas["Platinum medals"]; $i++) :?>
		<img class="img-responsive inline pull-left wide-margin-right" alt="Platinum Medal" src="/img/medal_3.png">
	<?php endfor ?>
	<?php for ($i = 0; $i < $datas["Gold medals"]; $i++) :?>
		<img class="img-responsive inline pull-left wide-margin-right" alt="Gold Medal" src="/img/medal_2.png">
	<?php endfor ?>
	<?php for ($i = 0; $i < $datas["Silver medals"]; $i++) :?>
		<img class="img-responsive inline pull-left wide-margin-right" alt="Silver Medal" src="/img/medal_1.png">
	<?php endfor ?>
	<?php for ($i = 0; $i < $datas["Bronze medals"]; $i++) :?>
		<img class="img-responsive inline pull-left wide-margin-right" alt="Bronze Medal" src="/img/medal_0.png">
	<?php endfor ?>
	<br>
	<br>
	<br>
	<br>
	<br>
</div>

<div class="row border-bottom" id="stats">
	<h1 class="text-left"><b>Stats</b></h1>
	<?php foreach ($datas as $title => $data ) :?>
		<div class="row">
			<div class="col-md-4 text-left">
				<?php if($title == "Bronze medals"): ?>
					<h2 class="bronze"><?= $title ?>:</h2>
				<?php elseif($title == "Silver medals"): ?>
					<h2 class="silver"><?= $title ?>:</h2>
				<?php elseif($title == "Gold medals"): ?>
					<h2 class="gold"><?= $title ?>:</h2>
				<?php elseif($title == "Platinum medals"): ?>
					<h2 class="platinum"><?= $title ?>:</h2>
				<?php else: ?>
					<h2><?= $title ?>:</h2>
				<?php endif ?>	
			</div>
			<div class="col-md-8 text-left"> 
				<?php if($title == "Bronze medals"): ?>
					<h1 class="bronze"> <span value="<?= isset($pers[$title]) ? $pers[$title] : 0?>"  class="data"><?= $data ?></span> <?= $suffix[$title] ?> </h1>
				<?php elseif($title == "Silver medals"): ?>
					<h1 class="silver" > <span value="<?= isset($pers[$title]) ? $pers[$title] : 0?>" class="data"><?= $data ?></span> <?= $suffix[$title] ?> </h1>
				<?php elseif($title == "Gold medals"): ?>
					<h1 class="gold"> <span class="data" value="<?= isset($pers[$title]) ? $pers[$title] : 0?>"><?= $data ?></span> <?= $suffix[$title] ?> </h1>
				<?php elseif($title == "Platinum medals"): ?>
					<h1 class="platinum"> <span value="<?= isset($pers[$title]) ? $pers[$title] : 0?>" class="data"><?= $data ?></span> <?= $suffix[$title] ?> </h1>
				<?php else: ?>
					<h1> <span class="data" value="<?= isset($pers[$title]) ? $pers[$title] : 0 ?>"><?= $data ?></span> <?= isset($suffix[$title]) ? $suffix[$title] : "" ?></h1>
				<?php endif ?>		
			</div>
		</div>
	<?php endforeach ?>
</div>
<a href="javascript:history.go(-1);">Back</a>
