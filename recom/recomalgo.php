<?php
// Load the food and ratings data
$food = file_get_contents('C:\\xampp\\htdocs\\HTB\\archive\\data.csv');
$ratings = file_get_contents('C:\\xampp\\htdocs\\HTB\\archive\\ratings.csv');

// Convert the CSV data into an array
$food = array_map('str_getcsv', explode("\n", $food));
$ratings = array_map('str_getcsv', explode("\n", $ratings));

// Remove the header row from the arrays
$foodHeader = array_shift($food);
$ratingsHeader = array_shift($ratings);

// Convert the arrays into dataframes
$food = array_map(function ($row) use ($foodHeader) {
    if (count($foodHeader) === count($row)) {
        return array_combine($foodHeader, $row);
    } else {
        return null;
    }
}, $food);

$food = array_filter($food); // Remove null values







$ratings = array_map(function ($row) use ($ratingsHeader) {
    if (count($row) === count($ratingsHeader)) {
        return array_combine($ratingsHeader, $row);
    } else {
        return false;
    }
}, $ratings);

$ratings = array_filter($ratings);

print_r($ratings);


// Prepare the dataset
$dataset = [];
foreach ($ratings as $rating) {
    $foodId = $rating['Food_ID'];
    $userId = $rating['User_ID'];
    $ratingValue = $rating['Rating'];

    if (!isset($dataset[$foodId])) {
        $dataset[$foodId] = [];
    }
    
    $dataset[$foodId][$userId] = $ratingValue;
}

// Fill missing values with 0
foreach ($dataset as &$foodRatings) {
    $foodRatings = array_replace(array_fill_keys(range(1, max(array_keys($foodRatings))), 0), $foodRatings);
}

// Food recommendation system
function food_recommendation($foodName)
{
    global $food, $dataset;

    $n = 10;
    $matchingFoods = [];
    foreach ($food as $foodItem) {
        if (stripos($foodItem['Name'], $foodName) !== false) {
            $matchingFoods[] = $foodItem;
        }
    }

    if (count($matchingFoods) > 0) {
        $foodId = $matchingFoods[0]['Food_ID'];
        $foodIndex = array_search($foodId, array_column($food, 'Food_ID'));

        $distances = [];
        foreach ($dataset as $index => $data) {
            if ($index != $foodIndex) {
                $distance = cosine_similarity($dataset[$foodIndex], $data);
                $distances[$index] = $distance;
            }
        }

        asort($distances);
        $foodIndices = array_keys($distances);

        $recommendations = [];
        for ($i = 0; $i < $n; $i++) {
            if (isset($foodIndices[$i])) {
                $foodIndex = $foodIndices[$i];
                $foodId = $dataset[$foodIndex]['Food_ID'];
                $foodName = $food[array_search($foodId, array_column($food, 'Food_ID'))]['Name'];
                $recommendations[] = $foodName;
            }
        }

        return $recommendations;
    } else {
        return "No similar foods found.";
    }
}

// Function to calculate cosine similarity
function cosine_similarity($vec1, $vec2)
{
    $dotProduct = array_sum(array_map(function ($v1, $v2) {
        return $v1 * $v2;
    }, $vec1, $vec2));

    $magnitudeV1 = sqrt(array_sum(array_map(function ($v) {
        return $v * $v;
    }, $vec1)));

    $magnitudeV2 = sqrt(array_sum(array_map(function ($v) {
        return $v * $v;
    }, $vec2)));

    if ($magnitudeV1 != 0 && $magnitudeV2 != 0) {
        return $dotProduct / ($magnitudeV1 * $magnitudeV2);
    } else {
        return 0;
    }
}


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Get the food name from the form data
$foodName = $_POST["food_name"];
// Call the food_recommendation function to get recommendations
$recommendations = food_recommendation($foodName);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Food Recommendation System</title>
</head>
<body>
    <h1>Food Recommendation System</h1>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <input type="text" name="food_name" placeholder="Enter food name">
        <input type="submit" value="Search">
    </form>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($recommendations)): ?>
    <h2>Food Name: <?php echo $foodName; ?></h2>
    <h3>Recommendations:</h3>
    <ul>
        <?php foreach ($recommendations as $recommendation): ?>
            <li><?php echo $recommendation; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
</body>
</html>