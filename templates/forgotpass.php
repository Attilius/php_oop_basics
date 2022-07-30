<main class="container pt-5">
    <form method="post" action="/forgotpass">
        <?php if ($sent): ?>
            <div class="alert alert-success">
                <?= $trans("We sent an e-mail to the address if it matches an account in our database") . "."; ?>
            </div>
            <a role="button" class="btn btn-info" href="/login"><?= $trans("Back to login"); ?></a>
        <?php else: ?>
            <div class="form-group">
                <label for="email"><?= $trans("Email address"); ?></label>
                <input type="email" class="form-control" name="email" id="email" placeholder="<?= $trans("Enter your email address") . "..."; ?>">
            </div>
            <button type="submit" class="btn btn-primary mt-2"><?= $trans("Reset password"); ?></button>
        <?php endif; ?>
    </form>
</main>