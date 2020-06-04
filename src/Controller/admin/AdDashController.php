<?php

namespace App\Controller\admin;

use Symfony\Component\Routing\Annotation\Route;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unirest;

    /**
     * @Route("/admin")
     */
class AdDashController extends BaseController
{

    /**
     * @Route("/", name="admin.index", methods={"GET"})
     */
    public function index() 
    {
        return $this->render('admin/base.html.twig');
    }

    /**
     * @Route("/stats", name="admin.stats.show", methods={"POST"})
     */
    public function getStatistics(Request $request)
    {

    }

    /**
     * @Route("/setting", name="admin.setting.index")
     */
    public function settings(Request $request)
    {
        return $this->render("admin/settings/base.html.twig"); 
    }

    /**
     * @Route("/setting/show", name="admin.setting.show", methods={"POST"})
     */
    public function getData(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $content = $request->getContent();

            
            $params = json_decode($content, true);
            
            $token      = $params['tokenUser'];
            $userId     = $params['idUser'];
            $username   = $params['username'];
            $avatar     = $params['avatar'];
            $email      = $params['email'];

          

            $headers = array('Accept' => 'application/json', 'Authorization' => "Bearer $token");
            $query = array('avatar' => $avatar,'username' => $username, 'email' => $email);

            $url = "https://webradio-stream.herokuapp.com/authorized/users/$userId";
            $body = Unirest\Request\Body::form($query);

            $response = Unirest\Request::put($url,$headers,$body);
 
            $result = $response->raw_body; 
            return new Response($result, 201);
            
        }
    }

  
    /**
     * @Route("/setting/password", name="admin.passwordChange")
     */
    public function passwordChange(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $content = $request->getContent();

            $params = json_decode($content, true);
            $token = $params['token'];
            $userId = $params['idUser'];
            $password = $params['password'];

            $headers = array('Accept' => 'application/json', 'Authorization' => "Bearer $token");
            
            $query = array('password' => $password);
            $body = Unirest\Request\Body::form($query);

            $url = "https://webradio-stream.herokuapp.com/authorized/users/password/$userId";
 
            $response = Unirest\Request::put($url,$headers,$body);
 
          // $result = $response->raw_body; return $this->redirectToRoute('profile.setting.index');
            
          $result = $response->raw_body; 
          return new Response($result, 201);
            
        }
    }



}