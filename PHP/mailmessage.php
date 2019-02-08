<?php
/**
 * Created by PhpStorm.
 * User: laura
 * Date: 08/02/19
 * Time: 15.40
 */

require_once 'utilities.php';
$user = init();
//$u = login($_POST['username'],$_POST['password']);

if ($_SESSION['ID'] == -1){
    printFeedback("Grazie, il tuo messaggio è stato inviato correttamente! Ti contatteremo al più presto", true);
} else {
    printFeedback("Grazie stronzo, il tuo messaggio è stato inviato correttamente! Ti contatteremo al più presto", true);
}

?>