<?php include "layout.php"; ?>

@section(css)
    <link rel="stylesheet" href="css/home.css">
@stop

@section(content)
    <div class="container" id="app">
        {{message}}
        <?php echo $test; ?>
    </div>
@stop

@section(script)
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                message: 'Hello Vue!'
            }
        })
    </script>
@stop