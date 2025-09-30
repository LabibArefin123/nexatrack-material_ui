<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Lead Report PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Lead Report</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Assigned To</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reportData as $index => $lead)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $lead->customer->name ?? '-' }}</td>
                    <td>{{ $lead->customer->email ?? '-' }}</td>
                    <td>{{ $lead->customer->phone ?? '-' }}</td>
                    <td>
                        <span
                            class="badge 
                                    @if ($lead->status === 'contacted') bg-success 
                                    @elseif($lead->status === 'not_contacted') bg-warning 
                                    @elseif($lead->status === 'closed') bg-primary 
                                    @elseif($lead->status === 'lost') bg-danger 
                                    @else bg-secondary @endif">
                            {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                        </span>
                    </td>
                    <td>{{ $lead->plan }}</td>
                    <td>{{ number_format($lead->amount) }} Tk</td>
                    <td>{{ $lead->assignedUser->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($lead->created_at)->format('d M, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
