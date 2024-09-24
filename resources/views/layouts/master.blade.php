<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="/assets/css/bootstrap.css">
   <link rel="stylesheet" href="/assets/css/main.css">
   <link rel="stylesheet" href="/assets/css/responsive.css">
   <script src="/assets/js/bootstrap.min.js"></script>
   <title>Energielabelsimpel -  @yield('title')</title>
   <meta name="description" content="Energielabelsimpel">
   <meta name="keywords" content="Energielabelsimpel">
   <meta name="author" content="Energielabelsimpel">
   <meta name="Resource-type" content="Document" />
     <link rel="shortcut icon" href="/assets/img/favicon.png">
</head>

<body>
<!---------------header section------------->
  
  @include('layouts.header') 
  @yield('content')
  @include('layouts.footer') 

</body>

</html>