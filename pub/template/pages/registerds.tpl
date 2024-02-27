<!DOCTYPE html>
<html data-bs-theme="dark">
<head>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
     <title><{{ Projectname }} &#x2022 Index</title>

</head>
<body>
<!-- <div id="navbarContainer"></div> -->
<link rel="stylesheet" href="{{ maincss }}">
<!-- <link rel="stylesheet" href="css/main.css"> -->
<link rel="stylesheet" href="{{ registerdscss }}">


<div class="container ">
<!-- <div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" id="toggleButton" checked>
    <label class="form-check-label" for="toggleButton">Toggle Dark Mode</label>
</div> -->
</div>  
<!-- <div class="col-md-4 border-right"> -->
            <!-- </div>  -->
<cat class="rounded position-absolute top-50 start-50 translate-middle">
    
    <div class="col-md-5">
    <img class="position-absolute rounded-circle start-50 translate-middle" src="{{ avatarUrl }}" height="94" />
        <h3>Register</h3>
            <form id="myForm" method="post">
                <div class="form-group">
                    <label for="registerPassword">Password:</label>
                    <input type="password" class="form-control mt-3" style="width: 450px" id="registerPassword" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="registerrePassword">Re-enter Password:</label>
                    <input type="password" class="form-control mt-3" style="width: 450px;" id="registerrePassword" name="re_password" placeholder="Password">
                </div>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox"  value="" id="flexCheckDefault" required>
                    <label class="form-check-label" for="flexCheckDefault">
                        Accept terms
                    </label>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Register</button>
            </form>
        </div>
        <div class="container">
        <div class="position-absolute top-0 end-0">
            <div style="background-color: white;" width="280px" height="420"></div>
        </div>
        </div>
    

</cat>

<button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>

<div class=" btn-primary position-fixed bottom-0 end-0 p-3" data-bs-autohide="false">
  <div id="liveToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body" >
        <div class="d-flex">
            <div class="toast-body"id="toastBody">
              Hello, world! This is a toast message.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        
    </div>
  </div>
</div>


<script>
    const toastTrigger = document.getElementById('liveToastBtn')
  const toastLiveExample = document.getElementById('liveToast')
  
  if (toastTrigger) {
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
    toastTrigger.addEventListener('click', () => {
      toastBootstrap.show()
    })
  }
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('#myForm').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission
    
            // Get the form data
            var formData = $(this).serialize();
    
            // Make an Ajax request
            $.ajax({
                type: 'POST',
                url: '{{ registerform }}',
                data: formData,
                success: function(response) {
                    // Handle the successful response here (update UI, show messages, etc.)
                    // // console.log(response);
                     window.location.replace("/settings");
                },
                // Handle AJAX errors
                success: function(response) {
                // Check if the response contains the error message
                if (response.includes("Passwords do not match.")) {
                    const toastTrigger = document.getElementById('liveToastBtn');
                    const toastLiveExample = document.getElementById('liveToast');
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
                    var toastBodyElement = document.getElementById('toastBody');

// Update the text content
                    toastBodyElement.textContent = 'Passwords do not match.';
                    // Show the toast
                    toastBootstrap.show();
                } else {
                    // Handle other cases or success
                    console.log(response);
                }
                if (response.includes("You already registered.")) {
                    const toastTrigger = document.getElementById('liveToastBtn');
                    const toastLiveExample = document.getElementById('liveToast');
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
                    var toastBodyElement = document.getElementById('toastBody');

// Update the text content
                    toastBodyElement.textContent = 'You already registered.';
                    // Show the toast
                    toastBootstrap.show();
                } else {
                    // Handle other cases or success
                    // console.log(response);
                }
                if (response.includes("This mail/discord is already in use. Please choose another.")) {
                    const toastTrigger = document.getElementById('liveToastBtn');
                    const toastLiveExample = document.getElementById('liveToast');
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
                    var toastBodyElement = document.getElementById('toastBody');

// Update the text content
                    toastBodyElement.textContent = 'This mail/discord is already in use. Please choose another.';
                    // Show the toast
                    toastBootstrap.show();
                } else {
                    // Handle other cases or success
                    // console.log(response);
                }
                if (response.includes("Connection failed:")) {
                    const toastTrigger = document.getElementById('liveToastBtn');
                    const toastLiveExample = document.getElementById('liveToast');
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
                    var toastBodyElement = document.getElementById('toastBody');

// Update the text content
                    toastBodyElement.textContent = response;
                    // Show the toast
                    toastBootstrap.show();
                } else {
                    // Handle other cases or success
                    // console.log(response);
                }
                },
                error: function(error) {
                // Handle AJAX errors
                console.error('Error in AJAX request:', error);

                // Assuming `error` is an object with a `message` property
                if (error && error.message === "Passwords do not match.") {
                    // Show the toast only for the specific error message
                    const toastTrigger = document.getElementById('liveToastBtn');
                    const toastLiveExample = document.getElementById('liveToast');
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);

                    // Show the toast
                    toastBootstrap.show();
                }
                if (error && error.message === "This mail/discord is already in use. Please choose another.") {
                    // Show the toast only for the specific error message
                    const toastTrigger = document.getElementById('liveToastBtn');
                    const toastLiveExample = document.getElementById('liveToast');
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);

                    // Show the toast
                    toastBootstrap.show();
                }
                
                if (error && error.message === "You already registered.") {
                    // Show the toast only for the specific error message
                    const toastTrigger = document.getElementById('liveToastBtn');
                    const toastLiveExample = document.getElementById('liveToast');
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);

                    // Show the toast
                    toastBootstrap.show();
                }
                if (xhr.responseText.includes("Connection failed")) {
                    // Show the toast only for the specific error message
                    const toastTrigger = document.getElementById('liveToastBtn');
                    const toastLiveExample = document.getElementById('liveToast');
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);

                    // Show the toast
                    toastBootstrap.show();
                }
                // console.log(error);
                }

            });
        });
    });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- <div class="background-image"></div> -->
</script>
  <!-- <script src="script.js"></script> -->
<script src="js/darktheme.js"></script>

</html>