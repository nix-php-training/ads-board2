<!DOCTYPE html>
<!-- saved from url=(0044)http://getbootstrap.com/examples/jumbotron/# -->
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://getbootstrap.com/favicon.ico">

    <title>Jumbotron Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/jumbotron/jumbotron.css" rel="stylesheet">

    <link href="/application/assets/css/style.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/home">Home</a>
            <a class="navbar-brand" href="/login">Login</a>
            <a class="navbar-brand" href="/register">Regitsration</a>
        </div>
    </div>
</nav>

<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <?php echo $content; ?>
    </div>
</div>
<!-- /container -->
<footer>
    <div class="container">
        <p>© Company 2014</p>
    </div>
</footer>

</body>
</html>