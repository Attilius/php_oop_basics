<main class="container pt-5">
    <form method="post" action="/register">
        <div class="form-group">
            <label for="email"><?= $trans("Email address"); ?></label>
            <input class="form-control" type="email" name="email" id="email">
        </div>
        <div class="form-group">
            <label for="password"><?= $trans("Password"); ?></label>
            <input class="form-control" type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="password"><?= $trans("Password again"); ?></label>
            <input class="form-control" type="password" name="password" id="password">
        </div>
        <button class="btn btn-primary mt-2" type="submit"><?= $trans("Register"); ?></button>
    </form>
</main>
