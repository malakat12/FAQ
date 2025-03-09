<?php
$conn = include __DIR__ . '/../../connection/connect.php';

if (!$conn || !($conn instanceof mysqli)) {
    die("Failed to include connect.php or establish database connection.");
}
echo "connect.php included and database connection established successfully!<br>";
$questions = [
    [
        'question' => 'What is the purpose of prompt patterns',
        'answer' => 'Prompt patterns offer reusable solutions to specific problems in the context of output generation from large-scale language models (LLMs) like ChatGPT.'
    ],
    [
        'question' => 'What is the Flipped Interaction pattern',
        'answer' => 'The Flipped Interaction pattern flips the interaction flow so the LLM asks the user questions to achieve a desired goal, rather than the user driving the conversation.'
    ],
    [
        'question' => ' What is the Meta Language Creation pattern',
        'answer' => 'The Meta Language Creation pattern explains the semantics of an alternative language to the LLM so the user can write future prompts using this new language.'
    ],
    [
        'question' => 'What is the Output Automater pattern?',
        'answer' => 'The Output Automater pattern involves having the LLM generate a script or automation artifact to reduce manual effort in implementing its output recommendations.'
    ],
    [
        'question' => 'What is the Persona pattern?',
        'answer' => 'The Persona pattern enables the LLM to generate output from a specific point of view or perspective, such as acting as a particular persona.'
    ],
    [
        'question' => 'What is the Question Refinement pattern?',
        'answer'=> 'The Question Refinement pattern ensures the LLM suggests better or more refined questions the user could ask instead of their original question.'
    ],
    [
        'question'=> 'What is the Alternative Approaches pattern?',
        'answer'=> 'The Alternative Approaches pattern ensures the LLM offers alternative ways of accomplishing a task, encouraging the user to consider different methods.'
    ],
    [
        'question'=> 'What is the Cognitive Verifier pattern?',
        'answer'=> 'The Cognitive Verifier pattern subdivides a question into additional questions to provide a more accurate and detailed answer.'
    ],
    [
        'question'=> 'What is the Fact Check List pattern?',
        'answer'=> 'The Fact Check List pattern ensures the LLM outputs a list of facts that form the basis of its output, helping the user verify the accuracy of the information.'
    ],
    [
        'question'=> 'What is the Template pattern?',
        'answer'=> 'The Template pattern ensures the LLM\’s output follows a precise template in terms of structure, as specified by the user.'
    ],
    [
        'question'=> 'What is the Infinite Generation pattern?',
        'answer'=> 'The Infinite Generation pattern allows the LLM to automatically generate a series of outputs without requiring the user to reenter the prompt each time.'
    ],
    [
        'question'=> 'What is the Visualization Generator pattern?',
        'answer'=> ' The Visualization Generator pattern uses text generation to create visualizations, making concepts easier to grasp in diagram or image format.'
    ],
    [
        'question'=> 'What is the Game Play pattern?',
        'answer'=> ' The Game Play pattern creates a game around a given topic, requiring users to apply problem-solving skills to accomplish tasks related to the scenario.'
    ],
    [
        'question'=> 'What is the Reflection pattern?',
        'answer'=> 'The Reflection pattern asks the LLM to explain the rationale behind its answers, helping users assess the validity of the output and understand the reasoning.'
    ],
    [
        'question'=> 'What is the Refusal Breaker pattern?',
        'answer'=> ' The Refusal Breaker pattern helps users rephrase a question when the LLM refuses to answer, providing alternative wordings that the LLM can address.'
    ],
    [
        'question'=> 'What is the Context Manager pattern?',
        'answer'=> 'The Context Manager pattern allows users to specify or remove context for a conversation with the LLM, focusing the conversation on specific topics.'
    ],
    [
        'question'=> 'What is the Recipe pattern?',
        'answer'=> 'The Recipe pattern provides constraints to output a sequence of steps given partially provided "ingredients," helping users achieve a stated goal.'
    ],
    [
        'question'=> 'What is the motivation behind the Output Automater pattern?',
        'answer'=> 'The motivation is to reduce manual effort and errors by automating the steps recommended by the LLM’s output.'
    ],
    [
        'question'=> 'What is a potential consequence of the Template pattern?',
        'answer'=> 'A potential consequence is that the LLM\’s output may be filtered, eliminating other useful outputs that do not fit the specified template.'
    ]
];

try {
    $conn->begin_transaction(); 
    foreach ($questions as $question) {
        $query = "INSERT INTO questions (question, answer) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $question['question'], $question['answer']);
        $stmt->execute();
    }

    $conn->commit(); 
    echo "Seeding successfully!";
} catch (Exception $e) {
    $conn->rollback(); 
    echo "Seeding failed: " . $e->getMessage();
}
?>