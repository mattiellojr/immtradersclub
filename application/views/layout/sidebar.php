   <aside class="menu-sidebar2">
            <div class="logo">
                <a href="#">
                    <img src="<?=base_url()?>assets/users/images/icon/logo-white.png" alt="immtraders" />
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                <div class="account2">
                    <div class="image img-cir img-120">
                        <img src="<?=base_url()?>assets/users/images/icon/avatar-big-01.jpg" alt="John Doe" />
                    </div>
                    <h4 class="name"><?=$userid?></h4>
                     <a href="#"><?=$this->auth_email?></a>
                    <a href="#"><?=$rank_name?></a>
                     <a href="#">Date Achieved : <?=$achieved_date?></a>
                     <a href="<?=site_url()?>examples/logout" class="btn btn-success btn-xs" style="color: #fff;">Sign out</a>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li <?=$this->uri->segment(1)=='dashboard' ? 'class="active"' : ''; ?>>
                            <a  href="<?=site_url()?>dashboard">
                                <i class="fas fa-tachometer-alt"></i>Dashboard
                            </a>
                        </li>
                        <li class="has-sub" <?=$this->uri->segment(1)=='account' ? 'class="active"' : ''; ?>>
                            <a class="js-arrow" href="#">
                                <i class="fas fa-gears"></i>Account Settings
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                 <li>
                                    <a href="<?=site_url()?>account/profile">
                                        <i class="fas fa-user"></i>Profile</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>account/bankdetails">
                                        <i class="fas fa-home"></i>Bank Details</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>account/wallet">
                                        <i class="fas fa-briefcase"></i>Wallet</a>
                                </li>

                                <li>
                                    <a href="<?=site_url()?>account/password">
                                        <i class="fas fa-unlock-alt"></i>Password</a>
                                </li>
                            </ul>
                        </li>

                        <li <?=$this->uri->segment(1)=='package' ? 'class="active"' : ''; ?>>
                            <a href="<?=site_url()?>package/purchase">
                                <i class="fas fa-shopping-basket"></i>Investment Package</a>
                        </li>
                       
                         <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-suitcase"></i>Fund Deposits
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                 <li>
                                    <a href="<?=site_url()?>deposits/bitcoin">
                                        <i class="fa fa-btc"></i>BTC</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>deposits/bankwire">
                                        <i class="fas fa-university"></i>Bankwire</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>deposits/creditdebit-card">
                                        <i class="fas fa-credit-card"></i>Credit/Debit Card</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>deposits/history">
                                        <i class="fas fa-history"></i>Deposit History</a>
                                </li>
                            </ul>
                        </li>
                         <li <?=$this->uri->segment(1)=='withdrawals' ? 'class="active"' : ''; ?>>
                            <a href="<?=site_url()?>withdrawals">
                                <i class="fas fa-shopping-basket"></i>My Withdrawals</a>
                        </li>
                          <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-desktop"></i>My Wallets
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                 <li>
                                    <a href="<?=site_url()?>mywallets/rwallet"><i class="fas fa-briefcase"></i>R-Wallet</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>mywallets/ewallet"><i class="fas fa-briefcase"></i>E-Wallet</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>mywallets/mother-wallet"><i class="fas fa-briefcase"></i>Mother Wallet</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>mywallets/history"><i class="fas fa-history"></i>Transaction History</a>
                                </li>
                            </ul>
                        </li>
                         <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-folder"></i>My Portfolio
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                 <li>
                                    <a href="<?=site_url()?>portfolio/my-portfolio">
                                        <i class="fas  fa-folder-open"></i>Portfolio Details</a>
                                </li>
                                 <li>
                                    <a href="<?=site_url()?>portfolio/my-closedportfolio">
                                        <i class="fas  fa-folder"></i>Closed Account</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-database"></i>My Coins
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                 <li>
                                    <a href="<?=site_url()?>coins/my-purchases">
                                        <i class="fas  fa-history"></i>Coin Purchases</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>coins/downline-purchases">
                                        <i class="fas  fa-history"></i>Downline Purchases</a>
                                </li>
                            </ul>
                        </li>
                         <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-archive"></i>Bonus Reports
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="<?=site_url()?>bonus-reports/direct-income">
                                        <i class="fas fa-money-bill-alt "></i>Direct Income</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>bonus-reports/level-income">
                                        <i class="fas fa-money-bill-alt "></i>Level Income</a>
                                </li>
                                 <li>
                                    <a href="<?=site_url()?>bonus-reports/profit-share-income">
                                        <i class="fas fa-money-bill-alt "></i>Profit Share Income</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>bonus-reports/bonus-profit-share-income">
                                        <i class="fas fa-money-bill-alt "></i>Bonus from Profit Share Level Income</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>bonus-reports/royalty-bonus">
                                        <i class="fas fa-money-bill-alt "></i>Royalty Bonus</a>
                                </li>

                            </ul>
                        </li>
                          <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-archive"></i>Team Reports
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="<?=site_url()?>team-reports/direct-members">
                                        <i class="fas fa-table"></i>Referral Members</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>team-reports/team-members">
                                        <i class="fas fa-trophy"></i>Team Members</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>team-reports/member-tree">
                                        <i class="fas fa-sitemap"></i>Downline Member Tree</a>
                                </li>

                            </ul>
                        </li>
                       <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-archive"></i>Other Reports
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="<?=site_url()?>other-reports/downline-purchases">
                                        <i class="fas fa-table"></i>Downline Purchases</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>other-reports/rank-achievement">
                                        <i class="fas fa-trophy"></i>Rank Achievement</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>other-reports/downline-withdrawals">
                                        <i class="fas fa-table"></i>Downline Withdrawals</a>
                                </li>
                            </ul>
                        </li>
        
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-desktop"></i>Marketing Tools
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="<?=site_url()?>marketing-tools/referral-links">
                                        <i class="fab fa-flickr"></i>Referral Links</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>marketing-tools/educational-material">
                                        <i class="fas fa-comment-alt"></i>Educational Materials</a>
                                </li>
                                <li>
                                    <a href="<?=site_url()?>marketing-tools/promotions">
                                        <i class="far fa-window-maximize"></i>Promotions</a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
