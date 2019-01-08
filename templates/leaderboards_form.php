<div>
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>Position</th>
                <th>Username</th>
                <th>Current Score</th>
                <th>Photon Production</th>
                <th class="platinum">Platinum medals</th>
                <th class="gold">Gold medals</th>
                <th class="silver">Silver medals</th>
                <th class="bronze">Bronze medals</th>
            </tr>
        </thead>
            <tbody>
            	<?php $counter = 1 ?>
                <?php foreach ($logs as $log): ?>
                    <tr>
                    	<td><?= $counter++ ?></td>
                        <td><div class="links"><a href="profile.php?id=<?= $log['id'] ?>"><?= $log["username"] ?></a></div></td>
                        <td><?= formatNumber($log["score"], 3) ?> photons.</td>
                        <td><?= formatNumber($log["rate"], 3) ?> photons/sec.</td>
                        <td class="platinum"><?= formatNumber($log["platinum"]) ?></td>
                        <td class="gold"><?= formatNumber($log["gold"]) ?></td>
                        <td class="silver"><?= formatNumber($log["silver"]) ?></td>
                        <td class="bronze"><?= formatNumber($log["bronze"]) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
</div>
<div>
    Return to your <a href="/">game</a> or <a href="logout.php">log out</a>
</div>
