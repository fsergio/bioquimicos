<?php
class bioquimicos {

    function get_obras_sociales($where=null) {
        $where = isset($where) ? "WHERE $where" : '';

        $sql = " select id,
                siglas,
                nombre,
                direccion,
                telefono,
                mail,
                contacto
                from negocio.obra_social
                $where order by 3";

        return toba::db()->consultar($sql);
    }

    function get_especialidades ($where=null) {
        $where = isset($where) ? "WHERE $where" : '';

        $sql = "  select id, 
                  descripcion
                  from negocio.especialidades
                  $where order by 2";

        return toba::db()->consultar($sql);
    }

    function get_diagnosticos ($where=null) {
        $where = isset($where) ? "WHERE $where" : '';

        $sql = "  select id, 
                  codigo,
                  descripcion
                  from negocio.diagnosticos
                  $where order by 3";

        return toba::db()->consultar($sql);
    }

    function get_practicas ($where=null) {
        $where = isset($where) ? "WHERE $where" : '';

        $sql = "select id, 
                codigo, 
                descripcion
                from negocio.practicas
                $where order by 3";

        return toba::db()->consultar($sql);
    }
}
?>
