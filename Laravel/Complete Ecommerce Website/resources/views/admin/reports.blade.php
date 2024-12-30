@extends('admin.layouts.app')

@section('content')

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-container {
            margin-left: 20px;
            margin-right: 20px;
            margin-bottom: 100px;
        }

        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        .table td {
            background-color: white;
            text-align: center;
        }

        /* Hide elements during print */
        @media print {

            /* Hide the search bar, print button, and reset button */
            .card-body,
            .mb-3,
            .siderbar,
            .w3-top,
            .fixed-footer,
            .me-2 {
                display: none;
            }

            /* Style the table to be more printable */
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                padding: 8px;
                border: 1px solid #000;
            }
        }
    </style>
</head>

<body>

    <div class="w3-main" style="margin-top: 100px;">
        @if(session('message'))
        <div id="message" class="alert alert-success">
            {{ session('message') }}
        </div>
        @elseif(session('error'))
        <div id="message" class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ url('admin/reports') }}" method="get" class="d-flex">
                    <input type="number" name="year" value="{{ old('year', $yearQuery) }}" placeholder="Year" class="form-control me-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <button class="btn btn-outline-secondary ms-2" style="margin-left: 5px;">
                        <a href="{{ url('admin/reports') }}" class="text-decoration-none text-reset">Reset</a>
                    </button>
                </form>
            </div>
        </div>

        <!-- Print Button -->
        <!-- Print Button -->
        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('reports.pdf', ['year' => $yearQuery]) }}" class="btn btn-secondary me-2" target="_blank">Print Report</a>
        </div>


        <!-- Table Container -->
        <div class="table-container">
            <h3 class="text-center">Report for Year: {{ $yearQuery }}</h3>
            <table class="table table-striped" id="reportTable">
                <thead>
                    <tr>
                        <th>Category</th>
                        @for ($month = 1; $month <= 12; $month++)
                            <th>{{ \Carbon\Carbon::create()->month($month)->format('F') }}</th>
                            @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        @for ($month = 1; $month <= 12; $month++)
                            <td>{{ $monthlyReport[$category->name][$month] ?? 0 }}</td>
                            @endfor
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- New Table for Totals -->
            <h4 class="text-center mt-5">Total for All Categories</h4>
            <table class="table table-striped" id="totalReportTable">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            @php
                            $total = 0;
                            for ($month = 1; $month <= 12; $month++) {
                                $total +=$monthlyReport[$category->name][$month] ?? 0;
                                }
                                @endphp
                                {{ $total }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
@endsection