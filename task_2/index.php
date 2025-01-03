<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
</head>
<body>

<?php 
    require_once(__DIR__ . '/vendor/autoload.php');
    require_once(__DIR__ . '/inc/Helpers.php');

    require_once(__DIR__ . '/inc/Quiz.php');
    $quiz = new Quiz([
        ['question' => 'What is the capital of France', 'answer' => 'Paris'],
        ['question' => 'What is the capital of Germany', 'answer' => 'Berlin'],
        ['question' => 'What is the capital of Italy', 'answer' => 'Rome']
    ]);

    use Valitron\Validator as V;
    V::lang('en'); 

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = Helpers::load(['question-1', 'question-2', 'question-3']);

        $v = new V($data);
       // Helpers::dump($data);

        $v->rules([
            'required' => ['question-1', 'question-2', 'question-3'],
            'in' => [
                ['question-1', [$quiz->getQuestion(0)['answer']]],
                ['question-2', [$quiz->getQuestion(1)['answer']]],
                ['question-3', [$quiz->getQuestion(2)['answer']]]
            ],
        ]);

        if($v->validate()) {
            $_SESSION['success'] = 'Success! You have completed the quiz';

        } else {
            $_SESSION['error'] = Helpers::get_errors($v->errors());
            
        }
    }
?>

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
    
</body>
</html>