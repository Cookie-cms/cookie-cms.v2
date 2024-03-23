<!-- template.tlp -->


<html data-bs-theme="dark">
  <head>
    <title>{{ Projectname }} &#x2022 Users</title>
    <link rel="icon" type="image/x-icon" href="{{ icon }}">
    <link href="{{ bootstrapcss }}" rel="stylesheet">
    <script src="{{bootstrapjs}}"></script>
    <link rel="stylesheet" href="{{bootstrapicons}}">
    <link rel="stylesheet" href="{{ maincss }}"> 
</head>


<style>
.down {
    position: absolute;
    top: 30%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.container-fluid {
    /* position: relative; */
    /* top: 50%;s */
    /* width: 100%; */

    padding: 0 30px;
}
.center {
    display: flex;
    justify-content: center;
}
    /* transform: translate(-50%, -50%); */
.search {
    position: absolute;
    top: 14%;
    left: 80%; /* updated from 50% to 40% */
    width: 20%;
    transform: translate(-50%, -50%);
}
.down {
    position: absolute;
    top: 30%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>
<body>
    {{ include 'inc/navbar.tpl' }}
    <div class="container-xl">
        <div class="input-group mb-3 search">
            <span class="input-group-text" id="basic-addon1">@</span>
            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
          </div>
          
        <div class="table-responsive down container-fluid">
            <div class="table-wrapper ">
                
                <table class="table table-striped table-hover ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>						
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{ list }}
                    </tbody>
                </table>
                
                <nav aria-label="Page navigation example center ">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>