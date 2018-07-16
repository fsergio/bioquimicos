<?php
/**
 * Esta clase fue y será generada automáticamente. NO EDITAR A MANO.
 * @ignore
 */
class bioquimicos_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'bioquimicos_comando' => 'extension_toba/bioquimicos_comando.php',
		'bioquimicos_modelo' => 'extension_toba/bioquimicos_modelo.php',
		'bioquimicos_ci' => 'extension_toba/componentes/bioquimicos_ci.php',
		'bioquimicos_cn' => 'extension_toba/componentes/bioquimicos_cn.php',
		'bioquimicos_datos_relacion' => 'extension_toba/componentes/bioquimicos_datos_relacion.php',
		'bioquimicos_datos_tabla' => 'extension_toba/componentes/bioquimicos_datos_tabla.php',
		'bioquimicos_ei_arbol' => 'extension_toba/componentes/bioquimicos_ei_arbol.php',
		'bioquimicos_ei_archivos' => 'extension_toba/componentes/bioquimicos_ei_archivos.php',
		'bioquimicos_ei_calendario' => 'extension_toba/componentes/bioquimicos_ei_calendario.php',
		'bioquimicos_ei_codigo' => 'extension_toba/componentes/bioquimicos_ei_codigo.php',
		'bioquimicos_ei_cuadro' => 'extension_toba/componentes/bioquimicos_ei_cuadro.php',
		'bioquimicos_ei_esquema' => 'extension_toba/componentes/bioquimicos_ei_esquema.php',
		'bioquimicos_ei_filtro' => 'extension_toba/componentes/bioquimicos_ei_filtro.php',
		'bioquimicos_ei_firma' => 'extension_toba/componentes/bioquimicos_ei_firma.php',
		'bioquimicos_ei_formulario' => 'extension_toba/componentes/bioquimicos_ei_formulario.php',
		'bioquimicos_ei_formulario_ml' => 'extension_toba/componentes/bioquimicos_ei_formulario_ml.php',
		'bioquimicos_ei_grafico' => 'extension_toba/componentes/bioquimicos_ei_grafico.php',
		'bioquimicos_ei_mapa' => 'extension_toba/componentes/bioquimicos_ei_mapa.php',
		'bioquimicos_servicio_web' => 'extension_toba/componentes/bioquimicos_servicio_web.php',
	);
}
?>