const articlePages = {};

articlePages.base_api = "http://localhost/FAQ/server/apis/v1";

const headers = {
    'Content-Type': 'application/json'
};

articlePages.get_data = async function(url) {
    try {
        const response = await axios.get(url, { headers });
        return response.data;
    } catch (error) {
        console.error("GET Error:", error);
        throw error;
    }
};

articlePages.post_data = async function(url, data) {
    try {
        const response = await axios.post(url, data, { headers });
        return response.data;
    } catch (error) {
        console.error("POST Error:", error);
        throw error;
    }
};

articlePages.console = function(title, values, one_value = false) {
    console.log("------" + title + "------");
    if (one_value) {
        console.log(values);
    } else {
        for (let i = 0; i < values.length; i++) {
            console.log(values[i]);
        }
    }
    console.log("------" + title + "------");
};

articlePages.loadFor = function(page_name) {
    eval("articlePages.load_" + page_name + "();");
};

articlePages.login = async function(email, password) {
    const login_api = articlePages.base_api + "/login.php";
    const data = { email, password };
    return await articlePages.post_data(login_api, data);

};

articlePages.signUp = async function(full_name, email, password) {
    const signUp_api = articlePages.base_api + "/signUp.php";
    const data = { full_name, email, password };
    return await articlePages.post_data(signUp_api, data);
};

articlePages.load_signUp = function() {
    const form = document.getElementById("signupForm");
    form.addEventListener("submit", async function(event) {
        event.preventDefault(); 

        const full_name = document.getElementById("full_name").value;
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        try {
            const response = await articlePages.signUp(full_name, email, password);
            alert("Sign up successful!");
            console.log(response);
            window.location.href = "login.html";
        } catch (error) {
            alert("Sign up failed. Please try again.");
            console.error(error);
        }
    });
};


articlePages.load_login = function() {
    const form = document.getElementById("loginForm");
    form.addEventListener("submit", async function(event) {
        event.preventDefault(); 

        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        try {
            const response = await articlePages.login(email, password);
            alert("login successful!");
            console.log(response);
            window.location.href = "home.html";
        } catch (error) {
            alert("login failed. Try again.");
            console.error(error);
        }
    });
};

articlePages.load_home= function(){
    document.addEventListener('DOMContentLoaded', async function () {
        const resultsDiv = document.getElementById('results'); 
    
        try {
            const response = await fetch('http://localhost/FAQ/server/apis/v1/getQuestions.php');
            const data = await response.json(); 
            
            displayQuestions(data, resultsDiv);
        } catch (error) {
            console.error('Error fetching questions:', error);
            resultsDiv.innerHTML = '<p>An error occurred while fetching questions.</p>';
        }
    
        document.getElementById('searchForm').addEventListener('submit', async function (event) {
            event.preventDefault();

            const keyword = document.getElementById('keyword').value.toLowerCase(); 
    
            try {
                const response = await fetch('http://localhost/FAQ/server/apis/v1/getQuestions.php');
                const data = await response.json();
                
                const filteredQuestions = data.filter(question => 
                    question.question.toLowerCase().includes(keyword) || 
                    question.answer.toLowerCase().includes(keyword)
                );
    
                displayQuestions(filteredQuestions, resultsDiv);
            } catch (error) {
                console.error('Error fetching questions:', error);
                resultsDiv.innerHTML = '<p>An error occurred while fetching questions.</p>';
            }
        });
    });
}

function displayQuestions(questions, container) {
    container.innerHTML = '';

    if (Array.isArray(questions) && questions.length > 0) {
        questions.forEach(question => {
            const questionDiv = document.createElement('div');
            questionDiv.className = 'question';
            questionDiv.innerHTML = `
                <h3>${question.question}</h3>
                <p>${question.answer}</p>
            `;
            container.appendChild(questionDiv);
        });
    } else {
        container.innerHTML = '<p>No questions found.</p>';
    }
}

articlePages.load_post= function(){
    document.getElementById('postQuestionForm').addEventListener('submit', async function(event) {
        event.preventDefault();
    
        const question = document.getElementById('question').value;
        const answer = document.getElementById('answer').value;
        const messageDiv = document.getElementById('message');
    
        if (!question || !answer) {
            messageDiv.innerHTML = '<p>Please fill in both fields.</p>';
            return;
        }
    
        try {
            const response = await fetch('http://localhost/FAQ/server/apis/v1/postQuestion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ question, answer }),
            });
    
            const data = await response.json();
    
            if (data.success) {
                messageDiv.innerHTML = `<p style="color: green;">${data.success}</p>`;
                window.location.href = "home.html";

            } else if (data.error) {
                messageDiv.innerHTML = `<p style="color: red;">${data.error}</p>`;
            }
        } catch (error) {
            console.error('Error posting question:', error);
            messageDiv.innerHTML = '<p style="color: red;">An error occurred while posting the question.</p>';
        }
    });
}