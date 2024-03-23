<!DOCTYPE html>
<html data-bs-theme="dark">
<head>
    <title>{{ Projectname }} &#x2022 Home</title>
    <link rel="icon" type="image/x-icon" href="{{ icon }}">
    <link href="{{ bootstrapcss }}" rel="stylesheet">
    <script src="{{bootstrapjs}}"></script>
    <link rel="stylesheet" href="{{bootstrapicons}}">
    <link rel="stylesheet" href="{{ maincss }}">
</head>
<body>
    {{ include 'inc/navbar.tpl' }}
    
<div class="container mt-3">
<!-- <div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" id="toggleButton" checked>
    <label class="form-check-label" for="toggleButton">Toggle Dark Mode</label>
</div> -->
</div>

</div>
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
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-6">
                                <label for="skin" class="form-label">Skin:</label>
                                <input class="form-control col-md-6" type="file" id="new_skin" name="new_skin">
                            </div>
                            <div class="col-md-6">
                                <label for="cape" class="form-label" >Cape:</label>
                                <button class="btn btn-primary col-md-4" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Upload</button>
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="col-md-8 w-50">
                <div class="row mt-1">
                    <div class="col-md-6">
                        {{ cape }}

                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  
<script src="{{ skinjs }}"></script>
<!-- <script src="<?php echo __RD__ ?>js/darktheme.js"></script> -->

<script>
    
let skinViewer = new skinview3d.SkinViewer({
        canvas: document.getElementById("skin_container"),
        width: 300,
        height: 400,
        skin: "img/skin.png"
    });

    skinViewer.width = 300;
    skinViewer.height = 600;
    skinViewer.loadSkin("/uploads/skins/{{ uuid }}.png");
    skinViewer.loadCape("/api/skinview/cape/{{ uuid }}/");
    skinViewer.fov = 70;
    skinViewer.zoom = 0.5;
    skinViewer.autoRotate = false;
    skinViewer.animation = new skinview3d.IdleAnimation();
    skinViewer.animation.speed = 0.5;
    skinViewer.animation.paused = false;
    
    skinViewer.nameTag = "{{ username }}";

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

