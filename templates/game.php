<!-- game's own js !-->
<script type="text/javascript" src="/js/game.js"></script>
<div class="row content noSelect">
	<div class="col-md-4 text-left">
		<div class="links panel-group" id="upgrades-container">
			<div class="upgrades-panel panel panel-default">
			    <div class="panel-body">
					<h2 class="panel-title">
						<a  href="#sprites" data-toggle="collapse" data-parent="#upgrades-container"> Light Sources <span id="chevron-icon-1" class="glyphicon glyphicon-chevron-down small"></span></a>
					</h2>
			    </div>
			  <div id="sprites" class="panel-collapse collapse list-group slists">
			  	<?php foreach ($sprites as $sprite) : ?>
					<div class="list-group-item">
						<div class="row">
							<div class="col-md-8">
								<h4 class="list-group-item-heading"> <span class="glyphicon glyphicon-<?= $sprite['glyphicon'] ?>"></span>&#160;&#160;<?= $sprite["title"] ?></h4>
							</div>
							<div class="col-md-4">
								<p class="pull-right">
									<?php if ($sprite["img"] == $source): ?>
										<button type="button" class="btn btn-primary btn-xs current" id="<?= $sprite['id'] ?>-buy" value="<?= $sprite['price'] ?>" >Active</button>
									<?php elseif (in_array($sprite["id"], $owned)) : ?>
										<button type="button" class="btn btn-success btn-xs owned" id="<?= $sprite['id'] ?>-buy" value="<?= $sprite['price'] ?>" >Equip</button>
									<?php else: ?>
										<?php if ($score < $sprite["price"]) : ?>
											<button type="button" class="btn btn-danger btn-xs disabled buy" id="<?= $sprite['id'] ?>-buy" value="<?= $sprite['price'] ?>" disabled>Buy</button>
										<?php else: ?>
											<button type="button" class="btn btn-warning btn-xs buy" id="<?= $sprite['id'] ?>-buy" value="<?= $sprite['price'] ?>" >Buy</button>
										<?php endif ?>
									<?php endif ?>
								</p>
							</div>
						</div>
						<div class="row">
							<p class ="list-group-item-text">
								<b>Description: </b><?= $sprite["description"] ?>
								<br>
								<b>Production: </b> <?= formatNumber($sprite["increment"]) ?> photons/click
								<br>
								<b>Price: </b> <?= ($sprite["price"] == 0) ? "FREE" :  (formatNumber($sprite["price"]) . " photons")?>
							</p>
						</div>
					</div>
				<?php endforeach ?>
			  </div>
			</div>
		  </div> 
	</div>
	<div class="noSelect col-md-4" >
		<div class="row" id="counter-container">
			<div class="col-md-12 text-center">
				<h1 id="counter"><?=formatNumber($score, 3) ?></h1>
			</div>		
		</div>
                <div class="row">
                        <div class="col-xs-12">
                                  Photons.
                        </div>
                </div>
		<div class="row">
			<div class="col-xs-1">
			</div>
			<div class="col-xs-10 text-center">
			<b>Production: </b><span id="production"><?= formatNumber($rate, 2) ?></span> photons/second.
			</div>
			<div class="col-xs-1 text-left"> 
			<span class="badge incrementer text-center" id="incrementer"></span>
			</div>
		</div>

		<div id="game-container">
			<span id="game-helper"></span><img class="img-responsive center-block" src="/img/<?= $source ?>.png" id="game" alt="Light Source"/>
		</div>
	</div>
	<div class="col-md-4">
		<div class="links panel-group" id="automates-container">
			<div class="upgrades-panel panel panel-default">
			    <div class="panel-body">
					<h2 class="panel-title">
						<a  href="#automates" data-toggle="collapse" data-parent="#automates-container">Auto Sources <span id="chevron-icon-2" class="glyphicon glyphicon-chevron-down small"></span></a>
					</h2>
			    </div>
				  <div id="automates" class="panel-collapse collapse list-group slists text-left">
				  <?php foreach ($autosprites as $autosprite) : ?>
					<div class="list-group-item">
						<div class="row">
							<div class="col-md-10">
					
									<h4 class="list-group-item-heading"><span class="glyphicon glyphicon-<?= $autosprite['glyphicon'] ?>"></span>&#160;&#160;<?= ($autosprite["title"] == "Torch") ? $autosprite["title"] . "es" : $autosprite["title"] . "s" ?>&#160;&#160;<span class="badge incrementer" id="<?= $autosprite['id'] ?>-incrementer"></span></h4>
								
						
								
							</div>
							<div class="col-md-2">
								<p class="pull-right">
									<?php if (in_array($autosprite["id"], $owned)): ?>
										<?php if ($score < $autosprite["auto"]) : ?>
											<button type="button" class="btn btn-danger btn-xs disabled buyauto"  id="<?= $autosprite['id'] ?>-buyauto" value="<?= $autosprite['auto'] ?>|<?= $autosprite['rate']?>" disabled>Buy</button>
										<?php else: ?>
											<button type="button" class="btn btn-success btn-xs buyauto"  id="<?= $autosprite['id'] ?>-buyauto" value="<?= $autosprite['auto'] ?>|<?= $autosprite['rate']?>" >Buy</button>
										<?php endif ?>
									<?php else: ?>
											<button type="button" class="btn btn-danger btn-xs disabled"  id="<?= $autosprite['id'] ?>-buyauto" value="<?= $autosprite['auto'] ?>|<?= $autosprite['rate']?>" disabled>Buy</button>
									<?php endif ?>
								</p>
							</div>
						</div>
						<div class="row">
						 	<div class="col-md-9">
								<p class ="list-group-item-text">
									<?php $c = $autocounts[$autosprite['id']] ?>
									<b>Production: </b> <?= ($autosprite["rate"] < 1) ? formatNumber($autosprite["rate"], 2) : formatNumber($autosprite["rate"]) ?> photons/second.
									<br>
									<b>Price: </b> <?= ($sprite['auto'] == 0) ? "FREE." :  (formatNumber($autosprite['auto']) . " photons.")?>
									<br>
									<b>Owned: </b> <span id="<?= $autosprite['id'] ?>-owned"><?= formatNumber($c) ?></span> / <span id ="<?= $autosprite['id']?>-progress-limit">
									<?php if ($c < 100): ?>100 <?php elseif ($c < 500): ?> 500 <?php elseif($c < 2000) : ?> 2,000 <?php else: ?> 10,000 <?php endif ?> </span>
									units.
								</p>
									<div class="progress progress-striped">
										<?php if ($c < 100): ?>
											<div class="progress-bar progress-bar-0 active" id="<?= $autosprite['id'] ?>-progress-bar" role="progressbar" aria-valuenow="<?= $c ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $c?>%">
											</div>
										<?php elseif ($c < 500): ?>
											<div class="progress-bar progress-bar-1 active" id="<?= $autosprite['id'] ?>-progress-bar" role="progressbar" aria-valuenow="<?= $c ?>" aria-valuemin="100" aria-valuemax="500" style="width: <?= $c / 500 * 100 ?>%">
											</div>
										<?php elseif($c < 2000) : ?> 
											<div class="progress-bar progress-bar-2 active" id="<?= $autosprite['id'] ?>-progress-bar" role="progressbar" aria-valuenow="<?= $c ?>" aria-valuemin="500" aria-valuemax="2000" style="width: <?= $c / 2000 * 100?>%">
											</div>
										<?php else: ?> 
											<div class="progress-bar progress-bar-3 active" id="<?= $autosprite['id'] ?>-progress-bar" role="progressbar" aria-valuenow="<?= $c ?>" aria-valuemin="2000" aria-valuemax="10000" style="width: <?= $c / 10000 * 100?>%">
											</div>
										<?php endif ?>
										
										
									</div>
							</div>
							<div class = "col-md-3">
								<?php if ($c < 100): ?>
									<img class="img-responsive" id="<?= $autosprite['id'] ?>-medal" src="/img/medal_blank.png" alt="?"/>
								<?php elseif ($c < 500): ?>
									<img class="img-responsive" id="<?= $autosprite['id'] ?>-medal" src="/img/medal_0.png" alt="Bronze Medal"/>
								<?php elseif($c < 2000) : ?> 
									<img class="img-responsive" id="<?= $autosprite['id'] ?>-medal" src="/img/medal_1.png" alt="Silver Medal"/>
								<?php elseif($c < 10000): ?> 
									<img class="img-responsive" id="<?= $autosprite['id'] ?>-medal" src="/img/medal_2.png" alt="Gold Medal"/>
								<?php else: ?>
									<img class="img-responsive" id="<?= $autosprite['id'] ?>-medal" src="/img/medal_3.png" alt="Platinum Medal"/>
								<?php endif ?>
							</div>
						</div>
					</div>
				<?php endforeach ?>
				  </div>
			</div>
		</div>
	</div>
</div>
<div class="links">
	<a id="save-link" href="/">Save Game</a>
</div>
				