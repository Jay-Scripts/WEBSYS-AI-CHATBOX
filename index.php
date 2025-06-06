<?php
include 'connection.php';

$password = $userName = '';
$errors = array('userName' => '', 'password' => '');

    function sanitizeInput($data)
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
      return $data;
    }
if (isset($_POST['submit'])) {  


  
  if (empty($_POST['userName'])) {
    $errors['userName'] = 'A userName is Required!';
  } else {
    $userName = sanitizeInput($_POST['userName']);
    // FOR CHECKING IF userName IS NOT LETTERS, NUMBERS, AND SPACES ONLY THEN DISPLAY ERROR
    if (!preg_match('/^[a-zA-Z\s0-9]+$/', $userName)) {
      $errors['userName'] = 'Please enter a valid User name!';
    }
  }

  if (empty($_POST['password'])) {
    $errors['password'] = 'A password is Required!';
  } else {
    $password = sanitizeInput($_POST['password']);
    // FOR CHECKING IF PASSWORD IS NOT LETTERS, NUMBERS, AND SPACES ONLY THEN DISPLAY ERROR
    if (!preg_match('/^[a-zA-Z\s0-9]+$/', $password)) {
      $errors['password'] = 'Password must be letters, numbers, and spaces only!';
    }
  }

  // If no validation errors, check credentials in database
  if (empty($errors['userName']) && empty($errors['password'])) {
    $query = "SELECT * FROM users WHERE user_name = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $userName, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
      header("Location: profilePage.html");
      exit();
    }
  }


  //checking if credentials has same entry
  $checkuserNameQuery = "SELECT user_name FROM users WHERE user_name = '$userName'";
  $result = mysqli_query($conn, $checkuserNameQuery);

    if (mysqli_num_rows($result) > 0) {
    }else{
      $errors['userName'] = 'Wrong Username try again!';
    }
  
  $checkuserPasswordQuery = "SELECT password FROM users WHERE password = '$password'";
  $result = mysqli_query($conn, $checkuserPasswordQuery);

    if (mysqli_num_rows($result) > 0) {
    }else{
      $errors['password'] = 'Wrong Password try again!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pinoy Health Buddy</title>
    <link
      href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css"
      rel="stylesheet"
    />
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="style.css" />
  </head>
  <body class="min-h-screen flex flex-col">
    <nav class="bg-[#f8f8f8] backdrop-blur shadow-2xl">
      <div class="flex flex-wrap items-center justify-between p-5">
        <a
          href="#"
          class="flex items-center justify-between space-x-3 rtl:space-x-reverse"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            height="24px"
            viewBox="0 -960 960 960"
            width="24px"
            fill="#00503c"
          >
            <path
              d="m826-585-56-56 30-31-128-128-31 30-57-57 30-31q23-23 57-22.5t57 23.5l129 129q23 23 23 56.5T857-615l-31 30ZM346-104q-23 23-56.5 23T233-104L104-233q-23-23-23-56.5t23-56.5l30-30 57 57-31 30 129 129 30-31 57 57-30 30Zm397-336 57-57-303-303-57 57 303 303ZM463-160l57-58-302-302-58 57 303 303Zm-6-234 110-109-64-64-109 110 63 63Zm63 290q-23 23-57 23t-57-23L104-406q-23-23-23-57t23-57l57-57q23-23 56.5-23t56.5 23l63 63 110-110-63-62q-23-23-23-57t23-57l57-57q23-23 56.5-23t56.5 23l303 303q23 23 23 56.5T857-441l-57 57q-23 23-57 23t-57-23l-62-63-110 110 63 63q23 23 23 56.5T577-161l-57 57Z"
            />
          </svg>
          <span
            class="self-center text-2xl font-semibold whitespace-nowrap text-[#00503c]"
            >Pinoy Health Buddy</span
          >
        </a>
        <button
          data-collapse-toggle="navbar-default"
          type="button"
          class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
          aria-controls="navbar-default"
          aria-expanded="false"
        >
          <span class="sr-only">Open main menu</span>
          <svg
            class="w-5 h-5"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 17 14"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M1 1h15M1 7h15M1 13h15"
            />
          </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
          <ul
            class="font-medium flex flex-col p-4 md:p-0 mt-4 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0"
          >
            <li>
              <a
                href="mainPage.html"
                class="block py-2 px-3 text-[#00503c] bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 dark:text-[#00503c] md:dark:text-blue-500"
                aria-current="page"
                >Home</a
              >
            </li>
            <li>
              <a
                href="About.html"
                class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-[#00503c] md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-[#00503c] md:dark:hover:bg-transparent"
                >About</a
              >
            </li>
            <li>
              <a
                href="Services.html"
                class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-[#00503c] md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-[#00503c] md:dark:hover:bg-transparent"
                >Services</a
              >
            </li>
            <li>
              <a
                href="profilePage.html"
                class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-[#00503c] md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-[#00503c] md:dark:hover:bg-transparent"
                >Profile</a
              >
            </li>
            <li>
              <a
                href="Contacts.html"
                class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-[#00503c] md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
                >Contact</a
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <main class="h-[100vh]">
      <!-- --------------------------------LIVE BG START------------------------------->

      <div class="area" id="liveBG">
        <ul class="circles">
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
        </ul>
      </div>
      <!-- --------------------------------LIVE BG END------------------------------->
      <!----------------------------------LOGIN FORMS START------------------------------->

      <div class="flex justify-center items-center h-full">
        <form action="index.php" method="POST">
          <div
            class="bg-gray-900/40 border-[4px] border-gray-900 rounded-2xl hover:border-green-500 transition-all duration-200"
            id="loginForm"
          >
            <div
              class="mx-auto flex space-y-4 py-16 px-12 font-semibold text-gray-500 flex-col"
            >
              <h1 class="text-white text-2xl text-center">Login</h1>
              <label
                      for="userName"
                      class=" text-white"
                      >Username</label
                    >
              <input
                class="w-full p-2 bg-white rounded-md border border-gray-700 focus:border-blue-700 hover:border-blue-500 transition-all duration-200"
                placeholder="Username"
                type="text"
                name="userName"
                id="userName"
                maxlength="15"
                required
                value="<?php echo sanitizeInput($userName) ?>" 
              />
              
              <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($errors['userName']) ?></p>

              <label
                      for="password"
                      class=" text-white"
                      >Password</label
                    >
              <input
                class="w-full p-2 bg-white rounded-md border border-gray-700 focus:border-blue-700 hover:border-blue-500 transition-all duration-200"
                placeholder="Password"
                type="password"
                required
                name="password"
                id="password"
                maxlength="15"
                value="<?php echo sanitizeInput($password) ?>" 
              />
              <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($errors['password']) ?></p>

              <button
                class="w-full p-2 bg-green-500 rounded-full font-bold text-white border-[4px] border-gray-700 hover:border-blue-500 transition-all duration-200"
                name="submit"
                id="submit"
              >
             Submit
              </button>
              <p class="font-semibold text-white transition-all duration-200">
                Don't have an account?
                <a
                  class="font-semibold text-blue-400 hover:text-blue-500 transition-all duration-200"
                  href="signup.php"
                  >Sign up</a
                >
              </p>
            </div>
          </div>
        </form>
      </div>
      <!-- --------------------------------LOGIN FORMS END------------------------------->
    </main>

    <footer class="text-[#00503c] py-8 w-[99vw]">
      <div class="w-[99vw]">
        <div class="flex flex-wrap justify-between items-center w-[99vw]">
          <a
            href="#"
            class="flex items-center space-x-3 rtl:space-x-reverse mb-4 sm:mb-0"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              height="32px"
              viewBox="0 -960 960 960"
              width="32px"
              fill="white"
            >
              <path
                d="m826-585-56-56 30-31-128-128-31 30-57-57 30-31q23-23 57-22.5t57 23.5l129 129q23 23 23 56.5T857-615l-31 30ZM346-104q-23 23-56.5 23T233-104L104-233q-23-23-23-56.5t23-56.5l30-30 57 57-31 30 129 129 30-31 57 57-30 30Zm397-336 57-57-303-303-57 57 303 303ZM463-160l57-58-302-302-58 57 303 303Zm-6-234 110-109-64-64-109 110 63 63Zm63 290q-23 23-57 23t-57-23L104-406q-23-23-23-57t23-57l57-57q23-23 56.5-23t56.5 23l63 63 110-110-63-62q-23-23-23-57t23-57l57-57q23-23 56.5-23t56.5 23l303 303q23 23 23 56.5T857-441l-57 57q-23 23-57 23t-57-23l-62-63-110 110 63 63q23 23 23 56.5T577-161l-57 57Z"
              />
            </svg>
            <span class="self-center text-2xl font-bold whitespace-nowrap"
              >Pinoy Health Buddy</span
            >
          </a>
          <div
            class="flex flex-wrap items-center justify-center text-sm font-medium"
          >
            <a href="About.html" class="hover:underline m-3">About</a>
            <a href="#" class="hover:underline m-3">Privacy Policy</a>
            <a href="#" class="hover:underline m-3">Licensing</a>
            <a href="Contacts.html" class="hover:underline m-3">Contact</a>
          </div>
        </div>
        <hr class="my-6 border-gray-200 opacity-50" />
        <div class="text-center w-[99vw]">
          <p class="text-sm">
            © 2025
            <a href="#" class="hover:underline font-bold">Pinoy Health Buddy™</a
            >. All Rights Reserved.
          </p>
          <p class="text-sm mt-2">
            Designed with by
            <a
              href="https://github.com/Jay-Scripts"
              class="hover:underline font-bold"
              >JayScripts</a
            >
          </p>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  </body>
</html>
