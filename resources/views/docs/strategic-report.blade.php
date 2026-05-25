<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #1a1a1a; }
        .header { text-align: center; border-bottom: 3px double #0054A5; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { position: absolute; left: 0; top: 0; width: 70px; }
        .title { text-align: center; font-size: 18px; font-weight: bold; margin: 30px 0; color: #0054A5; text-transform: uppercase; }
        .stats-grid { width: 100%; margin-bottom: 30px; }
        .stats-box { border: 1px solid #ddd; padding: 15px; text-align: center; background: #f9f9f9; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th { background: #0054A5; color: white; padding: 8px; }
        .table td { border: 1px solid #eee; padding: 8px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 9px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        @if($logo)<img src="{{ $logo }}" class="logo">@endif
        <strong>RÉPUBLIQUE DÉMOCRATIQUE DU CONGO</strong><br>
        MINISTÈRE DES MINES | SAEMAPE<br>
        DIRECTION PROVINCIALE DU HAUT-LOMAMI
    </div>

    <div class="title">Rapport de Synthèse Décisionnel</div>
    <p style="text-align: right;">Date d'édition : {{ date('d/m/Y') }}</p>

    <table class="stats-grid">
        <tr>
            <td class="stats-box">
                <span style="font-size: 10px; color: #666;">ASSOCIATIONS ACTIVES</span><br>
                <strong style="font-size: 16px;">{{ $totalAssoc }}</strong>
            </td>
            <td class="stats-box">
                <span style="font-size: 10px; color: #666;">PRODUCTION TOTALE (T)</span><br>
                <strong style="font-size: 16px;">{{ number_format($totalProd, 2) }}</strong>
            </td>
            <td class="stats-box">
                <span style="font-size: 10px; color: #666;">RECETTES GLOBALES (USD)</span><br>
                <strong style="font-size: 16px; color: #ED1C24;">{{ number_format($totalRecettes, 2) }} $</strong>
            </td>
        </tr>
    </table>

    <h3>Analyse par Type de Minerai</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nature du Minerai</th>
                <th>Quantité Cumulée (T)</th>
                <th>Recettes Cotisations (USD)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($minerals as $m)
            <tr>
                <td><strong>{{ $m->qualite_minerai }}</strong></td>
                <td style="text-align: center;">{{ number_format($m->total_qty, 2) }}</td>
                <td style="text-align: right;">{{ number_format($m->total_val, 2) }} $</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 60px; float: right; width: 250px; text-align: center;">
        Fait à Kamina, le {{ date('d/m/Y') }}<br><br>
        <strong>Le Directeur Provincial,</strong><br><br><br><br>
        ................................................
    </div>

    <div class="footer">SAEMAPE Haut-Lomami - Système de Gestion Digitalisé v1.0</div>
</body>
</html>