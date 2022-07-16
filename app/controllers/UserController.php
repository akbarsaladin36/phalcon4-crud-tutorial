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

        $response = new Response();
        if($this->session->get('user')) {
            $user = User::find();
    
            $result = [
                'code' => 200,
                'response' => 'Success',
                'message' => 'All users is succesfully appeared!',
                'data' => $user
            ];
    
            return $response->setJsonContent($result);
        } else {
            $result = [
                'code' => 400,
                'response' => 'Not Authenticated',
                'message' => 'You must logged in if you want to access!',
                'data' => null
            ];

            $response->setStatusCode(400,'Not Authenticated');
            return $response->setJsonContent($result);
        }

    }

    public function storeAction()
    {
        $this->view->disable();

        $request = $this->request->getJsonRawBody();
        $response = new Response();

        if($this->session->get('user')) {
            $user = new User;
            $user->user_username = $request->username;
            $user->user_password = $this->security->hash($request->password);
            $user->user_email = $request->email;
            $user->save();
    
            $result = [
                'code' => 200,
                'response' => 'Success',
                'message' => 'A new user is succesfully registered!',
                'data' => $user
            ];
    
            $response->setStatusCode(200,'Success');
            return $response->setJsonContent($result);
        } else {
            $result = [
                'code' => 400,
                'response' => 'Not Authenticated',
                'message' => 'You must logged in if you want to access!',
                'data' => null
            ];
            $response->setStatusCode(400,'Not Authenticated');
            return $response->setJsonContent($result);
        }
    }

    public function showAction($id)
    {
        $this->view->disable(); // Untuk menonaktifkan view
        
        $response = new Response();

        if($this->session->get('user')) {
            $user = User::findFirst([
                'conditions' => 'user_id = :id:',
                'bind' => [
                    'id' => $id
                ]
            ]);

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
        } else {
            $result = [
                'code' => 400,
                'response' => 'Not Authenticated',
                'message' => 'You must logged in if you want to access!',
                'data' => null
            ];
            $response->setStatusCode(400,'Not Authenticated');
            return $response->setJsonContent($result);
        }

        // var_dump($user);die();
    }

    public function updateAction($id) {
        $this->view->disable();

        $request = $this->request->getJsonRawBody();
        $response = new Response();

        if($this->session->get('user')) {
            $user = User::findFirst([
                'conditions' => 'user_id = :id:',
                'bind' => [
                    'id' => $id
                ]
            ]);
    
            if($user !== NULL) {
                $user->user_email = $request->email;
                $user->user_first_name = $request->first_name;
                $user->user_last_name = $request->last_name;
                $user->save();
                
                $result = [
                    'code' => 200,
                    'response' => 'Success',
                    'message' => 'Your profile with user '.$id.' is succesfully updated!',
                    'data' => $user
                ];
    
                $response->setStatusCode(200,'Success');
                return $response->setJsonContent($result);
            } else {
                $result = [
                    'code' => 400,
                    'response' => 'Failed',
                    'message' => 'Your profile with user '.$id.' is not found! Please try again!',
                    'data' => null
                ];
    
                $response->setStatusCode(400,'Not Found');
                return $response->setJsonContent($result);
            }
        } else {
            $result = [
                'code' => 400,
                'response' => 'Not Authenticated',
                'message' => 'You must logged in if you want to access!',
                'data' => null
            ];
            $response->setStatusCode(400,'Not Authenticated');
            return $response->setJsonContent($result);
        }
    }

    public function deleteAction($id) {
        $this->view->disable();

        $response = new Response();

        if($this->session->get('user')) {
            $user = User::findFirst([
                'conditions' => 'user_id = :id:',
                'bind' => [
                    'id' => $id
                ]
            ]);
    
            if($user !== NULL) {
                $user->delete();
    
                $result = [
                    'code' => 200,
                    'response' => 'Success',
                    'message' => 'Your profile with user '.$id.' is succesfully deleted!',
                    'data' => null
                ];
    
                $response->setStatusCode(200,'Success');
                return $response->setJsonContent($result);
            } else {
                $result = [
                    'code' => 400,
                    'response' => 'Failed',
                    'message' => 'Your profile with user '.$id.' is not found! Please try again!',
                    'data' => null
                ];
    
                $response->setStatusCode(400,'Not Found');
                return $response->setJsonContent($result);
            }
        } else {
            $result = [
                'code' => 400,
                'response' => 'Not Authenticated',
                'message' => 'You must logged in if you want to access!',
                'data' => null
            ];
            $response->setStatusCode(400,'Not Authenticated');
            return $response->setJsonContent($result);
        }
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

