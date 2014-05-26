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
$id = $dd[0];

$pp->tabela = $dd[1];
$sql= "select * from submit_documento
			inner join ".$pp->tabela." on doc_protocolo = pp_protocolo 
			inner join pareceristas on pp_avaliador = us_codigo
			inner join journals on doc_journal_id = jnl_codigo 
			where doc_protocolo = '".$id."'";

/* Código do avaliador */			
if (strlen($dd[2]) > 0) { $sql .= " and us_codigo = '".$dd[2]."' "; }

$rlt = db_query($sql);
$line = db_read($rlt);
$status = $line['status'];

$editor = $line['editor'];

$email_1 = trim($line['us_email']);
$email_2 = trim($line['us_email_alternativo']);
$nome = trim($line['us_nome']);
$data = $line['pp_parecer_data'];

$jid = round($line['doc_journal_id']);

$nw = $ic->ic('par_declaracao');

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
$texto = $nw['nw_descricao'];
$texto = troca($texto,'$nome',$nome);
$texto = troca($texto,'$issn',$issn);
$texto = troca($texto,'$ISSN',$issn);
$texto = troca($texto,'$NOME',$nome);
$texto = troca($texto,'$avaliador',$nome);
$texto = troca($texto,'$AVALIADOR',$nome);
$texto = troca($texto,'$link',$link);
$texto = troca($texto,'$LINK',$link);
$dia = substr($data,6,2);
$mes = round(substr($data,4,2));
$mes_nome = array('','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
$mes = $mes_nome[$mes];
$ano = substr($data,0,4);
$texto = troca($texto,'$REVISTA',$admin_nome);
$texto = troca($texto,'$DIA',$dia);
$texto = troca($texto,'$MES',$mes);
$texto = troca($texto,'$ANO',$ano);
$texto = troca($texto,'$EDITOR',$editor);



//echo '<BR><B>'.$titulo.'</B><BR>';
//echo mst($texto);

/*
 * PDF
 */
require($include.'fphp-153/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

	$img = '../public/'.$jid.'/images/homeHeaderLogoImage.png';
	if (file_exists($img)) 
		{
			 $pdf->Image($img,0,0,210); 
		}
	else 
		{
			$img = '../public/'.$jid.'/images/homeHeaderLogoImage.jpg';
			if (file_exists($img)) { $pdf->Image($img,0,0,210); }		
		}
	
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,100,' ',0,0,'C');
$pdf->ln(60);
$pdf->SetFont('Arial','B',22);
$pdf->Cell(0,12,'D E C L A R A Ç Ã O',0,0,'C');
$pdf->ln(20);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(0,10,$texto);
$pdf->SetX(0);
$pdf->SetY(260);
$pdf->MultiCell(0,5,'Declaração N. '.$dd[0].'/'.$ano);
$pdf->MultiCell(0,5,'Emitida digitalmente ('.$email_adm.')');
$pdf->Output();
?>
