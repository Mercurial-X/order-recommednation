<?php
session_start();
require 'connection.php';
$conn = Connect();
if (!isset($_SESSION['login_user2'])) {
    header("location: customerlogin.php");
    exit();
}

$gtotal = 0; // Initialize the grand total variable

foreach ($_SESSION["cart"] as $keys => $values) {
    $quantity = $values["food_quantity"];
    $price = $values["food_price"];
    $total = $quantity * $price;
    $gtotal += $total; // Add the total to the grand total
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment | ASPRESSO</title>
    <link rel="stylesheet" type="text/css" href="css/payment.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
    <button onclick="topFunction()" id="myBtn" title="Go to top">
        <span class="glyphicon glyphicon-chevron-up"></span>
    </button>

    <script type="text/javascript">
        window.onscroll = function () {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("myBtn").style.display = "block";
            } else {
                document.getElementById("myBtn").style.display = "none";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>

    <nav class="navbar navbar-inverse navbar-fixed-top navigation-clean-search" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">ASPRESSO</a>
            </div>

            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="recommendation.php">Recommendation</a></li>
                    <li><a href="aboutus.php">About</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                </ul>

                <?php if (isset($_SESSION['login_user1'])) { ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_user1']; ?> </a></li>
                        <li><a href="myrestaurant.php">MANAGER CONTROL PANEL</a></li>
                        <li><a href="logout_m.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                    </ul>
                <?php } elseif (isset($_SESSION['login_user2'])) { ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_user2']; ?> </a></li>
                        <li><a href="foodlist.php"><span class="glyphicon glyphicon-cutlery"></span> Food Zone</a></li>
                        <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart
                                <?php
                                if (isset($_SESSION["cart"])) {
                                    $count = count($_SESSION["cart"]);
                                    echo "($count)";
                                } else {
                                    echo "(0)";
                                }
                                ?>
                            </a></li>
                        <li><a href="logout_u.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                    </ul>
                <?php } else { ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-user"></span> Sign Up <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="customersignup.php">User Sign-up</a></li>
                                <li><a href="managersignup.php">Manager Sign-up</a></li>
                                <li><a href="#">Admin Sign-up</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-log-in"></span> Login <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="customerlogin.php">User Login</a></li>
                                <li><a href="managerlogin.php">Manager Login</a></li>
                                <li><a href="#">Admin Login</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="jumbotron">
            <h1>Choose your payment option</h1>
        </div>
    </div>
    <br>

    <h1 class="text-center">Grand Total: &#8360; <?php echo number_format($gtotal, 2); ?>/-</h1>

    <h5 class="text-center">Including all service charges (no delivery charges applied).</h5>
    <br>
    <h1 class="text-center">
        <a href="cart.php"><button class="btn btn-warning"><span class="glyphicon glyphicon-circle-arrow-left"></span> Go back to cart</button></a>
        <a href="COD.php"><button class="btn btn-success"><span class="glyphicon glyphicon-ok-circle"></span> Cash On Delivery</button></a>
        <a href="card.php"><button class="btn btn-warning"><span class="glyphicon glyphicon-circle-arrow-left"></span>Credit Card</button></a>
    </h1>

    <br><br><br><br><br><br>
</body>
</html>
