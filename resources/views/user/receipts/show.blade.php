<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>DMS Receipt</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .form_field_border {
            border-color: #666 !important;
            color: #333 !important;
        }

        .paid-watermark {
            position: relative;
            
            overflow: hidden;
            /* Prevent overflow of the watermark */
        }

        .paid-watermark::before {
            content: "PAID";
            /* Text for the watermark */
            position: absolute;
            /* Positioning the watermark */
            top: 50%;
            /* Center vertically */
            left: 50%;
            /* Center horizontally */
            transform: translate(-50%, -50%);
            /* Adjust for centering */
            font-size: 48px;
            /* Adjust font size */
            font-weight: bold;
            /* Make the text bold */
            color: rgba(6, 7, 6, 0.5);
            /* Light gray color with transparency */
            pointer-events: none;
            /* Ensure it doesn't interfere with table interactions */
            z-index: 1;
            /* Place it behind the table content */
        }

        @media print {
            .paid-watermark::before {
            content: "PAID";
            /* Text for the watermark */
            position: absolute;
            /* Positioning the watermark */
            top: 50%;
            /* Center vertically */
            left: 50%;
            /* Center horizontally */
            transform: translate(-50%, -50%);
            /* Adjust for centering */
            font-size: 48px;
            /* Adjust font size */
            font-weight: bold;
            /* Make the text bold */
            color: rgba(6, 7, 6, 0.5);
            /* Light gray color with transparency */
            pointer-events: none;
            /* Ensure it doesn't interfere with table interactions */
            z-index: 1;
            /* Place it behind the table content */
        }
        }
    </style>
</head>

<body>
    <!-- Invoice 1 - Bootstrap Brain Component -->
    <section class="py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9 col-xl-8 col-xxl-7">
                    <div class="row gy-3 mb-3">
                        <div class="col-12 text-center">
                            <a class="d-block text-center" href="#!">
                                <img src="{{ asset('BDIC Logo with name PNG.png') }}" class="img-fluid"
                                    alt="BDIC DMS Logo" width="135" height="44">
                            </a>
                        </div>
                        <div class="col-12">
                            <h2 class="text-uppercase text-endx m-0 text-center">Payment Receipt</h2>
                        </div>
                    </div>
                    <div class="row mb-3" style="background-color: #eeeee6;">
                        <div class="col-12 col-sm-6 col-md-7">
                            <h4>Received From</h4>
                            <address>
                                <strong>{{ $authUser->name }}</strong><br>
                                Phone: {{ $user->userDetail->phone_number }}<br>
                                Email: {{ $user->email }}
                            </address>
                        </div>
                        <div class="col-12 col-sm-6 col-md-5">
                            <h5 class="row">
                                <span class="col-6">Receipt # </span>
                                <span class="col-6 text-sm-end">RCT-001</span>
                            </h5>
                            <div class="row">
                                <span class="col-6">Date:</span>
                                <span
                                    class="col-6 text-sm-end">{{ date('Y-m-d', strtotime($receipt->transDate)) }}</span>
                                <span class="col-6">Time:</span>
                                <span
                                    class="col-6 text-sm-end">{{ date('H:i:s', strtotime($receipt->transDate)) }}</span>
                            </div>
                        </div>
                    </div>
                    <h4>Being payment for:</h4>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="table-responsive paid-watermark">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-uppercase">Qty</th>
                                            <th scope="col" class="text-uppercase">Description</th>
                                            <th scope="col" class="text-uppercase text-end">Unit Price</th>
                                            <th scope="col" class="text-uppercase text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Document Filling {{ $receipt->docuent_number }}</td>
                                            <td class="text-end">N{{ $receipt->transAmount }}</td>
                                            <td class="text-end">N{{ $receipt->transAmount }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">Subtotal</td>
                                            <td class="text-end">N{{ $receipt->transAmount }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">Proccessing fee</td>
                                            <td class="text-end">N{{ $receipt->transFee }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="3" class="text-uppercase text-end">Total</th>
                                            <td class="text-end">N{{ $receipt->transTotal }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <p class="mb-3">Received with thanks...</p>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-primary mb-3" onclick="downloadReceipt()">Download
                                Receipt</button>
                            <button type="button" class="btn btn-success mb-3" onclick="printReceipt()">Print
                                Receipt</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Include html2pdf.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        function downloadReceipt() {
            // Select the content you want to convert to PDF
            const element = document.querySelector('section').cloneNode(true);

            // Remove the buttons from the cloned content
            const buttons = element.querySelectorAll('button');
            buttons.forEach(button => button.remove());

            // Options for the PDF
            const options = {
                margin: 1,
                filename: 'receipt.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 3
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a3',
                    orientation: 'portrait'
                }
            };

            // Generate and download the PDF
            html2pdf().from(element).set(options).save();
        }

        function printReceipt() {
            const printContent = document.querySelector('section').cloneNode(true);
            const buttons = printContent.querySelectorAll('button');
            buttons.forEach(button => button.remove());

            const printWindow = window.open('', '', 'height=900,width=800');
            printWindow.document.write('<html><head><title>Print Receipt</title>');
            printWindow.document.write('<style>@media print { .paid-watermark::before { color: rgba(6, 7, 6, 0.5); } }</style>');
            printWindow.document.write(
                '<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">');
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContent.innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</body>

</html>
