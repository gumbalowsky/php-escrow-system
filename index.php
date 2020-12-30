<html>
    <head>
        <title>ESCROW example in PHP</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="adds/style.css">
    </head>

    <body>
    <?PHP
    session_start();
        if(isset($_SESSION['nickname']))
            include_once('core/escrow.php');
        else
            include_once('auth/login.php');
    ?>
    </body>
</html>