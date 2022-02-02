<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['facebook_app_id']              = '996078703923803';

$config['facebook_app_secret']          = '67c28383d173886d4de138d7601bb19d';

$config['facebook_login_type']          = 'web';

$config['facebook_login_redirect_url']  = 'user/fbauth';

$config['facebook_logout_redirect_url'] = 'user/logout';

$config['facebook_permissions']         = array('email');

$config['facebook_graph_version']       = 'v2.10';

$config['facebook_auth_on_load']        = TRUE;