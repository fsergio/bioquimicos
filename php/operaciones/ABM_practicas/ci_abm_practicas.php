<?php
class ci_abm_practicas extends bioquimicos_ci {
	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(bioquimicos_ei_filtro $filtro) {
        if (isset($this->s__filtro)) {
            $filtro->set_datos($this->s__filtro);
        }
	}

	function evt__filtro__filtrar($datos) {
        $this->s__filtro = $datos;
	}

	function evt__filtro__cancelar() {
        unset($this->s__filtro);
	}

	//-----------------------------------------------------------------------------------
	//---- formulario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

    function conf__formulario(bioquimicos_ei_formulario $form) {
        if($this->dep('datos')->esta_cargada()) {
            $datos=$this->dep('datos')->get();
            $form->set_datos($datos);
        }
    }

    function evt__formulario__alta($datos) {
        $this->dep('datos')->set($datos);
        $this->dep('datos')->sincronizar();
        $this->dep('datos')->resetear();
    }

    function evt__formulario__modificacion($datos) {
        $this->dep('datos')->set($datos);
        $this->dep('datos')->sincronizar();
        $this->dep('datos')->resetear();
    }

    function evt__formulario__cancelar() {
        $this->dep('datos')->resetear();
    }

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(bioquimicos_ei_cuadro $cuadro) {
        if(isset($this->s__filtro)) {
            $where = $this->dep('filtro')->get_sql_where();
            $datos=toba::consulta_php('bioquimicos')->get_practicas($where);
        } else {
            $datos=toba::consulta_php('bioquimicos')->get_practicas();
        }
        $cuadro->set_datos($datos);
	}

    function evt__cuadro__eliminar($seleccion) {
        $this->dep('datos')->cargar($seleccion);
        try {
            $this->dep('datos')->eliminar_todo();
            $this->dep('datos')->sincronizar();
        }catch(toba_error_db $e) {
            if($e->get_sqlstate()=="db_23503"){
                toba::notificacion()->agregar('ATENCION! el registro no ha sido eliminado.');
            }else{
                toba::notificacion()->agregar('ERROR!! El registro no puede eliminarse.');
            }
            $this->dep('datos')->resetear();

        }
    }

    function evt__cuadro__seleccion($seleccion) {
        $this->dep('datos')->cargar($seleccion);
    }
}

?>