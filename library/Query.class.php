<?php
namespace library;

class Query { 
    /**
     * Query::insert()
     * 
     * @param String $table
     * @param Array $datas
     * @param Boolean $time
     * @return SQL_INSERT
     */
    public static function insert($table, $datas, $time = NULL) {
        global $db;
        
        // Query FIELDS
        $sql_fields = array();
        $sql_values = array();
        
        foreach($datas AS $field => $value) {
            $sql_fields[] = $field;
            $sql_values[] = ($value == 'NULL' && strlen($value) == 4 ? 'NULL' : '\''.$db->escape($value).'\'');
        }
        
        if($time)
        {
            $sql_fields[] = 'created_at';
            $sql_fields[] = 'updated_at';
            $sql_values[] = 'NOW()';
            $sql_values[] = 'NOW()';
        }
        
        return 'INSERT INTO '.$table.' ('.implode(', ', $sql_fields).') VALUES ('.implode(', ', $sql_values).')';
    }
    
    /**
     * Query::update()
     * 
     * @param String $table
     * @param Array $datas
     * @param Array $where
     * @param Boolean $time
     * @return SQL_UPDATE
     */
    public static function update($table, $datas, $where, $time = NULL) {
        global $db;
        
        if($time)
            $datas['updated_at'] = 'NOW()';
        
        // Query SET
        $sql_set = array();
        foreach($datas AS $field => $value)
            $sql_set[] = $field.' = '.($value == 'NULL' && strlen($value) == 4 ? 'NULL' : '\''.$db->escape($value).'\'');
        
        // Clause WHERE
        $sql_where = array();
        foreach($where AS $field => $value)
            $sql_where[] = $field.' = \''.$db->escape($value).'\'';
        
        return 'UPDATE '.$table.' SET '.implode(', ', $sql_set).' WHERE '.implode(' AND ', $sql_where);
    }
}
?>