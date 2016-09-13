<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    /**
     * Faz a requisição para o site sintegra.
     *
     * @return array
     */
    public function send(Request $request){
        $client = new Client();
        $res = $client->request('POST', 'http://www.sintegra.es.gov.br/resultado.php', [
            'form_params' => [
                'num_cnpj' => $request->num_cnpj//'31.804.115-0002-43',
            ]
        ]);
        //echo $res->getStatusCode();
        // "200"
        //var_dump($res->getHeader('content-type'));
        // 'application/json; charset=utf8'
        return $res->getBody();
        //return (preg_match("/(.*), (.*)/", $res->getBody(), $res));
    }
}
