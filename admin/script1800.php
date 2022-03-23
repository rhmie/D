<?php

    include('./ssl_encrypt.php');

    $f1     =   encrypt_decrypt('encrypt', 'members').'_members.sql';
    $f2     =   encrypt_decrypt('encrypt', 'orders').'_orders.sql';
    $f3     =   encrypt_decrypt('encrypt', 'products').'_products.sql';

    exec('mysqldump --user=chuanshin_user --password=wf0rqesurlzz --host=localhost chuanshin_db members > ./'.$f1);
    exec('mysqldump --user=chuanshin_user --password=wf0rqesurlzz --host=localhost chuanshin_db orders > ./'.$f2);
    exec('mysqldump --user=chuanshin_user --password=wf0rqesurlzz --host=localhost chuanshin_db products > ./'.$f3);

?>