<?php
$backup_config = array(
    'DB_HOST' => 'localhost',////Database hostname
    'DB_NAME' => 'id19985644_checkyourmood',//Database name to backup
    'DB_USERNAME' => 'id19985644_checkyourmoodusers',//Database account username
    'DB_PASSWORD' => 'Ygj$gi7W$FwtN&IZS8BE',//Database account password
    'INCLUDE_DROP_TABLE' => false,//Include DROP TABLE IF EXISTS
    'SAVE_DIR' => '',//Folder to save file in
    'SAVE_AS' => 'backup-',//Prepend filename
    'APPEND_DATE_FORMAT' => 'd-m-Y',//Append date to file name
    'TIMEZONE' => 'UTC',//Timezone for date format
    'COMPRESS' => false,//Compress into gz otherwise keep as .sql
);


$ftp_addr = "files.000webhost.com";
$ftp_port = 21;
$ftp_username = "check-your-mood-amine";
$ftp_passwd = "gZW&mGHfpzpo(F&vt)!Q";

$saveName = backupDB($backup_config);
$uploadOK = uploadFTP($saveName, $ftp_addr, $ftp_username, $ftp_passwd, $ftp_port);


function backupDB(array $config): string
{
    $db = new PDO("mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']}; charset=utf8", $config['DB_USERNAME'], $config['DB_PASSWORD']);
    $db->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);

    date_default_timezone_set($config['TIMEZONE']);
    $do_compress = $config['COMPRESS'];

    if ($do_compress) {
        $save_string = $config['SAVE_AS'] . $config['SAVE_DIR'] . date($config['APPEND_DATE_FORMAT']) . '.sql.gz';
        $zp = gzopen($save_string, "a9");
    } else {
        $save_string = $config['SAVE_AS'] . $config['SAVE_DIR'] . date($config['APPEND_DATE_FORMAT']) . '.sql';
        $handle = fopen($save_string, 'a+');
    }

    //array of all database field types which just take numbers
    $numtypes = array('tinyint', 'smallint', 'mediumint', 'int', 'bigint', 'float', 'double', 'decimal', 'real');

    $return = "DROP DATABASE ".$config['DB_NAME'].";\n";
    $return .= "CREATE DATABASE `{$config['DB_NAME']}`;\n";
    $return .= "USE `{$config['DB_NAME']}`;\n";

    //names od
    $tables[] = 'utilisateur';
    $tables[] = 'libelle';
    $tables[] = 'humeur';

    //cycle through the table(s)
    foreach ($tables as $table) {
        $result = $db->query("SELECT * FROM $table");
        $num_fields = $result->columnCount();
        $num_rows = $result->rowCount();

        if ($config['INCLUDE_DROP_TABLE']) {
            $return .= 'DROP TABLE IF EXISTS `' . $table . '`;';
        }

        //table structure
        $pstm2 = $db->query("SHOW CREATE TABLE $table");
        $row2 = $pstm2->fetch(PDO::FETCH_NUM);
        $ifnotexists = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $row2[1]);
        $return .= "\n\n" . $ifnotexists . ";\n\n";

        if ($do_compress) {
            gzwrite($zp, $return);
        } else {
            fwrite($handle, $return);
        }
        $return = "";

        //insert values
        if ($num_rows) {
            $return = 'INSERT INTO `' . $table . '` (';
            $pstm3 = $db->query("SHOW COLUMNS FROM $table");
            $count = 0;
            $type = array();

            while ($rows = $pstm3->fetch(PDO::FETCH_NUM)) {
                if (stripos($rows[1], '(')) {
                    $type[$table][] = stristr($rows[1], '(', true);
                } else {
                    $type[$table][] = $rows[1];
                }

                $return .= "`" . $rows[0] . "`";
                $count++;
                if ($count < ($pstm3->rowCount())) {
                    $return .= ", ";
                }
            }

            $return .= ")" . ' VALUES';

            if ($do_compress) {
                gzwrite($zp, $return);
            } else {
                fwrite($handle, $return);
            }
            $return = "";
        }
        $counter = 0;
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $return = "\n\t(";

            for ($j = 0; $j < $num_fields; $j++) {

                if (isset($row[$j])) {

                    //if number, take away "". else leave as string
                    if ((in_array($type[$table][$j], $numtypes)) && (!empty($row[$j]))) {
                        $return .= $row[$j];
                    } else {
                        $return .= $db->quote($row[$j]);
                    }
                } else {
                    $return .= 'NULL';
                }
                if ($j < ($num_fields - 1)) {
                    $return .= ',';
                }
            }
            $counter++;
            if ($counter < ($result->rowCount())) {
                $return .= "),";
            } else {
                $return .= ");";
            }
            if ($do_compress) {
                gzwrite($zp, $return);
            } else {
                fwrite($handle, $return);
            }
            $return = "";
        }
        $return = "\n\n-- ------------------------------------------------ \n\n";
        if ($do_compress) {
            gzwrite($zp, $return);
        } else {
            fwrite($handle, $return);
        }
        $return = "";
    }

    $error1 = $pstm2->errorInfo();
    $error2 = $pstm3->errorInfo();
    $error3 = $result->errorInfo();
    echo $error1[2];
    echo $error2[2];
    echo $error3[2];

    if ($do_compress) {
        gzclose($zp);
    } else {
        fclose($handle);
    }
    return $save_string;
}

function uploadFTP($file, $ftp_server, $ftp_username, $ftp_userpass, $ftp_port)
{
    $conn_id = ftp_connect($ftp_server, $ftp_port);
    $login_result = ftp_login($conn_id, $ftp_username, $ftp_userpass);
    ftp_pasv($conn_id, true);
    $ok = ftp_put($conn_id, $file, $file, FTP_BINARY);
    unlink('backup-'.date('d-m-Y').'.sql');
    ftp_close($conn_id);

    return $ok;
}