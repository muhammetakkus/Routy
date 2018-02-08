<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/default.css">
    <!-- Custom Css -->
    @yield(css)

    <title>routy basic templating</title>
</head>
<body>

    <!-- NAV -->
    <nav>NAV</nav>

    <!-- Dynamic Content -->
    @yield(content)

    <!-- FOOTER -->
    <footer>FOOTER</footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
    <!-- Dynamic Script -->
    @yield(script)
</body>
</html>