<?php

namespace App\Models;

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelExporter
{
    /**
     * Verileri bir Excel dosyasına aktarır.
     *
     * @param array $data Dışa aktarılacak veri dizisi.
     * @param array $headers Sütun başlıkları dizisi.
     * @param string $filename İndirilecek dosyanın adı.
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Exception\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public static function export(array $data, array $headers, string $filename = 'export.xlsx'): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Başlıkları yaz
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++;
        }

        // Verileri yaz
        $row = 2;
        foreach ($data as $dataRow) {
            $column = 'A';
            foreach ($dataRow as $value) {
                $sheet->setCellValue($column . $row, $value);
                $column++;
            }
            $row++;
        }

        // Tarayıcıya indirme için başlıkları ayarla
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}