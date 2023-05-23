<!DOCTYPE html>
<html>
<head>
    <title>Credit Card Payment</title>
    <link rel="stylesheet" type="text/css" href="css/payment.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <h1>Payment via Credit Card</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default credit-card-box">
                    <div class="panel-heading display-table">
                        <div class="row display-tr">
                            <h3 class="panel-title display-td">Payment Details</h3>
                            <div class="display-td">
                                <img class="img-responsive pull-right" src="images/credit_card_icons.png">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form role="form" id="payment-form">
                            <div class="form-group">
                                <label for="cardNumber">Card Number</label>
                                <div class="input-group">
                                    <input type="tel" class="form-control" name="cardNumber" placeholder="Valid Card Number" autocomplete="cc-number" required autofocus>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-7 col-md-7">
                                    <div class="form-group">
                                        <label for="cardExpiry"><span class="hidden-xs">Expiration</span><span class="visible-xs-inline">EXP</span> Date</label>
                                        <input type="tel" class="form-control" name="cardExpiry" placeholder="MM / YY" autocomplete="cc-exp" required>
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5 pull-right">
                                    <div class="form-group">
                                        <label for="cardCVC">CV Code</label>
                                        <input type="tel" class="form-control" name="cardCVC" placeholder="CVC" autocomplete="cc-csc" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="couponCode">Coupon Code</label>
                                <input type="text" class="form-control" name="couponCode">
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Make Payment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#payment-form').submit(function(e) {
                e.preventDefault();

                // Here you can perform the necessary actions to process the payment, such as sending the card details to a server-side script for processing.

                // Once the payment is processed, you can redirect the user to a success page or perform any other desired actions.
                // Example:
                window.location.href = "payment_success.php";
            });
        });
    </script>
</body>
</html>
