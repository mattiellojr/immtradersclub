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
    <title>iMM-Traders Club | My Wallets - Mother Wallet</title>
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
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

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
                                                <a href="#">My Wallets</a>
                                            </li>
                                            <li class="list-inline-item seprate">
                                                <span>/</span>
                                            </li>
                                            <li class="list-inline-item">Mother Wallet</li>
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
                                <div class="col-md-12">
                                    <!-- DATA TABLE -->
                                    <h3 class="title-5 m-b-35" id="lvl"> My Other Accounts Wallet</h3> <button class="btn btn-info" data-toggle="modal" data-target="#exampleModal"> Add Account</button>
                                    <hr>
                                     <input type="hidden" id="token" value="<?=$this->security->get_csrf_hash();?>">
                                    <div class="table-responsive ">
                                        <table class="table" id="portfolio" style="font-size: 14px;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Account</th>
                                                    <th>R-Wallet Balance</th>
                                                    <th>E-Wallet Balance</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                          
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
              <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Account</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <?=form_open('mywallets/mother-wallet/setup',[])?>

                <div class="form-group">
                    <label>Your Sub-account Userid</label>
                    <input type="text" name="userid" class="form-control" >
                </div>
                 <div class="form-group">
                    <label>Your Sub-account Email</label>
                    <input type="email" name="username" class="form-control">
                </div>
                <div class="form-group">
                    <label>Your Sub-account Transaction Password</label>
                    <input type="password" name="t_code" class="form-control">
                </div>

                 <div class="form-group">
                    <label>Transaction Password of this Account that you're using</label>
                    <input type="password" name="c_t_code" class="form-control">
                </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
          </div>
        </div>
      </div>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <script type="text/javascript">
        $(document).ready( function () {
                $('#portfolio').dataTable();

                $('#datetimepicker1').datepicker();

            });
    </script>
    <script type="text/javascript">
        
        $(function() {


    
                        var table = $('#portfolio').dataTable( {
                                "bProcessing": true,
                                "bDestroy": true,
                                "sAjaxSource": "mother-wallet/details",
                                "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
                                    oSettings.jqXHR = $.ajax( {
                                            "dataType": 'json',
                                            "type": "POST",
                                            "url": sSource,
                                            "data": {trans_type : $('[name=trans_type]').val(),'date_from':$('[name=date_from]').val(),'date_to':$('[name=date_to]').val(),'imm_token' : $('#token').val()},
                                            "success": fnCallback
                                    } );
                                }
                                

                        } );


          
           
        })
    </script>
    <script type="text/javascript">
            
            $('#portfolio').on('click','#rwallet',function() {

                    var id = $(this).attr('data-id');
                    $('[name=usr]').val(id);

                $.confirm({
                    title: 'FUND TRANSFER',
                    content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Receiver Userid</label>' +
                    '<input type="text" placeholder="Enter ID" class="name form-control" required />' +
                    '</div>' +
                     '<div class="form-group">' +
                    '<label>Amount </label>' +
                    '<input type="number" placeholder="Enter Amount" class="amount form-control" required />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Wallet Transaction Password </label>' +
                    '<input type="password" placeholder="Transaction Password" class="t_code form-control" required />' +
                    '</div>' +
                    '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function () {
                                var name = this.$content.find('.name').val();
                                var amount = this.$content.find('.amount').val();
                                var code = this.$content.find('.t_code').val();
                                console.log(id);
                                if(!name){
                                    //$.alert('provide a receiver');
                                    $.alert({
                                        title: 'Alert!',
                                        icon: 'fa fa-warning',
                                        type: 'red',
                                        content: 'Enter Receiver USERID' 
                                    });
                                    return false;
                                }
                                 if(!amount){
                                    
                                     $.alert({
                                        title: 'Alert!',
                                        icon: 'fa fa-warning',
                                        type: 'red',
                                        content: 'Enter an amount to Transfer' 
                                    });
                                    return false;
                                }
                                 if(!code){
                                     $.alert({
                                        title: 'Alert!',
                                        icon: 'fa fa-warning',
                                        type: 'red',
                                        content: 'Please enter wallet transaction code' 
                                    });
                                    return false;
                                }
                                $.alert('Your name is ' + name);
                            }
                        },
                        cancel: function () {
                            //close
                        },
                    },
                    onContentReady: function () {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            });
        $('#portfolio').on('click','#ewallet',function() {
                $.confirm({
                    title: 'E to R FUND TRANSFER',
                    content: '' +
                    '<form action="" class="formName">' +
                     '<div class="form-group">' +
                    '<label>Amount </label>' +
                    '<input type="number" placeholder="Enter Amount" class="amount form-control" required />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Wallet Transaction Password </label>' +
                    '<input type="password" placeholder="Transaction Password" class="t_code form-control" required />' +
                    '</div>' +
                    '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function () {
                                var name = this.$content.find('.name').val();
                                var amount = this.$content.find('.amount').val();
                                var code = this.$content.find('.t_code').val();
                                if(!name){
                                    //$.alert('provide a receiver');
                                    $.alert({
                                        title: 'Alert!',
                                        icon: 'fa fa-warning',
                                        type: 'red',
                                        content: 'Enter Receiver USERID' 
                                    });
                                    return false;
                                }
                                 if(!amount){
                                    
                                     $.alert({
                                        title: 'Alert!',
                                        icon: 'fa fa-warning',
                                        type: 'red',
                                        content: 'Enter an amount to Transfer' 
                                    });
                                    return false;
                                }
                                 if(!code){
                                     $.alert({
                                        title: 'Alert!',
                                        icon: 'fa fa-warning',
                                        type: 'red',
                                        content: 'Please enter wallet transaction code' 
                                    });
                                    return false;
                                }
                                $.alert('Your name is ' + name);
                            }
                        },
                        cancel: function () {
                            //close
                        },
                    },
                    onContentReady: function () {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            });

          $('#portfolio').on('click','#withdraw',function() {
                $.confirm({
                    title: 'Withdraw',
                    content: '' +
                    '<form action="" class="formName">' +
                     '<div class="form-group">' +
                    '<label>Amount </label>' +
                    '<input type="number" placeholder="Enter Amount" name="withdraw_amount" class="amount form-control" required />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Wallet Transaction Password </label>' +
                    '<input type="password" placeholder="Transaction Password" class="t_code form-control" required />' +
                    '</div>' +
                    '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function () {
                                var name = this.$content.find('.name').val();
                                var amount = this.$content.find('.amount').val();
                                var code = this.$content.find('.t_code').val();
                                if(!name){
                                    //$.alert('provide a receiver');
                                    $.alert({
                                        title: 'Alert!',
                                        icon: 'fa fa-warning',
                                        type: 'red',
                                        content: 'Enter Receiver USERID' 
                                    });
                                    return false;
                                }
                                 if(!amount){
                                    
                                     $.alert({
                                        title: 'Alert!',
                                        icon: 'fa fa-warning',
                                        type: 'red',
                                        content: 'Enter an amount to Transfer' 
                                    });
                                    return false;
                                }
                                 if(!code){
                                     $.alert({
                                        title: 'Alert!',
                                        icon: 'fa fa-warning',
                                        type: 'red',
                                        content: 'Please enter wallet transaction code' 
                                    });
                                    return false;
                                }
                                $.alert('Your name is ' + name);
                            }
                        },
                        cancel: function () {
                            //close
                        },
                    },
                    onContentReady: function () {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            });


    </script>

</body>

</html>
<!-- end document-->
