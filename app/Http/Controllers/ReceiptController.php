<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Service;
use TCPDF;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Sendpulse;

class ReceiptController extends Controller
{
    use Sendpulse;
    public function generateReceiptPDF(Request $request)
    {
        $validatedData = $request->validate([
            'patient' => 'required|string',
        ]);

        $patient = Patient::find($validatedData['patient']);
        $selectedServices = json_decode($patient->services, true);

        // Check if an old receipt exists and delete it
        if ($patient->receipt_id) {
            $oldReceiptPath = storage_path('app/public/invoice/' . $patient->receipt_id . '.pdf');
            if (file_exists($oldReceiptPath)) {
                unlink($oldReceiptPath);
            }
        }
        
        // Get the current date in YYMMDD format
        $datePrefix = now()->format('ymd');
        
        // Generate the new receipt ID with format JKON{YYMMDD}01
        $latestReceipt = Patient::where('receipt_id', 'like', 'JKON' . $datePrefix . '%')
            ->orderBy('receipt_id', 'desc')
            ->first();
        
        // If there's already an invoice with today's date, increment the last two digits
        if ($latestReceipt) {
            $lastInvoiceNumber = (int) substr($latestReceipt->receipt_id, -2);
            $receiptId = 'JKON' . $datePrefix . str_pad($lastInvoiceNumber + 1, 2, '0', STR_PAD_LEFT);
        } else {
            // Otherwise, start with 01 for today
            $receiptId = 'JKON' . $datePrefix . '01';
        }
        


        // Generate a new receipt ID
        $patient->receipt_id = $receiptId;
        $patient->payment_date = now()->format('d:m:y');
        $patient->payment_status = 'Paid';
        $patient->save(); // Save the new receipt ID to the database

        // Initialize the items array
        $items = [];

        foreach ($selectedServices as $selectedService) {
            $service = Service::find($selectedService);

            // Append each service to the items array
            $items[] = [
                'name' => $service->name,
                'price' => $service->price,
                'quantity' => 1,
            ];
        }

        $pdf = new TCPDF;
        $pdf->SetTitle('Receipt');
        $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetFont('dejavusans', '', 12, '', true);
        $pdf->AddPage();

        $html = '
        <div style="display:flex; text-align: center; padding-bottom: 20px; border-bottom: 2px solid #ddd;">
            <div>
                <img src="https://joykonark.com/wp-content/uploads/2024/05/logo.png" alt="Logo" style="height: 100px;">
            </div>
            <div>
                <h2 style="margin-top: -10px;">Joy konark CBCT Centre</h2>
                <p style="margin: 0;">374, 2nd Floor, Sector 16, Vasundhara, Ghaziabad Pin - 201012</p>
                <p style="margin: 0;">Email: <a href="mailto:accounts@joykonark.com">accounts@joykonark.com</a> | Phone: +91-9599621367</p>
            </div>
        </div>';

        $html .= '
        <div style="margin-top: 20px;">
            <table style="width: 100%; margin-bottom: 20px;">
                <tr>
                    <td><strong>Invoice #:</strong> '.$receiptId.'</td>
                    <td style="text-align: right;"><strong>Date:</strong> '.$patient->created_at->format('d-m-y').'</td>
                </tr>
                <tr>
                    <td><strong>Billed To:</strong> '.$patient->name.'</td>
                    <td style="text-align: right;"><strong>Phone:</strong> +'.$patient->phone.'</td>
                </tr>
            </table>
        </div>';

        $html .= '
        <table border="1" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; margin-top: 10px;">
            <thead style="background-color: #f2f2f2;">
                <tr>
                    <th style="border: 1px solid #ddd; text-align: center; font-weight: bold;">No.</th>
                    <th style="border: 1px solid #ddd; text-align: left; font-weight: bold;">Item</th>
                    <th style="border: 1px solid #ddd; text-align: right; font-weight: bold;">Price (INR)</th>
                    <th style="border: 1px solid #ddd; text-align: center; font-weight: bold;">Quantity</th>
                    <th style="border: 1px solid #ddd; text-align: right; font-weight: bold;">Total (INR)</th>
                </tr>
            </thead>
            <tbody>';

        $total = 0;
        foreach ($items as $index => $item) {
            $html .= '
            <tr>
                <td style="border: 1px solid #ddd; text-align: center;">'.($index + 1).'</td>
                <td style="border: 1px solid #ddd; text-align: left;">'.$item['name'].'</td>
                <td style="border: 1px solid #ddd; text-align: right;">'.$item['price'].'</td>
                <td style="border: 1px solid #ddd; text-align: center;">'.$item['quantity'].'</td>
                <td style="border: 1px solid #ddd; text-align: right;">'.$item['price'].'</td>
            </tr>';
            $total += $item['price'];
        }

        $html .= '
            </tbody>
        </table>';

        $html .= '
        <div style="text-align: right; margin-top: 20px; font-size: 14px;">
            <p><strong>Sub Total:</strong> ₹'.$total.'</p>
            <p><strong>Discount:</strong> ₹'.($patient->discount ?? 0).'</p>
            <p><strong>Total:</strong> ₹'.($total - $patient->discount).'</p>
        </div>';

        $html .= '
        <div style="margin-top: 30px; padding-top: 10px; border-top: 2px solid #ddd; text-align: center;">
            <p style="margin: 0; font-size: 12px;">Thank you for trusting us!</p>
            <p style="margin: 0; font-size: 12px;">This is a system generated invoice. <br> If you have any questions, feel free to contact us at <a href="mailto:accounts@joykonark.com">accounts@joykonark.com</a>.</p>
        </div>';

        $pdf->writeHTML($html, true, false, true, false, '');

        // Save the PDF to the storage/app/public/invoice directory
        $pdf->Output(storage_path('app/public/invoice/' . $receiptId . '.pdf'), 'F');

        $invoiceLink = 'https://admin.joykonark.com/storage/invoice/' . $receiptId . '.pdf';
        $accessToken = $this->getSendPulseAccessToken();
        $formatedPhone = $patient->phone;
        $sendTemplateResponse = $this->sendTemplatebyPhone($patient->name, $formatedPhone, $receiptId, $invoiceLink, $accessToken);

        $responseArray = [
        'message' => 'Receipt generated and saved successfully.',
        'file_path' => 'https://admin.joykonark.com/storage/invoice/' . $receiptId . '.pdf',
        'send_template_response' => $sendTemplateResponse // Add the API response here
    ];
        // return response()->download($invoiceLink)->with('success', 'Invoice sent successfully.');
        return redirect()->back()->with('success', 'Invoice sent successfully.');
    // return response()->json($responseArray);
    }

    public function receipt()
    {
        return view('payment.index');
    }
}
