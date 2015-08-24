<?php
class GeneralRepository
{
    /**
     * Creates and executes an INSERT SQL statement for several rows.
     * 
     * Usage:
     * $rows = array(
     *      array('id' => 1, 'name' => 'John'),
     *      array('id' => 2, 'name' => 'Mark')
     * );
     * GeneralRepository::insertSeveral(User::model()->tableName(), $rows);
     * 
     * @param string $table the table that new rows will be inserted into.
     * @param array $array_columns the array of column datas array(array(name=>value,...),...) to be inserted into the table.
     * @return integer number of rows affected by the execution.
     */
    public static function insertSeveral($table, $array_columns)
    {
        $connection = Yii::app()->db;
        $sql = '';
        $params = array();
        $i = 0;
        foreach ($array_columns as $columns) {
            $names = array();
            $placeholders = array();
            foreach ($columns as $name => $value) {
                if (!$i) {
                    $names[] = $connection->quoteColumnName($name);
                }
                if ($value instanceof CDbExpression) {
                    $placeholders[] = $value->expression;
                    foreach ($value->params as $n => $v)
                        $params[$n] = $v;
                } else {
                    $placeholders[] = ':' . $name . $i;
                    $params[':' . $name . $i] = $value;
                }
            }
            if (!$i) {
                $sql = 'INSERT INTO ' . $connection->quoteTableName($table)
                . ' (' . implode(', ', $names) . ') VALUES ('
                . implode(', ', $placeholders) . ')';
            } else {
                $sql .= ',(' . implode(', ', $placeholders) . ')';
            }
            $i++;
        }
        //print_r($array_columns);
        //Yii::app()->end();
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($params);
    }
}
?>