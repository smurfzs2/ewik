<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/version.php";
$path = $_SERVER['DOCUMENT_ROOT'] . "/" . v . "/Common Data/";
set_include_path($path);
include('PHP Modules/mysqliConnection.php');
include('PHP Modules/anthony_wholeNumber.php');
include('PHP Modules/anthony_retrieveText.php');
include('PHP Modules/gerald_functions.php');
include('PHP Modules/rose_prodfunctions.php');
ini_set("display_errors", "on");
require('Libraries/PHP/FPDF/fpdf.php');
require('Libraries/PHP/FPDI/fpdi.php');
include('eric_connection.php');
class PDF extends FPDF
{
    // function Header()
    // {
    //     // Check if the current row index is divisible by 2
    //     if ($this->Row  % 2 == 0) {
    //         $this->SetFillColor(200, 200, 200); // Set the background color for even rows
    //     } else {
    //         $this->SetFillColor(255, 255, 255); // Set the background color for odd rows
    //     }
    //     $this->Cell(0, 10, '', 0, 1, 'L', true); // Add a cell with the background color
    // }
    // function Header()
    // {

    //     $this->SetFont('Arial', 'B', 10);
    //     $this->Cell(80, 10, 'JAMCO PHILS', 0, 0, 'L');
    //     $this->SetFont('Arial', 'B', 20);
    //     $this->Cell(50, 10, 'SALES INVOICE DETAILS', 0, 0, 'C');
    //     $this->SetFont('Arial', 'B', 10);
    //     $this->Cell(70, 10, 'SI 66240', 0, 1, 'R');
    //     $this->SetFont('Arial', 'B', 10);
    //     $this->Cell(10, 10, ' ', 1, 0, 'C');
    //     $this->Cell(35, 10, 'partNumber', 1, 0, 'C');
    //     $this->Cell(20, 10, 'revisionId', 1, 0, 'C');
    //     $this->Cell(25, 10, 'partName', 1, 0, 'C');
    //     $this->Cell(25, 10, 'poNumber', 1, 0, 'C');
    //     $this->Cell(25, 10, 'drNumber', 1, 0, 'C');
    //     $this->SetFont('Arial', 'B', 7);
    //     $this->Cell(10, 10, 'Quantity', 1, 0, 'C');
    //     $this->SetFont('Arial', 'B', 10);
    //     $this->Cell(25, 10, 'price', 1, 0, 'C');
    //     $this->Cell(25, 10, 'Amount', 1, 1, 'C');
    // }
    // function getTotal($nb)
    // {
    //     return $this->nb = $nb;
    // }
    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
       // $this->SetFillColor('RED');
        // $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    function AutoFitCell($w = '', $h = '', $font = '', $style = '', $fontSize = '', $string = '', $border = '', $ln = '', $align = '', $fill = '', $link = '')
    {
        $decrement = 0.1;
        $limit = round($w) - (round($w) / 3);

        $this->SetFont($font, $style, $fontSize);
        if (strlen($string) > $limit) {
            $string = substr($string, 0, $limit);
            $string .= '...';
        }

        while ($this->GetStringWidth($string) > $w) {
            $this->SetFontSize($fontSize -= $decrement);
        }

        return $this->Cell($w, $h, $string, $border, $ln, $align, $fill, $link);
    }
}
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetMargins(5, 5, 1, 1);
$pdf->AddPage();

$sqlSelect = "SELECT * FROM eric_db";
$query = $db->query($sqlSelect);
$i = 0;
if ($query->num_rows > 0) {
    while ($result = $query->fetch_assoc()) {
        // $id = $result['id'];
       
        ++$i;
        $color = ($i % 2 == 0)? '100,100,0' : '200,200,0';
        $pdf->SetFillColor($color);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 10, ++$s, 1, 0, 'C', TRUE);
        $pdf->Cell(20, 10, $result['firstName'], 1, 0, 'C',TRUE);
        $pdf->Cell(20, 10, $result['lastName'], 1, 0, 'C', TRUE);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(25, 10, $result['age'], 1, 0, 'C', TRUE);
        $pdf->Cell(25, 10, $result['gender'], 1, 0, 'C', TRUE);
        $pdf->Cell(20, 10, $result['birthday'], 1, 0, 'L', TRUE);
        $pdf->Cell(75, 10, $result['address'], 1, 1, 'L', TRUE);
       
    
    }
}

$pdf->Output();
?>
