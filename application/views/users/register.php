
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="iMM-Traders Club">
    <meta name="author" content="">
    <meta name="keywords" content="imm traders club">

    <!-- Title Page-->
    <title>iMM-Traders Club | Register</title>

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

    <!-- Main CSS-->
    <link href="<?=base_url()?>assets/users/css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="<?=base_url()?>assets/users/images/icon/logo-white.png" alt="CoolAdmin">
                            </a>
                        </div>
                        <div class="login-form">
                            <?php if(count(validation_errors()) > 1) { ?>
                                    <div class="alert alert-danger"><?=validation_errors()?></div>
                            <?php } ?>
                            <?php if($this->session->flashdata('msg') !=""){ ?>
                                 <div class="alert alert-success"><?=$this->session->flashdata('msg')?></div>
                            <?php }  $this->session->set_flashdata('msg', '');?>
                             <?php if($this->session->flashdata('error') !=""){ ?>
                                         <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
                                    <?php }  $this->session->set_flashdata('error', '');?>

                        <?=form_open('register/create')?>
                                      <input type="hidden" id="token" value="<?=$this->security->get_csrf_hash();?>">
                                 <div class="form-group">
                                    <label>Sponsor : </label>
                                    <input class="au-input au-input--full" type="text" name="sponsor" id="" placeholder=" Sponsor's Userid/Username/Email">
                                    <small class="text-success pull-right" id="user_name"></small>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="au-input au-input--full" type="text" name="email" id="" placeholder="Username/Email">
                                </div>

                                 <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password" id="" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="au-input au-input--full" type="password" name="confirm_passwd" id="" placeholder="Password">
                                </div>
                               
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign up</button>
                               
                            </form>
                  
                            <div class="register-link">
                                <p>
                                    Don't you have account?
                                    <a href="<?=site_url()?>login">Login Here</a>
                                </p>
                            </div>
                        </div>
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
    <script src="<?=base_url()?>assets/users/vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="<?=base_url()?>assets/users/js/main.js"></script>
    <script type="text/javascript">
      
        $(function(){
                  $('[name=sponsor]').focusout(function() {

                               $.ajax({
                                  type: "POST",
                                  url: 'register/search-sponsor',
                                  data:   {  
                                            
                                              'user'         :   $(this).val(),
                                              'imm_token'    : $('#token').val()
                        
                                         },
                                  cache: false,
                                  success: function(data){
                                        var obj = JSON.parse(data);
              
                                          console.log(obj[0].email);
                                          $('#user_name').html('<p>'+obj[0].email+'( ' + obj[0].user_id+ ' )</p>')

                                          $('[name=sponsor_name]').val(obj[0].name);

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
    <script type="text/javascript">
        $(document).ready(function(){
                 setTimeout(function(){ $('.alert').fadeOut('slow') },2500);

        });
    </script>

</body>

</html>
<!-- end document-->
