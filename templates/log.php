<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Username</th>
                <th>Score</th>
                <th>Production</th>
                <th>Platinum medals</th>
                <th>Gold medals</th>
                <th>Silver medals</th>
                <th>Bronze medals</th>
            </tr>
        </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><a href="profile.php?id=<?= $log['id' ?>"><?= $log["username"] ?></a></td>
                        <td><?= formatNumber($log["score"], 3) ?></td>
                        <td>$<?= formatNumber($log["rate"], 3) ?></td>
                        <td><?= formatNumber($log["platinum"]) ?></td>
                        <td><?= formatNumber($log["gold"]) ?></td>
                        <td><?= formatNumber($log["silver"]) ?></td>
                        <td><?= formatNumber($log["bronze"]) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
</div>
<div>
    Return to your <a href="/">game</a> or <a href="logout.php">log out</a>
</div>
