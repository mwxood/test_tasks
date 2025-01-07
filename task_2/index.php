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

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
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

    
<?php require_once(__DIR__ . '/views/quiz.tpl.php'); ?>

