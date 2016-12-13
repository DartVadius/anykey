<?php

/**
 * UserValidate
 *
 * @author DartVadius
 */
class UserValidate implements iValidate {
    private $user = NULL;
    public function __construct(UserModel $data) {
        $this->user = $data;
    }
    /**
     * check model
     * 
     * @return boolean
     */
    public function validate() {
        if (preg_match("/^[a-zA-Z0-9]+$/", $this->user->getUserLogin()) && strlen($this->user->getUserLogin()) >= Application::$App->login_length &&
                preg_match("/^[a-zA-Z0-9]+$/", $this->user->getUserName()) && strlen($this->user->getUserName()) >= Application::$App->name_length &&
                strlen($this->user->getUserPass()) >= Application::$App->pass_length) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * check existence of Id in object
     * 
     * @return boolean
     */
    public function validateId() {
        $id = $this->user->getUserId();
        if (isset($id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
