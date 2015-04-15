<?php
    /*-------------------------------------------------------+
    | PHP-Fusion Content Management System Version 8
    | Copyright (C) 2002 - 2013 Nick Jones
    | http://www.php-fusion.co.uk/
    +--------------------------------------------------------+
    | Project File: Advanced SQL Handling Methods Functions API
    | Filename: sqlhandler.inc.php
    | Author: PHP-Fusion 8 Development Team
    | Coded by : Frederick MC Chan (Hien)
    | Version : 8.1.6 (please update every commit)
    +--------------------------------------------------------+
    | This program is released as free software under the
    | Affero GPL license. You can redistribute it and/or
    | modify it under the terms of this license which you
    | can read by viewing the included agpl.txt or online
    | at www.gnu.org/licenses/agpl.html. Removal of this
    | copyright header is strictly prohibited without
    | written permission from the original author(s).
    +--------------------------------------------------------*/

    // Hierarchies
    function dbquery_tree($db, $id_col, $cat_col, $filter=false, $filter_order=false, $filter_show=false) {
        $data = array();
        $index = array();
        //$ordering = "ORDER BY $id_col ASC, $cat_col ASC";
        //$filter_orders = ($filter_order && $ordering) ? ", $filter_order" : "$filter_order";
        $filter_order = ($filter_order) ? "ORDER BY $filter_order" : '';
        $query = dbquery("SELECT $id_col, $cat_col FROM ".$db." $filter $filter_order $filter_show"); // mysql_query("SELECT id, parent_id, name FROM categories ORDER BY name");
        //print_p("SELECT $id_col, $cat_col FROM ".$db." $filter ORDER BY $filter_order $filter_show");
        while ($row = dbarray($query)) {
            $id = $row[$id_col];
            $parent_id = $row[$cat_col] === NULL ? "NULL" : $row[$cat_col];
            $index[$parent_id][] = $id;
        }
        return $index;
    }
    function dbquery_tree_data($db, $id_col, $cat_col, $filter=false, $filter_order=false, $filter_show=false) {
        $data = array();
        $index = array();
        //$ordering = "ORDER BY $id_col ASC, $cat_col ASC";
        //$filter_order = ($filter_order && $ordering) ? ", $filter_order" : "$filter_order";
        $filter_order = ($filter_order) ? "ORDER BY $filter_order" : '';
        $query = dbquery("SELECT * FROM ".$db." $filter $filter_order $filter_show"); // mysql_query("SELECT id, parent_id, name FROM categories ORDER BY name");
        while ($row = dbarray($query)) {
            $id = $row[$id_col];
            $data[$id] = $row;
        }
        return $data;
    }

    function dbquery_tree_full($db, $id_col, $cat_col, $sql_cond=false, $array=false) {
        $data = array();
        $index = array();
        if (!is_array($array)) {
            $query = "SELECT * FROM ".$db." $sql_cond";
        } else {
            $query = array_key_exists("query", $array) && $array['query'] ? $array['query'] : '';
        }
        $query = dbquery($query); // mysql_query("SELECT id, parent_id, name FROM categories ORDER BY name");
        while ($row = dbarray($query)) {
            $id = $row[$id_col];
            $parent_id = $row[$cat_col] === NULL ? "0" : $row[$cat_col];
            $data[$id] = $row;
            $index[$parent_id][$id] = $row;
        }
        return $index;
    }

    function tree_list($data, $id=false, $indent=false) {

        if (!$id) {
            $id = 0;
            $indent = 0;
        }
        $cdata = &$cdata;
        // start from root
        if (isset($data[$id]) && count($data[$id])) {
            foreach($data[$id] as $key => $index) {
                $index['level'] = $indent;
                $cdata[] = $index;
                if (isset($data[$key])) {
                    $a_list = tree_list($data, $key, $indent+1);
                    foreach($a_list as $subdata) {
                        $cdata[] = $subdata;
                    }
                }
            }
        }
        return $cdata;
    }

    function get_tree_root($index, $child_id) {

        /*
        * Display tree root
        */

        foreach($index as $key=>$array) {

            if (in_array($child_id, $array)) {
                if ($key == 0) {
                    return $child_id;
                } else {
                    return get_tree_root($index, $key);

                }
            }

        }

    }
    function get_parent($index, $child_id) {

        foreach($index as $key=>$value) {

            if (in_array($child_id, $value)) {

                return $key;
            }
        }

    }
    function get_child($index, $parent_id, &$children=false) {

        /*
        * Retrieving nodes using variables passed as reference:
        * Get ids of child nodes
        */

        $parent_id = $parent_id === NULL ? "NULL" : $parent_id;

        if (isset($index[$parent_id])) {

            foreach ($index[$parent_id] as $id) {
                $children[] = $id;
                get_child($index, $id, $children);
            }

        }

        return $children;
    }
    function get_depth($index, $child_id, $depth=false) {

        if (!$depth) {
            $depth = 1;
        }

        foreach ($index as $key=>$value) {
            if (in_array($child_id, $value)) {
                if ($key == 0) {
                    return $depth;
                } else {
                    return get_depth($index, $key, $depth + 1);
                }
            }
        }

    }

    // end of hierarchies
    function get_hkey($db, $id_col, $cat_col, $parent_id) {
        $hkey = &$hkey;
        $query = "SELECT $id_col, $cat_col FROM ".$db." WHERE $id_col = '$parent_id' LIMIT 1";
        //echo $query;
        $result = dbquery($query);
        if (dbrows($result)>0) {
            $data = dbarray($result);
            if ($data[$cat_col] > 0) {
                $hkey = get_hkey($db, $id_col, $cat_col, $data[$cat_col]);
            } else {
                $hkey = $data[$id_col];
            }
        } else {
            // predict current row.
            $rows = dbrows(dbquery("SELECT $id_col FROM ".$db.""));
            $hkey = $rows+1;
        }
        return $hkey;
    }

    /* used to make searches on field */
    // echo search_field(array('admin_title','admin_link'), 'ac c d ghi');
    function search_field($columns, $text)
    {
        $condition = '';
        $text = explode(" ", $text);
        foreach($text as $search_text) {
            if (strlen($search_text) >= 3) {
                $the_sql[] = stripinput($search_text);
            }
        }
        foreach ($the_sql as $counter => $search_text) {
            if (strlen($search_text) >= 3) {
                if (is_array($columns)) {
                    $condition .= "(";
                    foreach($columns as $arr => $col_field) {
                        $condition .= ($arr == count($columns)-1) ? "$col_field LIKE '%$search_text%'" : "$col_field LIKE '%$search_text%' OR ";
                    }
                    $condition .= ")";
                } else {
                    $condition .= "($col_field LIKE '%$search_text%')";
                }
            }
            $condition .= ($counter == count($the_sql)-1) ? "  " : " OR ";
        }
        return $condition;
    }

    function sql_manage_order($db, $id=false, $id_col=false, $cat=false, $cat_col=false, $order, $order_col, $opts=false) {

    /* Revision : save, update, delete */
        //sql_manage_order($db, $dmdata['field_id'], "field_id", "", "", $dmdata['field_order'], "field_order",  array("mode"=>"update"));
    if (is_array($opts)) {

        if (array_key_exists("mode",$opts)) {

            if ($opts['mode'] == "save") {
                $mode = 1;
            } elseif ($opts['mode'] == "update") {
                $mode = 2;
            } elseif ($opts['mode'] == "delete") {
                $mode = 3;
            }
        }

    } else {

        $mode = 2; // mode is always on update by default. so $id_col and $id is REQUIRED.

    }

    if ($mode =="1") {

        // save mode

        if (!empty($cat) && (!empty($cat_col))) {
            // nested category
            // there is a neet for $cat and $cat_col but id, and id_col not necessary for save.
            $result = dbquery("UPDATE ".$db." SET $order_col=$order_col+1 WHERE $cat_col='$cat' AND $order_col>='$order'");
        } else {
            //no category - single line type
            // see that there is no need for [ id, id_col, cat, cat_col ] for straight ordering.
            $result = dbquery("UPDATE ".$db." SET $order_col=$order_col+1 WHERE $order_col>='$order'");
        }

    } elseif ($mode =="2") {

        // update mode
        // in update mode, id and id col is REQUIRED.

        $old_order = dbresult(dbquery("SELECT $order_col FROM ".$db." WHERE $id_col='$id'"), 0);

        //print_p(" dbresult(dbquery('SELECT $order_col FROM ".$db." WHERE $id_col='$id''), 0);");
        //print_p($old_order);

        if (!empty($cat) && (!empty($cat_col))) {
            if ($old_order !=="0") {
                if ($order > $old_order) {
                    $result = dbquery("UPDATE ".$db." SET $order_col=$order_col-1 WHERE $cat_col='$cat' AND $order_col>'$old_order' AND $order_col<='$order'");
                    //echo "Current Order Dropped";
                } elseif ($order < $old_order) {
                    $result = dbquery("UPDATE ".$db." SET $order_col=$order_col+1 WHERE $cat_col='$cat' AND $order_col<'$old_order' AND $order_col>='$order'");
                    //echo "Current Order Escalated";
                }
            }

        } else {

            //no category - single line type
                if ($order > $old_order) {
                    $result = dbquery("UPDATE ".$db." SET $order_col=$order_col-1 WHERE $order_col>'$old_order' AND $order_col<='$order'");
                    //echo "Current Order Dropped - $order_col=$order_col-1 from 1 to 5, so all field order that is more than 1 goes 0 and negative, and field order that is less than 5 all less down ";
                } elseif ($order < $old_order) {
                    $result = dbquery("UPDATE ".$db." SET $order_col=$order_col+1 WHERE $order_col<'$old_order' AND $order_col>='$order'");
                    //echo "Current Order Escalated";
                }
        }

    } elseif ($mode == "3") {

        // delete mode

        // $id and $id_col is not necessary in delete mode.

        if (!empty($cat) && (!empty($cat_col))) {

            // in nested mode, $cat and $cat_col is REQUIRED.

            $result = dbquery("UPDATE ".$db." SET $order_col=$order_col-1 WHERE $cat_col='$cat' AND $order_col>'$order'");

        } else {

            $result = dbquery("UPDATE ".$db." SET $order_col=$order_col-1 WHERE $order_col>'$order'");
        }

    }
}
    function fieldgenerator($db) {
        $cresult = dbquery("SHOW COLUMNS FROM $db");
        $col_names = array();
        while ($cdata = dbarray($cresult)) {
            $col_names[] = $cdata['Field'];
        }
        return $col_names;
    }


    function array_depth($array) {
        $max_depth = 1;
        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = array_depth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }
    function tree_path_no_use($db, $id_col, $cat_col, $filter=false, $filter_order=false, $filter_show=false, $depth=false) {

        $selector = '';
        $column = '';
        $conditions = '';

        if (!$depth) {
            $depth = 10;
        }

        for($i=0; $depth>=$i; $i++) {

            $prev = $i-1;

            $selector .= ($i==$depth) ? "t$i.$id_col as level$i" : "t$i.$id_col as level$i, ";

            $column .= ($i==0) ? "FROM $db AS t$i " : "LEFT JOIN $db AS t$i ON t$i.$cat_col = t$prev.$id_col ";

            if ($i==0) {

                $conditions .= "WHERE t$i.$cat_col='0' OR";

            } else {

                $conditions .= ($i==$depth) ? " t$i.$cat_col = t$prev.$id_col " : " t$i.$cat_col= t$prev.$id_col OR ";

            }

        }


        $result = dbquery("SELECT $selector $column $conditions ORDER BY t1.$cat_col ASC, t1.$id_col ASC $filter_show");

        return $result;

    }

    // Get the Full Index of the Tree for Depth, Occurence Counting.
    function tree_index($db=false, $id_col, $cat_col, $cat_value=false) {

        ## Basic Tree node. No filtration. Use dbquery_tree() instead for a more powerful query.

        $refs = array();

        $list = array();

        $result = dbquery("SELECT * FROM ".$db."");

        $col_names = fieldgenerator($db);

        $i = 1;


        while ($data = dbarray($result)) {

            foreach($col_names as $arr=>$v) {
                if ($v == $id_col) {
                    $thisref = &$refs[$data[$id_col]];
                }
                $thisref[$v] = $data[$v];
            }

            if ($data[$cat_col] == $cat_value) {

                $list[$data[$id_col]] = &$thisref;

            } else {

                $refs[ $data[$cat_col]]['children'][$data[$id_col]] = &$thisref;

            }

            $i++;
        } // end while


        return $list;

    }
    function display_parent_nodes($data, $id_col, $cat_col, $id) {
        /*
        * Display parent nodes
        */


        $current = $data[$id];
        $parent_id = $current[$cat_col] === NULL ? "NULL" : $current[$cat_col];
        $parents = array();
        while (isset($data[$parent_id])) {
            $current = $data[$parent_id];
            $parent_id = $current[$cat_col] === NULL ? "NULL" : $current[$cat_col];
            $parents[] = $current[$id_col];
        }

    //    echo implode(" > ", array_reverse($parents));
        return $parents;

    }

    ## Will deprecate dbtree when RC1.
    function dbtree($db, $id_col, $cat_col, $cat_value, $ordering=false, $filter='', $filter_order='', $filter_show='') {
        ## V8 Universal Hierarchy Tree Coded by Hien.
        $refs = array();
        $list = array();

        $col_names = fieldgenerator($db);

        if ($filter || $filter_order || $filter_show) {

            $result = dbquery("SELECT * FROM ".$db." $filter $filter_order $filter_show");

    //        print_p(dbrows($result));

        } else {

            $ordering = (isset($ordering) && (!empty($ordering))) ? "order by $ordering" : "";

            $result = dbquery("SELECT * FROM ".$db." $ordering");

        }

        //$result = dbquery("SELECT * FROM ".$db." $condition ");

        while ($data = dbarray($result)) {

            foreach($col_names as $arr=>$v) {

                if ($v == $id_col) {

                    $thisref = &$refs[$data[$id_col]];

                }

                $thisref[$v] = $data[$v];

            }

            if ($data[$id_col] == $cat_value) { // cat_val = 0 = impossible

                $list[$data[$id_col]] = &$thisref; // pushing mechanism.

            } elseif ($data[$cat_col] == $cat_value) { // 0;

                // if current $data[article_cat_cat] == "3"
                // $list[1] <-- inject in array. // list the current children.
                $refs[$data[$cat_col]]['children'][$data[$id_col]] = &$thisref;

            } else {

                $refs[$data[$cat_col]]['children'][$data[$id_col]] = &$thisref;

            }

        } // end while
        return $list;
    }

    ## Internal to sort_tree - Very useful
    function sorter(&$array, $key) {
        $sorter=array();
        $ret=array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        $array=$ret;
        return $array;
    }

    ## To sort the tree or dbtree by keys.
    function sort_tree(&$result, $key) {

        $master_sort = sorter($result,$key);

        foreach ($master_sort as $data) {
            $id = $data[$key];
            // remove child
            $newdata = $data;
            unset($data['children']);
            $current_array[$id] = $data; // fielded parents

            if (array_key_exists("children",$newdata)) {
                $result = $newdata['children'];
                $current_array[$id]['children'] = sort_tree($result,$key);
            }
        }
        return $current_array;
    }
    // New SQL Row Modifier.
    function dbquery_insert($db, $inputdata, $mode, $options=false)
        {
            require_once OVERDRIVE."notify/notify.inc.php";
        // php-fusion 8 sql_insert - enhance automation of sql insert dynamically.
        // This function is a prototype function which eases the painful counting one by one, pair to pair everytime we code.
        // consider this an automatic calculator, and automatic sanitization on the fourth time!
        //print_p($inputdata);
            if (defined("ADMIN_PANEL")) {
                global $aidlink;
            } else {
                $aidlink = '?';
            }

            if (is_array($options)) {
                $redirect = (array_key_exists("noredirect", $options) && ($options['noredirect']=="1")) ? "0" : "1";
                $url = (array_key_exists("url", $options)) ? $options['url'] : "";
            } else {
                $redirect = "1";
                $url = "";
            }

            if (!defined("FUSION_NULL")) {

                $columns = fieldgenerator($db);
                $col_rows = count($columns);
                $col_names = array();
                $sanitized_input = array();
                // for save, status=success
                // for update, status=updated
                // for delete, status=del

                // Prime Module
                foreach($columns as $arr=>$v) {
                    if ($arr !== 0) {

                        if ($mode == "save") {
                            $col_names[] = ($arr==($col_rows-1)) ? "$v":"$v,"; // with or without comma
                        } elseif ($mode == "update") {
                            $col_names[] = ($arr==($col_rows-1)) ? "$v":"$v"; // all with no comma
                        }

                        if (array_key_exists($v, $inputdata)) {
                            $values = $inputdata[$v]; // go through the super sanitizer first.
                            if (isset($error) && ($values == $error)) {
                                redirect(FUSION_SELF.$aidlink."&status=error".($error ? "&error=$error" : ""));
                            }
                            if ($mode == "save") {
                                $sanitized_input[] = ($arr == ($col_rows-1)) ? "'$values'" : "'$values',";
                            } elseif ($mode == "update") {
                                $sanitized_input[] = ($arr == ($col_rows-1)) ? "$v='$values'" : "$v='$values',";
                            }

                        } else {
                            if ($mode == "save") {
                                $sanitized_input[]= ($arr == ($col_rows-1)) ? "''" : "'',";
                            } elseif ($mode == "update") {
                                $sanitized_input[]= ($arr == ($col_rows-1)) ? "$v=''" : "$v='',";
                            }


                        }
                    } // skips 1st id array.
                }
                if ($mode == "save") {

                    // counter to make sure it's the same.
                    $the_column = ""; $the_value = "";
                    foreach($col_names as $arr=>$v) {
                        $the_column .="$v";
                    }
                    foreach($sanitized_input as $arr=>$v) {
                        $the_value .="$v";
                    }
                    //print_p($col_names);
                    //print_p($sanitized_input);

                    if (count($col_names) !== count($sanitized_input)) { die(); } else {
                        //$result = "INSERT INTO ".$db." ($the_column) VALUES ($the_value)";
                        //print_p($result);
                        $result = dbquery("INSERT INTO ".$db." ($the_column) VALUES ($the_value)");
                        if ($redirect == "1") {
                            if ($url !=="") { redirect($url); } else { redirect(FUSION_SELF.$aidlink."&status=success"); }

                        }
                    }

                } elseif ($mode == "update") {

                    $the_value = "";
                    foreach($sanitized_input as $arr=>$v) {
                        $the_value .="$v";
                    }

                    // settings to use which field as the core for update.
                    $key = 0; // <----- the key
                    $update_core = "".$columns[$key]."='".$inputdata[$columns[$key]]."'";
                    //print_p($update_core);
                    //print_p($the_value);

                    if (count($col_names) !== count($sanitized_input)) { die(); } else {
                        //$result = "UPDATE ".$db." SET $the_value WHERE $update_core";
                        //print_p($result);
                        $result = dbquery("UPDATE ".$db." SET $the_value WHERE $update_core");
                        // equals to
                        if ($redirect == "1") {
                            if ($url !=="") { redirect($url); } else { redirect(FUSION_SELF.$aidlink."&status=updated"); }
                        }
                    }

                } elseif ($mode == "delete") {

                    if ($aidlink !=="") { // since only admin can launch deletion?
                        $col = $columns['0'];
                        $values = $inputdata[$col];
                        //print_p($col);
                        //print_p($values);
                        if ($values !== $error) {
                            $result = dbquery("DELETE FROM ".$db." WHERE $col='$values'");
                            //$result = "DELETE FROM ".$db." WHERE $col='$values'";
                            //print_p($result);
                            //redirect(FUSION_SELF.$aidlink."&status=deleted");

                            if ($redirect == "1") {
                                if ($url !=="") { redirect($url); } else { redirect(FUSION_SELF.$aidlink."&status=del"); }
                            }
                        }
                    }

                } else {
                    die();
                }
            } else {
                notify('Script stopped as an illegal operation is found.', 'Fusion Defender stopped SQL, auto exit before execution.');
            }

        }


    function construct_array($string, $string2=false, $delimiter=false) {

        // in event string is array. skips this.
        if (!is_array($string)) {

            if ($delimiter && (!empty($delimiter))) { $delimiter = $delimiter; } else { $delimiter = ","; }

            $value = explode("$delimiter", $string);

            if ($string2 !="") { $value2 = explode("$delimiter", $string2); } else { $value2 = ""; }

            if (is_array($value2)) {
                $value = array_combine($value2,$value);
            }

            return $value;

        } else {
            notify("Debug notice: There is a string injected in construct_array() function!", "Please recheck source codes in this page.");
        }

    }

    function deconstruct_array($string, $delimiter) {

        $value = implode("$delimiter", $string);

        return $value;
    }

    // To flatten ANY multidimensional array.
    function flatten_array($result) {
        return call_user_func_array('array_merge', $result);
    }

    function tree_depth($data, $field, $match, $depth='1') {

        if (!$depth) {

            $depth = '1';

        } else {

            $depth = &$depth;

        }

        foreach($data as $arr) {

            if ($arr[$field] == $match) {

                return $depth;

            } else {

                if (array_key_exists('children', $arr)) {

                     $deep = tree_depth($arr['children'], $field, $match, $depth+1);
                     if ($deep) {

                         return $deep;

                     }
                }
            }

        }
    }

    function tree_count($data, $field=false, $match=false) {

    // Find Occurence of match in a tree.
    //$unpublish_count = tree_count($dbresult, "wiki_cat_status", "0")-1;

        if (!isset($counter)) {

            $counter = 0;

        } else {

            $counter = &$counter;

        }

        foreach($data as $arr) {

            if (!empty($field)) {

                if ($arr[$field] == "$match") { $counter++; }

            } else {

                $counter++;
            }

            if (array_key_exists("children", $arr)) {

                $counter = tree_count($arr['children'], $field, $match)+$counter;

            }

        }

        return $counter;

    }

    function getcategory($cat) {

        $presult = dbquery("SELECT link_id, link_name, link_order FROM ".DB_SITE_LINKS." WHERE link_id='$cat'");

        if (dbrows($presult)>0) {

            $pdata = dbarray($presult);
            $link_id = $pdata['link_id'];
            $link_order = $pdata['link_order'];
            $link_name = $pdata['link_name'];

            $md[$cat] = "Menu Item Root";

            $result = dbquery("SELECT link_id, link_name FROM ".DB_SITE_LINKS." WHERE link_cat='$cat' ORDER BY link_order ASC");

            if (dbrows($result)>0) {

                while ($data = dbarray($result)) {

                    $link_id = $data['link_id'];

                    $link_name = $data['link_name'];

                    $md[$link_id] = "- ".$link_name."";

                }
            }

        }
        return $md;
    }

    function dbcompress($data, $mode, $delimiter=false, $sdelimiter=false)
    {
        /* New Compressor to compress $data into a single imploded statement */
        $delimiter =  (!empty($delimiter)) ? $delimiter : '//';
        $sdelimiter =  (!empty($sdelimiter)) ? $sdelimiter : '=';
        /* Sanitize $data before this */
        if ($mode == 'compress') {
            // method = x=y|a=b|
            $i = 1; $_data = '';
            foreach($data as $comp_arr => $comp_value) {
                $comp_arr = stripinput($comp_arr);
                $comp_value = stripinput($comp_value);
                $_data .= ((count($data) == $i)) ? $comp_arr.$sdelimiter.$comp_value : $comp_arr.$sdelimiter.$comp_value.$delimiter;
                $i++;
            }
            return $_data; // returns as imploded text

        } elseif ($mode == 'decompress') {

            $_data = explode("$delimiter", $data);
            foreach ($_data as $_newdata) {
                $_temp = explode("$sdelimiter", $_newdata);
                if ($_temp) {
                    $_sdata[$_temp['0']] = isset($_temp['1']) ? $_temp['1'] : '';
                }

            }
            unset($_data);
            return $_sdata;
        }
    }

?>