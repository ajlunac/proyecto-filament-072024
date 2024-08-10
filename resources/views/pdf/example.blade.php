<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #555;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Timeshees</h2>
    <table>
        <thead>
            <tr>
                <th>Calendario</th>
                <th>Tipo</th>
                <th>Entrada</th>
                <th>Salida</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($timesheets as $timesheet)

            <tr>
                <td>{{ $timesheet->calendar->name }}</td>
                <td>{{ $timesheet->type }}</td>
                <td>{{ $timesheet->day_in }}</td>
                <td>{{ $timesheet->day_out }}</td>
            </tr>
            
        @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Informe generado el {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>
</body>
</html>


