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
}
?>
<!--function get_obras_sociales ($where=null)-->
<!--{-->
<!--$where = isset($where) ? " WHERE $where " : '';-->
<!---->
<!--$sql = "SELECT 	id,-->
<!--siglas,-->
<!--nombre,-->
<!--direccion,-->
<!--telefono,-->
<!--mail,-->
<!--contacto-->
<!--FROM negocio.obra_social-->
<!--$where ORDER BY 3";-->
<!--return toba::db()->consultar($sql);-->
<!---->
<!--}-->
