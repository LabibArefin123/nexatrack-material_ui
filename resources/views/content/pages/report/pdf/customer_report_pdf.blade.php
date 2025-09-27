<!DOCTYPE html>
<html>

<head>
    <title>Customer Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Customer Report</h2>

    <table>
        <thead>
            <tr>
                <th>SL</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Company Name</th>
                <th>Area</th>
                <th>City</th>
                <th>Country</th>
                <th>Source</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $key => $customer)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->company_name }}</td>
                    <td>{{ implode(' ', array_slice(explode(' ', $customer->area), 0, 2)) }}</td>
                    <td>{{ $customer->city }}</td>
                    <td>{{ $customer->country }}</td>
                    <td>{{ $customer->source }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
