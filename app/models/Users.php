<?php


use Phalcon\Mvc\Model\Validator\Email as Email,
    Phalcon\Mvc\Model\Validator\Uniqueness as Uniqueness;

class Users extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;
     
    /**
     *
     * @var string
     */
    public $display_name;
     
    /**
     *
     * @var string
     */
    public $email;
     
    /**
     *
     * @var string
     */
    public $password;
     
    /**
     *
     * @var string
     */
    public $register_ts;
     
    /**
     *
     * @var string
     */
    public $login_ts;
     
    /**
     *
     * @var string
     */
    public $login_ip;
     
    /**
     * Validations and business logic
     */
    public function validation()
    {

        $this->validate(
            new Email(
                array(
                    "field"    => "email",
                    "required" => true
                )
            )
        );
        $this->validate(
            new Uniqueness(
                array(
                    "field"   => "display_name",
                    "message" => "Display name is invalid or not available."
                )
            )
        );
        $this->validate(
            new Uniqueness(
                array(
                    "field"   => "email",
                    "message" => "Email is invalid or not available."
                )
            )
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

}
