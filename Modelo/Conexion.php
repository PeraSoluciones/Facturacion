<?php

namespace Facturacion\Modelo;

use mysqli;
use mysqli_stmt;
use ReflectionClass;

class Conexion
{
    private const SERVER = "localhost";
    private const USER = "root";
    private const PASSWORD = "";
    private const BDNAME = "Testing";
    private $mysqli;

    public function __construct()
    {
        $this->mysqli = new mysqli(self::SERVER, self::USER, self::PASSWORD, self::BDNAME);

        if ($this->mysqli->connect_errno) {
            echo "Error: falló al conectarse a MySQL debido a:\n";
            echo "Error: " . $this->mysqli->connect_errno . "\n";
            echo "Error: " . $this->mysqli->connect_error . "\n";
        } else {
            echo "Conexión exitosa!";
        }
    }

    public function insercionPreparada(string $query, array $param_enlazados)
    {
        $consulta = $this->ejecutarConsultaPreparada($query, $param_enlazados);
        $resultado_r = $consulta->affected_rows;
        $consulta->close();
        return $resultado_r;
    }

    public function seleccionPreparada(string $query, array $param_enlazados)
    {
        $seleccion = $this->ejecutarConsultaPreparada($query, $param_enlazados);
        $campos_r = $this->extraerCampos($seleccion);

        foreach ($campos_r as $campo) {
            $enlazar_resultado_r[] = &${$campo};
        }

        $this->enlazarResultados($seleccion, $enlazar_resultado_r);

        $resultado_r = array();
        $i = 0;
        while ($seleccion->fetch()) {
            foreach ($campos_r as $campo) {
                $resultado_r[$i][$campo] = $$campo;
            }
            $i++;
        }
        $seleccion->close();
        return $resultado_r;
    }

    public function ejecutarConsultaPreparada(string $query, array $param_enlazados)
    {
        $declaracion = $this->mysqli->prepare($query);
        $this->enlazarParametros($declaracion, $param_enlazados);

        if ($declaracion->execute()) {
            return $declaracion;
        } else {
            echo "Error en $declaracion: "
                . mysqli_error($this->mysqli);
            return 0;
        }
    }

    public function extraerCampos(mysqli_stmt $declaracionSelect)
    {
        $metadata = $declaracionSelect->result_metadata();
        $campos_r = array();
        while ($campo = $metadata->fetch_field()) {
            $campos_r[] = $campo->name;
        }

        return $campos_r;
    }

    public function enlazarParametros(mysqli_stmt &$objeto, array $param_enlazados)
    {
        // call_user_func_array(array($objeto, "bind_param"), $param_enlazados);
        $reflectionClass = new ReflectionClass($objeto);
        $method = $reflectionClass->getMethod('bind_param');
        $method->invokeArgs($objeto, $param_enlazados);
    }

    public function enlazarResultados(mysqli_stmt &$objeto, array &$resultados_enlazados)
    {
        // call_user_func_array(array($objeto, "bind_result"), $resultados_enlazados);
        $reflectionClass = new ReflectionClass($objeto);
        $method = $reflectionClass->getMethod('bind_result');
        $method->invokeArgs($objeto, $resultados_enlazados);
    }
}
