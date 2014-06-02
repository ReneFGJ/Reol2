<?php
$http_site = 'http://www2.pucpr.br/reol/editora/';
$hd->jid = $_SESSION['journal_id'];
$hd->journal_name = $_SESSION['journal_title'];
$jid = intval($hd->jid);
$hd->jid  = $jid;
$http=$hd->http;
$http = 'http://www2.pucpr.br/reol/';
?>