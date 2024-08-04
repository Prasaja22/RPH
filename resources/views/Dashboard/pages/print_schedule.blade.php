@extends('Dashboard.layouts')

@section('pages')
<div class="card" id="printableArea">
    <div class="card-body p-3">
        <div class="text-center mb-4">
            <h4><b>RENCANA PRODUKSI HARIAN ASSEMBLY</b></h4>
            <h4><b>PT INDOPRIMA GEMILANG</b></h4>
        </div>
        <hr>
        <h5 class="mb-4"><b>Tanggal : {{ \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('l, j F Y') }}</b></h5>
        @foreach($groupedSchedules as $shift => $lines)
            <div class="schedule-section">
                <h5>Shift: {{ $shift }}</h5>
                @foreach($lines as $line => $schedules)
                    <h6>Line: {{ $line }}</h6>
                    @foreach($schedules as $schedule)
                        <div class="line-shift-info">
                            <h5>LINE-{{ $schedule->line }} | Shift-{{ $schedule->shift }}</h5>
                        </div>
                        <table class="custom-table mb-4">
                            <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Partnumber</th>
                                    <th rowspan="2">Team</th>
                                    <th rowspan="2">Plan</th>
                                    <th rowspan="2">Lotnumber</th>
                                    <th rowspan="2">Qty</th>
                                    <th colspan="2">Target/Jam</th>
                                    <th rowspan="2">Act</th>
                                </tr>
                                <tr>
                                    <th>10:00</th>
                                    <th>14:00</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedule->details->groupBy('partnumber') as $partnumber => $details)
                                    @php
                                        $firstDetail = $details->first();
                                        $mergedLotNoQty = $details->map(function ($detail) {
                                            return [
                                                'lot_no' => $detail->lot_no,
                                                'qty' => $detail->qty,
                                            ];
                                        })->toArray();
                                    @endphp
                                    <tr>
                                        <td rowspan="{{ count($mergedLotNoQty) }}">{{ $loop->iteration }}</td>
                                        <td rowspan="{{ count($mergedLotNoQty) }}">{{ $firstDetail->partnumber }}</td>
                                        <td rowspan="{{ count($mergedLotNoQty) }}">{{ $firstDetail->team }}</td>
                                        <td rowspan="{{ count($mergedLotNoQty) }}">{{ $firstDetail->plan }}</td>
                                        <td>{{ $mergedLotNoQty[0]['lot_no'] }}</td>
                                        <td>{{ $mergedLotNoQty[0]['qty'] }}</td>
                                        <td rowspan="{{ count($mergedLotNoQty) }}">{{ round($firstDetail->target_perjam_1) }}</td>
                                        <td rowspan="{{ count($mergedLotNoQty) }}">{{ round($firstDetail->target_perjam_2) }}</td>
                                        <td rowspan="{{ count($mergedLotNoQty) }}">{{ $firstDetail->act }}</td>
                                    </tr>
                                    @for ($i = 1; $i < count($mergedLotNoQty); $i++)
                                        <tr>
                                            <td>{{ $mergedLotNoQty[$i]['lot_no'] }}</td>
                                            <td>{{ $mergedLotNoQty[$i]['qty'] }}</td>
                                        </tr>
                                    @endfor
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                @endforeach
            </div>
        @endforeach
    </div>
</div>
<div class="text-end">
    <button onclick="printContent();" class="btn btn-primary"><i class="ri-printer-fill"></i> Print</button>
</div>

<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    function printContent() {
        printJS({
            printable: 'printableArea',
            type: 'html',
            style: `
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 20px;
                }
                .custom-table {
                    width: 100%;
                    border-collapse: collapse;
                    text-align: center;
                    page-break-inside: avoid;
                }
                .custom-table th, .custom-table td {
                    border: 1px solid black;
                    padding: 8px;
                    vertical-align: middle;
                    font-size: 14px;
                }
                .custom-table th {
                    background-color: #f2f2f2;
                }
                .custom-table th[colspan="2"] {
                    text-align: center;
                }
                .custom-table th[rowspan="2"] {
                    vertical-align: middle;
                }
                .custom-table thead tr:first-child th {
                    border-bottom: none;
                }
                .custom-table thead tr:nth-child(2) th {
                    border-top: 1px solid black;
                }
                .custom-table th.no-border {
                    border-right: none;
                    border-left: none;
                }
                .text-center {
                    text-align: center;
                }
                h4, h5, h6 {
                    margin: 0;
                    padding: 5px 0;
                }
                hr {
                    border: none;
                    border-top: 3px solid black;
                    margin: 20px 0;
                }
                .schedule-section {
                    page-break-inside: avoid;
                    margin-bottom: 20px;
                }
                @media print {
                    .custom-table thead {
                        display: table-header-group;
                    }
                    .custom-table tbody {
                        display: table-row-group;
                    }
                    .text-center {
                        text-align: center;
                    }
                    .print-header {
                        display: block;
                    }
                }
            `
        });
    }
</script>
@endsection
