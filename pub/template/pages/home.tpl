<!DOCTYPE html>
<html data-bs-theme="dark">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <!-- <link href="css/home.css"> -->
     <title><?php echo $titlepage ?> &#x2022 Home</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
     <!-- <link rel="stylesheet" href="css/home.css"> -->
     <link rel="stylesheet" href="{{ maincss }}">
</head>
<body>
    {{ include 'inc/navbar.tpl' }}
    
<!-- <div id="navbarContainer"></div> -->
<div class="container mt-3">
<!-- <div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" id="toggleButton" checked>
    <label class="form-check-label" for="toggleButton">Toggle Dark Mode</label>
</div> -->
</div>

</div>

  <!-- <span class="slider"></span> -->
</label>

     <div class="container rounded  mt-5">
                         
        <div class="row">
            <div class="col-md-4 border-right">
               <canvas id="skin_container"></canvas>
            </div>
            <div class="col-md-8 w-50">
                <div class="p-3 py-5">
               </div>
               <form method="post" action="engine/modules/home/update.php" enctype="multipart/form-data">
                        <div class="row mt-1">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control" placeholder="Username" value="" name="new_username" id="username">
                            </div>
                            <!-- <div class="col-md-6">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" placeholder="Password" value="" name="new_password" id="password">
                            </div> -->
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-6">
                                <label for="skin" class="form-label">Skin:</label>
                                <input class="form-control col-md-6" type="file" id="new_skin" name="new_skin">
                            </div>
                            <div class="col-md-6">
                                <label for="cape" class="form-label" >Cape:</label>
                                <input class="form-control col-md-6" type="file" id="cape" style="" disabled>
                            </div>
                        </div>
                        <div class="mt-3 text-right">
                            <button class="btn btn-primary profile-button col-md-4" type="submit" name="update">Save Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="{{ skinjs }}"></script>
<!-- <script src="<?php echo __RD__ ?>js/darktheme.js"></script> -->

<script>
    
let skinViewer = new skinview3d.SkinViewer({
        canvas: document.getElementById("skin_container"),
        width: 300,
        height: 400,
        skin: "img/skin.png"
    });

    // Change viewer size
    skinViewer.width = 300;
    skinViewer.height = 600;

    // Load another skins
    skinViewer.loadSkin("/uploads/skins/368697c6-4d5f-2b1a-d1b2-cb97b1fa5428.png");

    // Load a cape
    skinViewer.loadCape("/api/skins/?type=cape&uuid={{ uuid }}");

    // Change camera FOV
    skinViewer.fov = 70;

    // Zoom out
    skinViewer.zoom = 0.5;

    // Rotate the player
    skinViewer.autoRotate = false;

    // Apply an animation
    skinViewer.animation = new skinview3d.IdleAnimation();

    // Set the speed of the animation
    skinViewer.animation.speed = 0.5;

    // Pause the animation
    skinViewer.animation.paused = false;

    skinViewer.nameTag = "{{ Username }}";
    // skinViewer.nameTag = "s";


//     // Get the radio button elements by their names
//     const elytraRadioButton = document.querySelector('input[name="back_equipment"][value="elytra"]');
//     const capeRadioButton = document.querySelector('input[name="back_equipment"][value="cape"]');

    // Add event listeners to the radio buttons
//     elytraRadioButton.addEventListener("change", handleEquipmentChange);
//     capeRadioButton.addEventListener("change", handleEquipmentChange);

    // Function to handle the change event
//     function handleEquipmentChange(event) {
//     const selectedValue = event.target.value;

//     if (selectedValue === "elytra") {
//         // Code to handle elytra selection
//         console.log("Elytra selected");
//         // Call the skinViewer.loadCape() function or any other relevant actions
//         skinViewer.loadCape("https://spaceshield.org/api/cloaks/<?=$user->uuid?>", { backEquipment: "elytra" });
//     } else if (selectedValue === "cape") {
//         // Code to handle none (cape) selection
//         console.log("None (cape) selected");
//         // Remove the elytra but keep the cape
//         skinViewer.loadCape("https://spaceshield.org/api/cloaks/<?=$user->uuid?>");
//     }
//     }

</script>
  <script>
fetch('inc/header.html')
  .then(response => response.text())
  .then(data => {
    document.getElementById('navbarContainer').innerHTML = data;
  })
  .catch(error => {
    console.error('Error fetching navbar content:', error);
  });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- <div class="background-image"></div> -->
<!-- <?php 
// }else{
    //  header("Location: index.php");
    //  exit();
    // echo "nope"; 
// }
//  ?>
