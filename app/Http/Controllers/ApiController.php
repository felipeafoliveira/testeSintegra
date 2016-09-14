<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Sintegra;

class ApiController extends Controller
{
    /**
     * Faz a requisição para o site sintegra.
     *
     * @return array
     */
    public function send(Request $request){
        
        $url = 'http://www.sintegra.es.gov.br/resultado.php';
        //montando o array com os campos do form que serao enviados como parametro
        $campos = array(
                'num_cnpj' => utf8_encode($request->num_cnpj)//'31804115000243')
            );        
        //passando os campos para uma string
        //$string_campos = 'params=' . json_encode($campos);
        $postData = '';
        foreach($campos as $k => $v) 
        { 
           $postData .= $k . '='.$v.'&'; 
        }
        $postData = rtrim($postData, '&');
        $ch = curl_init();
        //configurando as opções da conexão curl
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postData);//$string_campos);	
        //este parâmetro diz que queremos resgatar o retorno da requisição
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
        //curl_setopt($ch,CURLOPT_HTTPHEADER, array(
        //    'Content-Type:  application/x-www-form-urlencoded',
        //    'Content-Length: 1')
        //);          
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION, true);
        //manda a requisição post
        $resultado = curl_exec($ch);	
        
        $info = curl_getinfo($ch); //informações da conexão
        
        $msgerro = "";
        
        if ($resultado === false){
            //não houve retorno
            $msgerro = curl_error($ch);
        }else{
            //verifica se o retorno aconteceu
            if($info['http_code']=='200'){
                //Simular dados da pagina de resultado
                $resultado = '
                <table border="0" class="resultado">
                    <tr>
                        <td class="cadastro">Cadastro atualizado até: 13/09/2016</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                                <tr>
                                    <td class="secao" colspan="4">
                                        IDENTIFICAÇÃO - PESSOA JURÍDICA            		</td>
                                </tr>
                                <tr>
                                    <td class="titulo" width="20%">&nbsp;CNPJ:</td>
                                    <td class="valor" width="30%">&nbsp;31.804.115/0002-43</td>
                                    <td class="titulo" width="25%" align="center">Inscrição Estadual:</td>
                                    <td class="valor">&nbsp;082.254.28-1</td>
                                </tr>
                                <tr>
                                    <td width="20%" class="titulo">&nbsp;Razão Social :</td>
                                    <td class="valor" colspan="3">&nbsp;CEREAIS DO NICO LTDA</td>
                                </tr>
                            </table>
                
                            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                                <tr>
                                    <td class="secao" colspan="4">
                                        ENDEREÇO
                                    </td>
                                </tr>
                                <tr>
                                    <td class="titulo" width="20%">&nbsp;Logradouro:</td>
                                    <td class="valor" colspan="3">&nbsp;RUA IPE</td>
                                </tr>
                                <tr>
                                    <td class="titulo" width="20%">&nbsp;Número:</td>
                                    <td class="valor" width="15%">&nbsp;10</td>
                                    <td class="titulo" width="20%">&nbsp;Complemento:</td>
                                    <td class="valor">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="titulo" width="20%">&nbsp;Bairro:</td>
                                    <td class="valor" colspan="3">&nbsp;MOVELAR</td>
                                </tr>
                                <tr>
                                    <td class="titulo" width="20%">&nbsp;Município:</td>
                                    <td class="valor" width="15%">&nbsp;LINHARES</td>
                                    <td class="titulo">&nbsp;UF:</td>
                                    <td class="valor">&nbsp;ES</td>
                                </tr>
                                <tr>
                                    <td class="titulo" width="20%">&nbsp;CEP:</td>
                                    <td width="30%" class="valor">&nbsp;29906-120</td>
                                    <td width="20%" class="titulo">&nbsp;Telefone:</td>
                                    <td width="30%" class="valor">&nbsp;        </td>
                                </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                                <tr>
                                    <td class="secao">INFORMAÇÕES COMPLEMENTARES</td>
                                </tr>
                                <tr>
                                    <td class="titulo" width="40%" align="right">Atividade Econômica:&nbsp;</td>
                                    <td class="valor" width="60%">COMERCIO ATACADISTA DE CEREAIS E LEGUMINOSAS BENEFICIADAS</td>
                                </tr>
                                <tr>
                                    <td class="titulo" width="40%" align="right">Data de Inicio de Atividade:&nbsp;</td>
                                    <td class="valor">26/03/2004</td>
                                </tr>
                                <tr>
                                    <td class="titulo" width="40%" align="right">Situação Cadastral Vigente:&nbsp;</td>
                                    <td class="valor">HABILITADO</td>
                                </tr>
                                <tr>
                                    <td class="titulo" width="40%" align="right">Data desta Situação Cadastral:&nbsp;</td>
                                    <td class="valor">26/03/2004</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                ';
                preg_match("'<table border=\"0\" class=\"resultado\">(.*?)</table>'si", $resultado, $tabelaLogin);
                $json = "";
                //verifica se existe a tabela de resultados para pegar as informacoes
                if($tabelaLogin){
                    $celulasCampos = array_slice(preg_split('/(?:<\/td>\s*|)<td[^>]*class=\"titulo\"[^>]*>/iu', $resultado), 1);                    
                    foreach($celulasCampos as $campos){
                        $strCampo = str_replace("&nbsp;", "", $campos);
                        preg_match("'(.*?):'si", $strCampo, $arrayCampo);
                        $campo = $arrayCampo[1];
                        $celulasValores = array_slice(preg_split('/(?:<\/td>\s*|)<td[^>]*class=\"valor\"[^>]*>/iu', $strCampo), 1);
                        foreach($celulasValores as $valores){
                            if(strpos($valores,"<")!==false){
                                preg_match("'(.*?)<'si", $valores, $arrayValor);
                            }else{
                                $arrayValor[1] = $valores;
                            }
                            $json .= '"'.addslashes(str_replace('"','',$campo)).'":"'.addslashes(str_replace('"','',$arrayValor[1])).'",';
                        }
                        
                    }
                    $json = "{".substr($json, 0, -1)."}";
                }else{
                    $json = "Não foi possível fazer a conexão com esse CNPJ";
                }
            }
            
        }        
        curl_close($ch);
        $sintegra = new Sintegra;
        $sintegra->user_id = Auth::user()->id;
        $sintegra->cnpj = $request->num_cnpj;
        $sintegra->resultado_json = !empty($msgerro) ? $msgerro : $json;
        $sintegra->save();
        
        return redirect('/sintegra');
    }
}
