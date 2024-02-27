<!-- template.tlp -->


<html data-bs-theme="dark">
  <head>
    <title>{{ Projectname }} &#x2022 Index</title>
    <link rel="icon" type="image/x-icon" href="{{ icon }}">
    <link href="{{ bootstrapcss }}" rel="stylesheet">
    <script src="{{bootstrapjs}}"></script>
    <link rel="stylesheet" href="{{bootstrapicons}}">
    <link rel="stylesheet" href="{{ maincss }}"> 
</head>


<style>

</style>
<body>
<!-- {{ t }} -->
    {{ include 'inc/navbar.tpl' }}
    

    <div class=".fs-2s text-center position-absolute top-50 start-50 translate-middle">

        <h2 class="">{{ Projectname }}</h2>
        <h4 class="a">{{ description }}</h4>
        <!-- <button type="button" class="btn btn-outline-success lg" data-bs-toggle="modal" data-bs-target="#myModal">
          Start play
        </button> -->

        <!-- <h2>{{ pageTitle }}</h2>
        <p>{{ pageDescription }}</p> -->
        <!-- Ваши другие элементы страницы -->
    </div>
    <script src="{{ jqueryPath }}"></script>
    <script src="{{ popperPath }}"></script>
    <!-- <script src="{{ bootstrapJsPath }}"></script> -->
    <!-- Дополнительные скрипты, если необходимо -->
    <div class="modal fade" id="myModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
    
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Modal Heading</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
    
          <!-- Modal body -->
          <div class="modal-body">
            Modal body..
          </div>
    
          <!-- Modal footer -->
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button> -->
          </div>
    
        </div>
      </div>
    </div>
    <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>

<div class="toast-container position-fixed bottom-0 end-0 p-3" data-bs-autohide="false">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <!-- <img src="..." class="rounded me-2" alt=""> -->
      <strong class="me-auto">ERROR</strong>
      <!-- <small>11 mins ago</small> -->
      <!-- <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button> -->
    </div>
    <div class="toast-body">
      This method disabled
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">New version <?php echo($tagname) ?></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Name: <?php echo($releasename) ?> <br>
        Tags: <?php echo($tagname) ?> <br>
        Type of version: <?php echo($type) ?> <br>
        Notes: <?php echo($releasebody) ?> <br>
        <!-- <div class="input-group-sm"><br>
        password owner
        <input type="password" class="form-control" placeholder="">
        </div> -->
      </div>
      

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">install</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
</body>
</html>