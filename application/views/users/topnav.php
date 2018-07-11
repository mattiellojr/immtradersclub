
            <div class="topbar">
               
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="index.html" class="logo"><img src="<?=base_url()?>assets/images/logo.png" alt="logo-img" style="width:60%;height: 60%"></a>
                        <a href="index.html" class="logo-sm"><img src="<?=base_url()?>assets/images/logo.png" alt="logo-img"></a>
                    </div>
                </div>
              
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button type="button" class="button-menu-mobile open-left waves-effect waves-light">
                                    <i class="ion-navicon"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>
                            <form class="navbar-form pull-left" role="search">
                              
                                <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>

                            </form>
                             
                            <ul class="nav navbar-nav navbar-right pull-right">
                                <li class="dropdown hidden-xs">
                                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light notification-icon-box" data-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-bell"></i> <span class="badge badge-lg badge-danger"><p style="color:#fff;" id="cts">0</p></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg noti-list-box" id="notif">
                                       
                                        <li class="text-center notifi-title">Notification <span class="badge badge-xs badge-success"><p id="ct">0</p></span></li>
                                       
                                          
                                        </li>
                                    </ul>
                                </li>
                                <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light notification-icon-box"><i class="mdi mdi-fullscreen"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">

                                        <?php if($info['image_name']==''){ ?>
                                    <img src="<?=base_url()?>assets/images/meb-1.png" alt="" class="img-circle">

                               <?php }else {?>

                             <img src="<?=base_url()?>assets/photos/<?=$info['image_name']?>" alt="user-img" class="img-circle">
                                
                                <?php  }?>
                                        
                                    </a>
                                    <ul class="dropdown-menu">
                                       
                                        <li><a href="https://immtradersclub.com/member/examples/logout"> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->