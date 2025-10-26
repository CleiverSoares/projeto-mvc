<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Participantes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
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
            background-color: #007BFF;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total {
            margin-top: 10px;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Participantes</h1>
        <p>Gerado em: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Data Cadastro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pessoas as $pessoa)
            <tr>
                <td>{{ $pessoa->nome_pessoa }}</td>
                <td>{{ $pessoa->cpf_pessoa }}</td>
                <td>{{ $pessoa->email_pessoa }}</td>
                <td>{{ $pessoa->telefone_pessoa }}</td>
                <td>{{ $pessoa->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Total de participantes: {{ $total }}</p>
    </div>
</body>
</html>

