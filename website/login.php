<html>
    <?php
    include 'menu.php';
    ?>
    <head><title>Login</title></head>
    <br/>
    <body>
    <h1>Login onto Punctuality Pal Website</h1>
        <form method="post" target="_self">
            <label for="email">E-mail:</label><br>
            <input type="text" id="email" name="email"><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>

            <br/>        
            <input type="submit" name="login" value="login">
        </form>

        <?php
        if(isset($_POST['login'])){
            login($_POST['login'],$_POST['password']);
        }
        ?>
    </body>
</hmtl>