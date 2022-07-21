
<main class="container">
    <form class="form-control">
        <div class="form-group">
            <label for="size">Page size</label>
            <select id="size" name="size">
                <?php foreach ($possiblePageSizes as $pageSize):?>
                    <option
                        <?php if ($pageSize == $size): ?>
                            selected="selected"
                        <?php endif ?>
                    ><?= $pageSize ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/image/add" class="btn btn-success">Add image</a>
        </div>
    </form>
    <?php require "pagination.php"; ?>
    <?php foreach ($content as $image):?>
        <a href="/image/<?php esc( $image->getId() ); ?>"><img class="mt-2 mb-2 mx-1" title="<?php esc( $image->getTitle() ); ?>" src="<?php esc( $image->getThumbnail() ); ?>" /></a>
    <?php endforeach;?>
    <?php require "pagination.php"; ?>
</main>



