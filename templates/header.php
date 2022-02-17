<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>blog.com</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="public/style.css?v=<?php echo time(); ?>">
</head>
    <body class="grey lighten-4">
        <nav class="white z-depth-0">
            <div class="container">
                <a href="index.php" class="left brand-logo brand-text">blog.com</a>
                <ul id="nav-mobile" class="right hide-on-small-and-down">
                    <li><a href="post.php" class="btn brand z-depth-0">Create a Post</a></li>     
                    <?php if (!isset($_SESSION["auth"])) {?>
                        <li><a href="login.php" class="btn brand z-depth-0">Login</a></li>
                        <li><a href="register.php" class="btn brand z-depth-0">Register</a></li>
                    <?php } else { ?> 
                        <li><a href="logout.php" class="btn brand z-depth-0">Logout</a></li>
                    <?php } ?>  
                </ul>
            </div>
        </nav>
    
    