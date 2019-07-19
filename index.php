<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Custom Calendar</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/calendar.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="./js/index.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="jumbotron text-center">
                <h1>Custom Calendar</h1>
                <p>Build a Calendar Using PHP</p> 
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="seldate" name="seldate" placeholder="dd.mm.yyyy">
                    </div>
                    <div class="col-md-3"><button type="button" class="btn btn-primary" id="getday">Get Day</button></div>
                    <div class="col-md-3"></div>
                </div>
                <br>
                <div id="description"></div>
                <hr>
                <div class="row">
                    <div class="col-md-12" id="custom">
                        <?php
                        include 'calendar.php';
                        $calendar = new Calendar();
                        echo $calendar->show();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
