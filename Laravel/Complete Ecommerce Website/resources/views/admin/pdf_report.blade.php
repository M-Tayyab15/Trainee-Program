<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #000;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body>

    <!-- Monthly Report Table -->
    <h3>Report for Year: {{ $yearQuery }}</h3>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                @foreach (range(1, 12) as $month)
                    <th>{{ \Carbon\Carbon::create()->month($month)->format('F') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($structuredData as $category => $months)
                <tr>
                    <td>{{ $category }}</td>
                    @foreach ($months as $month => $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total Report Table -->
    <h4 class="text-center mt-5">Total for All Categories</h4>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($structuredData as $category => $months)
                <tr>
                    <td>{{ $category }}</td>
                    <td>
                        @php
                            $total = 0;
                            // Sum the values across all 12 months
                            foreach ($months as $month => $value) {
                                $total += $value;
                            }
                        @endphp
                        {{ $total }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
