<!DOCTYPE html>
<html>
<head>
    <title>Relatório Completo - Projeto Doar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #007BFF;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #007BFF;
            font-size: 24px;
        }
        .info-box {
            background-color: #f8f9fa;
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #007BFF;
            border-radius: 4px;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 16px;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin: 15px 0;
        }
        .info-row {
            display: table-row;
        }
        .info-cell {
            display: table-cell;
            padding: 8px;
            vertical-align: top;
        }
        .info-label {
            font-weight: bold;
            color: #666;
            width: 40%;
        }
        .info-value {
            color: #333;
        }
        .stats-grid {
            margin: 20px 0;
        }
        .stats-row {
            background-color: #e9ecef;
            padding: 12px;
            margin: 8px 0;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stats-label {
            font-weight: bold;
            color: #333;
        }
        .stats-value {
            font-size: 18px;
            color: #007BFF;
            font-weight: bold;
        }
        .highlight-box {
            background-color: #fff3cd;
            border: 2px solid #ffc107;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .highlight-box h3 {
            margin: 0 0 10px 0;
            color: #856404;
        }
        .section-title {
            font-size: 16px;
            color: #007BFF;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 5px;
            margin: 20px 0 10px 0;
            font-weight: bold;
        }
        .icon-badge {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            font-weight: bold;
            margin-right: 8px;
            font-size: 14px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RELATÓRIO COMPLETO - PROJETO DOAR</h1>
        <p><strong>Gerado em:</strong> {{ date('d/m/Y H:i') }}</p>
        <p><strong>Período:</strong> {{ $periodo }}</p>
    </div>

    <!-- Estatísticas Gerais -->
    <div class="section-title">
        <span class="icon-badge">#</span>ESTATÍSTICAS GERAIS DO PROJETO
    </div>
    
    <div class="stats-grid">
        <div class="stats-row">
            <span class="stats-label">Total de Participantes Cadastrados</span>
            <span class="stats-value">{{ $pessoas_total }}</span>
        </div>
        <div class="stats-row">
            <span class="stats-label">Total de Projetos Ativos</span>
            <span class="stats-value">{{ $projetos_total }}</span>
        </div>
        <div class="stats-row">
            <span class="stats-label">Total de Eventos Realizados</span>
            <span class="stats-value">{{ $eventos_total }}</span>
        </div>
        <div class="stats-row">
            <span class="stats-label">Total de Doações Recebidas</span>
            <span class="stats-value">{{ $doacoes_total }}</span>
        </div>
    </div>

    <!-- Destaque Financeiro -->
    <div class="highlight-box">
        <h3>ARRECADAÇÃO TOTAL</h3>
        <div style="font-size: 28px; font-weight: bold; color: #28a745; text-align: center;">
            R$ {{ number_format($valor_total, 2, ',', '.') }}
        </div>
    </div>

    <!-- Detalhes dos Projetos -->
    <div class="section-title">
        <span class="icon-badge">P</span>PROJETOS EM ANDAMENTO
    </div>
    <div class="info-box">
        <h3>Informações Gerais</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Total de Projetos:</div>
                <div class="info-cell info-value">{{ $projetos_total }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Status Geral:</div>
                <div class="info-cell info-value">Em Operação</div>
            </div>
        </div>
    </div>

    <!-- Atividades Realizadas -->
    <div class="section-title">
        <span class="icon-badge">E</span>ATIVIDADES REALIZADAS
    </div>
    <div class="info-box">
        <h3>Eventos e Encontros</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Total de Eventos:</div>
                <div class="info-cell info-value">{{ $eventos_total }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Participantes Ativos:</div>
                <div class="info-cell info-value">{{ $pessoas_total }}</div>
            </div>
        </div>
    </div>

    <!-- Sustentabilidade Financeira -->
    <div class="section-title">
        <span class="icon-badge">$</span>SUSTENTABILIDADE FINANCEIRA
    </div>
    <div class="info-box">
        <h3>Doações Recebidas</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Total de Doações:</div>
                <div class="info-cell info-value">{{ $doacoes_total }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Valor Total:</div>
                <div class="info-cell info-value" style="color: #28a745; font-weight: bold;">
                    R$ {{ number_format($valor_total, 2, ',', '.') }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Média por Doação:</div>
                <div class="info-cell info-value">
                    @php
                        $media = $doacoes_total > 0 ? $valor_total / $doacoes_total : 0;
                    @endphp
                    R$ {{ number_format($media, 2, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Resumo Executivo -->
    <div class="section-title">
        <span class="icon-badge">R</span>RESUMO EXECUTIVO
    </div>
    <div class="info-box" style="background-color: #e7f3ff; border-left-color: #007BFF;">
        <h3>Visão Geral do Projeto</h3>
        <p style="line-height: 1.6;">
            O Projeto Doar está operando com <strong>{{ $pessoas_total }} participantes cadastrados</strong> 
            em <strong>{{ $projetos_total }} projetos</strong>. Foram realizados <strong>{{ $eventos_total }} eventos</strong> 
            e recebidos <strong>{{ $doacoes_total }} doações</strong>, totalizando uma arrecadação de 
            <strong>R$ {{ number_format($valor_total, 2, ',', '.') }}</strong>.
        </p>
        <p style="line-height: 1.6;">
            Esses números demonstram o comprometimento da comunidade e o impacto positivo gerado pelo projeto 
            social na região.
        </p>
    </div>

    <!-- Indicadores -->
    <div class="section-title">
        <span class="icon-badge">I</span>INDICADORES DE DESEMPENHO
    </div>
    <div class="info-grid">
        <div class="info-row">
            <div class="info-cell info-label">Taxa de Participação:</div>
            <div class="info-cell info-value">{{ $taxa_participacao_status }} ({{ $taxa_participacao_percent }}%)</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Engajamento:</div>
            <div class="info-cell info-value">{{ $engajamento }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Sustentabilidade:</div>
            <div class="info-cell info-value">{{ $sustentabilidade }}</div>
        </div>
    </div>

    <div class="footer">
        <p><strong>PROJETO DOAR - Sistema de Gestão Social</strong></p>
        <p>Este relatório foi gerado automaticamente pelo sistema</p>
        <p>Para mais informações, acesse o sistema de gestão</p>
    </div>
</body>
</html>
