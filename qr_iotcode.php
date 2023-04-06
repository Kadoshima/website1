<?php

    function qrcode_chage($qrcode, $dbh){
        
        //qrcodeからiotcodeを取得する部分
        $sql = "SELECT iotcode FROM segway WHERE qrcode = :qrcode";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':qrcode', $qrcode);
        $stmt->execute();
        $member = $stmt->fetch();

        if(empty($member['iotcode'])){
            return 4000;
        }else{
            return $member['iotcode'];
        }
        
    }

?>
