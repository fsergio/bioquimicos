<?php
class ci_abm_obras_sociales extends bioquimicos_ci
{
	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(bioquimicos_ei_filtro $filtro)
	{
        if (isset($this->s__filtro)) {
            $filtro->set_datos($this->s__filtro);
        }
    }

	function evt__filtro__filtrar($datos)
	{
        $this->s__filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
        unset($this->s__filtro);
    }

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(bioquimicos_ei_cuadro $cuadro)
	{
        if(isset($this->s__filtro)){
            $where = $this->dep('filtro')->get_sql_where();
            $datos=toba::consulta_php('bioquimicos')->get_paises($where);
        }
        else{
            $datos=toba::consulta_php('bioquimicos')->get_paises();
        }
        $cuadro->set_datos($datos);
    }

	function evt__cuadro__seleccion($seleccion)
	{
        $this->dep('datos')->cargar($seleccion);
    }

	function conf_evt__cuadro__seleccion(toba_evento_usuario $evento, $fila)
	{
	}

	//-----------------------------------------------------------------------------------
	//---- formulario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__formulario(bioquimicos_ei_formulario $form)
	{
        if($this->dep('datos')->esta_cargada()){
            $datos=$this->dep('datos')->get();
            $form->set_datos($datos);
        }
    }

	function evt__formulario__alta($datos)
	{
        $this->dep('datos')->set($datos);
        $this->dep('datos')->sincronizar();
        $this->dep('datos')->resetear();
	}

	function evt__formulario__baja()
	{

	}

	function evt__formulario__modificacion($datos)
	{
	}

	function evt__formulario__cancelar()
	{
        $this->dep('datos')->resetear();
	}

}

?>