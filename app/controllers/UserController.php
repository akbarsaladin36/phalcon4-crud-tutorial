<?php
declare(strict_types=1);

use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Security;

class UserController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $this->view->disable();
        
        $user = User::find();

        $response = new Response();

        $result = [
            'code' => 200,
            'response' => 'Success',
            'message' => 'All users is succesfully appeared!',
            'data' => $user
        ];

        return $response->setJsonContent($result);

    }

    public function showAction($id)
    {
        $this->view->disable(); // Untuk menonaktifkan view

        $user = User::findFirst([
            'conditions' => 'user_id = :id:',
            'bind' => [
                'id' => $id
            ]
        ]);

        $response = new Response();

        if($user !== NULL) {
            // echo 'OK!';
            $result = [
                'code' => 200,
                'response' => 'Success',
                'message' => 'The user with id '.$id.' data is succesfully appeared!',
                'data' => $user
            ];

            $response->setStatusCode(200,'Success');
            return $response->setJsonContent($result);
        } else {
            $result = [
                'code' => 400,
                'response' => 'Failed',
                'message' => 'The user with id '.$id.' data is not found!',
                'data' => null
            ];

            $response->setStatusCode(400,'Not Found');
            return $response->setJsonContent($result);
        }

        // var_dump($user);die();
    }

    public function updateAction($id) {

    }

    public function deleteAction($id) {
        
    }

    public function testingSessionAction()
    {
        $this->view->disable();
        $response = new Response();

        $user_session = $this->session->get('user');

        if($user_session !== NULL) {
            $result = [
                'data' => $user_session
            ];
            return $response->setJsonContent($result);
        } else {
            $result = [
                'message' => 'no active session',
                'data' => null
            ];
            return $response->setJsonContent($result);
        }

        // var_dump($this->session->get('user'));die();
    }

}

