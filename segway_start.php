<?php

    function segway_start($acount_token){

        //segwayのアンロック
        require_once('segway_unlock.php');

        //ロック解除用の関数呼び出し
        segway_unlock($acount_token);

    }

    if(!empty($_POST['user_id'])){
        segway_start($_POST['user_id']);
    }


?>