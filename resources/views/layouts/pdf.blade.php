<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        h2 {
            text-align: center;
            font-weight: 700;
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .summary {
            margin-bottom: 30px;
            font-weight: 600;
            text-align: center;
        }
        .summary h4 {
            margin-bottom: 10px;
            font-size: 18px;
            color: #34495e;
            border-bottom: 2px solid #2980b9;
            padding-bottom: 5px;
        }
        .summary p {
            font-size: 18px; /* bigger font */
            margin: 8px 0;
            font-weight: 700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #2980b9;
            color: white;
            font-weight: 700;
            padding: 12px;
            text-transform: uppercase;
            font-size: 13px;
        }
        td {
            padding: 10px;
            font-size: 13px;
            vertical-align: middle;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            color: white;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }
        .badge-success { background-color: #27ae60; }
        .badge-warning { background-color: #f39c12; }
        .badge-danger { background-color: #c0392b; }

        .chart-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .chart-container img {
            max-width: 400px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
