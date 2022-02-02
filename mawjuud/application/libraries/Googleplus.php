<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Googleplus {
	public function __construct() {
		$CI =& get_instance();
		$CI->config->load('googleplus');
		require APPPATH .'third_party/google-api-php-client/src/Google_Client.php';
		require APPPATH .'third_party/google-api-php-client/src/contrib/Google_PlusService.php';
		require APPPATH .'third_party/google-api-php-client/src/contrib/Google_Oauth2Service.php';
		
		$cache_path = $CI->config->item('cache_path');
		$GLOBALS['apiConfig']['ioFileCache_directory'] = ($cache_path == '') ? APPPATH .'cache/' : $cache_path;
		
		$this->client = new Google_Client();
		$this->client->setApplicationName($CI->config->item('application_name', 'googleplus'));
		$this->client->setClientId($CI->config->item('client_id', 'googleplus'));
		$this->client->setClientSecret($CI->config->item('client_secret', 'googleplus'));
		$this->client->setRedirectUri($CI->config->item('redirect_uri', 'googleplus'));
		$this->client->setDeveloperKey($CI->config->item('api_key', 'googleplus'));
        $this->client->setScopes($CI->config->item('scopes', 'googleplus'));
        $this->client->setAccessType('online');
        $this->client->setApprovalPrompt('auto');
		$this->plus = new Google_PlusService($this->client);
		$this->oauth2 = new Google_Oauth2Service($this->client);
	}
    public function loginURL() {
        return $this->client->createAuthUrl();
    }
    
    public function getAuthenticate() {
        return $this->client->authenticate();
    }
    
    public function getAccessToken() {
        return $this->client->getAccessToken();
    }
    
    public function setAccessToken() {
        return $this->client->setAccessToken();
    }
    
    public function revokeToken() {
        return $this->client->revokeToken();
    }
    
    public function getUserInfo() {
        return $this->oauth2->userinfo->get();
    }

	public function __get($name) {
		
		if(isset($this->plus->$name)) {
			return $this->plus->$name;
		}
		return false;
		
	}
	
	public function __call($name, $arguments) {
		if(method_exists($this->plus, $name)) {
			return call_user_func(array($this->plus, $name), $arguments);
		}
		return false;
	}

}
?>