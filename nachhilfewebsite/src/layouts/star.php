{{!-- This is the base layout for your project, and will be used on every page. --}}
{{> getRootPath}}
<html class="no-js" lang="en" id="star">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=utf8"/>
    <title>Nachhilfe</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.ttf">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">


    <link rel="stylesheet" href="<?php echo $root?>assets/css/app.css">
    <link rel="shortcut icon" href="favicon.ico" >
    <link rel="icon" href="animated_favicon.gif" type="image/gif" >
</head>
<body id="star">

{{!-- Pages you create in the src/pages/ folder are inserted here when the flattened page is created. --}}
{{> body}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/1.0.0/anime.min.js"></script>
<script src="https://cdn.rawgit.com/namuol/cheet.js/master/cheet.min.js"></script>


<script src="<?php echo $root?>assets/js/app.js"></script>
</body>
</html>