<html>
    <?php
    include 'requesttokenfunctions.php';
    $conn = getConnectionAPI();
    ?>
    <head><title>Register for API token</title></head>
    <br/>
    <body>
    <h1>Fill in form to request API access</h1>
        <form method="post" target="_self">
            <label for="firstname">First name:</label><br>
            <input type="text" id="firstname" name="firstname"><br>

            <label for="lastname">Last name:</label><br>
            <input type="text" id="lastname" name="lastname"><br>

            <label for="email">E-mail:</label><br>
            <input type="text" id="email" name="email"><br>

            <label for="pp">Access to Punctuality Pal:&ensp;</label>
            <input type="checkbox" id="pp" name="pp" value=1><br>

            <label for="mb">Access to Moodboard:&emsp;&ensp;&ensp;</label>
            <input type="checkbox" id="mb" name="mb" value=1><br>

            <label for="cs">Access to CheapScraper:&emsp;</label>
            <input type="checkbox" id="email" name="cs" value=1><br>           
    
            <br/>        
            <input type="submit" name="register" value="register">
        </form>

        <?php
        if(isset($_POST['register'])){
            register($_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['pp'],$_POST['mb'],$_POST['cs'],$conn);

        }
        ?>
    </body>
</hmtl>