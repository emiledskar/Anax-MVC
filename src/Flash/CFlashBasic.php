<?php

namespace Anax\Flash;

/**
 * Store messages for flashing them to the user as user feedback.
 *
 */
class CFlashBasic
{
    use \Anax\DI\TInjectable;
    /**
     * Properties
     *
     */
    protected $message;



   /**
     * Set a message.
     *
     * @param string a message.
     *     
     * @return void
     */
    public function setMessage($message)
    {
        $this->session->set('message', $message);
    }

    public function setInfoMessage($message)
    {
        $this->session->set('message', '<div class="alert alert-info" role="alert">'.$message.'</div>');
    }

    public function setErrorMessage($message)
    {
        $this->session->set('message', '<div class="alert alert-danger" role="alert">'.$message.'</div>');
    }

    public function setSuccessMessage($message)
    {
        $this->session->set('message', '<div class="alert alert-success" role="alert">'.$message.'</div>');
    }



   /**
     * Get the message.
     *
     * @return void
     *
     */
    public function getMessage()
    {
        return $this->session->get('message');
    }
}
