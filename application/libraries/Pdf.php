<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter PDF Library
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Muhanz
 * @license			MIT License
 * @link			https://github.com/hanzzame/ci3-pdf-generator-library
 *
 */


use Dompdf\Dompdf;
use Dompdf\Options;
class Pdf
{
	public function create($html,$filename,$location)
    {
	    $dompdf = new Dompdf();
	    $options = new Options();
	    $options->setIsRemoteEnabled(true);

	    $dompdf->setOptions($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
	    $dompdf->render();
	    $output = $dompdf->output();
	    $location = $location.$filename.'.pdf';
	    file_put_contents($location, $output);
  	}

  	public function download_pdf($html,$filename)
    {
	    $dompdf = new Dompdf();
	    $options = new Options();
	    $options->setIsRemoteEnabled(true);

	    $dompdf->setOptions($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
	    $dompdf->render();
        $dompdf->stream($filename.'.pdf');
        

        // $dompdf = new Dompdf();
        // $dompdf->loadHtml('hello world');

        // // (Optional) Setup the paper size and orientation
        // $dompdf->setPaper('A4', 'landscape');

        // // Render the HTML as PDF
        // $dompdf->render();

        // // Output the generated PDF to Browser
        // $dompdf->stream('tesy.pdf');
  	}
}