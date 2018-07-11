<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="iMM-Traders" name="description" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>iMM-Traders | Recovery</title>
        <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.ico">
        <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css">
          
    </head>
    <body>
        <!-- Begin page -->
        
       
        <div class="accountbg"></div>
        <div class="wrapper-page">
            
            <div class="panel panel-color panel-primary panel-pages">
                <div class="panel-body">
                    <h3 class="text-center m-t-0 m-b-15">
                        <a href="index.html" class=""><img src="<?=base_url()?>assets/images/flogo.png"  alt="logo-img"></a>
                    </h3>
                    <h4 class="text-muted text-center m-t-0"><b>Account Recovery</b></h4>


<?php
if( isset( $disabled ) )
{
	echo '
		<div style="border:1px solid red;">
			<p>
				Account Recovery is Disabled.
			</p>
			<p>
				If you have exceeded the maximum login attempts, or exceeded
				the allowed number of password recovery attempts, account recovery 
				will be disabled for a short period of time. 
				Please wait ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' 
				minutes, or contact us if you require assistance gaining access to your account.
			</p>
		</div>
	';
}
else if( isset( $banned ) )
{
	echo '
		<div style="border:1px solid red;">
			<p>
				Account Locked.
			</p>
			<p>
				You have attempted to use the password recovery system using 
				an email address that belongs to an account that has been 
				purposely denied access to the authenticated areas of this website. 
				If you feel this is an error, you may contact us  
				to make an inquiry regarding the status of the account.
			</p>
		</div>
	';
}
else if( isset( $confirmation ) )
{
	echo '
		<div style="">
			<p>
				Congratulations, you have created an account recovery link.
			</p>
			
			<p>
				"We have sent you an email with instructions on how 
				to recover your account."
			</p>
			
		</div>
	';
}
else if( isset( $no_match ) )
{
	echo '
		<div  style="border:1px solid red;">
			<p class="feedback_header">
				Supplied email did not match any record.
			</p>
		</div>
	';

	$show_form = 1;
}
else
{
	echo '
		<p>
			If you\'ve forgotten your password and/or username, 
			enter the email address used for your account, 
			and we will send you an e-mail 
			with instructions on how to access your account.
		</p>
	';

	$show_form = 1;
}
if( isset( $show_form ) )
{
	?>

		 <?php echo form_open(); ?>
			<div class="form-group">
		
					

						<?php
							// EMAIL ADDRESS *************************************************
							echo form_label('Email Address','email', ['class'=>'form_label'] );

							$input_data = [
								'name'		=> 'email',
								'id'		=> 'email',
								'class'		=> 'form-control',
								'maxlength' => 255
							];
							echo form_input($input_data);
						?>

				</div>
				
					<div class="form-group">

						<?php
							// SUBMIT BUTTON **************************************************************
							$input_data = [
								'name'  => 'submit',
								'id'    => 'submit_button',
								'value' => 'Send Email',
								'class'	=> 'btn btn-primary'
							];
							echo form_submit($input_data);
						?>

					</div>
				
			
		</form>

	<?php
}?>
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
        <script src="<?=base_url()?>assets/js/app.js"></script>
        
        <script type="text/javascript">
                    $('#submit').submit(function(){
                              //  e.preventDefault();
                                $('#btn_submit').attr('disabled',true);
                                $('#btn_submit').html("<span class='fa fa-spinner'>Redirecting .. Please wait</span>");
                       
                    });
        </script>
        <script type="text/javascript">
      // $("#submit_button").on("click",function(){
      //       $('#submit_button').attr('disabled',true);
      //       $('#login_string').attr('disabled',true);
      //       $('#login_pass').attr('disabled',true);
      //       $('#submit_button').html('<span class="fa fa-spin fa-spinner"></span>SIGNING IN . . ');
            
      // });

     

        $('form').on('submit',function(){
                  $('#submit_button').attr('disabled',true)
                $('#submit_button').html('<span class="fa fa-spin fa-spinner"> </span> Establishing connection ... Please wait')

                
        });
</script>


        

    </body>
</html>