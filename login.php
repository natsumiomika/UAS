<?php 

require_once("koneksi.php");

if(isset($_POST['login'])){

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM data_pendaftar WHERE username=:username OR email=:email";
    $stmt = $db->prepare($sql);
    
    // bind parameter ke query
    $params = array(
        ":username" => $username,
        ":email" => $username
    );

    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // jika user terdaftar
    if($user){
        // verifikasi password
        if(password_verify($password, $user["password"])){
            // buat Session
            session_start();
            $_SESSION["user"] = $user;
            // login sukses, alihkan ke halaman index
            header("Location: index.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bismillah</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="hero">
        <div class="form-box">
            <div class="button-box">
                <div id="button"></div>
                <button type="button" class="toggle-button" onclick="login()">Log In</button>
                <button type="button" class="toggle-button" onclick="register()">Register</button>
            </div>
            <form id="login" action="index.php" class="input-group">
                <input type="text" class="input-field" placeholder="Username">
                <input type="password" class="input-field" placeholder="Password">
                <input type="checkbox" class="check-box"><span>Remember Me</span>
                <button type="submit" class="submit-button">Login</button>
            </form>
            <form id="register" action="Register.php" class="input-group">
                <input type="text" class="input-field" placeholder="Username">
                <input type="email" class="input-field" placeholder="Email">
                <input type="password" class="input-field" placeholder="Password">
                <input type="checkbox" class="check-box"><span>I agree to the term & conditions</span>
                <button type="submit" class="submit-button">Register</button>
            </form>
        </div>
    </div>


    <script>
        var x = document.getElementById("login");
        var y = document.getElementById("register");
        var z = document.getElementById("button");

        function register() {
            x.style.left = "-400px";
            y.style.left = "50px";
            z.style.left = "110px";
        }

        function login() {
            x.style.left = "50px";
            y.style.left = "450px";
            z.style.left = "0";
        }
    </script>
    
</body>

</html>