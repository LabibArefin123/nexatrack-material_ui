<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Customers Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 9px;
            line-height: 1.2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 3px;
            border: 1px solid #000;
            text-align: left;
            word-wrap: break-word;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            font-size: 14px;
            margin-bottom: 8px;
        }
    </style>
</head>

<body>
    <h2>Customer Report</h2>
    <table>
        <thead>
            <tr>
                <th>SL</th>
                <th>Software</th>
                <th>Name</th>
                <th>Company Name</th>
                <th>Address</th>
                <th>Area</th>
                <th>City</th>
                <th>Country</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $index => $customer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $customer->software }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->company_name }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->area }}</td>
                    <td>{{ $customer->city }}</td>
                    <td>{{ $customer->country }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
