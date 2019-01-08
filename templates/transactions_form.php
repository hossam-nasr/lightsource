<div>
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>Number</th>
                <th>Soruce Type</th>
                <th>Source Name</th>
                <th>Price</th>
            </tr>
        </thead>
            <tbody>
            	<?php $counter = 1 ?>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                    	<td><?= $counter++ ?></td>
                        <td><?= $transaction["type"] ?></td>
                        <td><span class="glyphicon glyphicon-<?= $transaction['glyphicon'] ?>"></span>&#160;&#160;<?= $transaction["title"] ?></td>
                        <td><?= formatNumber($transaction["price"]) ?> photons.</td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
</div>
<div>
    Return to your <a href="/">game</a> or <a href="logout.php">log out</a>
</div>
