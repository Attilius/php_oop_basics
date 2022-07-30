
<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">
    <a class="navbar-brand mx-2" href="/"><?= $trans("My images") ?></a>
    <div class="navbar-collapse collapse ">
        <ul class="navbar-nav">
            <a class="nav-item nav-link" href="/locale/hu_HU">HU</a>
            <a class="nav-item nav-link" href="/locale/fr_FR">FR</a>
            <a class="nav-item nav-link" href="/locale/en_US">EN</a>
        </ul>
    </div>
    <?php if (!empty($user)):?>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
            <?php esc($user["name"]); ?>
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/logout"><?= $trans("Logout"); ?></a>
            <a class="dropdown-item" href="/profile"><?= $trans("Profile"); ?></a>
        </div>
    </div>
    <?php else:?>
    <ul class="navbar-nav pull-right">
        <li class="nav-item active">
            <a class="nav-link" href="/login"><?= $trans("Login"); ?></a>
        </li>
    </ul>
    <?php endif; ?>
</nav>
