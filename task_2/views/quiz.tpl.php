<?php require_once(__DIR__ . '../../components/header.php'); ?>

<div class="container">
    <div class="row mt-5">
        <div class="col-md-6 mx-auto">
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
                    <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php
                        echo $_SESSION['success'];
                       unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>
            <form class="mt-5" method="post">
                <?php  for($i = 0; $i < 3; $i++) : ?>
                    <div class="form-group mb-3">
                        <label class="mb-3" for="question-<?= $i+1 ?>">
                            Question-<?= $i+1; ?> <?= $quiz->getQuestion($i)['question']; ?>
                        </label>
                        <input type="text" class="form-control <?php echo isset($v) && !empty($v->errors()) ? 'is-invalid' : '' ?>" name="question-<?= $i+1 ?>" id="question-<?= $i+1 ?>" placeholder="Enter yoyr answer">
                    </div>
                <?php endfor; ?>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . '../../components/footer.php'); ?>