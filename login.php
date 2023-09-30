<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "loginregister";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup_email']) && isset($_POST['signup_password'])) {
  $email = $_POST['signup_email'];
  $password = $_POST['signup_password'];

  $password_hash = hash('sha256', $password);

  // Use prepared statement to insert user data into the database
  $query = "INSERT INTO users (email, password) VALUES (?, ?)";

  $stmt = mysqli_prepare($conn, $query);
  if ($stmt) {
      mysqli_stmt_bind_param($stmt, "ss", $email, $password_hash);
      
      if (mysqli_stmt_execute($stmt)) {
          echo "Registration successful!";
          // Redirect or do something else here after successful registration
      } else {
          echo "Error: " . mysqli_error($conn);
      }

      mysqli_stmt_close($stmt);
  } else {
      echo "Error: " . mysqli_error($conn);
  }

  mysqli_close($conn);
}


?>






<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "loginregister";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_email']) && isset($_POST['login_password'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    // Retrieve the user's hashed password from the database
    $query = "SELECT id, password FROM users WHERE email=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];

        $entered_password_hash = hash('sha256', $password);

        // Verify the entered password hash against the stored hash
        if ($entered_password_hash === $stored_password) {
            echo "Login successful!";
            header("Location:index.php");
            exit(); // Pastikan untuk menggunakan exit() untuk menghentikan eksekusi lebih lanjut
            
        } else {
            echo "<span style='color:red'>Login failed. Incorrect password.</span>";
        }
    } else {
        echo "<span style='color:red'>Login failed. Email not found.</span>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}


?>

<?php

$recaptcha_secret_key = "6LeIeGQoAAAAAItfeuE1sbkP7XxRFVCNxBDpTXVP";

if (isset($_POST['g-recaptcha-response']) && $_POST['recaptcha_completed'] === 'true') {
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $recaptcha_secret_key,
        'response' => $recaptcha_response,
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $recaptcha_data = json_decode($result);

    if ($recaptcha_data->success) {
        // reCAPTCHA verification successful, proceed with registration.
    } else {
        echo "reCAPTCHA verification failed. Please try again.";
    }
} else {
    echo "";
}

?>

<?php
// Include the Google API PHP client library
require_once 'vendor/autoload.php';

// Configuration for your Google API project
$clientID = '941770330557-k2usad6qi0f8cebc4bvhr755u4gfbutq.apps.googleusercontent.com';
$clientSecret = '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';
$redirectURI = 'http://belajar-php.xyz/login.php'; // Replace with your redirect URI

// Initialize the Google API client
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectURI);
$client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);

// Create a Google_Service_Oauth2 instance for user information
$service = new Google_Service_Oauth2($client);

// Check if a user is already authenticated
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
    
    // Get user data
    $userData = $service->userinfo->get();
    
    // Print user data
    echo "Welcome, " . $userData->givenName . " " . $userData->familyName . "!";
} else {
    // Generate the Google login URL
    $authUrl = $client->createAuthUrl();
    
    
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Sign or Login PHP</title>
  <link rel="Icon" href="logo.png" type="image/Icon">

  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://kutty.netlify.app/build.css">
  <script src="https://kutty.netlify.app/kutty.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>


</head>

<body>

  <section class="bg-gradient-to-r from-indigo-900 via-violet-700 to-purple-500" style="height: 100vh;">
    <div class="px-0 py-20 mx-auto max-w-7xl sm:px-4">
      <div class="w-full px-4 pt-5 pb-6 mx-auto mt-8 mb-6 bg-white rounded-none shadow-xl sm:rounded-lg sm:w-10/12 md:w-8/12 lg:w-6/12 xl:w-4/12 sm:px-6">
        <div class="flex justify-center space-x-4 mb-4">
          <button id="show-signup" class="py-3 btn btn-primary">Sign Up</button>
          <button id="show-login" class="py-3 btn btn-primary">Login</button>
        </div>

        <div id="signup-container" class="hidden" >
          <h1 class="mb-4 text-lg font-semibold text-left text-gray-900">Sign up for a new account</h1>
          <form action="" method="post" id="signup-form" class="mb-8 space-y-4">
            <label class="block">
              <span class="block mb-1 text-xs font-medium text-gray-700">Your Email</span>
              <input class="form-input" type="email" placeholder="Example@gmail.com" inputmode="email" name="signup_email" required />
            </label>
            <label class="block">
              <span class="block mb-1 text-xs font-medium text-gray-700">Create Password</span>
              <input class="form-input" type="password" placeholder="••••••••" required name="signup_password" />
            </label>
            <input type="hidden" name="recaptcha_completed" id="recaptcha_completed" value="false">
<div class="g-recaptcha" data-sitekey="6LeIeGQoAAAAADLVgBkQlZ2ecqcIofa0QkJ0z8Nc" data-callback="recaptchaCallback" ></div>
            
            <!-- Add any additional signup fields here -->
            <input type="submit" class="w-full py-3 mt-1 btn btn-primary" value="Sign Up" name="POST" />
          </form>
        </div>

        <div id="login-container">
  <h1 class="mb-4 text-lg font-semibold text-left text-gray-900">Log in to your account</h1>
  <form action="" method="post" id="login-form" class="mb-8 space-y-4">
    <label class="block">
      <span class="block mb-1 text-xs font-medium text-gray-700">Your Email</span>
      <input class="form-input" type="email" placeholder="Ex. james@bond.com" inputmode="email" name="login_email" required />
    </label>
    <label class="block">
      <span class="block mb-1 text-xs font-medium text-gray-700">Your Password</span>
      <input class="form-input" type="password" placeholder="••••••••" required name="login_password" />
    </label>
    <input type="hidden" name="recaptcha_completed" id="recaptcha_completed" value="false">
<div class="g-recaptcha" data-sitekey="6LeIeGQoAAAAADLVgBkQlZ2ecqcIofa0QkJ0z8Nc" data-callback="recaptchaCallback"></div>


    <?php if(isset($msg1)){?>
    <tr>
      <td colspan="2" align="center" valign="top"><?php echo $msg1;?></td>
    </tr>
    <?php } ?>
    <?php if(isset($msg2)){?>
    <tr>
      <td colspan="2" align="center" valign="top"><?php echo $msg2;?></td>
    </tr>
    <?php } ?>
    <input type="submit" class="w-full py-3 mt-1 btn btn-primary" value="Login" name="POST" id="login-button" />
  </form>
</div>
        <div class="space-y-8">
          <div class="text-center border-b border-gray-200" style="line-height: 0px">
            <span class="p-2 text-xs font-semibold tracking-wide text-gray-600 uppercase bg-white"
              style="line-height: 0px">Or</span>
          </div>
          <div class="grid grid-cols-2 gap-4">
          <!-- Google Login -->
          <?php
    // Your PHP code here

    // Echo the HTML code
    echo '<a href="' . $authUrl . '" id="google-link" class="py-3 btn btn-icon btn-google">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="mr-1">
            <path
                d="M20.283,10.356h-8.327v3.451h4.792c-0.446,2.193-2.313,3.453-4.792,3.453c-2.923,0-5.279-2.356-5.279-5.28	c0-2.923,2.356-5.279,5.279-5.279c1.259,0,2.397,0.447,3.29,1.178l2.6-2.599c-1.584-1.381-3.615-2.233-5.89-2.233	c-4.954,0-8.934,3.979-8.934,8.934c0,4.955,3.979,8.934,8.934,8.934c4.467,0,8.529-3.249,8.529-8.934	C20.485,11.453,20.404,10.884,20.283,10.356z"
            />
        </svg>
        <span class="sr-only">Continue with</span> Google
    </a>';
    ?>
    <!-- GitHub Login -->
    <a href="https://github.com" id="github-link" class="py-3 btn btn-icon btn-dark">
        <img src="https://github.com/fluidicon.png" alt="GitHub" width="24" height="24" class="mr-1">
        <span class="sr-only">Continue with</span> GitHub
    </a>


          </div>
        </div>
      </div>
    </div>
  </section>


  <script>
function recaptchaCallback(response) {

    if (response !== '') {
        document.getElementById('recaptcha_completed').value = 'true';
    }
    
}
</script>


  <script>
    // Get references to the Google and Apple links
    const googleLink = document.getElementById('google-link');
    const appleLink = document.getElementById('apple-link');

    // Get references to the show signup and show login buttons
    const showSignupButton = document.getElementById('show-signup');
    const showLoginButton = document.getElementById('show-login');

    // Get references to the signup and login containers
    const signupContainer = document.getElementById('signup-container');
    const loginContainer = document.getElementById('login-container');

    // Add click event listeners to show signup and show login buttons
    showSignupButton.addEventListener('click', function (event) {
      event.preventDefault();
      signupContainer.style.display = 'block';
      loginContainer.style.display = 'none';
    });

    showLoginButton.addEventListener('click', function (event) {
      event.preventDefault();
      signupContainer.style.display = 'none';
      loginContainer.style.display = 'block';
    });
  </script>

</body>

</html>
