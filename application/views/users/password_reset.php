<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>iMM-Traders | Password reset</title>

        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">

    </head>

    <body>
        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">

                <div class="panel-body">
                    <h3 class="text-center m-t-0 m-b-15">
                        <a href="#" class=""><img src="<?=base_url()?>assets/images/flogo.png" alt=""></a>
                    </h3>

                    <form class="form-horizontal m-t-20" name="resetForm">
                        <div class="user-thumb text-center m-b-30">
                            <label>PASSWORD RESET</label>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" name="emails" required="" placeholder="Enter email">
                            </div>
                        </div>

                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" id="btn_search" type="submit">Submit</button>
                            </div>
                        </div>

                        <div class="form-group m-t-30 m-b-0">
                            <div class="col-sm-12 text-center">
                                <a href="<?=site_url()?>" class="text-muted">Not you?</a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>



        <!-- jQuery  -->
        <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
        <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>assets/js/modernizr.min.js"></script>
        <script src="<?=base_url()?>assets/js/detect.js"></script>
        <script src="<?=base_url()?>assets/js/fastclick.js"></script>
        <script src="<?=base_url()?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?=base_url()?>assets/js/jquery.blockUI.js"></script>
        <script src="<?=base_url()?>assets/js/waves.js"></script>
        <script src="<?=base_url()?>assets/js/wow.min.js"></script>
        <script src="<?=base_url()?>assets/js/jquery.nicescroll.js"></script>
        <script src="<?=base_url()?>assets/js/jquery.scrollTo.min.js"></script>
         <script src="<?=base_url()?>assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
        <script src="<?=base_url()?>assets/pages/sweet-alert.init.js"></script>

        <script src="<?=base_url()?>assets/js/app.js"></script>
        
        <script type="text/javascript">

            $(function(){

                    $('[name=resetForm]').submit(function(){
                                 $('#btn_search').attr('disabled',true);
                                                $('#btn_search').html('<span><i class="fa fa-spin fa-spinner"> </i>Searching ..</span')   ;

                                    var formData = {
                                               'emails'    : $('[name=emails]').val(),
                                              
                                    };
                             $.ajax({                          
                                        type        : 'POST', 
                                        url         : 'send', 
                                        data        : formData, 
                                        dataType    : 'json', 
                                        encode          : true
                                    }).done(function(data) {
                                                 swal(data[0].title, data[0].msg, data[0].status);
                                                    $('[name=emails]').val(''),
                                                $('#btn_search').attr('disabled',false);
                                                $('#btn_search').html('<span>Submit</span')   
                                                   
                                        });


                              event.preventDefault();

                    });

            });
       
        </script>
         
    </body>
</html>