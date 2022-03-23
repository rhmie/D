<?php
$mysqlhost="localhost";
$mysqluser="root";
$mysqlpasswd="";
$mysqldb="chuanshin_db";
        $mysqli = new mysqli($mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb);
        //檢查是否連線成功
        if (mysqli_connect_errno()) {
            printf("<p>Connection ERROR..</p>", mysqli_connect_error());
            $this->mysqli = FALSE;
            exit('MySQL connect error!');
        } else {
			mysqli_set_charset($mysqli,"utf8mb4");
		}
        //$mysqli->close();
?>
