<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To BENGEDMS</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #EBECEC;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header img {
            max-height: 90px;
        }
        .content {
            padding: 20px;
            color: #333333;
        }
        .content p {
            line-height: 1.6;
        }
        .content ul {
            padding-left: 20px;
        }
        .content ul li {
            margin-bottom: 10px;
        }
        .button {
            text-align: center;
            margin-top: 20px;
        }
        .button a {
            text-decoration: none;
            color: #ffffff;
            background-color: #009CFF !important;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }
        .footer {
            background-color: #009CFF !important;
            padding: 10px;
            text-align: center;
            color:rgb(255, 255, 255);
            font-size: 14px;
        }
        .footer img {
            height: 20px;
            vertical-align: middle;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://edms.benuestate.gov.ng/landing/images/benue_new_logo.svg" style="border-radius: 1em" height="50" alt="Logo">
        </div>
        <div class="content">
            <p>Dear {{ $recipientName }},</p>
            <p>
                We are thrilled to welcome you to <strong>{{ $appName }}</strong>. 
                It’s our pleasure to have you join our community, and we are excited 
                to support you as you embark on this journey with us. We are confident 
                that you'll have an exceptional experience and find immense value in 
                what we offer.
            </p>
            <p>
                Should you have any questions or need assistance, please don't hesitate 
                to reach out to us. We are here to help and ensure your experience with 
                us is seamless. You can contact us anytime at 
                <a href="mailto:{{ $contactMail }}">{{ $contactMail }}</a>.
            </p>
            <p>
                Once again, welcome aboard! We look forward to you having a great experience and seeing 
                all the amazing things you'll achieve with us.
            </p>
            <p>Best regards,</p>
            <p><strong>{{ $appName }} Team</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ $appName }}. All rights reserved.<br>
            Powered by: BDIC <img src="https://edms.benuestate.gov.ng/landing/images/BDIC%20logo%201%201.svg" alt="BDIC Logo">
        </div>
    </div>
</body>
</html>
