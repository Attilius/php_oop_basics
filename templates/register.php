<main class="container pt-5">
    <form method="post" action="/register">
        <div class="form-group">
            <label for="email"><?= $trans("Email address"); ?></label>
            <input class="form-control" type="email" name="email" id="email" placeholder="<?= $trans("Enter your email address") . "..."; ?>">
        </div>
        <div class="form-group">

        </div>
        <div class="form-group">

        </div>
        <button class="btn btn-primary mt-2" type="submit"><?= $trans("Register"); ?></button>
    </form>
</main>
