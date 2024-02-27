<!-- template.tlp -->


<html data-bs-theme="dark">
<head>
    <title>{{ Projectname }}</title>
    <link rel="icon" type="image/x-icon" href="{{ icon }}">
    
    <!-- <link rel="stylesheet" href="{{ bootstrapCssPath }}"> -->
    <!-- Дополнительные стили или скрипты, если необходимо -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ maincss }}"> 

</head>

<style>

</style>
<body>

    {{ include 'inc/navbar.tpl' }}
    

    <div class=".fs-2s text-center position-absolute top-50 start-50 translate-middle">

      <form>
        <div class="row g-3">
          <label for="exampleInputPassword1" class="form-label">Code</label>
          <input type="text" class="form-control" id="code">
        </div><br>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
        <!-- <h2>{{ pageTitle }}</h2>
        <p>{{ pageDescription }}</p> -->
        <!-- Ваши другие элементы страницы -->
    </div>
    <script src="{{ jqueryPath }}"></script>
    <script src="{{ popperPath }}"></script>
    <!-- <script src="{{ bootstrapJsPath }}"></script> -->
    <!-- Дополнительные скрипты, если необходимо -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>
<!-- template.tlp -->
