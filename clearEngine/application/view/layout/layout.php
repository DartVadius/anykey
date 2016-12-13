<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/blog/public/js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/blog/public/css/bootstrap.css">
    <script src="/blog/public/js/bootstrap.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="/blog/public/css/style.css">    
    <script src="/blog/public/js/ckeditor/ckeditor.js"></script>
    
    <title><?php echo Application::$App->title; ?></title>
</head>
<body class="" style="">
    <div class="container">
        <?php foreach ($content as $value) { echo $value; } ?>        
    </div>
</body>
</html>