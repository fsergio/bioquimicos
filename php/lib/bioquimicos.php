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
                       m.id_especialidad
                       FROM negocio.medicos_efectores m
                       $where order by 3";

        return toba::db()->consultar($sql);
    }

    function get_pacientes ($where=null) {
        $where = isset($where) ? "WHERE $where" : '';

        $sql = "SELECT
                p.id,
                p.descripcion,
                p.id_obra_social,
                p.numero,
                o.nombre,
                o.id
                FROM negocio.pacientes p
                inner join negocio.obra_social o
                on p.id_obra_social = o.id
                $where order by 3";

        return toba::db()->consultar($sql);
    }

    function get_orden_cabecera ($where=null) {
        $where = isset($where) ? "WHERE $where" : '';

        $sql = "SELECT 
                o.id, 
                o.fecha_recepcion,
                o.fecha_prescripcion,
                o.id_efector, 
                o.id_bioquimico, 
                o.id_diagnostico,
                o.nro_afiliado, 
                o.id_osocial,
                m.id as ide,
                m.nombre_apellido as nomape,
                b.id as idb,
                b.nombre_apellido as nomapeb,
                d.id as idd,
                d.descripcion as des,
                s.id as ids,
                s.nombre as nomobrasocial
                FROM negocio.orden_cabecera o
                inner join negocio.medicos_efectores m
                on o.id_efector = m.id
                inner join negocio.bioquimicos b
                on o.id_bioquimico = b.id 
                inner join negocio.diagnosticos d 
                on o.id_diagnostico = d.id
                inner join negocio.obra_social s 
                on o.id_osocial = s.id
                $where order by 3";

        return toba::db()->consultar($sql);
    }

    function get_orden_detalle ($where=null) {
        $where = isset($where) ? "WHERE $where" : '';

        $sql = "SELECT id, 
                id_cabecera, 
                id_practica, 
                cantidad
                FROM negocio.orden_detalle
                $where";

        return toba::db()->consultar($sql);
    }
}
?>
