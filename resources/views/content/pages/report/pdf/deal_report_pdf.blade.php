<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Deal Report PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
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
            padding: 6px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Deal Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Stage</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Source</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reportData as $deal)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $deal->name }}</td>
                    <td>{{ ucfirst($deal->deal_stage) }}</td>
                    <td>{{ ucfirst($deal->deal_type) }}</td>
                    <td>{{ number_format($deal->amount) }}</td>
                    <td>{{ $deal->currency }}</td>
                    <td>{{ $deal->source }}</td>
                    <td>{{ $deal->start_date }}</td>
                    <td>{{ $deal->end_date }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">No deals found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
