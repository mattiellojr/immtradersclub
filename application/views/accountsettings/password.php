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
    <title>iMM-Traders Club | Password</title>

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

    <!-- Main CSS-->
    <link href="<?=base_url()?>assets/users/css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
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
                                                <a href="#">Account</a>
                                            </li>
                                            <li class="list-inline-item seprate">
                                                <span>/</span>
                                            </li>
                                            <li class="list-inline-item">Password Setup</li>
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END BREADCRUMB-->
                <div class="main-content">
                     <div class="section__content section__content--p30">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-md-12">
                                        
                                    <?php if($this->session->flashdata('error') !=""){ ?>
                                         <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
                                    <?php }  $this->session->set_flashdata('error', '');?>
                                    <?php if($this->session->flashdata('msg') !=""){ ?>
                                         <div class="alert alert-success"><?=$this->session->flashdata('msg')?></div>
                                    <?php }  $this->session->set_flashdata('msg', '');?>
                                </div>
                                   
                            </div>
                            <div class="row">


                                
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong>ACCOUNT PASSWORD</strong>
                                           
                                        </div>
                                         <?=form_open('account/update-password',[])?>
                                        <div class="card-body card-block">
                                            <div class="form-group">
                                                <label for="vat" class=" form-control-label">New Password</label>
                                                <input type="password"  name="password" class="form-control">
                                            </div>
                                             <div class="form-group">
                                                <label for="vat" class=" form-control-label">Confirm New Password</label>
                                                <input type="password"  name="password_confirm" class="form-control">
                                            </div>
                                           
                                    
                                             <div class="form-group">
                                                    <button type="submit" class=" form-control btn btn-info">Update</button>
                                                    <hr>
                                                   
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong>TRANSACTION PASSWORD</strong>
                                           
                                        </div>
                                         <?=form_open('account/update-transpassword',[])?>
                                        <div class="card-body card-block">
                                        
                                            <div class="form-group">
                                                        <label for="city" class=" form-control-label">New Transaction Password</label>
                                                        <input type="password"  name="transaction_code" class="form-control" >
                                            </div>    
                                             <div class="form-group">
                                                <label for="postal-code" class=" form-control-label">Confirm New Transaction Password</label>
                                                <input type="password" name="confirm_transaction_code" class="form-control">
                                            </div>
                                    
                                             <div class="form-group">
                                                    <button type="submit" class=" form-control btn btn-info">Update</button>
                                                     <hr>
                                                   
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>

                               
                            </div>

                        </div>
                    </div>


                </div>

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
    <script type="text/javascript">
        $(document).ready(function(){
                 setTimeout(function(){ $('.alert').fadeOut('slow') },4000);

        });
    </script>

</body>

</html>
<!-- end document-->