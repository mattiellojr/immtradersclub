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
    <title>iMM-Traders Club | R-Wallet</title>
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
                                                <a href="#">My Wallet </a>
                                            </li>
                                            <li class="list-inline-item seprate">
                                                <span>/</span>
                                            </li>
                                            <li class="list-inline-item">R-Wallet</li>
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
                                <div class="col-md-12" id="msg">
                                    <?php if(count(validation_errors()) > 1) { ?>
                                            <div class="alert alert-danger"><?=validation_errors()?></div>
                                    <?php } ?>
                                    <?php if($this->session->flashdata('msg') !=""){ ?>
                                         <div class="alert alert-success"><?=$this->session->flashdata('msg')?></div>
                                    <?php }  $this->session->set_flashdata('msg', '');?>

                                    <?php if($this->session->flashdata('error') !=""){ ?>
                                         <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
                                    <?php }  $this->session->set_flashdata('error', '');?>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    
                                      <div class="card">
                                        <div class="card-header">
                                            <strong>E-WALLET CURRENT BALANCE : <?=$current_balance?> </strong>
                                        </div>
                                        <div class="card-body card-block">
                                                 <div class="card-title">
                                            <h3 class="text-center title-2">WITHDRAWAL</h3>
                                        </div>
                                        <hr>
                                         <?=form_open('mywallets/mother-wallet/ewallet/fund/withdraw',[])?>
                                         <div class="form-group">
                                                <label for="street" class=" form-control-label">Wallet UserID</label>
                                                <input type="text" value="<?=$this->uri->segment(4)?>"  name="user_id" class="form-control" required="" readonly="">
                                            </div>
                                            <div class="form-group">
                                                <label for="street" class=" form-control-label">Amount</label>
                                                <input type="number"  name="amount" class="form-control" required="">
                                            </div>
                                               
                                              <div class="form-group">
                                                <label for="postal-code" class=" form-control-label">Withdrawal Mode :</label>
                                                <select class="form-control" name="withdrawal_mode" required="">
                                                    <option value="Bankwire">Bankwire</option>
                                                    <option value="BTC">BTC</option>
                                                </select>
                                            </div>
                                             <div class="form-group">
                                                <label for="street" class=" form-control-label">Wallet Transaction Code</label>
                                                <input type="password"  name="t_code" class="form-control">
                                            </div>
                                             <div class="form-group">
                                                <button type="submit" class=" form-control btn btn-info">Withdraw</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                      <div class="card">
                                        <div class="card-header">
                                            <strong>E-WALLET CURRENT BALANCE : <?=$current_balance?></strong>
                                        </div>
                                        <div class="card-body card-block">
                                                 <div class="card-title">
                                            <h3 class="text-center title-2">E-WALLET TO R-WALLET </h3>
                                        </div>
                                        <hr>
                                        <?=form_open('mywallets/mother-wallet/ewallet/fund/transfer',[])?>
                                         <div class="form-group">
                                                <label for="street" class=" form-control-label">Wallet UserID</label>
                                                <input type="text" value="<?=$this->uri->segment(4)?>"  name="sender_id" class="form-control" required="" readonly="">
                                            </div>
                                            <div class="form-group">
                                                <label for="street" class=" form-control-label">Amount</label>
                                                <input type="number"  name="amount" class="form-control" required="">
                                            </div>
                                               
                                          
                                             <div class="form-group">
                                                <label for="street" class=" form-control-label">Wallet Transaction Code</label>
                                                <input type="password"  name="t_code" class="form-control">
                                            </div>
                                             <div class="form-group">
                                                <button type="submit" class=" form-control btn btn-info">Transfer To RWallet</button>
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
                 setTimeout(function(){ $('.alert').fadeOut('slow') },5000);

        });
    </script>

    <script type="text/javascript">
      
        $(function(){
                  $('[name=receiver]').focusout(function() {

                               $.ajax({
                                  type: "POST",
                                  url: 'rwallet/search-receiver',
                                  data:   {  
                                            
                                              'user'         :   $(this).val(),
                        
                                         },
                                  cache: false,
                                  success: function(data){
                                        var obj = JSON.parse(data);
              
                                          console.log(obj[0].email);
                                          $('#user_name').html('<p>'+obj[0].email+'( ' + obj[0].user_id+ ' )</p>')

                                         

                                          if(obj[0].name =="") {
                                                 $('#btn_reg').attr('disabled',true);
                                          }
                                        else {

                                            $('#btn_reg').attr('disabled',false);
                                        }                     
                                  }

                            });

              });

        });
   
    </script>

</body>

</html>
<!-- end document-->