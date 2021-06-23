<?php

// Connect to the database
require_once("../server/database.php");

// Select all destinations in the database
$sql = "SELECT * FROM destinations";
$result = mysqli_query($conn, $sql);

// Initialize array to store each destination in a proper format
$destinations = array();

// For each row (for each single destination)
while ($row = mysqli_fetch_assoc($result)) {
    // Add the destination to the array $destinations
    array_push($destinations, $row);
}

// For each element in the array $destinations
foreach ($destinations as $key=>$value) {
    // Convert the string "quiz_recommend" to an array so it can be processed by the JavaScript code
    $destinations[$key]['quiz_recommend'] = explode(",", $value['quiz_recommend']);
}

// Convert the $destinations array to a JSON object so it can be passed to JavaScript
$destinations = json_encode($destinations);

// Close DataBase connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
        <link rel="stylesheet" href="../css/quiz.css?dummy=13s2" />
        <!-- FontAwesome -->
        <script
            defer
            src="https://use.fontawesome.com/releases/v5.15.3/js/all.js"
            integrity="sha384-haqrlim99xjfMxRP6EWtafs0sB1WKcMdynwZleuUSwJR0mDeRYbhtY+KPMr+JL6f"
            crossorigin="anonymous"
        ></script>
        <!-- JQuery for http requests -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </head>
    <body>
        <main class="quiz-wrapper">
            <div class="quiz-background-image"></div>

            <div class="progress-bar-container">
                <div
                    id="progressBar"
                    class="progress-bar"
                    style="width: 0%"
                ></div>
            </div>

            <header class="quiz-header container">
                <a class="logo" href="./home.html"> HotSpot </a>
            </header>

            <!-- Intro -->

            <section class="quiz-step container current-step">
                <h2>Live A Dream Experience</h2>
                <h4>
                    Tell us your preferences to match you with recommended
                    destinations.
                </h4>
                <div class="quiz-buttons-container">
                    <button
                        type="button"
                        class="quiz-button"
                        onclick="nextStep(this)"
                    >
                        <div class="quiz-icons">
                            <i class="fas fa-play"></i>
                        </div>
                        <p>Start</p>
                    </button>
                </div>
            </section>

            <!-- First Question -->

            <section class="quiz-step container">
                <h2>What kind of vacationer are you?</h2>
                <div class="quiz-buttons-container">
                    <input type="checkbox" name="1a" id="1a" hidden />
                    <label for="1a" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-couch"></i>
                        </div>
                        <p>I like to relax and take it easy</p>
                    </label>
                    <input type="checkbox" name="1b" id="1b" hidden />
                    <label for="1b" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-glass-cheers"></i>
                        </div>
                        <p>I want to go out and do things</p>
                    </label>
                    <input type="checkbox" name="1c" id="1c" hidden />
                    <label for="1c" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-archway"></i>
                        </div>
                        <p>I like excursions and sightseeing</p>
                    </label>
                </div>
            </section>

            <!-- Second Question -->

            <section class="quiz-step container">
                <h2>What kind of vacation budget works best for you?</h2>
                <div class="quiz-buttons-container">
                    <input type="checkbox" name="2a" id="2a" hidden />
                    <label for="2a" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <p>$800 or less</p>
                    </label>
                    <input type="checkbox" name="2b" id="2b" hidden />
                    <label for="2b" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-dollar-sign"></i>
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <p>$800 - $1,200</p>
                    </label>
                    <input type="checkbox" name="2c" id="2c" hidden />
                    <label for="2c" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-dollar-sign"></i>
                            <i class="fas fa-dollar-sign"></i>
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <p>$1,200 or more</p>
                    </label>
                </div>
            </section>

            <!-- Third Question -->

            <section class="quiz-step container">
                <h2>Where do you prefer to stay?</h2>
                <div class="quiz-buttons-container">
                    <input type="checkbox" name="3a" id="3a" hidden />
                    <label for="3a" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-city"></i>
                        </div>
                        <p>In the city</p>
                    </label>
                    <input type="checkbox" name="3b" id="3b" hidden />
                    <label for="3b" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-umbrella-beach"></i>
                        </div>
                        <p>Close to the beach</p>
                    </label>
                    <input type="checkbox" name="3c" id="3c" hidden />
                    <label for="3c" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-tree"></i>
                        </div>
                        <p>Somewhere out of the main city</p>
                    </label>
                </div>
            </section>

            <!-- Fourth Question -->

            <section class="quiz-step container">
                <h2>What is your ideal vacation?</h2>
                <div class="quiz-buttons-container">
                    <input type="checkbox" name="4a" id="4a" hidden />
                    <label for="4a" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-cocktail"></i>
                        </div>
                        <p>Relaxing and outdoor activities</p>
                    </label>
                    <input type="checkbox" name="4b" id="4b" hidden />
                    <label for="4b" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <p>Sightseeing famous landmarks</p>
                    </label>
                    <input type="checkbox" name="4c" id="4c" hidden />
                    <label for="4c" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-cloud-moon"></i>
                        </div>
                        <p>Nightlife and Fun activities</p>
                    </label>
                    <input type="checkbox" name="4d" id="4d" hidden />
                    <label for="4d" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <p>Hiking, Exploring and Discovery</p>
                    </label>
                </div>
            </section>

            <!-- Fifth Question -->

            <section class="quiz-step container">
                <h2>What is your preferred way of getting around?</h2>
                <div class="quiz-buttons-container">
                    <input type="checkbox" name="5a" id="5a" hidden />
                    <label for="5a" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-bus-alt"></i>
                        </div>
                        <p>Public transportation</p>
                    </label>
                    <input type="checkbox" name="5b" id="5b" hidden />
                    <label for="5b" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-car"></i>
                        </div>
                        <p>By car</p>
                    </label>
                    <input type="checkbox" name="5c" id="5c" hidden />
                    <label for="5c" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-walking"></i>
                        </div>
                        <p>Walking</p>
                    </label>
                </div>
            </section>

            <!-- Sixth Question -->

            <section class="quiz-step container">
                <h2>What kind of weather do you prefer?</h2>
                <div class="quiz-buttons-container">
                    <input type="checkbox" name="6a" id="6a" hidden />
                    <label for="6a" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-sun"></i>
                        </div>
                        <p>Hot and sunny</p>
                    </label>
                    <input type="checkbox" name="6b" id="6b" hidden />
                    <label for="6b" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-cloud-sun"></i>
                        </div>
                        <p>Warm and sunny</p>
                    </label>
                    <input type="checkbox" name="6c" id="6c" hidden />
                    <label for="6c" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-cloud-rain"></i>
                        </div>
                        <p>Cloudy and rainy</p>
                    </label>
                    <input type="checkbox" name="6d" id="6d" hidden />
                    <label for="6d" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-snowflake"></i>
                        </div>
                        <p>Cold with snow</p>
                    </label>
                </div>
            </section>

            <!-- Seventh Question -->

            <section class="quiz-step container">
                <h2>What is your preferred sleeping accommodation?</h2>
                <div class="quiz-buttons-container">
                    <input type="checkbox" name="7a" id="7a" hidden />
                    <label for="7a" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-hotel"></i>
                        </div>
                        <p>Hotel/Resort</p>
                    </label>
                    <input type="checkbox" name="7b" id="7b" hidden />
                    <label for="7b" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fab fa-airbnb"></i>
                        </div>
                        <p>Airbnb/Rental Home</p>
                    </label>
                    <input type="checkbox" name="7c" id="7c" hidden />
                    <label for="7c" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-bed"></i>
                        </div>
                        <p>Hostel</p>
                    </label>
                    <input type="checkbox" name="7d" id="7d" hidden />
                    <label for="7d" class="quiz-button">
                        <div class="quiz-icons">
                            <i class="fas fa-campground"></i>
                        </div>
                        <p>Outdoors/Cabin</p>
                    </label>
                </div>
            </section>

            <!-- Recommendations (END) -->

            <section class="quiz-step quiz-step-last container">
                <h2>Top 3 recommended destinations for you:</h2>
                <div class="quiz-destinations">
                    <div class="destination-card">
                        <img src="https://www.viajarlosangeles.com/img/guia-viajar-los-angeles.jpg" />
                        <p>Los Angeles, California</p>
                    </div>
                    <div class="destination-card">
                        <img src="https://img.ev.mu/images/villes/7195/600x400/7195.jpg" />
                        <p>San Juan, Puerto Rico</p>
                    </div>
                    <div class="destination-card">
                        <img src="https://www.wallpapertip.com/wmimgs/43-432816_nashville-tn-nashville-tennessee.jpg" />
                        <p>Nashville, Tennessee</p>
                    </div>
                </div>
                <a href="./myPage.php">Go To Profile</a>
            </section>

            <!-- Bottom Navigator -->

            <div id="quizNavigator" class="quiz-navigator">
                <a href="#" class="show" onclick="previousStep()">Go Back</a>
                <a href="#" class="show" onclick="nextStep(this)">Next</a>
            </div>

        </main>

        <script>
            // Pass the $destinations array from PHP to JavaScript
            const destinations = <?php echo $destinations; ?>;
            
            // Get all steps <section> (prototype.slice converts the HTML NodeList to an Array)
            const steps = Array.prototype.slice.call(
                document.querySelectorAll('.quiz-step')
            );
            // Get the Bottom Navigator
            const navigator = document.getElementById('quizNavigator');

            function validateStep(step) {
                // Get all answers of current step
                let buttons = step.querySelectorAll('label');

                // If there are no options checked and it is not the Intro step
                if (
                    !step.querySelector('input[type="checkbox"]:checked') &&
                    step !== steps[0]
                ) {
                    // For each option, play "shake" animation
                    for (let i = 0; i < buttons.length; i++) {
                        buttons[i].classList.add('step-error');
                        setTimeout(function () {
                            buttons[i].classList.remove('step-error');
                        }, 1000);
                    }
                    return false;
                // If there is at least one option checked or it is the Intro step
                } else {
                    return true;
                }
            }

            function handleProgressBar(status) {
                let progressBar = document.getElementById('progressBar');
                let currentWidth = parseFloat(
                    progressBar.style.width.split('%')[0]
                );

                if (status === 'increase') {
                    progressBar.style.width = currentWidth + 12.5 + '%';
                } else if (status === 'decrease') {
                    progressBar.style.width = currentWidth - 12.5 + '%';
                }
            }

            function nextStep(el) {
                let currentStep = document.querySelector('.current-step');

                // If current step answer is valid, go to next step
                if (validateStep(currentStep)) {
                    currentStep.classList.remove('current-step');

                    if (currentStep === steps[0]) {
                        navigator.classList.add('show');
                    }

                    // If it is the last question, display the results
                    if (currentStep === steps[steps.length - 2]) {
                        navigator.classList.remove('show');
                        recommendDestinations();
                    }

                    currentStep.nextElementSibling.classList.add(
                        'current-step'
                    );

                    handleProgressBar('increase');
                }
            }

            function previousStep() {
                let currentStep = document.querySelector('.current-step');
                currentStep.classList.remove('current-step');

                if (currentStep.previousElementSibling === steps[0]) {
                    navigator.classList.remove('show');
                }

                currentStep.previousElementSibling.classList.add(
                    'current-step'
                );

                handleProgressBar('decrease');
            }

            function recommendDestinations() {
                // Get all the selected answers
                let selectedInputs = document.querySelectorAll('input[type="checkbox"]:checked');
                // Initialize an array to store the ids of the answers
                let choices = [];

                // For each answer, store the id
                for (let i = 0; i < selectedInputs.length; i++) {
                    choices.push(selectedInputs[i].id);
                }

                // For each possible destination
                for (let i = 0; i < destinations.length; i++) {
                    // Initialize number of matches with the current answers
                    destinations[i].match = 0;

                    // For each possible option to recommend current destination
                    for (let j = 0; j < destinations[i].quiz_recommend.length; j++) {
                        // If the option is in the array of answers submitted by the user
                        if (choices.includes(destinations[i].quiz_recommend[j])) {
                            // Increase the number of match
                            destinations[i].match += 1;
                        }
                    }
                }

                // Sort the array based on the number of matches of each destination and get only top three
                const recommendedDestinations = destinations.sort(function(a,b) { return parseInt(b.match) - parseInt(a.match) }).slice(0, 3);
                // Get the recommended destination containers to display them
                const destinationsElements = document.querySelectorAll(".quiz-destinations .destination-card");

                // Save the destinations to the database
                saveDestinations(recommendedDestinations);

                // For each recommended destination
                for (let i = 0; i < recommendedDestinations.length; i++) {
                    // Display the image and the location
                    destinationsElements[i].querySelector("img").src = recommendedDestinations[i].img_url;
                    destinationsElements[i].querySelector("p").textContent = recommendedDestinations[i].name;
                }
            }

            function saveDestinations(destinations) {
                // Make an object of ids of the recommended destinations to store them in the database
                let ids = {
                    firstDestination: destinations[0].id,
                    secondDestination: destinations[1].id,
                    thirdDestination: destinations[2].id
                };

                // Send the request to the server side code
                sendRequest(ids, '../server/update_destinations.php');
            }

            function sendRequest(obj,url) {
                // AJAX request ot server side code
                $.ajax({
                    url: url,
                    type: "POST",
                    data: obj,
                    success: function (response) {
                        if (response.includes("Error")) {
                            alert(response);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        if (xhr.status == 200) {
                            alert(ajaxOptions);
                        } else {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    },
                });
            }
        </script>
    </body>
</html>
