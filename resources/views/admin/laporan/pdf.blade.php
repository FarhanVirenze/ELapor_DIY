<!DOCTYPE html>
<html>

<head>
    <title>Laporan Aduan PDF</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm 5mm 10mm 5mm;
        }

        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-left img {
            width: 60px;
            height: auto;
            margin-right: 10px;
        }

        .header-left .instansi {
            font-size: 14px;
            font-weight: bold;
            line-height: 1.2;
        }

        .tanggal-cetak {
            font-size: 10px;
            text-align: right;
            width: 120px;
        }

        h2 {
            text-align: center;
            margin: 5px 0 3px 0;
            font-size: 16px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px 4px;
            vertical-align: top;
        }

        th {
            background: #eaeaea;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
        }

        td:first-child {
            text-align: center;
            font-weight: bold;
        }

        .wrap-cell {
            white-space: normal !important;
            overflow-wrap: break-word !important;
            word-wrap: break-word !important;
            word-break: break-all !important;
            hyphens: auto !important;
        }

        .isi-laporan {
            white-space: pre-line;
            line-height: 1.2;
            font-size: 9px;
            overflow-wrap: break-word;
            word-break: break-all;
        }

        tr {
            page-break-inside: avoid;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="header-left">
            <img src="{{ public_path('images/logo-diy.png') }}" alt="Logo DIY">
            <div class="instansi">
                DINAS KOMUNIKASI DAN INFORMATIKA <br>
                PROVINSI DAERAH ISTIMEWA YOGYAKARTA
            </div>
        </div>
        <div class="tanggal-cetak">
            Dicetak: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
        </div>
    </div>

    <h2 style="text-align: center; margin: 5px 0 3px 0; font-size: 16px; font-weight: bold;">
        LAPORAN ADUAN — {{ $admin->name }}
    </h2>

    <div style="margin: 6px 0 10px 0; font-size:11px; display:flex; flex-wrap:wrap; gap:18px;">
        <div><strong>Kategori:</strong> {{ $filterInfo['kategori'] }}</div>
        <div><strong>Wilayah:</strong> {{ $filterInfo['wilayah'] }}</div>
        <div><strong>Status:</strong> {{ $filterInfo['status'] }}</div>
        <div><strong>Tahun:</strong> {{ $filterInfo['tahun'] }}</div>
        <div><strong>Tanggal:</strong> {{ $filterInfo['tanggal'] }}</div>
        <div><strong>Dicetak Oleh:</strong> {{ $filterInfo['dicetak'] }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%">No</th>
                <th style="width: 6%">Tracking</th>
                <th style="width: 10%">Judul</th>
                <th style="width: 20%">Isi Aduan</th>
                <th style="width: 10%">Pelapor</th>
                <th style="width: 12%">Email</th>
                <th style="width: 6%">Telepon</th>
                <th style="width: 6%">NIK</th>
                <th style="width: 8%">Kategori</th>
                <th style="width: 8%">Wilayah</th>
                <th style="width: 6%">Status</th>
                <th style="width: 6%">Longitude</th>
                <th style="width: 6%">Latitude</th>
                <th style="width: 15%">Lokasi</th>
                <th style="width: 5%">Urgensi</th>
                <th style="width: 5%">SLA</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($reports as $r)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="wrap-cell">{{ $r->tracking_id }}</td>
                    <td class="wrap-cell">{{ $r->judul }}</td>
                    <td><span class="isi-laporan">{{ $r->isi }}</span></td>
                    <td class="wrap-cell">{{ $r->is_anonim ? 'Anonim' : $r->user->name ?? ($r->nama_pengadu ?? '-') }}
                    </td>
                    <td class="wrap-cell">{{ $r->is_anonim ? '-' : $r->user->email ?? ($r->email_pengadu ?? '-') }}
                    </td>
                    <td class="wrap-cell">{{ $r->is_anonim ? '-' : $r->telepon_pengadu ?? '-' }}</td>
                    <td class="wrap-cell">{{ $r->is_anonim ? '-' : $r->nik ?? '-' }}</td>
                    <td class="wrap-cell">{{ $r->kategori->nama ?? '-' }}</td>
                    <td class="wrap-cell">{{ $r->wilayah->nama ?? '-' }}</td>
                    <td class="wrap-cell">{{ $r->status }}</td>
                    <td class="wrap-cell">{{ $r->longitude ?? '-' }}</td>
                    <td class="wrap-cell">{{ $r->latitude ?? '-' }}</td>
                    <td class="wrap-cell">{{ $r->lokasi ?? '-' }}</td>
                    <td class="wrap-cell">{{ $r->effective_priority }}</td>
                    <td class="wrap-cell">{{ $r->sla_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
