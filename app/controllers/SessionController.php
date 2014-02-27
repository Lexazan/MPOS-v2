<?php

use Phalcon\Tag as Tag;

class SessionController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('main');
        Tag::setTitle('Sign Up/Sign In');
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->request->isPost()) {
            Tag::setDefault('email', '');
            Tag::setDefault('password', '');
        }
    }

    public function registerAction()
    {
      $request = $this->request;
      if ($request->isPost()) {

        if ($this->request->isPost()) {
          if ($this->security->checkToken()) {
            $display_name = $request->getPost('display_name', 'alphanum');
            $email = $request->getPost('email', 'email');
            $password = $request->getPost('password');
            $repeatPassword = $this->request->getPost('repeatPassword');

            if ($password != $repeatPassword) {
              $this->flash->error('Passwords are diferent');
              return false;
            }

            $user = new Users();
            $user->display_name = $display_name;
            $user->password = $this->security->hash($password);
            $user->email = $email;
            $user->register_ts = new Phalcon\Db\RawValue('NOW()');
            if ($user->save() == false) {
              foreach ($user->getMessages() as $message) {
                $this->flash->error((string) $message);
              }
            } else {
              Tag::setDefault('email', '');
              Tag::setDefault('password', '');
              $this->flash->success('Thanks for sign-up, please log-in to start generating invoices');
              return $this->forward('session/index');
            }
          } else {
            $this->flash->error('Invalid or expired CSRF Token. Please try again.');
            return false;
          }
        }
      }
    }

    /**
     * Register authenticated user into session data
     *
     * @param Users $user
     */
    private function _registerSession($user)
    {
      $this->session->set('auth', array(
        'id' => $user->id,
        'name' => $user->display_name
      ));
    }

    /**
     * This actions receive the input from the login form
     *
     */
    public function startAction()
    {
      if ($this->request->isPost()) {
        if ($this->security->checkToken()) {
          $email = $this->request->getPost('email', 'email');

          $password = $this->request->getPost('password');

          $user = Users::findFirstByEmail($email);
          if ($user != false) {
            if ($this->security->checkHash($password, $user->password)) {
              $login_ip = $this->request->getClientAddress();
              $message = 'Last login was from ' . $user->login_ip . ' at ' . $user->login_ts;
              if ($login_ip == $user->login_ip) {
                $this->flash->notice($message);
              } else {
                $this->flash->warning($message);
              }
              $user->login_ts = new Phalcon\Db\RawValue('NOW()');
              $user->login_ip = $login_ip;
              if ($user->save() == false) {
                foreach ($user->getMessages() as $message) {
                  $this->flash->error((string) $message);
                }
              } else {
                $this->_registerSession($user);
                $this->flash->success('Welcome ' . $user->display_name);
                return $this->forward('/index/index');
              }
            }
          }

          $this->flash->error('Wrong email/password');
        } else {
          $this->flash->error('Invalid or expired CSRF token. Please try again');
        }

        return $this->forward('session/index');
      }
    }

    /**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function endAction()
    {
      $this->session->remove('auth');
      $this->flash->success('Goodbye!');
      return $this->dispatcher->forward(array("controller" => "index", "action" => "index"));
    }
}
