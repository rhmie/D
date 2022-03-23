<?php session_start(); ?>
<?php

    $result =   Array();

    if (!isset($_SESSION['bee_admin'])){
        $result['err_msg']  =   '-1';
        exit(json_encode($result));
    }

    include('../check_ref.php');

    include('../mysql.php');   
    require_once ('../MysqliDb.php');
    $db = new MysqliDb($mysqli);

    $data			=	Array();

    $fid    =   (int)$_POST['fid'];

    if ($fid == 1){
        $data['header'] =   $data['wname']      =   $_POST['wname'];
        $data['header']     =   htmlentities($_POST['header']);
        $data['logo_url']   =   $_POST['logo_url'];
        $data['level']      =   $_POST['level'];
        $data['status']     =   $_POST['status'];
        $data['reg_mode']   =   $_POST['reg_mode'];
        $data['need_reg']   =   $_POST['need_reg'];
        $data['page_items'] =   $_POST['page_items'];
        $data['related_items'] =   $_POST['related_items'];
        $data['weburl']     =   $_POST['weburl'];
        $data['language']   =   $_POST['language'];
        $data['side_menu']   =   $_POST['side_menu'];
        $data['nav_mode']   =   $_POST['nav_mode'];
        $data['banner_mode']   =   $_POST['banner_mode'];
        $data['sms_account']     =  NULL;
        $data['sms_pass']   =   NULL;
        $data['announce']   =   NULL;
        $data['fb_app_id']  =   NULL;
        $data['fb_msg']     =   NULL;
        $data['line_channel']     =   NULL;
        $data['line_secret']     =   NULL;
        $data['keywords']   =   NULL;
        $data['comment1']   =   0;
        $data['comment2']   =   0;
        $data['show_cat']   =   0;
        $data['signal_id']  =   NULL;

        $data['show_banners']   =   0;
        $data['show_dis']       =   0;
        $data['show_hot']       =   0;
        $data['show_art']       =   0;
        $data['show_news']      =   0;
        $data['show_his']       =   0;


        if (isset($_POST['show_cat']))
            $data['show_cat']  =   1;

        if (!empty($_POST['keywords']))
            $data['keywords']   =   $_POST['keywords'];

        if (isset($_POST['show_banners']))
            $data['show_banners']  =   1;

        if (isset($_POST['show_dis']))
            $data['show_dis']  =   1;

        if (isset($_POST['show_hot']))
            $data['show_hot']  =   1;

        if (isset($_POST['show_art']))
            $data['show_art']  =   1;


        if (isset($_POST['show_news']))
            $data['show_news']  =   1;

        if (isset($_POST['show_his']))
            $data['show_his']  =   1;


        if (!empty($_POST['sms_account'])) $data['sms_account']   =   $_POST['sms_account'];
        if (!empty($_POST['sms_pass'])) $data['sms_pass']   =   $_POST['sms_pass'];
        if (!empty($_POST['announce'])) $data['announce']   =   $_POST['announce'];
        if (!empty($_POST['fb_app_id'])) $data['fb_app_id']   =   $_POST['fb_app_id'];
        if (!empty($_POST['fb_msg'])) $data['fb_msg']   =   $_POST['fb_msg'];

        if (!empty($_POST['line_channel'])) $data['line_channel']   =   $_POST['line_channel'];
        if (!empty($_POST['line_secret'])) $data['line_secret']   =   $_POST['line_secret'];

        if (isset($_POST['comment1'])) $data['comment1']    =   1;
        if (isset($_POST['comment2'])) $data['comment2']    =   1;

        if (!empty($_POST['signal_id'])) $data['signal_id'] =   $_POST['signal_id'];

    }


    if ($fid == 2){
        $data['email']      =   NULL;
        $data['line']       =   NULL;
        $data['fbpage']     =   NULL;
        $data['wechat']     =   NULL;
        $data['tele']       =   NULL;
        $data['addr']       =   NULL;
        $data['phone']      =   NULL;
        $data['twitter']    =   NULL;
        $data['instagram']  =   NULL;

        if (!empty($_POST['line'])) $data['line']   =   $_POST['line'];
        if (!empty($_POST['fbpage'])) $data['fbpage']   =   $_POST['fbpage'];
        if (!empty($_POST['email'])) $data['email']   =   $_POST['email'];
        if (!empty($_POST['wechat'])) $data['wechat']   =   $_POST['wechat'];
        if (!empty($_POST['tele'])) $data['tele']   =   $_POST['tele'];
        if (!empty($_POST['addr'])) $data['addr']   =   $_POST['addr'];
        if (!empty($_POST['phone'])) $data['phone']   =   $_POST['phone'];
        if (!empty($_POST['twitter'])) $data['twitter']   =   $_POST['twitter'];
        if (!empty($_POST['instagram'])) $data['instagram']   =   $_POST['instagram'];
    }


    if ($fid == 3){
        $data['discount']  =   $_POST['discount'];
        //$data['bonus']  =   $_POST['bonus']; //紅利-暫時不用
        $data['free_ship']  =   $_POST['free_ship'];
        $data['ship']  =   $_POST['ship'];
        $data['free_ship2']  =   $_POST['free_ship2'];
        $data['ship2']  =   $_POST['ship2'];
        $data['free_ship3']  =   $_POST['free_ship3'];
        $data['ship3']  =   $_POST['ship3'];
        $data['show_stock'] =   0;
        $data['gift'] =   0;
        $data['dismode']    =   $_POST['dismode'];

        if (isset($_POST['gift']))
            $data['gift']  =   1;

        if (isset($_POST['show_stock']))
            $data['show_stock']  =   1;
    }


    if ($fid == 4){
        $data['sms_order']  =   NULL;
        if (!empty($_POST['sms_order'])) $data['sms_order']   =   $_POST['sms_order'];

        $data['sms_ship']   =   0;
        if (!empty($_POST['sms_ship'])) $data['sms_ship']    =   1;

        $data['smtp']           =   NULL;
        $data['mail_usrname']   =   NULL;
        $data['mail_usrpass']   =   NULL;
        $data['mailport']       =   NULL;
        $data['mail_from']       =  NULL;
        $data['mail_ssl']       =   0;

        $data['newsletter'] =   0;
        if (!empty($_POST['newsletter'])){
            $data['newsletter']     =   1;
            $data['smtp']           =   $_POST['smtp'];
            $data['mail_usrname']   =   $_POST['mail_usrname'];
            $data['mail_usrpass']   =   $_POST['mail_usrpass'];
            $data['mailport']       =   $_POST['mailport'];
            $data['mail_from']       =  $_POST['mail_from'];
            $data['mail_ssl']       =   0;
            if (!empty($_POST['mail_ssl'])) $data['mail_ssl']    =   1;
        }
    }


    if ($fid == 5){

        $data['mod1']   =   $data['mod2']   =   $data['mod3']   =   $data['mod4']   =   0;
        $data['st1']    =   $data['st2']    =   $data['st3']    =   $data['st4']    =   0;

        $data['gstatus']    =   $_POST['gstatus'];

        $data['hashkey']        =   NULL;
        $data['hashiv']         =   NULL;
        $data['merchantid']     =   NULL;
        $data['g_language']     =   $_POST['g_language'];

        if (isset($_POST['mod1'])) $data['mod1']    =   1;
        if (isset($_POST['mod2'])) $data['mod2']    =   1;
        if (isset($_POST['mod3'])) $data['mod3']    =   1;
        if (isset($_POST['mod4'])) $data['mod4']    =   1;

        if (!empty($_POST['hashkey']) && !empty($_POST['hashiv']) && !empty($_POST['merchantid'])){

            $data['hashkey']        =   $_POST['hashkey'];
            $data['hashiv']         =   $_POST['hashiv'];
            $data['merchantid']     =   $_POST['merchantid'];
        }

        if (isset($_POST['st1'])) $data['st1'] = 1;
        if (isset($_POST['st2'])) $data['st2'] = 1;
        if (isset($_POST['st3'])) $data['st3'] = 1;
        if (isset($_POST['st4'])) $data['st4'] = 1;

    }


    if ($db->update('system', $data)){
        $result['err_msg']  =   'OK';
    } else {
        $result['err_msg'] = 'DB UPDATE ERROR '.$db->getLastError();
    }

    echo json_encode($result);

?>