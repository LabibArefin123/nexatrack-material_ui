<!DOCTYPE html>
<html>

<head>
    <title>Plan Report</title>
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
    <h2 style="text-align: center;">plan Report</h2>

    <table>
        <thead>
            <tr>
                <th>SL</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Company Name</th>
                <th>Area</th>
                <th>City</th>
                <th>Plan</th>
                <th>Country</th>
                <th>Source</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $key => $plan)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $plan->name }}</td>
                    <td>{{ $plan->email }}</td>
                    <td>{{ $plan->company_name }}</td>
                    <td>{{ implode(' ', array_slice(explode(' ', $plan->area), 0, 2)) }}</td>
                    <td>{{ $plan->city }}</td>
                    <td>{{ $plan->plan }}</td>
                    <td>{{ $plan->country }}</td>
                    <td>{{ $plan->source }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
