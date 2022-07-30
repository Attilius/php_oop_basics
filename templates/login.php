<main class="container pt-5">
    <form method="post" action="/login">
        <?php if ($containsError):?>
        <div class="alert alert-danger">
            <?= $trans("The username or password aren't matching") . "!"; ?>
        </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="email"><?= $trans("Email address"); ?></label>
            <input class="form-control" type="email" name="email" id="email" placeholder="<?= $trans("Enter your email address") . "..."; ?>">
        </div>
        <div class="form-group">
            <label for="password"><?= $trans("Password"); ?></label>
            <input class="form-control" type="password" name="password" id="password" placeholder="<?= $trans("Enter your password") . "..."; ?>">
        </div>
        <button class="btn btn-primary mt-2" type="submit"><?= $trans("Login"); ?></button>
        <?= $_csrf ?>
    </form>
    <div style="padding-top: 20px; text-align: center">
        <a class="btn btn-info" role="button" href="/register"><?= $trans("Register"); ?></a>
        <a class="btn btn-info" role="button" href="/forgotpass"><?= $trans("Forgot password"); ?></a>
    </div>
</main>
