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
<style>
    .col-md-4 {
        max-height: 520px; /* Set a fixed height */
        overflow-y: auto; /* Enable vertical scrolling if the content exceeds the height */
    }
</style>
  <!-- <span class="slider"></span> -->
</label>

     <div class="bg-secondary-soft container rounded  mt-5">
            <form method="post" action="engine/modules/home/update.php" enctype="multipart/form-data">
                         
        <div class="row">

            <div class="col-md-4 border-right">
                <div class="list-group" data-bs-spy="scroll">

                {{ list }}
            </div>


            </div>
            <div class="col-md-8 w-50">
                <div class="p-3 py-5">
               </div>
                        <div class="row mt-1">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Mail:</label>
                                <input type="text" style="font: initial;" class="form-control" placeholder="Username" value="example@example.com" name="new_username" id="username" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Discord:</label>
                                <input type="text" style="font: initial;" class="form-control" placeholder="Password" value="coffeewithoutsugar" name="new_password" id="password" disabled>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-6">
                                <label for="skin" class="form-label">Skin:</label>
                                <input class="form-control col-md-6" type="password" id="new_skin" name="new_skin" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="cape" class="form-label" style="display: none;">Cape:</label>
                                <input class="form-control col-md-6" type="file" id="cape" style="display: none;" disabled>
                            </div>
                            <a hrefu="" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#userid">
<i class="bi bi-plus" style="font-size: 2rem; color: cornflowerblue;"></i> ADD ACCOUNT
        </a>
                        </div>
                        <div class="mt-3 text-right">
                            <button class="btn btn-primary profile-button col-md-4" type="submit" name="update">Change information</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
      
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Modal Heading</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
      
            <!-- Modal body -->
            <div class="modal-body">
              <form action="" method="post">
                <label for="username" class="form-label">username:</label>
                <input class="form-control col-md-4" type="text"><br>
                <button class="btn btn-primary profile-button " type="submit" name="update">create</button>
              </form>
            </div>
      
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
            </div>
      
          </div>
        </div>
      </div>
    
      
      <div class="modal fade" id="userid">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
      
    
<!-- Bootstrap JS and Popper.js scripts (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
