
<?php

    $qry = $pdo->prepare('select addres from detail_t');
    $qry->execute();
    foreach($qry->fetchAll() as $q){
        echo '<tr>';
        echo $row["area_name"];
        echo('<br>');
        echo $row["addres"];
        echo('<br>');
        echo $row["tel"];
        echo('<br>');
        echo $row["comment"];
        echo('<br>');
        echo '</tr>';
    }

?>