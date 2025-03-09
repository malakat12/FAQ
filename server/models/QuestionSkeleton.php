<?php


class QuestionSkeleton
{

    private $question;

    private $answer;

    public function __construct( $question, $answer) {
        $this->id = $id;
        $this->question = $question;
        $this->answer=$answer;
    }

    public function getQuestion()
    {
        return $this->question;
    }
    
    public function getAnswer()
    {
        return $this->answer;
    }

    public function setQuestion($question)
    {
        $this->question = $question;
    }

    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    

}
?>
