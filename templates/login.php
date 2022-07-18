<main class="container pt-5">
    <form method="post" action="/login">
        <?php if ($containsError):?>
        <div class="alert alert-danger">
            The username or password aren't matching!
        </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="email">Email address</label>
            <input class="form-control" type="email" name="email" id="email" placeholder="Enter your email address...">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password" id="password" placeholder="Enter your password...">
        </div>
        <button class="btn btn-primary mt-2" type="submit">Login</button>
    </form>
    <div style="padding-top: 20px; text-align: center">
        <a class="btn btn-info" role="button" href="/register">Register</a>
        <a class="btn btn-info" role="button"href="/forgotpass">Forgot password</a>
    </div>
</main>
