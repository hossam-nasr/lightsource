<form action="change.php" method="post">
    <fieldset>
        <?php if ($mode == "p" or $mode == "v"): ?>
            <?php if ($mode == "p"): ?>
                <div class="form-group">            
                    <input autofocus class="form-control" name="old" placeholder="Old Password" type="password"/>
                </div>
            <?php endif ?>
            <div class="form-group">
                <input class="form-control" name="new" placeholder="New Password" type="password"/>
            </div>
            <div class="form-group">
                <input class="form-control" name="confirmation" placeholder="Confirm New Password" type="password"/>
            </div>
        <?php elseif ($mode == "e"): ?>
            <div class="form-group">
                <input autofocus class="form-control" name="email" placeholder="E-mail Address" type="text"/>
            </div>
        <?php endif ?>
        <input type="hidden" name="mode" value="<?= $mode ?>" />
        <input type="hidden" name="id" value="<?= $id ?>" />
        <div class="form-group">
            <button type="submit" class="btn btn-default">Reset Password</button>
        </div>         
    </fieldset>
</form>
