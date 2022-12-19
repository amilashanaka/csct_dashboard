<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index.php" class="nav-link">Home</a>
        </li>
        <!--        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>-->
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control-navbar" style="   max-height: 25px;margin-top: 8px;" type="search"
                placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    Message Start
                    <div class="media">
                        <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    Message End
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    Message Start
                    <div class="media">
                        <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    Message End
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    Message Start
                    <div class="media">
                        <img src="./img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    Message End
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->

        <li class="nav-item dropdown " style="color: rgba(0,0,0,.9);
    width: 61px;
    height: 33px;
    font-size: 30px;
    margin-top: -18px">
            <a class="nav-link" href="#">

                <span class="badge   navbar-badge"> 100 <i class="fas fa-wallet"></i></span>
            </a>

        </li>


        <li class="nav-item dropdown " style="color: rgba(0,0,0,.9);
    width: 50px;
    height: 23px;
    font-size: 25px;
    margin-top: -18px">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-language"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0">
                <a href="<?= $current_file ?>?lang=en" class="dropdown-item active">
                    <i class="flag-icon flag-icon-us mr-2"></i> English
                </a>
                <a href="<?= $current_file ?>?lang=cn" class="dropdown-item">
                    <i class="flag-icon flag-icon-cn mr-2"></i> Chinese
                </a>
                <a href="<?= $current_file ?>?lang=th" class="dropdown-item">
                    <i class="flag-icon flag-icon-th mr-2"></i> Thi
                </a>

            </div>
        </li>





        <img src="img/login.jpg" onclick="mylogin()" class="user-image img-circle elevation-2" alt="User Image">


        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <?php 
                      
                
                        
                        echo'<img src="./img/avt.png" class="user-image img-circle elevation-2" alt="User Image">';
                  
                    ?>


            <span class="d-none d-md-inline">Login name</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- User image -->
            <li class="user-header " style="background: transparent">
                <?php 
                      
                  
                        
                        echo'<img src="./img/avt.png" class="user-image img-circle elevation-2" alt="User Image">';
                 
                
                    
                    ?>

                <p>

                <h4>user name</h4>

                <small>email</small>
                <br>
                <small>Member Since : 2000</small>
                </p>
            </li>
            <!-- Menu Body -->

            <!-- Menu Footer-->
            <li class="user-footer">

                <div class="row">
                    <div class="col-md-6">
                        <a href="#"><button class="btn btn-info">My Profile</button></a>
                    </div>

                    <div class="col-md-6">

                        <a><button onclick="logout()" class="btn btn-danger">Sign out</button></a>

                    </div>

                </div>


            </li>
        </ul>
        </li>

    </ul>
</nav>
</nav>
<!-- /.navbar -->