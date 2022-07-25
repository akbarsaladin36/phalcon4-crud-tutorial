<?php
declare(strict_types=1);

use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Security;

class AuthController extends \Phalcon\Mvc\Controller
{

    public function registerAction()
    {
        $this->view->disable();

        $request = $this->request->getJsonRawBody();

        $user = new User;
        $user->user_username = $request->username;
        $user->user_password = $this->security->hash($request->password);
        $user->save();

        $response = new Response();
        $result = [
            'code' => 200,
            'response' => 'Success',
            'message' => 'Success registered user!',
            'data' => $user
        ];

        // return json_encode($result); --> ini menggunakan metode PHP untuk menampilkan JSON

        // menggunakan function dari Phalcon untuk menampilkan hasil bentuk JSON
        return $response->setJsonContent($result);
    }

    public function loginAction()
    {
        $this->view->disable();

        $credentials = $this->request->getJsonRawBody();
        $response = new Response();

        $username = $credentials->username;
        $password = $credentials->password;

        // $user = User::findFirst("user_username = '$username'");

        $user = User::findFirst([
            'conditions' => 'user_username = :username:',
            'bind' => [
                'username' => $username
            ]
        ]);

        // var_dump($user);die();

        if($user !== NULL) {
            $checkPassword = $this->security->checkHash($password, $user->user_password);
            if($checkPassword === true) {
                $this->session->set('user', [
                    'user_id' => $user->user_id,
                    'user_username' => $user->user_username
                ]);
                $result = [
                    'code' => 200,
                    'response' => 'Success',
                    'message' => 'Your username is succesfully login!',
                    'data' => $user
                ];
                $response->setStatusCode(200,'Success');
                return $response->setJsonContent($result);
            } else {
                $result = [
                    'code' => 400,
                    'response' => 'Failed',
                    'message' => 'Your password is not match. Please type your correct password!',
                    'data' => null
                ];
                $response->setStatusCode(400,'Password Mismatched');
                return $response->setJsonContent($result);
            }
        } else {
            // echo 'Your username is not registered. Please register a new user now!';
            $result = [
                'code' => 400,
                'response' => 'Failed',
                'message' => 'Your username is not registered. Please register a new user now!',
                'data' => null
            ];
            $response->setStatusCode(400,'Not Found');
            return $response->setJsonContent($result);
        }
    }

    public function logoutAction()
    {
        $this->view->disable();

        $this->session->destroy();

        echo 'Logout Successful!';
    }

}

