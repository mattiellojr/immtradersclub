
    
 <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">

                    <div class="user-details">
                        <div class="pull-left">
                            <?php if($info['image_name']==''){ ?>
                                    <img src="<?=base_url()?>assets/images/meb-1.png" alt="" class="thumb-md img-circle">
                               <?php }else {?>
                                <img src="<?=base_url()?>assets/photos/<?=$info['image_name']?>" alt="" class="thumb-md img-circle">
                     
                             <?php  }?>
                           
                        </div>
                        <div class="user-info">
                            
                            <p class="text-muted m-0"><?=$info['user_id']?></p>
                            <p class="text-info " style="font-size: 10px;"><?=$info['username']?></p>
                            <p class="text-muted m-0"><span class="label label-info"><?=strtoupper($info['rank'])?></span></p>
                             <p class="text-success" style="font-size: 10px;" >Date Achieved : <?=date('M d, Y',strtotime($this->session->userdata('qualify_date')))?></p>

                        </div>
                    </div>
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title">Menu</li>
                            <li >
                                <a href="<?=site_url()?>dashboard" class="waves-effect  <?=$this->uri->segment(1)=='dashboard' ? 'active' : ''; ?>"><i class="mdi mdi-home"></i><span> DASHBOARD </span></a>
                            </li>
                            <li class="has_sub" <?=$this->uri->segment(1)=='account' ? 'class="active"' : ''; ?>>
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-box-outline"></i> <span>ACCOUNT </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                    <li <?=$this->uri->segment(2)=='settings' ? 'class="active"' : ''; ?>><a href="<?=site_url()?>account/settings">Account Settings</a></li>
                                    <li><a href="<?=site_url()?>account/funds">Deposit Funds</a></li> 
                                     <li><a href="<?=site_url()?>history/funds">Add Fund Requests</a></li>
                                    <li><a href="<?=site_url()?>account/investment">Investment Package</a></li>   
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-database"></i><span> COINS </span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="<?=site_url()?>coins/purchases">Coin Purchases</a></li>
                                    <li><a href="<?=site_url()?>coins/purchases/downline">Downline Coin Purchases</a></li>
                                    <li><a href="<?=site_url()?>coins/mycoins">Coin Balances</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-google-wallet"></i><span> WALLET SECTION </span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="<?=site_url()?>wallet/r-wallet">R-Wallet</a></li>
                                    <li><a href="<?=site_url()?>wallet/e-wallet">E-Wallet </a></li>
                                    <li><a href="<?=site_url()?>wallet/imc-wallet"">IMC Wallet</a></li>
                                    <li><a href="<?=site_url()?>history/transactions">Transaction History</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-cube-send"></i> <span> MY PORTFOLIO </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="<?=site_url()?>/portfolio/details">Portfolio Details</a></li>
                                   
                                </ul>
                            </li>
                              <li class="has_sub" <?=$this->uri->segment(1)=='reports' ? 'class="active"' : ''; ?>>
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book-multiple-variant"></i> <span>BONUS REPORTS </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                    <li ><a href="<?=site_url()?>reports/directincome">Direct Income</a></li>
                                    <li><a href="<?=site_url()?>reports/level-income-bonus">Level Income</a></li>
                                    <li><a href="<?=site_url()?>reports/profit-share">Profit Share Income</a></li>
                                    <li><a href="<?=site_url()?>reports/bonus-profit">Bonus from Profit Share Level Income</a></li>
                                    <li><a href="<?=site_url()?>reports/royalty">Royalty Bonus</a></li>
                                   <!--  <li><a href="<?=site_url()?>reports/downline-purchases">Downline Purchases</a></li>
                                    <li><a href="<?=site_url()?>reports/rank-achievement">Rank Achievement</a></li>
                                    <li><a href="<?=site_url()?>reports/direct-member">Referral Members</a></li>
                                    <li><a href="<?=site_url()?>reports/downline-members">Team Members</a></li>
                                    <li><a href="<?=site_url()?>reports/direct-members">Downline Member Tree</a></li>
                                    <li><a href="<?=site_url()?>reports/downline-withdrawals">Downline Withdrawals</a></li> -->
                                </ul>
                            </li>
                            <li class="has_sub" <?=$this->uri->segment(1)=='reports' ? 'class="active"' : ''; ?>>
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book-multiple-variant"></i> <span>TEAM REPORTS </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                   
                                    <li><a href="<?=site_url()?>reports/direct-member">Referral Members</a></li>
                                    <li><a href="<?=site_url()?>reports/downline-members">Team Members</a></li>
                                    <li><a href="<?=site_url()?>reports/direct-members">Downline Member Tree</a></li>
                                    
                                </ul>
                            </li>
                              <li class="has_sub" <?=$this->uri->segment(1)=='reports' ? 'class="active"' : ''; ?>>
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book-multiple-variant"></i> <span>OTHER REPORTS </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                   
                                    <li><a href="<?=site_url()?>reports/downline-purchases">Downline Purchases</a></li>
                                    <li><a href="<?=site_url()?>reports/rank-achievement">Rank Achievement</a></li>
                                   
                                    <li><a href="<?=site_url()?>reports/downline-withdrawals">Downline Withdrawals</a></li>
                                </ul>
                            </li>
                             <!-- <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted-type"></i> <span> HISTORY </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="<?=site_url()?>history/transactions">Transaction History</a></li>
                                   
                                    <li><a href="<?=site_url()?>history/funds">Add Fund Request</a></li>

                                </ul>
                            </li> -->
                           
                           
                        
                             <li class="has_sub" <?=$this->uri->segment(1)=='reports' ? 'class="active"' : ''; ?>>
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-book-multiple-variant"></i> <span>MKTNG. TOOLS </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                   <li>
                                <a href="<?=site_url()?>referal-links" ><span> REFERRAL LINKS</span></a>
                            </li>
                             <li>
                                <a href="<?=site_url()?>promos"><span> PROMOS</span></a>
                            </li>
                            
                              
                                </ul>
                            </li>

                          <!--<li>
                                <a href="<?=site_url()?>referal-links" class="waves-effect"><i class="mdi mdi-cellphone-link"></i><span> REFERRAL LINKS</span></a>
                            </li>
                             <li>
                                <a href="<?=site_url()?>promos" class="waves-effect"><i class="mdi mdi-trophy-award"></i><span> PROMOS</span></a>
                            </li>-->
                            <li>
                                <a href="<?=site_url()?>educational-material" class="waves-effect"><i class="mdi mdi-television-guide"></i><span> EDUC. MATERIALS</span></a>
                            </li> 
                                <li class="menu-title">SUPPORT</li>
                            <li>
                                <a href="<?=site_url()?>contact-support" class="waves-effect"><i class="mdi mdi-email-outline"></i><span> CONTACT SUPPORT </span></a>
                            </li>
                               
                        
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->


                