<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Currency Fair</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="/" class="navbar-brand"><img height="25" src="images/logo.png"></a>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li>
                    <a href="http://www.currencyfair.ie" target="_blank">Currency Fair</a>
                </li>
            </ul>
        </div>
    </div>
</div>


<div class="container">

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-6">
                <h1>Currency Fair</h1>
                <p class="lead">Stats</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Total Conversions</h3>
                </div>
                <div class="panel-body">
                    <?php echo $options['total_conversions']; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Total Amount Sell</h3>
                </div>
                <div class="panel-body">
                    <?php echo $options['total_amount_sell']; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Total Amount Buy</h3>
                </div>
                <div class="panel-body">
                    <?php echo $options['total_amount_buy']; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="highchart" class="col-md-12">

        </div>
    </div>

    <hr>

    <footer>

        <div class="row">
            <div class="col-lg-12">

                <ul class="list-unstyled">
                    <li class="pull-right"><a href="#top">Back to top</a></li>
                    <li>Made by <a href="mailto:pholdcroft@gmail.com" rel="nofollow">Pierce Holdcroft</a></li>
                </ul>

            </div>
        </div>

    </footer>


</div>


<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootswatch.js"></script>
<script src="js/highcharts.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        <?php echo $options['chart']->render('chart'); ?>
    });
</script>

</body>
</html>
