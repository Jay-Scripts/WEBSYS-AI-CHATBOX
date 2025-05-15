<?php
include 'connection.php';

$email = $password = $firstName = $lastName = $phone = $address = $sendingDataStatus = $userName = '';
$errors = array('email' => '', 'password' => '', 'firstName' => '','lastName' => '','phone' => '','address' => '','userName' => '' );

    function sanitizeInput($data)
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
      return $data;
    }
if (isset($_POST['submit'])) {  

  if (empty($_POST['email'])) {
    $errors['email'] = 'An email is required!';
  } else {
    $email = sanitizeInput($_POST['email']);
    // Proper email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Please enter a valid email address!';
    }
  }

  
  if (empty($_POST['userName'])) {
    $errors['userName'] = 'A userName is Required!';
  } else {
    $userName = sanitizeInput($_POST['userName']);
    // FOR CHECKING IF userName IS NOT LETTERS, NUMBERS, AND SPACES ONLY THEN DISPLAY ERROR
    if (!preg_match('/^[a-zA-Z\s1-9]+$/', $userName)) {
      $errors['userName'] = 'Please enter a valid User name!';
    }
  }

    if (empty($_POST['password'])) {
    $errors['password'] = 'A password is Required!';
  } else {
    $password = sanitizeInput($_POST['password']);
    // FOR CHECKING IF PASSWORD IS NOT LETTERS AND SPACES ONLY THEN DISPLAY ERROR
    if (!preg_match('/^[a-zA-Z\s1-9]+$/', $password)) {
      $errors['password'] = 'Password must be letters, numbers, and spaces only!';
    }
  }

  if (empty($_POST['firstName'])) {
    $errors['firstName'] = 'A firstName is Required!';
  } else {
    $firstName = sanitizeInput($_POST['firstName']);
    // FOR CHECKING IF firstName IS NOT LETTERS, NUMBERS, AND SPACES ONLY THEN DISPLAY ERROR
    if (!preg_match('/^[a-zA-Z]+$/', $firstName)) {
      $errors['firstName'] = 'Please enter a valid First Name!';
    }
  }

  if (empty($_POST['lastName'])) {
    $errors['lastName'] = 'A lastName is Required!';
  } else {
    $lastName = sanitizeInput($_POST['lastName']);
    // FOR CHECKING IF lastName IS NOT LETTERS, NUMBERS, AND SPACES ONLY THEN DISPLAY ERROR
    if (!preg_match('/^[a-zA-Z]+$/', $lastName)) {
      $errors['lastName'] = 'Please enter a valid Last Name!';
    }
  }

    if (empty($_POST['phone'])) {
    $errors['phone'] = 'A phone is Required!';
  } else {
    $phone = sanitizeInput($_POST['phone']);
    // FOR CHECKING IF phone IS NOT LETTERS AND SPACES ONLY THEN DISPLAY ERROR
    if (!preg_match('/^[0-9]+$/', $phone)) {
      $errors['phone'] = 'Please enter a valid Number!';
    }
  }

  if (empty($_POST['address'])) {
    $errors['address'] = 'A address is Required!';
  } else {
    $address = sanitizeInput($_POST['address']);
    // FOR CHECKING IF address IS NOT LETTERS, NUMBERS, AND SPACES ONLY THEN DISPLAY ERROR
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $address)) {
      $errors['address'] = 'Address must be letters, numbers, and spaces only!';
    }
  }

  //checking if email has same entry
$checkEmailQuery = "SELECT email FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $checkEmailQuery);

if (mysqli_num_rows($result) > 0) {
  $errors['email'] = 'This email is already registered!';
}

  // If no errors, insert into DB
  if (empty(array_filter($errors))) {
    $sql = "INSERT INTO users (email, user_name, password, first_name, last_name, phone, address)
            VALUES ('$email', '$userName', '$password', '$firstName', '$lastName', '$phone', '$address')";
    
    if (mysqli_query($conn, $sql)) {
      $sendingDataStatus = "User registered successfully!";
    } else {
      $sendingDataStatus = "Database error: " . mysqli_error($conn);
    }
  } else {
    $sendingDataStatus = "Please fix the errors in the form.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
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
          class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
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
          <li></li>
        </ul>
      </div>
      <!-- --------------------------------LIVE BG END------------------------------->
      <!----------------------------------LOGIN FORMS START------------------------------->
   <button
        class="absolute top-[10%] left-[1%] group flex items-center justify-start w-11 h-11 bg-red-600 rounded-full cursor-pointer overflow-hidden transition-all duration-200 shadow-lg hover:w-32 hover:rounded-lg active:translate-x-1 active:translate-y-1"
        onclick="history.back();"
      >
        <div
          class="flex items-center justify-center w-full transition-all duration-300 group-hover:justify-start group-hover:px-3"
        >
          <svg class="w-4 h-4" viewBox="0 0 512 512" fill="white">
            <path
              d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"
            ></path>
          </svg>
        </div>
        <div
          class="absolute right-5 transform translate-x-full opacity-0 text-white text-lg font-semibold transition-all duration-300 group-hover:translate-x-0 group-hover:opacity-100"
        >
          Return
        </div>
      </button>
    
      <div
        class="flex justify-center items-center h-full portrait:h[20vh] overflow-auto"
      >
      <form action="signup.php" method="POST">
          <div
            class="bg-gray-900/40 border-[4px] border-gray-900 w-[35vw] rounded-2xl hover:border-green-500 transition-all duration-200"
            id="loginForm"
          >
            <div
              class="mx-auto flex items-center space-y-4 py-16 px-12 font-semibold text-white flex-col portrait:h[20vh] overflow-auto"
            >
              <h1 class="text-white text-2xl">Sign up</h1>

              <form class="max-w-md mx-auto">
                <div class="relative z-0 w-full mb-5 group">
                  <input
                    type="email"
                    name="email"
                    id="email"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" "
                    required
                    maxlength="50"
                    value="<?php echo sanitizeInput($email) ?>"
                  />
                   <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($errors['email']) ?></p>
                  <label
                    for="email"
                    class="peer-focus:font-medium absolute text-sm text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    >Email address</label
                  >
                   
                </div>
                
                  <div class="relative z-0 w-full mb-5 group">
                    <input
                      type="text"
                      name="userName"
                      id="userName"
                      class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                      placeholder=" "
                      required
                      maxlength="15"
                      value="<?php echo sanitizeInput($userName) ?>" 
                    />
                    <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($errors['userName']) ?>
                  </p>
                    <label
                      for="userName"
                      class="peer-focus:font-medium absolute text-sm text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                      >Username</label
                    >      <p class="text-red-500">
  </div>

                <div class="relative z-0 w-full mb-5 group">
                  <input
                    type="password"
                    name="password"
                    id="password"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" "
                    required
                    maxlength="15"
                    value="<?php echo sanitizeInput($password) ?>"
                  />
                  <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($errors['password']) ?></p>

                  <label
                    for="password"
                    class="peer-focus:font-medium absolute text-sm text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    >Password</label
                  >
                </div>

                  <div class="relative z-0 w-full mb-5 group">
                    <input
                      type="text"
                      name="firstName"
                      id="firstName"
                      class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                      placeholder=" "
                      required
                      maxlength="15"
                      value="<?php echo sanitizeInput($firstName) ?>" 
                    />
                    <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($errors['firstName']) ?>
                  </p>
                    <label
                      for="firstName"
                      class="peer-focus:font-medium absolute text-sm text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                      >First name</label
                    >      <p class="text-red-500">
  </div>
                 
                  <div class="relative z-0 w-full mb-5 group">
                    <input
                      type="text"
                      name="lastName"
                      id="lastName"
                      class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                      placeholder=" "
                      required
                      maxlength="15"
                      value="<?php echo sanitizeInput($lastName) ?>" 
                    />
                    <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($errors['lastName']) ?>
                  </p>
                    <label
                      for="lastName"
                      class="peer-focus:font-medium absolute text-sm text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                      >Last name</label
                    >
                  </div>
                
                  <div class="relative z-0 w-full mb-5 group">
                    <input
                      type="tel"
                      name="phone"
                      id="phone"
                      class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                      placeholder=" "
                      required
                      value="<?php echo sanitizeInput($phone) ?>" 
                    />
                    <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($errors['phone']) ?>
                  </p>
                    <label
                      for="phone"
                      class="peer-focus:font-medium absolute text-sm text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                      >Phone</label
                    >      <p class="text-red-500">
  </div>
                 
                  <div class="relative z-0 w-full mb-5 group">
                    <input
                      type="text"
                      name="address"
                      id="address"
                      class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                      placeholder=" "
                      required
                      maxlength="50"
                      value="<?php echo sanitizeInput($address) ?>" 
                    />
                    <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($errors['address']) ?>
                  </p>
                    <label
                      for="address"
                      class="peer-focus:font-medium absolute text-sm text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                      >Address</label
                    >
                  </div>
                

              <button
                class="w-full p-2 bg-green-500 rounded-full font-bold text-white border-[4px] border-gray-700 hover:border-blue-500 transition-all duration-200"
                name="submit"
                type="submit"
              >
                    Submit
              </button>
              <p class="font-semibold text-white transition-all duration-200">
                Do you have an account?
                <a
                  class="font-semibold text-blue-400 hover:text-blue-500 transition-all duration-200"
                  href="index.php"
                  >Log in</a
                >
              </p>
                    <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($sendingDataStatus); ?>

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
