<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Internal Memo</title>
    <meta name="viewport" content="width=850">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f4f7fa;
            margin: 0;
            padding: 40px 0;
            font-family: 'Roboto', Arial, sans-serif;
        }

        .memo-container {
            background: #fff;
            width: 900px;
            min-height: 900px;
            margin: 0 auto;
            box-shadow: 0 4px 32px rgba(0, 0, 0, 0.12);
            border-radius: 10px;
            padding: 60px 60px 40px 60px;
            position: relative;
            border-top: 6px solid #254e7b;
            border-bottom: 6px solid #254e7b;
        }

        .letterhead {
            text-align: center;
            margin-bottom: 32px;
            border-bottom: 2px solid #e3e7ec;
            padding-bottom: 18px;
        }

        .logo {
            width: 70px;
            height: 70px;
            margin: 0 auto 10px auto;
            background: url({{ asset('logos/' . $senderUser->userDetail->tenant->logo ?? 'landing/images/Benue_New_Logo.png') }}) no-repeat center center;
            /* background: url('https://upload.wikimedia.org/wikipedia/commons/4/4a/Logo_2013_Google.png') no-repeat center center; */
            background-size: contain;
            display: block;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(37, 78, 123, 0.12);
        }

        .org-name {
            font-size: 1.5em;
            font-weight: 700;
            color: #254e7b;
            margin: 0;
            letter-spacing: 1px;
            text-align: center;
        }

        .org-address {
            font-size: 1em;
            color: #6b7a8f;
            margin-top: 4px;
            text-align: center;
        }

        .memo-title {
            text-align: center;
            font-size: 1.0em;
            font-weight: 700;
            color: #254e7b;
            letter-spacing: 2px;
            margin: 36px 0 32px 0;
            text-transform: uppercase;
            letter-spacing: 4px;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 32px;
            font-size: 1.05em;
            color: #333;
            border-collapse: separate;
            border-spacing: 0;
            border-top: 2px solid #254e7b;
            border-bottom: 2px solid #254e7b;
        }

        .meta-table td {
            padding: 9px 12px 9px 0;
            vertical-align: top;
        }

        .meta-label {
            font-weight: 700;
            color: #254e7b;
            width: 120px;
            white-space: nowrap;
        }

        .meta-divider {
            width: 2px;
            min-width: 2px;
            max-width: 2px;
            background: #254e7b;
            padding: 0;
            margin: 0 8px;
        }

        .memo-body {
            font-size: 1.15em;
            color: #222;
            line-height: 1.7;
            margin-bottom: 40px;
        }

        .signature {
            margin-top: 60px;
        }

        .signature .name {
            font-weight: 700;
            color: #254e7b;
            font-size: 1.1em;
        }

        .footer {
            position: absolute;
            bottom: 24px;
            left: 0;
            width: 100%;
            text-align: center;
            color: #b3b9c5;
            font-size: 0.95em;
            letter-spacing: 1px;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .memo-container {
                box-shadow: none;
                border-radius: 0;
                margin: 0;
            }

            .footer {
                position: static;
            }
        }
    </style>
</head>

<body>
    <div class="memo-container">
        <div class="letterhead">
            <div class="logo"></div>
            <div class="org-address">{{ $senderUser->userDetail->tenant->name }}</div>
        </div>
        <div class="memo-title">INTERNAL MEMO</div>
        <table class="meta-table">
            <tr>
                <td class="meta-label">To:</td>
                <td>{{ $memo->receiver }}</td>
                <td class="meta-divider"></td>
                <td class="meta-label">Date:</td>
                <td>{{ $memo->created_at->format('M j, Y') }}</td>
            </tr>
            <tr>
                <td class="meta-label">From:</td>
                <td>
                    {{ $memo->sender . ', ' }}
                    {{ $senderUser->userDetail->designation }}

                </td>
                <td class="meta-divider"></td>
                <td class="meta-label">Subject:</td>
                <td>{{ $memo->title }}</td>
            </tr>
        </table>
        <div class="memo-body">
            <p>
                Dear Sir/Madam,
            </p>
            {{-- <p>{{$memo->content}}</p> --}}
            <div style="white-space: pre-wrap;">{{ $memo->content }}</div>

        </div>
        <div class="signature">
            <div class="name">{{ $senderUser->name }}</div>
            <div>{{ $senderUser->userDetail->signature }}</div>
            <div>{{ $senderUser->userDetail->designation }}</div>
        </div>
        <div class="footer">
            &mdash; Internal Memo &mdash;
        </div>
        {{-- <button class="btn btn-danger" id="download-pdf-btn">
                <i class="fa fa-file-pdf-o"></i> Download PDF
            </button> --}}
    </div>
    {{-- <button id="download-pdf" class="btn btn-primary">
        <i class="fa fa-file-pdf-o"></i> Download as PDF
    </button> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    {{-- <script>
        document.getElementById('download-pdf').addEventListener('click', function() {
            // Select the content you want to export
            const memoContent = document.querySelector('.memo-container');
            html2canvas(memoContent).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new window.jspdf.jsPDF('p', 'mm', 'a4');
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pageWidth;
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save('memo.pdf');
            });
        });
    </script> --}}
{{-- <script>
        document.getElementById('download-pdf-btn').addEventListener('click', function() {
            const memoContent = document.querySelector('.memo-container');
            html2canvas(memoContent).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new window.jspdf.jsPDF('p', 'mm', 'a4');
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pageWidth;
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save('memo.pdf');
            });
        });
    </script> --}}

    <script>
document.getElementById('download-pdf-btn').addEventListener('click', function() {
    const memoContent = document.querySelector('.memo-container');
    html2canvas(memoContent, { scale: 2 }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new window.jspdf.jsPDF('p', 'mm', 'a3');
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();

        // Calculate the number of pages
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pageWidth;
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        let heightLeft = pdfHeight;
        let position = 0;

        // Add first page
        pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
        heightLeft -= pageHeight;

        // Add more pages if necessary
        while (heightLeft > 0) {
            position = heightLeft - pdfHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
            heightLeft -= pageHeight;
        }

        pdf.save('memo.pdf');
    });
});
</script>
 
</body>

</html>

{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Internal Memo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">

  <style>
    body {
      background: #f4f7fa;
      font-family: 'Roboto', Arial, sans-serif;
      padding-top: 30px;
    }
    .memo-container {
      background: #fff;
      border-top: 6px solid #254e7b;
      border-bottom: 6px solid #254e7b;
      padding: 40px 30px;
      box-shadow: 0 4px 32px rgba(0,0,0,0.12);
      border-radius: 10px;
    }
    .logo {
      width: 70px;
      height: 70px;
      margin: 0 auto 10px auto;
      background: url({{ asset('logos/' . $senderUser->userDetail->tenant->logo ?? 'landing/images/Benue_New_Logo.png') }}) no-repeat center center;
      background-size: contain;
      display: block;
      border-radius: 50%;
      box-shadow: 0 2px 8px rgba(37,78,123,0.12);
    }
    .org-address {
      font-size: 1rem;
      color: #6b7a8f;
    }
    .memo-title {
      text-align: center;
      font-size: 1.2rem;
      font-weight: bold;
      color: #254e7b;
      margin: 30px 0 20px;
      text-transform: uppercase;
      letter-spacing: 3px;
    }
    .meta-label {
      font-weight: 700;
      color: #254e7b;
      white-space: nowrap;
    }
    .meta-divider {
      width: 100%;
      height: 2px;
      background: #254e7b;
      margin: 10px 0;
    }
    .memo-body {
      font-size: 1rem;
      color: #222;
      line-height: 1.7;
      margin-bottom: 30px;
    }
    .signature .name {
      font-weight: 700;
      color: #254e7b;
      font-size: 1.1rem;
    }
    .footer {
      text-align: center;
      color: #b3b9c5;
      font-size: 0.95em;
      letter-spacing: 1px;
      margin-top: 40px;
    }
    @media print {
      body {
        background: #fff;
      }
      .memo-container {
        box-shadow: none;
        border-radius: 0;
        margin: 0;
      }
      .footer {
        position: static;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="memo-container">
    <!-- Header -->
    <div class="text-center mb-4 border-bottom pb-3">
      <div class="logo"></div>
      <h5 class="org-address">{{ $senderUser->userDetail->tenant->name }}</h5>
    </div>

    <!-- Title -->
    <h3 class="memo-title">Internal Memo</h3>

    <!-- Meta Information -->
    <div class="mb-4">
      <div class="row">
        <div class="col-md-6 mb-2">
          <span class="meta-label">To:</span> {{ $memo->receiver }}
        </div>
        <div class="col-md-6 mb-2">
          <span class="meta-label">Date:</span> {{ $memo->created_at->format('M j, Y') }}
        </div>
        <div class="col-md-6 mb-2">
          <span class="meta-label">From:</span> {{ $memo->sender }}, {{ $senderUser->userDetail->designation }}
        </div>
        <div class="col-md-6 mb-2">
          <span class="meta-label">Subject:</span> {{ $memo->title }}
        </div>
      </div>
    </div>
<!-- Meta Information -->
<div class="mb-4">
  <div class="row align-items-start">
    <!-- To -->
    <div class="col-md-5 mb-2">
      <span class="meta-label">To:</span> {{ $memo->receiver }}
    </div>

    <!-- Vertical Divider -->
    <div class="col-md-1 d-none d-md-flex justify-content-center">
      <div style="width: 2px; height: 100%; background-color: #254e7b;"></div>
    </div>

    <!-- Date -->
    <div class="col-md-6 mb-2">
      <span class="meta-label">Date:</span> {{ $memo->created_at->format('M j, Y') }}
    </div>

    <!-- From -->
    <div class="col-md-5 mb-2">
      <span class="meta-label">From:</span> {{ $memo->sender }}, {{ $senderUser->userDetail->designation }}
    </div>

    <!-- (Optional vertical divider for second row) -->
    <div class="col-md-1 d-none d-md-flex justify-content-center">
      <div style="width: 2px; height: 100%; background-color: #254e7b;"></div>
    </div>

    <!-- Subject -->
    <div class="col-md-6 mb-2">
      <span class="meta-label">Subject:</span> {{ $memo->title }}
    </div>
  </div>
</div>

    <!-- Divider -->
    <div class="meta-divider"></div>

    <!-- Memo Body -->
    <div class="memo-body">
      <p>Dear Sir/Madam,</p>
      <p>{{ $memo->content }}</p>
    </div>

    <!-- Signature -->
    <div class="signature mt-5">
      <div class="name">{{ $senderUser->name }}</div>
      <div>{{ $senderUser->userDetail->signature }}</div>
      <div>{{ $senderUser->userDetail->designation }}</div>
    </div>

    <!-- Footer -->
    <div class="footer mt-4">
      &mdash; Internal Memo &mdash;
    </div>
  </div>
</div>

</body>
</html> --}}
