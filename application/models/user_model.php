<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	private $userId;
    private $username;
    private $fullName;
    private $avatar;
 	
 	public function __construct($user = NULL){
        // Call the Model constructor
        parent::__construct();
        if(isset($user)){
        	if(is_array($user)){
        		$this->set_user_array($user);
        	}
        	else{
        		$this->set_user_object($user);
        	}
        }
    }

    public function get_user_id(){
    	return $this->userId;
    }

    public function get_username(){
    	return $this->username;
    }

    public function get_fullname(){
    	return $this->fullName;
    }

    public function get_avatar(){
    	return base_url().$this->avatar;
    }

    public function get_avatar_path(){
        return $this->avatar;
    }
    public function get_avatar_name(){
        $path = explode("/", $this->avatar);
        return $path[count($path)-1];
    }

    public function get_user()
    {
        $query = $this->db->get('user',1);
        $user = $query->row();
        if(count($user) == 0){
        	return NULL;
        }
        $this->set_user_object($query->row());
        return $this;
    }


    public function save(){
    	if(isset($this->userId)){
    		if($this->update_user() > 0){
                return $this->userId;
            }
            return NULL;
    	}
    	else{
            $user_id = $this->insert_user();
    		if($user_id !== FALSE){
                return $user_id;
            }
            return NULL;
    	}
    }




    /***** private functions *******/

    private function insert_user(){
    	$insertArr = array(
    		"username"	=>$this->username,
    	 	"fullName" 	=>$this->fullName,
    	 	"avatar"   	=>$this->avatar
    		);
    	
    	if($this->db->insert("user", $insertArr)){
    		return $this->db->insert_id();
    	}
        return FALSE;
    }

    private function update_user(){
    	$updateArr = array(
    		"username" =>$this->username,
            "fullName"  =>$this->fullName
    	 	);
        if(isset($this->avatar) && $this->avatar != NULL)
            $updateArr['avatar'] = $this->avatar;
    	
    	$this->db->set($updateArr);
    	$this->db->where("userId", $this->userId);

    	return $this->db->update("user");
    }

    private function set_user_object($userObj){
    	

    	if(isset($userObj->userId)) 	$this->userId 		= $userObj->userId;
    	if(isset($userObj->username)) 	$this->username 	= $userObj->username;
    	if(isset($userObj->fullName)) 	$this->fullName 	= $userObj->fullName;
    	if(isset($userObj->avatar)) 	$this->avatar 		= $userObj->avatar;
    }

    private function set_user_array($userArr){
		if(isset($userArr['userId'])) 		$this->userId 		= $userArr['userId'];	
    	if(isset($userArr['username'])) 	$this->username 	= $userArr['username'];
    	if(isset($userArr['fullName'])) 	$this->fullName 	= $userArr['fullName'];
    	if(isset($userArr['avatar'])) 		$this->avatar 		= $userArr['avatar'];
    }


    
}
?>