<?php
require_once('vendor/autoload.php');

// Connect to MySQL database
$conn = mysqli_connect('localhost', 'root', '', 'expenses_db');


// Query database to get table data
$query = "SELECT * FROM expenses";
$result = mysqli_query($conn, $query);

// Create HTML table
$html = '<table border="1" cellpadding="5" cellspacing="0" padding="8px">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>Title</th>';
$html .= '<th>Category</th>';
$html .= '<th>Date</th>';
$html .= '<th>Income</th>';
$html .= '<th>Expenses</th>';
$html .= '<th>Balance</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';
while ($row = mysqli_fetch_assoc($result)) {
  $html .= '<tr>';
  $html .= '<td>' . $row['title'] . '</td>';
  $html .= '<td>' . $row['category'] . '</td>';
  $html .= '<td>' . $row['date'] . '</td>';
  $html .= '<td>' . $row['income'] . '</td>';
  $html .= '<td>' . $row['expenses'] . '</td>';
  $html .= '<td>' . $row['income'] - $row['expenses'] . '</td>';
  $html .= '</tr>';
}
$html .= '</tbody>';
$html .= '</table>';



// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Khant');
$pdf->SetTitle('Expenses');
$pdf->SetSubject('Expenses');
$pdf->SetKeywords('PDF, document, example');


// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
  require_once(dirname(__FILE__).'/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// Add a page
$pdf->AddPage();

// Write HTML table to PDF document
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF file as binary download
$pdf->Output('my-table.pdf', 'D');

// Close MySQL connection
mysqli_close($conn);
?>