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
            alert("login failed. Please try again.");
            console.error(error);
        }
    });
};
