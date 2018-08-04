<?php
class ci_ordenes_cabecera extends bioquimicos_ci {
    protected $s__filtro;


    function tabla($id) {
        return $this->dep('datos')->tabla($id);
    }
    //-----------------------------------------------------------------------------------
    //---- Configuraciones --------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    /**
     * Ventana de extensión para configurar la pantalla. Se ejecuta previo a la configuración de los componentes pertenecientes a la pantalla
     * por lo que es ideal por ejemplo para ocultarlos en base a una condición dinámica, ej. $pant->eliminar_dep("tal")
     * @param toba_ei_pantalla $pantalla
     */
    function conf__pant_inicial(toba_ei_pantalla $pantalla) {

    }

    /**
     * Ventana de extensión para configurar la pantalla. Se ejecuta previo a la configuración de los componentes pertenecientes a la pantalla
     * por lo que es ideal por ejemplo para ocultarlos en base a una condición dinámica, ej. $pant->eliminar_dep("tal")
     * @param toba_ei_pantalla $pantalla
     */
    function conf__pant_edicion(toba_ei_pantalla $pantalla) {
        $hay_cambios = $this->dep('datos')->hay_cambios();
        toba::menu()->set_modo_confirmacion('Esta a punto de abandonar la operacion sin grabar, Desea continuar?', $hay_cambios);

    }

    //-----------------------------------------------------------------------------------
    //---- Eventos ----------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    /**
     * Atrapa la interacción del usuario a través del botón asociado. El método no recibe parámetros
     */
    function evt__agregar() {
        $this->dep('datos')->resetear();
        $this->set_pantalla('pant_edicion');
    }

    /**
     * Originalmente este método limpia las variables y definiciones del componente, y en caso de exisitr un CN asociado ejecuta su cancelar. Para mantener este comportamiento llamar a parent::evt__cancelar
     */
    function evt__cancelar() {
        $this->dep('datos')->resetear();
        unset($this->s__filtro);
        $this->set_pantalla('pant_inicial');
    }

    /**
     * Atrapa la interacción del usuario a través del botón asociado. El método no recibe parámetros
     */
    function evt__guardar() {
        $this->dep('datos')->persistidor()->desactivar_transaccion();
        toba::db()->abrir_transaccion();

        try{
            $this->dep('datos')->sincronizar();
            toba::db()->cerrar_transaccion();

        }catch (toba_error_db $e){
            toba::db()->abortar_transaccion();
            toba::logger()->error('Error de la Base');
            $mensaje_usuario='ERROR al guardar. Los cambios NO fueron registrados.';
            $mensaje='<br><br>Información Adicional: ';
            $mensaje.='<br><strong>Error Nº </strong>'.$e->get_sqlstate();
            $mensaje.='<br><br><strong> Mensaje: </strong>'.$e->get_mensaje_motor();
            throw new toba_error($mensaje_usuario,$mensaje);
        }

        $this->set_pantalla('pant_inicial');
    }

    //-----------------------------------------------------------------------------------
    //---- cuadro -----------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    /**
     * Permite cambiar la configuración del cuadro previo a la generación de la salida
     * El formato de carga es de tipo recordset: array( array('columna' => valor, ...), ...)
     */
    function conf__cuadro(bioquimicos_ei_cuadro $cuadro) {

        if(isset($this->s__filtro)){
            $where = $this->dep('filtro')->get_sql_where();
            $datos = toba::consulta_php('bioquimicos')->get_orden_cabecera($where);
            $cuadro->set_datos($datos);

        }else{
            $datos = toba::consulta_php('bioquimicos')->get_orden_cabecera();
            $cuadro->set_datos($datos);

        }
    }

    /**
     * Atrapa la interacción del usuario con el botón asociado
     * @param array $seleccion Id. de la fila seleccionada
     */
    function evt__cuadro__seleccion($seleccion) {

        $this->dep('datos')->cargar($seleccion);
        $this->set_pantalla('pant_edicion');
    }

    /**
     * Atrapa la interacción del usuario con el botón asociado
     * @param array $seleccion Id. de la fila seleccionada
     */
    function evt__cuadro__eliminar($seleccion) {
        try{
            $this->dep('datos')->cargar($seleccion);
            $this->dep('datos')->eliminar_todo();
        }catch (toba_error_db $e) {
            if($e->get_sqlstate()=="db_23503"){
                toba::notificacion()->agregar('ATENCION!! El registro No será eliminado para mantener la integridad de los datos.');
            }else{
                toba::notificacion()->agregar('El registro no puede borrarse: '.$e->get_sqlstate() );
            }
        }
    }

    //-----------------------------------------------------------------------------------
    //---- formulario -------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    /**
     * Permite cambiar la configuración del formulario previo a la generación de la salida
     * El formato del carga debe ser array(<campo> => <valor>, ...)
     */
    function conf__formulario(bioquimicos_ei_formulario $form)
    {
        $form->set_datos($this->tabla('orden_cabecera')->get());
    }

    /**
     * Atrapa la interacción del usuario con el botón asociado
     * @param array $datos Estado del componente al momento de ejecutar el evento. El formato es el mismo que en la carga de la configuración
     */
    function evt__formulario__modificacion($datos)
    {
        $this->tabla('orden_cabecera')->set($datos);
    }

    //-----------------------------------------------------------------------------------
    //---- ml_mails ---------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    /**
     * Permite cambiar la configuración del ML previo a la generación de la salida
     * El formato debe ser una matriz array('id_fila' => array('id_ef' => valor, ...), ...)
     */
    function conf__ml_detalles(bioquimicos_ei_formulario_ml $form_ml)
    {
        $datos=$this->tabla('orden_detalle')->get_filas();
        $form_ml->set_datos($datos);

    }

    /**
     * Atrapa la interacción del usuario con el botón asociado
     * @param array $seleccion Id. de la fila seleccionada
     */
    function evt__ml_detalles__modificacion($seleccion)
    {
        $this->tabla('orden_detalle')->procesar_filas($seleccion);
        $this->dep('ml_detalles')->limpiar_interface();
    }



}
?>