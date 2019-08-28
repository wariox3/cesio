<?php

namespace App\Controller\ApiConductor;


use App\Entity\Operador;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ApiConductorController extends FOSRestController
{
    /**
     * @Rest\Get("/api/conductor/autenticar/{usuario}/{clave}", name="api_conductor_autenticar")
     */
    public function autenticar(Request $request, $usuario, $clave)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);
        $em = $this->getDoctrine()->getManager();

        $arUsuario = $em->getRepository(Usuario::class)->findOneBy(array('usuario'=> $usuario, 'clave' => $clave));
        if($arUsuario) {
            return [
                'autenticar' => true,
                'operador' => $arUsuario->getCodigoOperadorFk(),
                'mensaje' => "Correcto"
            ];
        } else {
            return [
                'autenticar' => false,
                'mensaje' => "Datos errados"
            ];
        }
    }

    /**
     * @Rest\Get("/api/conductor/despacho/guias/{codigoOperador}/{codigoDespacho}", name="api_conductor_despacho_guias")
     */
    public function guia(Request $request, $codigoOperador, $codigoDespacho)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);
        $em = $this->getDoctrine()->getManager();
        $arOperador =$em->getRepository(Operador::class)->find($codigoOperador);
        $direccion = $arOperador->getUrlServicio();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $direccion . "/transporte/api/app/guia/despacho/$codigoDespacho");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $arrGuias = json_decode($response, true);
        if($arrGuias['error']) {
            return [];
        } else {
            return $arrGuias['guias'];
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
        $arOperador =$em->getRepository(Operador::class)->find($codigoOperador);
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
        $contenido = json_decode($request->getContent(),true);
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
        $arOperador =$em->getRepository(Operador::class)->find($codigoOperador);
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
     * @Rest\Get("/api/conductor/monitoreo/registro/{codigoOperador}/{codigoDespacho}/{latitud}/{longitud}/{usuario}", name="api_conductor_monitoreo_registro")
     */
    public function monitoreoRegistro(Request $request, $codigoOperador, $codigoDespacho, $latitud, $longitud, $usuario)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);
        $em = $this->getDoctrine()->getManager();
        $arOperador =$em->getRepository(Operador::class)->find($codigoOperador);
        $direccion = $arOperador->getUrlServicio();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $direccion . "/transporte/api/app/monitoreo/registro/$codigoDespacho/$latitud/$longitud");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $respuesta = json_decode($response, true);
        return $respuesta;
    }

    /**
     * @Rest\Get("/api/conductor/guia/cumplido", name="api_conductor_guia_cumplido")
     */
    public function guiaDetalle(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $operador = $raw['operador'];
            $guia = $raw['guia'];
            $imagen = $raw['imageString'];
            $Base64Img = base64_decode($imagen);
            file_put_contents('/temporal/prueba.jpg', $Base64Img);

            return ['estado' => 'ok'];
        } catch (\Exception $e) {
            return [
                'error' => "Ocurrio un error en la api " . $e->getMessage(),
            ];
        }
    }

}
