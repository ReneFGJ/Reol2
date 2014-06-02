<?
$sql = "select * from journals where journal_id = ".round($jid)." limit 1";
$rlt = db_query($sql);
$line = db_read($rlt);
$admin_nome = trim($line['title']);
$email_adm = trim($line['jn_email']);
?>