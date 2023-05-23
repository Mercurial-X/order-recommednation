<!DOCTYPE html>
<html>
<head>
    <title>APSRESSO ||Recommendation</title>
</head>
<link rel="stylesheet" type = "text/css" href ="css/bootstrap.min.css">
<body>
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

        <div class="collapse navbar-collapse " id="myNavbar">
          <ul class="nav navbar-nav">
            <li class="active" ><a href="index.php">Home</a></li>
            <li><a href="C:\xampp\htdocs\HTB\recom\recomalg.py">Recommendation</a></li>
            <li><a href="aboutus.php">About</a></li>
            <li><a href="contactus.php">Contact Us</a></li>
    

          </ul>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
<br>
<br>
<br>
<br>
<br>
<br>
    <h1>ASPRESSO Food Recommendation System</h1>
    <br>
    <br>
    <form action="recommendation.php" method="GET">
        <input type="text" name="Food_Name" placeholder="What do you want recommendation for?" size="50">
        <input type="submit" value="Search">
    </form>
    <br>
    <br>

    <?php
    // Check if a food name is submitted
    if (isset($_GET['Food_Name'])) {
        // Retrieve the submitted food name
        $foodName = $_GET['Food_Name'];

        // Invoke the Python script using Python Shell and pass the food name as a command-line argument
        $command = 'python C:\\xampp\\htdocs\\HTB\\recom\\recomalg.py ' . escapeshellarg($foodName);
        $output = shell_exec($command);

        // Process the output
        $recommendations = explode(PHP_EOL, trim($output));

        // Remove any empty elements from the array
        $recommendations = array_filter($recommendations);

        // Display the recommendations
        if (!empty($recommendations)) {
            echo '<h2>Recommendations:</h2>';
            echo '<ol>'; // Use <ol> for ordered list
            foreach ($recommendations as $recommendation) {
                echo '<li>' . htmlspecialchars($recommendation) . '</li>'; // Use htmlspecialchars to handle special characters
            }
            echo '</ol>';
        } else {
            echo '<p>We are sorry to inform you that we do not have any recommendation for you at the moment.</p>';
        }
    }
    ?>
</body>
</html>
