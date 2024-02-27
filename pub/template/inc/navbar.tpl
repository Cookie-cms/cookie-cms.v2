        <nav class="navbar navbar-expand-lg">
        
            <div class="container px-5">
                <a class="navbar-brand" href="/">&nbsp;{{ Projectname }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                
            </li>
            {{ if loggedds }}
                {{ if avatarUrlds }}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://cdn.discordapp.com/avatars/741957448532754493/3905f10efdf7de4b3c76fed401c56270.webp?size=80" width="32" height="32" class="rounded-circle">
                        <!-- User -->
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                        <li><hr class="dropdown-divider"></li>
                    </ul>
                </li>
                {{ else }}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <img src="https://cdn.discordapp.com/avatars/741957448532754493/3905f10efdf7de4b3c76fed401c56270.webp?size=80" width="32" height="32" class="rounded-circle">
                        <!-- User -->

                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Actiona</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                        <li><hr class="dropdown-divider"></li>
                        
                    </ul>
                </li>
                {{ endif }}
                
            {{ else }}
            {{ endif }}




                    

        

                </div>
                    </ul>
                </div>
            </div>
        </nav> 
<!-- < -->
<!--  -->