<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Doações</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #28a745;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total {
            margin-top: 10px;
            padding: 10px;
            background-color: #d4edda;
            border-left: 4px solid #28a745;
        }
        .total-item {
            font-weight: bold;
        }
        .total-valor {
            font-size: 18px;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Doações</h1>
        <p>Gerado em: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Doador</th>
                <th>Valor</th>
                <th>Tipo</th>
                <th>Forma Pagamento</th>
                <th>Data</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doacoes as $doacao)
            <tr>
                <td>{{ $doacao->nome_doador }}</td>
                <td>R$ {{ number_format($doacao->valor_doacao, 2, ',', '.') }}</td>
                <td>{{ $doacao->tipo_doacao }}</td>
                <td>{{ $doacao->forma_pagamento ?? '-' }}</td>
                <td>{{ $doacao->data_doacao ? $doacao->data_doacao->format('d/m/Y') : '-' }}</td>
                <td>{{ $doacao->status_doacao }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p class="total-item">Total de doações: {{ $total }}</p>
        <p class="total-valor">Valor total arrecadado: R$ {{ number_format($total_valor, 2, ',', '.') }}</p>
    </div>
</body>
</html>

