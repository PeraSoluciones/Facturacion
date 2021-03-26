<?php

namespace Facturacion\Controlador;

use Facturacion\Helper\Util;

use Error;

class ControladorUsuario
{

    function __get($name)
    {
        if (!property_exists($this, $name)) {
            throw new Error("Propiedad: {$name} no existe");
        }

        return $this->{$name};
    }

    public function obtenerUsuarioPorId(int $id)
    {
        $consulta = "SELECT * FROM usuario WHERE id = ?";
        $conexion = new \Facturacion\Modelo\Conexion();
        $param_enlazados = Util::valoresReferencia(array("i", $id));
        $resultado = $conexion->seleccionPreparada($consulta, $param_enlazados);
        return $resultado;
    }
}
