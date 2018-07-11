<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$route[LOGIN_PAGE] 										= 'Examples/login';
$route['default_controller'] 							= 'Examples';


$route['dashboard'] 									= 'users/Dashboard';
$route['register'] 										= 'users/Register';
$route['register/search-sponsor'] 						= 'users/Register/searchUser';
$route['register/create'] 								= 'users/Register/create_user';


$route['account/profile'] 								= 'AccountController';
$route['account/bankdetails'] 							= 'AccountController/bankdetails';
$route['account/wallet'] 								= 'AccountController/wallet';
$route['account/password'] 								= 'AccountController/password';
$route['account/update-profile'] 						= 'AccountController/updateProfile';
$route['account/update-address'] 						= 'AccountController/updateAddress';
$route['account/update-bank'] 							= 'AccountController/updateBankDetails';
$route['account/update-wallet'] 						= 'AccountController/updateWallet';
$route['account/update-password']						= 'AccountController/updatePassword';
$route['account/update-transpassword']					= 'AccountController/updateTransPassword';


$route['package/purchase'] 								= 'InvestmentController';
$route['package/buy'] 									= 'InvestmentController/purchase';

$route['deposits/bankwire']								= 'DepositController';
$route['deposits/bitcoin']								= 'DepositController/bitcoin_deposit';
$route['deposits/creditdebit-card']						= 'DepositController/credit_debit';
$route['desposits/submit-cardpayment']					= 'DepositController/check';
$route['deposits/submit-bankwire']						= 'DepositController/deposit';
$route['deposits/submit-bitcoin']						= 'DepositController/submit_bitcoin';

$route['deposits/history']								= 'DepositController/history';
$route['deposits/my-history']							= 'DepositController/get_history';
$route['deposits/search-my-history']					= 'DepositController/search_deposits';


$route['mywallets/rwallet'] 							= 'RwalletController';
$route['mywallets/rwallet/search-receiver'] 			= 'RwalletController/searchUser';
$route['mywallets/ewallet'] 							= 'mywallets/EwalletController';
$route['mywallets/ewallet/transfer'] 					= 'mywallets/EwalletController/transfer_fund';
$route['mywallets/ewallet/withdraw'] 					= 'mywallets/EwalletController/withdraw';
$route['mywallets/history'] 							= 'mywallets/HistoryController';
$route['mywallets/history/search-history'] 				= 'mywallets/HistoryController/search_history';
$route['mywallets/mother-wallet'] 						= 'mywallets/MotherwalletController';
$route['mywallets/mother-wallet/setup'] 				= 'mywallets/MotherwalletController/setupAccount';
$route['mywallets/mother-wallet/details'] 				= 'mywallets/MotherwalletController/subaccount_details';
$route['mywallets/mother-wallet/ewallet/:any'] 			= 'mywallets/MotherwalletController/ewallet';
$route['mywallets/mother-wallet/rwallet/:any'] 			= 'mywallets/MotherwalletController/rwallet';
$route['mywallets/mother-wallet/ewallet/fund/transfer'] 	= 'mywallets/MotherwalletController/transfer_fund_ewallet';
$route['mywallets/mother-wallet/rwallet/fund/transfer'] 	= 'mywallets/MotherwalletController/transfer_fund_rwallet';
$route['mywallets/mother-wallet/ewallet/fund/withdraw'] 	= 'mywallets/MotherwalletController/withdraw';




$route['mywallets/rwallet/transfer-rwallet'] 				= 'RwalletController/transfer_fund';

$route['portfolio/my-closedportfolio'] 						= 'PortfolioController/closed';
$route['portfolio/my-closedportfolio/details'] 				= 'PortfolioController/closeaccounts';

$route['portfolio/my-portfolio'] 							= 'PortfolioController';
$route['portfolio/my-portfolio/close'] 						= 'PortfolioController/closeAccount';
$route['portfolio/my-portfolio/cancel'] 					= 'PortfolioController/cancelCloseAccount';
$route['portfolio/my-portfolio/details'] 					= 'PortfolioController/portfolio_details';

$route['bonus-reports/direct-income']						= 'bonusreport/DirectincomeController';
$route['bonus-reports/direct-income/history']				= 'bonusreport/DirectincomeController/get_history';
$route['bonus-reports/direct-income/history/search']		= 'bonusreport/DirectincomeController/search_history';

$route['bonus-reports/level-income']						= 'bonusreport/LevelincomeController';
$route['bonus-reports/level-income/history']				= 'bonusreport/LevelincomeController/get_history';
$route['bonus-reports/level-income/history/search']			= 'bonusreport/LevelincomeController/search_history';

$route['bonus-reports/profit-share-income']					= 'bonusreport/ProfitshareincomeController';
$route['bonus-reports/profit-share-income/history']			= 'bonusreport/ProfitshareincomeController/get_history';
$route['bonus-reports/profit-share-income/history/search']	= 'bonusreport/ProfitshareincomeController/search_history';


$route['bonus-reports/bonus-profit-share-income']			= 'bonusreport/BonusincomeController';
$route['bonus-reports/bonus-profit-share-income/share/history']	= 'bonusreport/BonusincomeController/get_bonus';
$route['bonus-reports/bonus-profit-share-income/share/search-history']	= 'bonusreport/BonusincomeController/search_history';


$route['bonus-reports/royalty-bonus']						= 'bonusreport/RoyaltyincomeController';
$route['bonus-reports/royalty-bonus/:any']					= 'bonusreport/RoyaltyincomeController';

$route['team-reports/direct-members']						= 'teamreport/ReferralmemberController';
$route['team-reports/direct-members/purchases']				= 'teamreport/ReferralmemberController/get_direct_members';

$route['team-reports/team-members']							= 'teamreport/TeammemberController';
$route['team-reports/member-tree']							= 'teamreport/MembertreememberController';
$route['team-reports/member-tree-downline']					= 'teamreport/MembertreememberController/get_downline_tree';


$route['other-reports/downline-purchases']					= 'otherreport/DownlinepurchaseController';
$route['other-reports/search-downline-purchase']			= 'otherreport/DownlinepurchaseController/search_downline_purchases';

$route['other-reports/rank-achievement']					= 'otherreport/RankachievementController';
$route['other-reports/downline-withdrawals']				= 'otherreport/DownlinewithdrawalController';
$route['other-reports/search-downline-withdrawals']			= 'otherreport/DownlinewithdrawalController/search_withdrawal';

$route['withdrawals']										= 'WithdrawalsController';
$route['withdrawals/my-withdrawals']						= 'WithdrawalsController/get_withdrawals';
$route['withdrawals/search-my-withdrawals']					= 'WithdrawalsController/search_withdrawals';


$route['marketing-tools/referral-links']					= 'marketingtools/MarketingtoolsController';
$route['marketing-tools/educational-material']				= 'marketingtools/MarketingtoolsController/educMaterial';
$route['marketing-tools/promotions']						= 'marketingtools/MarketingtoolsController/promo';

$route['coins/my-purchases']								= 'CoinsController';
$route['coins/my-purchases/coinhistory']					= 'CoinsController/coin_histoy';
$route['coins/downline-purchases']							= 'CoinsController/downlines';
$route['coins/my-purchases/downlines']						= 'CoinsController/search_downline_purchases';



$route['404_override']										= '';
$route['translate_uri_dashes'] 								= FALSE;
