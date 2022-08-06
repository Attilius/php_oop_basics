<style>
    .box_uploading,
    .box_success,
    .box_error,
    #uploadable{
        display: none;
    }

    .box{
        min-height: 10em;
        padding: 1em;
        margin-bottom: 1em;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #eeeeee;
        outline: 2px dashed black;
        outline-offset: -10px;
    }

    .is-dragover{
        background-color: gray!important;
    }

    .box.is-uploading .box_input{
        visibility: hidden;
    }

    .box.is-uploading .box_uploading{
        display: block;
    }

</style>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <form method="post" id="uploadform" action="/image/add" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title"><?= $trans("Title"); ?></label>
                    <input id="title" name="title" class="form-control" placeholder="<?= $trans("Enter the title here"); ?>" />
                    <?php if ($violations): ?>
                        <?php foreach ($violations as $violation): ?>
                            <div class="alert alert-warning"><?= $violation->getMessage() ?></div>
                        <?php endforeach ?>
                    <?php endif ?>
                    <?= $_csrf ?>

                </div>
                <div class="box">
                    <div class="box_input">
                        <label for="uploadable" class="box_filelabel">
                            <strong><?= $trans("Choose a file"); ?></strong>
                            <span class="box_dragndrop"><?= $trans("or drag it here"); ?></span>.
                        </label>
                        <input name="file" id="uploadable" type="file" class="form-control"/>
                    </div>
                    <div class="box_uploading"><?= $trans("Uploading"); ?></div>
                    <div class="box_success"><?= $trans("Done") . "!"; ?></div>
                    <div class="box_error"><?= $trans("Error") . "!"; ?></div>
                </div>
                <button type="submit" class="btn btn-primary"><?= $trans("Create"); ?></button>
                <a href="/" class="btn btn-primary"><?= $trans("Cancel"); ?></a>
            </form>
        </div>
</main>
