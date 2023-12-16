<?php
if (isset($_POST['hide'])) {
    require_once("../model/commentActionModelH.php");
    hideComment($_POST['hide']);
} elseif (isset($_POST['unhide'])) {
    require_once("../model/commentActionModelH.php");
    unhideComment($_POST['unhide']);
}
?>
