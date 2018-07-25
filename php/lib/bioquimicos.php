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

        $sql = "SELECT id,
                codigo,
                descripcion
                FROM negocio.practicas
                $where order by 3";

        return toba::db()->consultar($sql);
    }

    function get_bioquimicos ($where=null) {
        $where = isset($where) ? "WHERE $where" : '';

        $sql = "SELECT b.id,
                b.matricula, 
                b.nombre_apellido, 
                b.direccion, 
                b.telefono, 
                b.mail, 
                b.id_especialidad, 
                e.id, 
                e.descripcion
                FROM negocio.bioquimicos b 
                inner join negocio.especialidades e 
                on b.id_especialidad = e.id
                $where order by 3";

        return toba::db()->consultar($sql);
    }

    function get_medicos_efectores ($where=null) {
        $where = isset($where) ? "WHERE $where" : '';

        $sql = "SELECT m.id, 
                       m.matricula, 
                       m.nombre_apellido, 
                       m.direccion, 
                       m.telefono, 
                       m.mail, 
                       m.id_especialidad, 
                       e.id, 
                       e.descripcion
                       FROM negocio.medicos_efectores m 
                       inner join negocio.especialidades e 
                       on  m.id_especialidad = e.id
                $where order by 3";

        return toba::db()->consultar($sql);
    }
}
?>
