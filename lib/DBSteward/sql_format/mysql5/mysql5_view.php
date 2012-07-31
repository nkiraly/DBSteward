<?php
/**
 * Manipulate view node
 *
 * @package DBSteward
 * @subpackage mysql5
 * @license http://www.opensource.org/licenses/bsd-license.php Simplified BSD License
 * @author Austin Hyde <austin109@gmail.com>
 */

class mysql5_view extends sql99_view {
  public static function get_creation_sql($node_schema, $node_view) {
    if ( isset($node_view['description']) && strlen($node_view['description']) > 0 ) {
      $ddl = "-- {$node_view['description']}\n";
    }

    $view_name = mysql5::get_fully_qualified_table_name($node_schema['name'],$node_view['name']);

    $ddl = "CREATE OR REPLACE VIEW $view_name\n";
    $ddl.= "  AS " . static::get_view_query($node_view) . ";\n";

    // @TODO: Implement as DEFINER = ____
    // if ( isset($node_view['owner']) && strlen($node_view['owner']) > 0 ) {
    //   $ddl .= "ALTER VIEW " . $view_name
    //     . "\n\tOWNER TO " . xml_parser::role_enum(dbsteward::$new_database, $node_view['owner']) . ";\n";
    // }

    return $ddl;
  }

  public static function get_drop_sql($node_schema, $node_view) {
    return "DROP VIEW IF EXISTS " . mysql5::get_fully_qualified_table_name($node_schema['name'], $node_view['name']) . ";\n";
  }
}