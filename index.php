<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body class="text-left">
    <div class="container">
    <h1>Sign Up</h1>
    <form id="signupForm" action="welcome.html">
        First Name: <input type="text" name="fname" /><br />
        Last Name: <input type="text" name="lname" /><br />
        Gender: <input type="radio" name="gender" value="m" /> Male
        <input type="radio" name="gender" value="f" /> Female<br />

        Zip Code: <input type="text" name="zip" id="zip" /><br />
        City: <span id="city"></span><br />
        Latitude: <span id="latitude"></span><br />
        Longitude: <span id="longitude"></span><br /><br />

        State:
        <select id="state" name="state">
            <option>Select One</option>
            <option value="ca">California</option>
            <option value="ny">New York</option>
            <option value="tx">Texas</option>
        </select><br />

        Select a County: <select id="county"></select><br /><br />
        Desired Username: <input type="text" id="username" name="username" /><br />
        <span id="usernameError"></span><br />

        Password: <input type="password" id="password" name="password" /><br />
        Password Again: <input type="password" id="passwordAgain" /><br />
        <span id="passwordAgainError"></span><br />

        <input type="submit" value="Sign up!" />
    </form>
</div>
    <script>
        var usernameAvailable = false;
        //Displaying City from API after typing a zip Code
        $("#zip").on("change", async function() {
            //alert($("#zip").val());
            let zipCode = $("#zip").val();
            let url = `https://cst336.herokuapp.com/projects/api/cityInfoAPI.php?zip=${zipCode}`;
            let response = await fetch(url);
            let data = await response.json();
            console.log(data);
            $("#city").html(data.city);
            $("#latitude").html(data.latitude);
            $("#longitude").html(data.longitude);
        }); //zip

        $("#state").on("change", async function() {
            //alert($("#state").val());
            let state = $("#state").val();
            let url = `https://cst336.herokuapp.com/projects/api/countyListAPI.php?state=${state}`;
            let response = await fetch(url);
            let data = await response.json();
            console.log(data);
            $("#county").html("<option>Select one</option>");
            for (let i = 0; i < data.length; i++) {
                $("#county").append(`<option>${data[i].county}</option>`);
            }
        }) //state

        $("#username").on("change", async function() {
            //alert($("#username").val());
            let username = $("#username").val();
            let url = `https://cst336.herokuapp.com/projects/api/usernamesAPI.php?username=${username}`;
            let response = await fetch(url);
            let data = await response.json();

            if (data.available) {
                $("#usernameError").html("Username available!");
                $("#usernameError").css("color", "green");
                usernameAvailable = true;
            } else {
                $("#usernameError").html("Username not available!");
                $("#usernameError").css("color", "red");
                usernameAvailable = false;
            };
        }); //username

        $("#signupForm").on("submit", function(event){
            //alert(usernameAvailable);
            if(!isFormValid()){
                event.preventDefault();
            };
        });

        function isFormValid(){
            isValid = true;
            if(!usernameAvailable){
                isValid = false;
            };

            if($("#username").val().length == 0){
                isValid = false;
                $("#usernameError").html("Username is required");
                $("#usernameError").css("color", "red");
            };

            if($("#password").val() != $("#passwordAgain").val()){
                $("#passwordAgainError").html("Password mismatch!");
                $("#passwordAgainError").css("color", "red");
                isValid= false;
            };

            if($("#password").val().length < 6){
                $("#passwordAgainError").html("Password must be at least 6 characters!");
                $("#passwordAgainError").css("color", "red");
                isValid = false;
            };

            return isValid;
        };
    </script>
</body>

</html>
