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



<script async src="https://www.googletagmanager.com/gtag/js?id=AW-17706802616"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-17706802616');
</script>

<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-17706802616/aozgCNWa674BELi7oftB',
      'value': 1.0,
      'currency': 'EUR'
  });
</script>
</head>

<body>
<!---------------header section------------->
  
  @include('layouts.header') 
  @yield('content')
  @include('layouts.footer') 


<script>


document.addEventListener("DOMContentLoaded", function() {

  
    // Function to handle smooth scrolling to an anchor with a delay for full page load
    function scrollToAnchor() {
        if (window.location.hash) {
            const targetElement = document.querySelector(window.location.hash);
            if (targetElement) {
                // Use setTimeout to ensure the page is fully loaded before scrolling
                setTimeout(() => {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100, // Adjust for header height
                        behavior: 'smooth'
                    });
                }, 200); // Increase delay if needed
            }
        }
    }

    // Scroll when coming to the page with a hash in the URL
    scrollToAnchor();

    // Handle smooth scrolling when hash changes (if links are clicked)
    window.addEventListener('hashchange', function() {
        scrollToAnchor();
    });

    // Handle smooth scrolling for internal anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetElement = document.querySelector(this.getAttribute('href'));
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100, // Adjust for header height
                    behavior: 'smooth'
                });
            }
        });
    });

       const phoneNumber = "+31 (0)6 19027995";
        const phoneLink = `<a href="tel:${phoneNumber.replace(/ /g, '')}">${phoneNumber}</a>`;
        document.getElementById("phone-number").innerHTML = phoneLink;
});



</script>
</body>

</html>