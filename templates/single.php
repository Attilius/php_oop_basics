<main class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img width="100%" class="mt-2 mb-2 mx-1" title="<?php esc( $image->getTitle() ); ?>" src="<?php esc( $image->getUrl() ); ?>" alt="image" />
        </div>
        <div class="col-md-6">
            <form method="post" action="/image/<?php esc( $image->getId() ); ?>/edit">
                <div class="form-group">
                    <label for="title"><?= $trans("Title"); ?></label>
                    <input id="title" name="title" value="<?php esc( $image->getTitle() ); ?>" class="form-control" placeholder="<?= $trans("Enter the title here") . "..."; ?>" />
                </div>
                <button type="submit" class="btn btn-primary"><?= $trans("Update"); ?></button>
            </form>
            <form class="mt-5" method="post" action="/image/<?php esc( $image->getId() ); ?>/delete">
                <div class="form-group">
                    <label for="title"><?= $trans("Danger zone"); ?></label>
                </div>
                <button type="submit" class="btn btn-danger"><?= $trans("Delete"); ?></button>
            </form>
        </div>
    </div>
</main>
