<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', $lang_block['stt']);
$sheet->setCellValue('B1', $lang_block['news_title']);
$sheet->setCellValue('C1', $lang_block['news_author']);
$sheet->setCellValue('D1', $lang_block['news_date']);
$sheet->setCellValue('E1', $lang_block['news_view']);
$sheet->setCellValue('F1', $lang_block['news_rate']);
$sheet->getStyle('A1:F1')->getFont()->setBold(true);      
$sheet->getStyle('A1:F1')->getAlignment()->setHorizontal('center'); 

global $db, $module_data, $lang_block;  
$i = 0;
$db->select('id, title, author, publtime, hitstotal, total_rating, click_rating')
	->from(NV_PREFIXLANG . '_' . $module_data . '_rows')
    ->order('id ASC');
$sth = $db->prepare($db->sql());
$sth->execute();

while ($view = $sth->fetch()) {
	$i = $i + 1;
	$ave_rating = ($view['click_rating']>0) ? ($view['total_rating']/$view['click_rating']) : 0;
	$sheet->setCellValue('A'.($i+1), $i);
	$sheet->setCellValue('B'.($i+1), nv_unhtmlspecialchars($view['title']));
	$sheet->setCellValue('C'.($i+1), $view['author']);
	$sheet->setCellValue('D'.($i+1), nv_date("H:i d/m/Y", $view['publtime']));
	$sheet->setCellValue('E'.($i+1), $view['hitstotal']);
	$sheet->setCellValue('F'.($i+1), $ave_rating);
} 

foreach(range('A','F') as $columnID) {
    $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);	    
}

$writer = new Xlsx($spreadsheet);

header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Danh sach tin tuc.xlsx"');
$writer->save('php://output');

header('Location: ' . $global_config['site_url']);
exit();

?>