<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PropertyAccess\PropertyAccess;


final class MeteoviewController extends AbstractController{
    public function __construct(
        private RequestStack $requestStack,
    ) {}
    #[Route('/meteoview/{cityName}',methods: ['GET', 'HEAD'] , name: 'app_meteoview')]
    public function meteoview(string|bool $cityName=false): Response{
        $cityList = ['toulouse','paris', 'marseille','lyon','bordeaux','strasbourg','nice','lille','rennes','perpignan','poitier','agen','rodez','orléan','metz','clermont-ferrand','auch','foix','tarbes'];
        $session = $this->requestStack->getSession();

        if(empty($session->get('setCity',''))){
            $session->set('setCity',[]);
        }
        
        try{
            //print_r($session->get($cityName));
            
            $accessor = PropertyAccess::createPropertyAccessor();
            $tempCity = $session->get($cityName,'');
            $header = [
                'Access-Control-Allow-Origin'=>'http://localhost'
            ];
            $property = (!empty($tempCity)?$accessor->getValue($tempCity, 'current_condition'):null);
            if(empty($tempCity) || strtotime($accessor->getValue($property,'date')) < date('d.m.Y')){
            //if(empty($tempCity) || strtotime($tempCity->get('current_condition.date')) < date('d.m.Y')){
                $url = 'https://prevision-meteo.ch/services/json/'.$cityName;
                $method = 'GET';
                $data = false;
                $curl = curl_init();
                switch ($method){
                    case "POST":
                        curl_setopt($curl, CURLOPT_POST, 1);
                        if ($data)
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                    case "PUT":
                        curl_setopt($curl, CURLOPT_PUT, 1);
                        break;
                    default:
                        if ($data)
                            $url = sprintf("%s?%s", $url, http_build_query($data));
                }
                curl_setopt($curl, CURLOPT_HTTPHEADER , array('Content-Type: application/json', 'Accept: application/json'));
                // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                // curl_setopt($curl, CURLOPT_USERPWD, "usernamcityNamee:password");

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                $result = json_decode(curl_exec($curl));
                curl_close($curl);
                

                if(empty($session->get($cityName,'')) && $result){
                    $session->set($cityName,$result);
                    $session->set('setCity', $cityName);
                }
            
            }

            $session->set('currentCity',$cityName);
            $query = [];   
            
            foreach($cityList as $city){
                if(!empty($session->get($city,''))){
                    $query[$city] = $session->get($city);
                }
            }
            $data = [
                'success' => true,
                'payload'=> [
                    'data' => $query,
                    'currentCity' => $session->get('currentCity',''),
                    'setCities' => $session->get('setCity','')
                ],
            ];
            $response = new JsonResponse($data);
            foreach($header as $key=>$value){
                $response->headers->set($key, $value);
            }
            
            return $response;
            
        }catch(EXCEPTION $error){
            die("<strong>Error curl</strong> : ".$error->getMessage());
        }
        
    }
}
