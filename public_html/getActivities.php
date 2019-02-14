<?php
    public function getactual() {
        $strSelect = "SELECT a.*, s.vcFriendlyName FROM mh_activity a " .
                        "LEFT JOIN mh_subject s " .
                        "ON a.vcSubject = s.vcName " .
                        "WHERE daTime > UNIX_TIMESTAMP() " .
                        "ORDER BY a.daTime LIMIT 16";
        return $this->db->_fetch_array($strSelect);
    }


    echo json_encode($a->getactual());
?>