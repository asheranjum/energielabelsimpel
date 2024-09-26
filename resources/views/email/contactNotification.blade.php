<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 7px;
        }
        .header {
            background: #e9e9e9;
            padding: 10px 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .header h2 {
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .footer {
            text-align: center;
            padding: 10px 20px;
            background: #e9e9e9;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Query</h2>
        </div>
        <div class="content">
            <p><strong>Voornaam:</strong>  {{$details['first_name']}} </p>
            <p><strong>Achternaam:</strong> {{$details['last_name']}}</p>
            <p><strong>Woon of bedrijfsadres (met plaats en postcode):</strong>  {{$details['address_1']}}</p>
            <p><strong>Projectadres (met plaats en postcode):</strong>  {{$details['address_2']}}</p>
            <p><strong>Email:</strong> <a href="mailto:{{$details['email']}}">{{$details['email']}}</a></p>
            <p><strong>Telefoonnummer:</strong> <a href="tell:{{$details['phone']}}">{{$details['phone']}}</a></p>
            <p><strong>Uw vraag:</strong></p>
            <p>{{$details['question']}}</p>
        </div>
        <div class="footer">
            <p>This is an automated message. Please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html>
