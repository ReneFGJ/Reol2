<?php
$include = '../';
require("../db.php");

require($include.'sisdoc_email.php');

require("_class/_class_journal.php");
$jnl = new journal;

require("_class/_class_ic.php");
$ic = new ic;


require("_class/_class_parecer.php");
$pp = new parecer;
$id = round($dd[0]);

echo '<HR>';
$pp->tabela = $dd[1];
$sql= "select * from ".$pp->tabela." 
					inner join pareceristas on pp_avaliador = us_codigo
					inner join submit_documento on pp_protocolo = doc_protocolo
					inner join journals on doc_journal_id = jnl_codigo 
					where id_pp = ".$id;
$rlt = db_query($sql);
$line = db_read($rlt);
$status = $line['status'];

$email_1 = trim($line['us_email']);
$email_2 = trim($line['us_email_alternativo']);
$nome = '<B>'.trim($line['us_nome']).'</b>';

$jid = $line['us_journal_id'];

$nw = $ic->ic('par_decl_avaliador');

/*
 * Recupera dados da publicação
 */
$jnl->le($jid);
$admin_nome = trim($line['jn_title']);
$email_adm = trim($line['jn_email']);
$parecerista = trim($line['us_codigo']);

/*
 * Dados do avaliador
 */

require("_class/_class_pareceristas.php");
$par = new parecerista;
$par->le($parecerista); 
$link = $par->link_avaliador;
 
$titulo = $nw['nw_titulo'];
$texto = mst($nw['nw_descricao']);
$texto = troca($texto,'$nome',$nome);
$texto = troca($texto,'$NOME',$nome);
$texto = troca($texto,'$avaliador',$nome);
$texto = troca($texto,'$AVALIADOR',$nome);
$texto = troca($texto,'$link',$link);
$texto = troca($texto,'$LINK',$link);

$texto = '<IMG SRC="'.$http.'/public/'.$jid.'/images/homeHeaderLogoImage.jpg">'.'<BR><BR>'.$texto;

$sql = "update ".$pp->tabela." set pp_status = 'C' where id_pp = ".$dd[0];
echo $sql;
exit;

enviaremail('renefgj@gmail.com','',$titulo,$texto);

require("close.php");
?>
