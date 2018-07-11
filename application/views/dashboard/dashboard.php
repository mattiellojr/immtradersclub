<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>iMM-Traders Club | Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="<?=base_url()?>assets/users/css/font-face.css" rel="stylesheet" media="all">
    <link href="<?=base_url()?>assets/users/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="<?=base_url()?>assets/users/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="<?=base_url()?>assets/users/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="<?=base_url()?>assets/users/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="<?=base_url()?>assets/users/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="<?=base_url()?>assets/users/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="<?=base_url()?>assets/users/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="<?=base_url()?>assets/users/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="<?=base_url()?>assets/users/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="<?=base_url()?>assets/users/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?=base_url()?>assets/users/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link href="<?=base_url()?>assets/users/vendor/vector-map/jqvmap.min.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.css">

    <!-- Main CSS-->
    <link href="<?=base_url()?>assets/users/css/theme.css" rel="stylesheet" media="all">
    <style type="text/css">
        #fvpp-blackout {
          display: none;
          z-index: 499;
          position: fixed;
          width: 100%;
          height: 100%;
          top: 0;
          left: 0;
          background: #000;
          opacity: 0.5;
        }

        #my-welcome-message {
          display: none;
          z-index: 500;
          position: fixed;
          width: 36%;
          left: 30%;
          top: 20%;
          padding: 20px 2%;
          font-family: Calibri, Arial, sans-serif;
          background: #FFF;
        }

        #fvpp-close {
          position: absolute;
          top: 10px;
          right: 20px;
          cursor: pointer;
        }

        #fvpp-dialog h2 {
          font-size: 2em;
          margin: 0;
        }

        #fvpp-dialog p { margin: 0; }
        #closebt-container {
            position: relative;
            width:100%;
            text-align:center;
            margin-top:40px;
        }

        .closebt {
            -webkit-transition: all 0.2s;
            -moz-transition: all 0.2s;
            -ms-transition: all 0.2s;
            -o-transition: all 0.2s;
            transition: all 0.2s;
            cursor:pointer;
        }

        .closebt:hover {
            transform:rotate(90deg);
        }

        #item > p  {
            margin:0px;
            color:#E74B3D;
        }
        /************************************
             * SVG ANIMATIONS
            ************************************/
            #browser-container {
                position:relative;
                top:500px;
            }


            #btn-openModal {
                -webkit-transform-origin: center center;
                        transform-origin: center center;
                opacity:0;

            }


            #cursor{
                position:relative;
                top:-100px;
            }

            #modal {
                -webkit-transform-origin: center center;
                        transform-origin: center center;
                opacity:0;
            }

            #modal-btn-close {
                -webkit-transform-origin: center center;
                        transform-origin: center center;
                opacity:0;
            }

            #el-01,
            #el-02,
            #el-03  
            {
                -webkit-transform-origin: center center;
                        transform-origin: center center;
                opacity:0;
            }
    </style>

</head>

<body>

        <div id="teste">
            <div id="closebt-container" class="close-teste">
                <img class="closebt" src="https://joaopereirawd.github.io/animatedModal.js/img/closebt.svg"> <span class="text-primary">Close</span>
            </div>
            <div id="modal-container" class=" col-lg-12 col-lg-offset-2">
                <div class="row">
                <div class="thumb col-lg-4" style="display:none;">
                    <label>Announcement !</label>
                </div>

                <div class="thumb col-lg-4" style="display:none;">
                    <img  src="https://joaopereirawd.github.io/animatedModal.js/img/thumbnail.svg">
                </div>

                <div class="thumb col-lg-4" style="display:none;">
                    <img  src="https://joaopereirawd.github.io/animatedModal.js/img/thumbnail.svg">
                </div>
                </div>
                
           </div>
        </div>

   
    <div class="page-wrapper">   


  
        <div id="my-welcome-message">

                      <h2>Announcement !</h2>

                         <!-- <a id="demo03" class="btn" href="#teste">READ ANNOUNCEMENT</a> -->

        </div>

        <!-- MENU SIDEBAR-->
        <?php $this->view('layout/sidebar')?>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
                 <?php $this->view('layout/header')?>
            <!-- END HEADER DESKTOP-->
            <!-- BREADCRUMB-->  
                 <section class="au-breadcrumb m-t-75">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="au-breadcrumb-content">
                                    <div class="au-breadcrumb-left">
                                        <span class="au-breadcrumb-span">You are here:</span>
                                        <ul class="list-unstyled list-inline au-breadcrumb__list">
                                            <li class="list-inline-item active">
                                                <a href="#">Home</a>
                                            </li>
                                            <li class="list-inline-item seprate">
                                                <span>/</span>
                                            </li>
                                            <li class="list-inline-item">Dashboard</li>
                                        </ul>


                                    </div>
                                    
                                </div>

                              

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END BREADCRUMB-->
            <!-- STATISTIC-->

            <?php

                $total      = 0 ;
                $referral   = 0 ;
                $level      = 0 ;
                $profit     = 0 ;
                $royalty    = 0 ;


                foreach ($incomes as $key => $value) {
                        
                        $referral = $value->referral_income;
                        $level    = $value->level_income;
                        $profit   = $value->profit_share_income;
                        $royalty  = $value->royalty_income;
                }

                $total  = $referral + $level + $profit + $royalty;




             ?>
            
            <section class="statistic">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">
                                 
                            <a id="demo03" class="btn pull-right" href="#teste"><i class="fa fa-bullhorn faa-flash animated fa-3x"></i>I HAVE AN ANNOUNCEMENT ! CLICK ME</a>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-account-o"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?=$downlines?></h2>
                                                <span>Total Downlines</span>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-money"></i>
                                            </div>
                                            <div class="text">
                                                <h2>$<?=number_format($ewallet,2)?></h2>
                                                <span>E-Wallet </span>
                                            </div>
                                        </div>
                                     
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-money"></i>
                                            </div>
                                            <div class="text">
                                                <h2>$<?=number_format($rwallet,2)?></h2>
                                                <span>R-Wallet</span>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c4">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-money"></i>
                                            </div>
                                            <div class="text">
                                                <h2>$ <?=number_format($total,2)?></h2>
                                                <span>Total Income</span>
                                            </div>
                                        </div>

                                      
                                    </div>
                                </div>
                            </div>
                        </div>
    

                          <div class="row">
                             <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c4">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-money"></i>
                                            </div>
                                            <div class="text">
                                                <h2>$ <?=number_format($referral,2)?></h2>
                                                <span>Referral Income</span>
                                            </div>
                                        </div>
                                         
                                      
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-money"></i>
                                            </div>
                                            <div class="text">
                                                <h2>$ <?=number_format($level,2)?></h2>
                                                <span>Level Income</span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                         

                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-money"></i>
                                            </div>
                                            <div class="text">
                                                <h2>$ <?=number_format($profit,2)?></h2>
                                                <span>Profit Share </span>
                                            </div>
                                        </div>
                                         
                                      
                                    </div>
                                </div>
                            </div>

                             <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-money"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?=number_format($royalty,2)?></h2>
                                                <span>Royalty Income</span>
                                            </div>
                                        </div>
                                        
                                      
                                    </div>
                                </div>
                            </div>
                          
                        
                        </div>

                         <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-account-o"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?=$direct_downlines?></h2>
                                                <span>Referrals</span>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-account-o"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?=$paid_downline?></h2>
                                                <span>Paid Dowlines </span>
                                            </div>
                                        </div>
                                     
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-account-o"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?=$downlines - $paid_downline?></h2>
                                                <span >Unpaid </span>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c4">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-album"></i>
                                            </div>
                                            <div class="text">
                                                <h2> <?=$imc?></h2>
                                                <span>IMC Balance</span>
                                            </div>
                                        </div>

                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END STATISTIC-->

            <section>
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-4">
                                <!-- TASK PROGRESS-->
                                <div class="task-progress">
                                    <h3 class="title-3">rank achievement progress</h3>
                                    <div class="au-skill-container">
                                        
                                        <?php foreach($next_rank as $key => $cr){
                                                    
                                                    $next_rank_id = $cr->rank_id * 10;
                                                    $next_rank_name = $cr->rank_name;

                                            }?>


                                      <div class="au-progress">
                                            <span class="au-progress__title"><?=$rank_name?> (Current Rank)</span>
                                            <div class="au-progress__bar">
                                                <div class="au-progress__inner js-progressbar-simple" role="progressbar" data-transitiongoal="100">
                                                    <span class="au-progress__value js-value"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="au-progress">
                                            <span class="au-progress__title"><?=$next_rank_name?> (Next Rank)</span>
                                            <div class="au-progress__bar">
                                                <div class="au-progress__inner js-progressbar-simple" role="progressbar" data-transitiongoal="<?=$next_rank_id?>">
                                                    <span class="au-progress__value js-value"></span>
                                                </div>
                                            </div>
                                        </div>
                                    
                                     
                                     
                                     
                                    </div>
                                </div>
                                <!-- END TASK PROGRESS-->
                            </div>
                              <div class="col-xl-8">
                                <!-- MAP DATA-->
                                <div class="map-data m-b-40">
                                    <h3 class="title-3 m-b-30">
                                        <i class="zmdi zmdi-map"></i>Your Investment Summary</h3>
                                    <div class="table-wrap">
                                        <div class="table-responsive ">
                                            <table class="table">
                                                <tbody>
                                                    <?php $total = 0 ;  foreach($investments as $key => $value){  $total = $total + $value->amount?>

                                                  
                                                    <tr>
                                                        <td><?=$value->package_name?></td>
                                                        <td>$ <?=$value->amount?></td>
                                                    </tr>
                                                     <?php }?>
                                                     <tr>
                                                         <td colspan="2"><hr></td>
                                                     </tr>
                                                     <tr>
                                                        <td>TOTAL INVESTMENTS </td> <td>$ <?=$total?></td>
                                                      </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                     
                                    </div>
                                </div>
                                <!-- END MAP DATA-->
                            </div>
                        </div>
                    </div>
                </div>
            </section>

      
            

            <!--FOOTER-->

                 <?php $this->view('layout/footer')?>

            <!---END FOOTER-->

            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="<?=base_url()?>assets/users/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="<?=base_url()?>assets/users/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="<?=base_url()?>assets/users/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="<?=base_url()?>assets/users/vendor/slick/slick.min.js">
    </script>
    <script src="<?=base_url()?>assets/users/vendor/wow/wow.min.js"></script>
    <script src="<?=base_url()?>assets/users/vendor/animsition/animsition.min.js"></script>
    <script src="<?=base_url()?>assets/users/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="<?=base_url()?>assets/users/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="<?=base_url()?>assets/users/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="<?=base_url()?>assets/users/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="<?=base_url()?>assets/users/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?=base_url()?>assets/users/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="<?=base_url()?>assets/users/vendor/select2/select2.min.js"></script>
    <script src="<?=base_url()?>assets/users/vendor/vector-map/jquery.vmap.js"></script>
    <script src="<?=base_url()?>assets/users/vendor/vector-map/jquery.vmap.min.js"></script>
    <script src="<?=base_url()?>assets/users/vendor/vector-map/jquery.vmap.sampledata.js"></script>
    <script src="<?=base_url()?>assets/users/vendor/vector-map/jquery.vmap.world.js"></script>

    <!-- Main JS-->
    <script src="<?=base_url()?>assets/users/js/main.js"></script>
    <script  src="https://joaopereirawd.github.io/animatedModal.js/js/plugins.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/users/js/animatedModal.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/users/js/jquery.firstVisitPopup.js"></script>

    <script type="text/javascript" src="<?=base_url()?>assets/users/js/animte.js"></script>
    <script type="text/javascript">
        $('#my-welcome-message').firstVisitPopup({
          cookieName : 'homepage',
          showAgainSelector: '#show-message'
        });

    </script>

</body>

</html>
<!-- end document-->