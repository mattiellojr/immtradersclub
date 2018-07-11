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
                    <h4 class="text-muted text-center m-t-0"><b>Account Recovery Stage 2</b></h4>

<?php

$showform = 1;

if( isset( $validation_errors ) )
{
	echo '
		<div style="border:1px solid red;">
			<p>
				The following error occurred while changing your password:
			</p>
			<ul>
				' . $validation_errors . '
			</ul>
			<p>
				PASSWORD NOT UPDATED
			</p>
		</div>
	';
}
else
{
	$display_instructions = 1;
}

if( isset( $validation_passed ) )
{
	echo '
		<div style="border:1px solid green;">
			<p>
				You have successfully changed your password.
			</p>
			<p>
				You can now <a href="https://immtradersclub.com/member/login">login</a>
			</p>
		</div>
	';

	$showform = 0;
}
if( isset( $recovery_error ) )
{
	echo '
		<div style="border:1px solid red;">
			<p>
				No usable data for account recovery.
			</p>
			<p>
				Account recovery links expire after 
				' . ( (int) config_item('recovery_code_expiration') / ( 60 * 60 ) ) . ' 
				hours.<br />You will need to use the 
				<a href="<?=site_url()?>password/recovery">Account Recovery</a> form 
				to send yourself a new link.
			</p>
		</div>
	';

	$showform = 0;
}
if( isset( $disabled ) )
{
	echo '
		<div style="border:1px solid red;">
			<p>
				Account recovery is disabled.
			</p>
			<p>
				You have exceeded the maximum login attempts or exceeded the 
				allowed number of password recovery attempts. 
				Please wait ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' 
				minutes, or contact us if you require assistance gaining access to your account.
			</p>
		</div>
	';

	$showform = 0;
}
if( $showform == 1 )
{
	if( isset( $recovery_code, $user_id ) )
	{
		if( isset( $display_instructions ) )
		{
			if( isset( $username ) )
			{
				echo '<p>
					Your login user name is <i>' . $username . '</i><br />
					Please write this down, and change your password now:
				</p>';
			}
			else
			{
				echo '<p>Please change your password now:</p>';
			}
		}

		?>
			<div id="form">
				<?php echo form_open(); ?>
					
						<label>Step 2 - Choose your new password</label>
						<div class="form-group">

							<?php
								// PASSWORD LABEL AND INPUT ********************************
								echo form_label('Password','passwd', ['class'=>'form_label']);

								$input_data = [
									'name'       => 'passwd',
									'id'         => 'passwd',
									'class'      => 'form-control password',
									'max_length' => config_item('max_chars_for_password')
								];
								echo form_password($input_data);
							?>

						</div>
						<div class="form-group">

							<?php
								// CONFIRM PASSWORD LABEL AND INPUT ******************************
								echo form_label('Confirm Password','passwd_confirm', ['class'=>'form_label']);

								$input_data = [
									'name'       => 'passwd_confirm',
									'id'         => 'passwd_confirm',
									'class'      => 'form-control password',
									'max_length' => config_item('max_chars_for_password')
								];
								echo form_password($input_data);
							?>

						</div>
					
					<div>
						<div class="form-group">

							<?php
								// RECOVERY CODE *****************************************************************
								echo form_hidden('recovery_code',$recovery_code);

								// USER ID *****************************************************************
								echo form_hidden('user_identification',$user_id);

								// SUBMIT BUTTON **************************************************************
								$input_data = [
									'name'  => 'form_submit',
									'id'    => 'submit_button',
									'value' => 'Change Password',
									'class' => 'btn btn-primary'
								];
								echo form_submit($input_data);
							?>

						</div>
					</div>
				</form>
			</div>
		<?php
	}
}
?>
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
        <script src="http://malsup.github.com/jquery.form.js"></script> 
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