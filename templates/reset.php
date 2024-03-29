<main class="container pt-5">
    <form method="post" action="/reset">
        <?php if ($sent): ?>
            <div class="alert alert-success">
                <?= $trans("You successfully reset your password. Use your new credentials to login."); ?>
            </div>
            <a role="button" class="btn btn-info" href="/login"><?= $trans("Back to login"); ?></a>
        <?php else: ?>
            <?php if ($failed): ?>
                <div class="alert alert-warning">
                    <?= $trans("The password and the confirmation should match and the password length should be at least 8 characters"); ?>.
                </div>
            <?php endif; ?>
            <input type="hidden" name="token" value="<?= $token ?>"/>
            <div class="form-group">
                <label for="password"><?= $trans("New password"); ?></label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="form-group mt-2">
                <label for="password_confirmation"><?= $trans("Confirm new password"); ?></label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
            </div>
            <button type="submit" class="btn btn-primary mt-2"><?= $trans("Set password"); ?></button>
        <?php endif; ?>
    </form>
</main>