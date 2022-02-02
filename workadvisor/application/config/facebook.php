<?php defined('BASEPATH') OR exit('No direct script access allowed');
$config['facebook_app_id']              = '1335953649844739';
$config['facebook_app_secret']          = '586e1a3d3495f5e96801e82765d53755';
$config['facebook_login_type']          = 'web';
$config['facebook_login_redirect_url']  = 'home/fbauth';
$config['facebook_logout_redirect_url'] = 'home/logout';
$config['facebook_permissions']         = array('email');
$config['facebook_graph_version']       = 'v2.12';
$config['facebook_auth_on_load']        = TRUE;