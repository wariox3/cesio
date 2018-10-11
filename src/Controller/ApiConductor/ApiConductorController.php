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
            return null;
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

        set_time_limit(0);
        ini_set("memory_limit", -1);
        $em = $this->getDoctrine()->getManager();
        $contenido = json_decode($request->getContent(),true);
        $strImagen = $contenido['imageString'];
        $Base64Img = base64_decode($strImagen);
        file_put_contents('/bandeja/unodepiera.jpg', $Base64Img);
        return ['hola' => $contenido];
    }

}
