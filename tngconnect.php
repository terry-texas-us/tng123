<?php

function tng_db_connect($dbhost, $dbname, $dbusername, $dbpassword, $dbport = null, $dbsocket = null) {
    global $textpart, $session_charset, $tng_notinstalled;

    if (!trim($dbport)) $dbport = null;

    if (!trim($dbsocket)) $dbsocket = null;

    $link = tng_connect($dbhost, $dbusername, $dbpassword, $dbname, $dbport, $dbsocket);
    if ($link && tng_select_db($link, $dbname)) {
        mysqli_query($link, "SET SESSION sql_mode = ''");
        if ($session_charset == 'UTF-8') tng_set_charset($link, 'utf8');

        return $link;
    } else {
        if ($textpart != "setup" && $textpart != "index") {
            if (isset($tng_notinstalled) && $tng_notinstalled) {
                header("Location:readme.html");
                exit;
            } else {
                echo "Error: TNG is not communicating with your database. Please check your database settings and try again. Settings can be found under Admin/Setup/General Settings/Database, or at the top of your config.php file.";
            }
            exit;
        }
    }
    return (FALSE);
}

function tng_affected_rows() {
    global $link;
    return mysqli_affected_rows($link);
}

function tng_stmt_affected_rows($stmt) {
    return mysqli_stmt_affected_rows($stmt);
}

function tng_connect($dbhost, $dbusername, $dbpassword, $dbname, $dbport = null, $dbsocket = null) {
    return @mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname, $dbport, $dbsocket);
}

function tng_data_seek($result, $offset) {
    return mysqli_data_seek($result, $offset);
}

function tng_error() {
    global $link;
    return mysqli_error($link);
}

/**
 *  fetches all result rows
 *
 * @param mysqli_result Specifies a result set identifier returned by mysqli_query(), mysqli_store_result() or mysqli_use_result()
 * @return array result-set as an associative array
 */
function tng_fetch_all(mysqli_result $result) {
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function tng_fetch_assoc($result) {
    return mysqli_fetch_assoc($result);
}

function tng_fetch_array($result, $resulttype = null) {
    if ($resulttype == 'assoc') {
        $usetype = MYSQLI_ASSOC;
    } elseif ($resulttype == 'num') {
        $usetype = MYSQLI_NUM;
    } else {
        $usetype = null;
    }
    return $usetype ? mysqli_fetch_array($result, $usetype) : mysqli_fetch_array($result);
}

function tng_field_info($result, $fieldnr, $info) {
    $fielddef = mysqli_fetch_field_direct($result, $fieldnr);

    eval("\$fieldinfo = \$fielddef->$info;");
    return $fieldinfo;
}

function tng_get_client_info() {
    global $link;
    return mysqli_get_client_info($link);
}

function tng_get_server_info() {
    global $link;
    return mysqli_get_server_info($link);
}

function tng_free_result($result) {
    mysqli_free_result($result);
}

function tng_insert_id() {
    global $link;
    return mysqli_insert_id($link);
}

function tng_real_escape_string($escapestr) {
    global $link;
    return mysqli_real_escape_string($link, $escapestr);
}

function tng_num_fields($result) {
    return mysqli_num_fields($result);
}

function tng_num_rows($result) {
    return mysqli_num_rows($result);
}

function tng_set_charset($link, $charset) {
    return mysqli_set_charset($link, $charset);
}

function tng_select_db($link, $dbname) {
    return mysqli_select_db($link, $dbname);
}

//first arg of $params must be template, ie, 'sssd'
//use for insert or update queries
//params must be passed by reference (includes template)
function tng_execute($query, $params) {
    $stmt = tng_prepare($query);
    return tng_execute_only($stmt, $query, $params);
}

function tng_execute_noerror($query, $params) {
    $stmt = tng_prepare($query);
    return tng_execute_only_noerror($stmt, $params);
}

function tng_prepare($query) {
    global $link;

    return mysqli_prepare($link, $query);
}

function tng_execute_only($stmt, $query, $params) {
    global $link, $text;

    call_user_func_array([$stmt, 'bind_param'], $params);
    if (!mysqli_stmt_execute($stmt)) {
        $error = mysqli_error($link);
        $errorstr = $error ? "<br><br>$error" : "";
        echo $text['problem'] . "<br><br>{$text['query']}: $query<br>" . implode(" | ", $params) . " " . $errorstr;
        exit;
    }
    $affected_rows = tng_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    return $affected_rows;
}

function tng_execute_only_noerror($stmt, $params) {
    call_user_func_array([$stmt, 'bind_param'], $params);
    @mysqli_stmt_execute($stmt);
    $affected_rows = tng_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    return $affected_rows;
}

function tng_query($query) {
    global $link, $text;

    $result = mysqli_query($link, $query);
    if (!$result) {
        $error = mysqli_error($link);
        $errorstr = $error ? "<br><br>$error" : "";
        echo $text['problem'] . "<br><br>{$text['query']}: $query$errorstr";
        exit;
    }
    return $result;
}

function tng_query_noerror($query) {
    global $link;

    return @mysqli_query($link, $query);
}
