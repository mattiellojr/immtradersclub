
    <?=$this->view('users/body_header')?>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <div class="">
                        <div class="page-header-title">
                            <h4 class="page-title">Dashboard</h4>
                        </div>


                    </div>

                    <div class="page-content-wrapper ">

                        <div class="container">
                            
                              <div class="container">
                                    



                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->


                    <?=$this->view('users/footer')?>

            </div>
            <!-- End Right content here -->
        </div>
        <!-- END wrapper -->

       
        <!-- jQuery  -->
         <?=$this->view('users/scripts')?>

       

           <script type="text/javascript">
               $(function(){
                        $.ajax({
                                    type: "POST",
                                    url: '<?=site_url()?>/userinfo',
                                    data: {}  ,
                                    cache: false,
                                success: function(result){

                                                console.log(result);
                                    }
                                });
        

               });
           </script>
  <?=$this->view('users/body_footer')?>