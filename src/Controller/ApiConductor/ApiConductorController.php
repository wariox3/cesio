<?php

namespace App\Controller\ApiConductor;


use App\Entity\Cupon;
use App\Entity\Operador;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ApiConductorController extends FOSRestController
{

    /**
     * @Rest\Get("/api/conductor/despacho/guias/{codigoDespacho}", name="api_conductor_despacho_guias")
     */
    public function guia(Request $request, $codigoDespacho)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);
        $em = $this->getDoctrine()->getManager();
        $arrCadena = explode("-", $codigoDespacho);
        if($arrCadena) {
            if(count($arrCadena) == 3) {
                $operador = $arrCadena[0];
                $arOperador = $em->getRepository(Operador::class)->find($operador);
                if($arOperador) {
                    $codigo = $arrCadena[1];
                    $token = $arrCadena[2];
                    $direccion = $arOperador->getUrlServicio();
                    //$direccion = "http://localhost/cromo/public/index.php";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $direccion . "/transporte/api/app/guia/despacho/$codigo/$token");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $response = curl_exec($ch);
                    $respuesta = json_decode($response, true);
                    return $respuesta;
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => 'No existe el operador'
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => 'La estructura del parametro es OP-NUMERO-TOKEN'
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => 'Faltan parametros para el consumo de la api'
            ];
        }


    }

    /**
     * @Rest\Get("/api/conductor/guia/entrega/{codigoOperador}/{codigoGuia}/{fecha}/{hora}/{usuario}", name="api_conductor_guia_entrega")
     */
    public function guiaEntrega(Request $request, $codigoOperador, $codigoGuia, $fecha, $hora, $usuario)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);
        $em = $this->getDoctrine()->getManager();
        $arOperador = $em->getRepository(Operador::class)->find($codigoOperador);
        $direccion = $arOperador->getUrlServicio();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $direccion . "/transporte/api/app/guia/entrega/$codigoGuia/$fecha/$hora/$usuario");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $respuesta = json_decode($response, true);
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/conductor/guia/captura/{codigoOperador}/{codigoGuia}", name="api_conductor_guia_captura")
     */
    public function guiaCaptura(Request $request, $codigoOperador, $codigoGuia)
    {

        /*
         *
         * Consumir esta api, ya gestiona toda la logica
         * interna solo es enviarle el body de este servicio al
         * servicio local crear el jpg en temporal y ya esta
         * el otro codigo
         *
         *
         *
         *
         */


        set_time_limit(0);
        ini_set("memory_limit", -1);
        $em = $this->getDoctrine()->getManager();
        $contenido = json_decode($request->getContent(), true);
        $strImagen = $contenido['imageString'];
        $Base64Img = base64_decode($strImagen);
        file_put_contents('/bandeja/unodepiera.jpg', $Base64Img);
        return ['hola' => $contenido];
    }

    /**
     * @Rest\Get("/api/conductor/guia/novedad/{codigoOperador}/{codigoGuia}/{fecha}/{hora}/{usuario}/{codigoNovedad}", name="api_conductor_guia_novedad")
     */
    public function guiaNovedad(Request $request, $codigoOperador, $codigoGuia, $fecha, $hora, $usuario, $codigoNovedad)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);
        $em = $this->getDoctrine()->getManager();
        $arOperador = $em->getRepository(Operador::class)->find($codigoOperador);
        $direccion = $arOperador->getUrlServicio();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $direccion . "/transporte/api/app/guia/novedad/$codigoGuia/$fecha/$hora/$usuario/$codigoNovedad");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $respuesta = json_decode($response, true);
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/conductor/despacho/ubicacion", name="api_conductor_despacho_ubicacion")
     */
    public function ubicacion(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $operador = $raw['operador'] ?? null;
            $arOperador = $em->getRepository(Operador::class)->find($operador);
            $direccion = $arOperador->getUrlServicio();
            $data_string = json_encode($raw);
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data_string,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST => 1,
                CURLOPT_URL => $url = $direccion . "/transporte/api/cesio/despacho/ubicacion",
                CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
            ]);
            $resp = json_decode(curl_exec($curl), true);
            curl_close($curl);
            return $resp;
        } catch (\Exception $e) {
            return [
                'error' => "Ocurrio un error en la api " . $e->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Post("/api/conductor/guia/cumplido", name="api_conductor_guia_cumplido")
     */
    public function cumplido(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $operador = $raw['operador'] ?? null;
            $arOperador = $em->getRepository(Operador::class)->find($operador);
            $direccion = $arOperador->getUrlServicio();
            $data_string = json_encode($raw);
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data_string,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST => 1,
                CURLOPT_URL => $url = $direccion . "/transporte/api/cesio/guia/entrega",
                CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
            ]);
            $resp = json_decode(curl_exec($curl), true);
            curl_close($curl);
            return $resp;
        } catch (\Exception $e) {
            return [
                'error' => "Ocurrio un error en la api " . $e->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Post("/api/novedadtipo/lista", name="api_novedadtipo_lista")
     */
    public function novedadLista(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $operador = $raw['operador'] ?? null;
            $arOperador = $em->getRepository(Operador::class)->find($operador);
            $direccion = $arOperador->getUrlServicio();
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST => 1,
                CURLOPT_URL => $url = $direccion . "/transporte/api/cesio/novedadtipo/lista"
            ]);
            $respuesta = json_decode(curl_exec($curl), true);
            curl_close($curl);
            return $respuesta;
        } catch (\Exception $e) {
            return [
                'error' => "Ocurrio un error en la api " . $e->getMessage(),
            ];
        }
    }

}
