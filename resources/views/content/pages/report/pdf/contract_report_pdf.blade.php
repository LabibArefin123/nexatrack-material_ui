<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contract Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Contract Report</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Subject</th>
                <th>Customer</th>
                <th>Type</th>
                <th>Value</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reportData as $contract)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $contract->subject }}</td>
                    <td>{{ $contract->customer->name ?? '-' }}</td>
                    <td>{{ $contract->type_name }}</td>
                    <td>{{ number_format($contract->value, 2) }}</td>
                    <td>{{ $contract->start_date }}</td>
                    <td>{{ $contract->end_date }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No contracts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <p>Total Contracts: {{ $reportData->count() }}</p>
        <p>Total Value: {{ number_format($reportData->sum('value'), 2) }}</p>
    </div>
</body>

</html>
