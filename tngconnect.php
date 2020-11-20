<?php

/**
 * @param $dbhost
 * @param $dbname
 * @param $dbusername
 * @param $dbpassword
 * @param null $dbport
 * @param null $dbsocket
 * @return false|mysqli
 */
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

/**
 * @return int
 */
function tng_affected_rows() {
    global $link;
    return mysqli_affected_rows($link);
}

/**
 * @param $stmt
 * @return int|string
 */
function tng_stmt_affected_rows($stmt) {
    return mysqli_stmt_affected_rows($stmt);
}

/**
 * @param $dbhost
 * @param $dbusername
 * @param $dbpassword
 * @param $dbname
 * @param null $dbport
 * @param null $dbsocket
 * @return false|mysqli
 */
function tng_connect($dbhost, $dbusername, $dbpassword, $dbname, $dbport = null, $dbsocket = null) {
    $connection = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname, $dbport, $dbsocket);
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
    return $connection;
}

/**
 * @param $result
 * @param $offset
 * @return bool
 */
function tng_data_seek($result, $offset) {
    return mysqli_data_seek($result, $offset);
}

/**
 * @return string
 */
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

/**
 * @param $result
 * @return string[]|null
 */
function tng_fetch_assoc($result) {
    return mysqli_fetch_assoc($result);
}

/**
 * @param $result
 * @param null $resulttype
 * @return array|null
 */
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

/**
 * @param $result
 * @param $fieldnr
 * @param $info
 * @return mixed
 */
function tng_field_info($result, $fieldnr, $info) {
    $fielddef = mysqli_fetch_field_direct($result, $fieldnr);

    eval("\$fieldinfo = \$fielddef->$info;");
    return $fieldinfo;
}

/**
 * @return string
 */
function tng_get_client_info() {
    global $link;
    return mysqli_get_client_info($link);
}

/**
 * @return string
 */
function tng_get_server_info() {
    global $link;
    return mysqli_get_server_info($link);
}

/**
 * @param $result
 */
function tng_free_result($result) {
    mysqli_free_result($result);
}

/**
 * @return int|string
 */
function tng_insert_id() {
    global $link;
    return mysqli_insert_id($link);
}

/**
 * @param $escapestr
 * @return string
 */
function tng_real_escape_string($escapestr) {
    global $link;
    return mysqli_real_escape_string($link, $escapestr);
}

/**
 * @param $result
 * @return int
 */
function tng_num_fields($result) {
    return mysqli_num_fields($result);
}

/**
 * @param $result
 * @return int
 */
function tng_num_rows($result) {
    return mysqli_num_rows($result);
}

/**
 * @param $link
 * @param $charset
 * @return bool
 */
function tng_set_charset($link, $charset) {
    return mysqli_set_charset($link, $charset);
}

/**
 * @param $link
 * @param $dbname
 * @return bool
 */
function tng_select_db($link, $dbname) {
    return mysqli_select_db($link, $dbname);
}

//first arg of $params must be template, ie, 'sssd'
//use for insert or update queries
//params must be passed by reference (includes template)
/**
 * @param $query
 * @param $params
 * @return int|string
 */
function tng_execute($query, $params) {
    $stmt = tng_prepare($query);
    return tng_execute_only($stmt, $query, $params);
}

/**
 * @param $query
 * @param $params
 * @return int|string
 */
function tng_execute_noerror($query, $params) {
    $stmt = tng_prepare($query);
    return tng_execute_only_noerror($stmt, $params);
}

/**
 * @param $query
 * @return false|mysqli_stmt
 */
function tng_prepare($query) {
    global $link;

    return mysqli_prepare($link, $query);
}

/**
 * @param $stmt
 * @param $query
 * @param $params
 * @return int|string
 */
function tng_execute_only($stmt, $query, $params) {
    global $link;

    call_user_func_array([$stmt, 'bind_param'], $params);
    if (!mysqli_stmt_execute($stmt)) {
        $error = mysqli_error($link);
        $errorstr = $error ? "<br><br>$error" : "";
        echo _('An error has occurred in the TNG software. This could be due to a setup issue, an incomplete upgrade or a program bug. If you are the site owner, you may contact TNG support for help with this problem. Please copy the query below and paste it into your message.') . "<br><br>" . _('Query') . ": $query<br>" . implode(" | ", $params) . " " . $errorstr;
        exit;
    }
    $affected_rows = tng_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    return $affected_rows;
}

/**
 * @param $stmt
 * @param $params
 * @return int|string
 */
function tng_execute_only_noerror($stmt, $params) {
    call_user_func_array([$stmt, 'bind_param'], $params);
    @mysqli_stmt_execute($stmt);
    $affected_rows = tng_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    return $affected_rows;
}

/**
 * @param $query
 * @return bool|mysqli_result
 */
function tng_query($query) {
    global $link;

    $result = mysqli_query($link, $query);
    if (!$result) {
        $error = mysqli_error($link);
        $errorstr = $error ? "<br><br>$error" : "";
        echo _('An error has occurred in the TNG software. This could be due to a setup issue, an incomplete upgrade or a program bug. If you are the site owner, you may contact TNG support for help with this problem. Please copy the query below and paste it into your message.') . "<br><br>" . _('Query') . ": $query$errorstr";
        exit;
    }
    return $result;
}

/**
 * @param $query
 * @return bool|mysqli_result
 */
function tng_query_noerror($query) {
    global $link;

    return @mysqli_query($link, $query);
}
