<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #0054A5; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { position: absolute; left: 0; top: 0; width: 60px; }
        .title { text-align: center; font-size: 16px; font-weight: bold; text-decoration: underline; margin: 20px 0; color: #0054A5; }
        .report-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .report-table th { background-color: #0054A5; color: white; padding: 10px; text-transform: uppercase; }
        .report-table td { border: 1px solid #ddd; padding: 8px; }
        .total-row { background-color: #f4f4f4; font-weight: bold; font-size: 13px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 9px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        @if($logo)<img src="{{ $logo }}" class="logo">@endif
        <div style="margin-left: 70px;">
            <strong>RÉPUBLIQUE DÉMOCRATIQUE DU CONGO</strong><br>
            MINISTÈRE DES MINES<br>
            SAEMAPE - DIRECTION PROVINCIALE HAUT-LOMAMI
        </div>
    </div>

    <div class="title">RAPPORT CONSOLIDÉ DES RECETTES (COTISATIONS)</div>
    
    <p>Période : Situation au {{ date('d/m/Y à H:i') }}</p>

    <table class="report-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Réf. Quittance</th>
                <th>Association</th>
                <th>Minerai</th>
                <th>Montant (USD)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $pay)
            <tr>
                <td>{{ $pay->date_paiement->format('d/m/Y') }}</td>
                <td>#REC-{{ $pay->id }}</td>
                <td>{{ $pay->association->raison_sociale }}</td>
                <td>{{ $pay->qualite_minerai }}</td>
                <td style="text-align: right;">{{ number_format($pay->montant_cotisation, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">TOTAL GÉNÉRAL :</td>
                <td style="text-align: right; color: #ED1C24;">{{ number_format($total, 2) }} USD</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 50px; float: right; width: 200px; text-align: center;">
        Fait à Kamina, le {{ date('d/m/Y') }}<br>
        <strong>Le Chef de Bureau CEDAF</strong><br><br><br><br>
        Sceau & Signature
    </div>

    <div class="footer">SAEMAPE HL - Système de Gestion Digitalisé v1.0</div>
</body>
</html>