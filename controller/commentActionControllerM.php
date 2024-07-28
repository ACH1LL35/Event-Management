<?php
if (isset($_POST['hide'])) {
    require_once("../model/commentActionModelM.php");
    hideComment($_POST['hide']);
} elseif (isset($_POST['unhide'])) {
    require_once("../model/commentActionModelM.php");
    unhideComment($_POST['unhide']);
}
?>
