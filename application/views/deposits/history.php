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
    <title>iMM-Traders Club |  Deposits - History</title>
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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
   
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">

    <link href="<?=base_url()?>assets/users/vendor/vector-map/jqvmap.min.css" rel="stylesheet" media="all">
    <!-- Main CSS-->
    <link href="<?=base_url()?>assets/users/css/theme.css" rel="stylesheet" media="all">

</head>

<body>
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
                                                <a href="#">Deposits </a>
                                            </li>
                                            <li class="list-inline-item seprate">
                                                <span>/</span>
                                            </li>
                                            <li class="list-inline-item">History</li>
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
                                    <!-- DATA TABLE -->
                                     <input type="hidden" id="token" value="<?=$this->security->get_csrf_hash();?>">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Payment Mode</label>
                                            <select class="form-control" name="withdrawal_mode">
                                                <option></option>
                                                <option>Bankwire</option>
                                                <option>BTC</option>
                                                <option>CARD</option>
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <input type="date" name="date_from" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Date To</label>
                                            <input type="date" name="date_to" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label></label><br>
                                                <button class="btn btn-primary" id="btn_submit">Search</button>
                                            </div>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- DATA TABLE -->
                                    <h3 class="title-5 m-b-35" id="lvl"> My Deposit History</h3> 
                                    <div class="table-responsive ">
                                        <table class="table" id="portfolio" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Transaction No.</th>
                                                    <th>Receipt No.</th>
                                                    <th>Receipt File</th>
                                                    <th class="sum">Amount Deposited</th>
                                                    <th>Payment Mode</th>
                                                    <th>Deposit Date</th>
                                                    <th>Admin Response Date</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                            <tfoot>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><small class="text-success">Total Deposited : </small> </td>
                                                    <td>0.00</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                    <!-- END DATA TABLE -->
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

    <!-- Main JS-->
     <script src="<?=base_url()?>assets/users/js/main.js"></script>
    
    <script type="text/javascript" src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready( function () {
               
                $('#portfolio').dataTable( {
                                "bProcessing": true,
                                "bDestroy": true,
                                "sAjaxSource": "my-history",
                                "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
                                    oSettings.jqXHR = $.ajax( {
                                            "dataType": 'json',
                                            "type": "POST",
                                            "url": sSource,
                                            "data": {user_id : $('[name=user_id]').val(),'date_from':$('[name=date_from]').val(),'date_to':$('[name=date_to]').val(),'imm_token' : $('#token').val()},
                                            "success": fnCallback
                                    } );
                                },
                                "footerCallback": function(row, data, start, end, display) {
                                  var api = this.api();
                                 
                                  api.columns('.sum', {
                                    page: 'all'
                                  }).every(function() {
                                    var sum = this
                                      .data()
                                      .reduce(function(a, b) {
                                        var x = parseFloat(a) || 0;
                                        var y = parseFloat(b) || 0;
                                        return x + y;
                                      }, 0);
                                    console.log(sum); //alert(sum);
                                    $(this.footer()).html('<b class="text-success">$ '+ sum +'</b>');
                                  });
                                }

                        } );

            });
    </script>
    <script type="text/javascript">
        
        $(function() {


            $( "#btn_submit" ).click(function() {

                        $('#portfolio').dataTable( {
                                "bProcessing": true,
                                "bDestroy": true,
                                "sAjaxSource": "search-my-history",
                                "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
                                    oSettings.jqXHR = $.ajax( {
                                            "dataType": 'json',
                                            "type": "POST",
                                            "url": sSource,
                                            "data": {withdrawal_mode : $('[name=withdrawal_mode]').val(),'date_from':$('[name=date_from]').val(),'date_to':$('[name=date_to]').val(),'imm_token' : $('#token').val()},
                                            "success": fnCallback
                                    } );
                                },
                                "footerCallback": function(row, data, start, end, display) {
                                  var api = this.api();
                                 
                                  api.columns('.sum', {
                                    page: 'current'
                                  }).every(function() {
                                    var sum = this
                                      .data()
                                      .reduce(function(a, b) {
                                        var x = parseFloat(a) || 0;
                                        var y = parseFloat(b) || 0;
                                        return x + y;
                                      }, 0);
                                    console.log(sum); //alert(sum);
                                    $(this.footer()).html('<b class="text-success">$ '+ sum +'</b>');
                                  });
                                }

                        } );


                  
             });

           
        })
    </script>

</body>

</html>
<!-- end document-->
