<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;

class PDFController extends Controller
{
    public function generatePDF()
    {
        // Dummy data simulating the content of strukorder table
        $orders = [
            ['id' => 1, 'product_id' => 1, 'quantity' => 10],
            ['id' => 2, 'product_id' => 2, 'quantity' => 5],
            ['id' => 3, 'product_id' => 1, 'quantity' => 7],
            ['id' => 4, 'product_id' => 2, 'quantity' => 3],
        ];

        // Iterate through orders and print each product
        foreach ($orders as $order) {
            $product = $this->getProductDetails($order['product_id']);
            $html = View::make('pdf_view', compact('product'))->render();
            $dompdf = new Dompdf();
            $dompdf->setPaper([0, 0, 5 * 28.35, 5 * 28.35], 'portrait'); // 5 x 5 cm
            $dompdf->loadHtml($html);
            $dompdf->render();

            // Save PDF to file
            $pdfPath = public_path('document_' . $order['id'] . '.pdf');
            file_put_contents($pdfPath, $dompdf->output());

            // Determine printer name based on the product's label color
            $printerName = $this->determinePrinterName($product['label_color']);

            // Initialize cURL session to print
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, env('PRINT_NODE_API') . '/print');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $postFields = [
                'file' => new \CURLFile($pdfPath, 'application/pdf', 'document_' . $order['id'] . '.pdf'),
                'printerName' => $printerName
            ];
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

            // Execute cURL request
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                curl_close($ch);
                return redirect()->back()->with('error', 'Failed to send PDF to printer: ' . $error_msg);
            }
            curl_close($ch);
        }

        return view('handle_pdf')->with('success', 'All PDFs sent to printers successfully.');
    }

    private function getProductDetails($productId)
    {
        $products = [
            1 => ['name' => 'Product A', 'label_color' => 'white'],
            2 => ['name' => 'Product B', 'label_color' => 'blue']
        ];

        return $products[$productId] ?? ['name' => 'Unknown', 'label_color' => 'default'];
    }

    private function determinePrinterName($labelColor)
    {
        switch ($labelColor) {
            case 'white':
                return 'EPSON LX-310 ESC/P';
            case 'blue':
                return 'Microsoft Print to PDF';
            default:
                return 'default_printer';
        }
    }



    public function downloadPDF()
    {
        $pdfPath = public_path('document.pdf');

        if (File::exists($pdfPath)) {
            return response()->download($pdfPath, 'document.pdf')->deleteFileAfterSend(true);
        }

        return redirect()->back()->with('error', 'PDF not found');
    }

    public function getPrinterList(Request $request)
    {
        dd($request->all());
    }
}
