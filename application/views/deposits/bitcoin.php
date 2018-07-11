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
    <title>iMM-Traders Club | Deposit-Bankwire</title>
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
                                                <a href="#">Fund Deposits </a>
                                            </li>
                                            <li class="list-inline-item seprate">
                                                <span>/</span>
                                            </li>
                                            <li class="list-inline-item">Bankwire</li>
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
                                    <div class="card-header">DEPOSIT ADDRESS</div>
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h3 class="text-center title-2">Deposit your fund to the address below:</h3>
                                        </div>
                                        <hr>

                                       <center>
                                                <img src="https://chart.googleapis.com/chart?chs=125x125&amp;cht=qr&amp;chl=<?=$address?>" width="50%">
                                                <p class="text-success" style="word-wrap: break-word;"><?=$address?></p>
                                                    <span ><i class="fa fa-spin fa-spinner"></i> Waiting for new payment</span>
                                                </center>
                                        
                                    </div>
                                </div>
                                </div>
                                <div class="col-lg-6">
                                      <div class="card">
                                        <div class="card-header">
                                            <strong>DEPOSIT DETAILS</strong>
                                        </div>
                                        <div class="card-body card-block">
                                                 <div class="card-title">
                                                    <small class="text-danger">Note : Send your fund first before clicking the submit button. Be sure not to reload the page while  sending your bitcoin to the address, or else, your fund will be lost and won't be refunded. Amount will automatically appear below after sending your bitcoin.</small>
                                                 </div>
                                        <hr>
                                        <?=form_open('deposits/submit-bitcoin', [] ) ?>
                                            <div class="form-group">
                                                <label for="street" class=" form-control-label">Amount  (BTC)</label>
                                                <input type="text" readonly=""  required="" name="amount" class="form-control">
                                            </div>
                                             <div class="form-group">
                                                <label for="street" class=" form-control-label">Amount  (USD)</label>
                                                <input type="text" readonly="" min="10" required="" name="usd" class="form-control">
                                            </div>
                                    
                                             <div class="form-group">
                                                    <button type="submit" id="submit" class=" form-control btn btn-info">Submit</button>
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
                 setTimeout(function(){ $('.alert').fadeOut('slow') },2500);

        });
    </script>

     <script>
 
   var specAdd = '<?=$address?>';

  var btcs = new WebSocket('wss://ws.blockchain.info/inv');

  btcs.onopen = function()
    {
    btcs.send( JSON.stringify( {"op":"addr_sub", "addr":"<?php echo $address; ?>"} ) );
    };

  btcs.onmessage = function(onmsg)
  {
    var response = JSON.parse(onmsg.data);
    var getOuts = response.x.out;
    var countOuts = getOuts.length; 
    
    if(countOuts > 0) {
         for(i = 0; i < countOuts; i++)
    {
      //check every output to see if it matches specified address
      var outAdd = response.x.out[i].addr;
     
         if (outAdd == specAdd )
         {
         var amount = response.x.out[i].value;
         var calAmount = amount / 100000000;
         console.log(outAdd);
         if(calAmount > 0) {
              $('#messages').html("Received " + calAmount + " BTC");
              $('#done').show(); 
              
            
               
         }
         else {
                $('#messages').html('<span class="fa fa-spin fa-spinner"> </span> Waiting for confirmations');
              
         }
                

        $('[name=amount]').val(calAmount);
        $('#wt').hide();


        $.getJSON('https://api.coindesk.com/v1/bpi/currentprice/BTC.json',function(data){

            console.log(data.bpi.USD.rate);

             var usd = data.bpi.USD.rate;

              usd=usd.replace(/\,/g,''); // 1125, but a string, so convert it to number
              usd=parseInt(usd,10);

             var btc_usd = usd * calAmount;

             $('[name=usd]').val(btc_usd);

        });

        $('#msg').html('<div class="alert alert-sucess">Payment has been received.! Please click "Submit" button below to fully submit your deposit. </div>')

            
            }
    } 
        
    }
    
    else {
        
        

    }
    
   
  }</script>

</body>

</html>
<!-- end document-->