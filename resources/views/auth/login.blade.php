<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            background: #white;
            font-family: Assistant, sans-serif;
            display: flex;
            min-height: 90vh;
        }

        .login {
            color: white;
            background: background: #136a8a;
            background:
                -webkit-linear-gradient(to right, #267871, #136a8a);
            background:
                linear-gradient(to right, #267871, #136a8a);
            margin: auto;
            box-shadow:
                0px 2px 10px rgba(0, 0, 0, 0.2),
                0px 10px 20px rgba(0, 0, 0, 0.3),
                0px 30px 60px 1px rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            padding: 50px;
        }

        .login .head {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login .head .company {
            font-size: 2.2em;
        }

        .login .msg {
            text-align: center;
        }

        .login .form input[type=text].text {
            border: none;
            background: none;
            box-shadow: 0px 2px 0px 0px white;
            width: 100%;
            color: white;
            font-size: 1em;
            outline: none;
        }

        .login .form .text::placeholder {
            color: #D3D3D3;
        }

        .login .form input[type=password].password {
            border: none;
            background: none;
            box-shadow: 0px 2px 0px 0px white;
            width: 100%;
            color: white;
            font-size: 1em;
            outline: none;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .login .form .password::placeholder {
            color: #D3D3D3;
        }

        .login .form .btn-login {
            background: none;
            text-decoration: none;
            color: white;
            box-shadow: 0px 0px 0px 2px white;
            border-radius: 3px;
            padding: 5px 2em;
            transition: 0.5s;
        }

        .login .form .btn-login:hover {
            background: white;
            color: dimgray;
            transition: 0.5s;
        }

        .login .forgot {
            text-decoration: none;
            color: white;
            float: right;
        }

        footer {
            position: absolute;
            color: #136a8a;
            bottom: 10px;
            padding-left: 20px;
        }

        footer p {
            display: inline;
        }

        footer a {
            color: green;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        footer .heart {
            color: #B22222;
            font-size: 1.5em
        }
    </style>
</head>

<body>
    <section class='login' id='login'>
        <div class='head'>
            <img src="https://mateuspntx.github.io/templates/login-page/i/telescope.png">
            <h1 class='company'>Customer Login</h1>
        </div>
        <p class='msg'>Welcome back</p>
        <div class='form'>
            <form id="login-form">
                <input type="text" placeholder='Email Address' class='text' id='email' value="jhonar@gmail.com"
                    required><br>
                <input type="password" placeholder='••••••••••••••' class='password' id='password' value="password@123"
                    required><br>
                <!-- Changed anchor to button type submit -->
                <button type="submit" class='btn-login' id='do-login'>Login</button>
                <a href="#" class='forgot'>Forgot?</a>
            </form>
        </div>
    </section>
    <footer>
    </footer>

    <script>
        window.onload = function() {
            var token = localStorage.getItem('authToken');
            if (token) {
                // Redirect to dashboard if token exists
                window.location.href = '{{ url('customers') }}';
            }
        };

        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission behavior

            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;

            // Send login request to the backend
            fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200) {
                        // Save the token in localStorage
                        localStorage.setItem('authToken', data.data.token);

                        // Update the UI
                        document.getElementById('login').innerHTML =
                            '<p>We\'re happy to see you again, </p><h1>' + email + '</h1>';

                        setTimeout(() => {
                            window.location.href = '{{ url('customers') }}';
                        }, 2000);
                    } else {
                        alert('Login failed: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>
