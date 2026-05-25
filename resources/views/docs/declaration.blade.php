<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; padding: 20px; }
        .header { border-bottom: 3px solid #0054A5; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { float: left; width: 70px; }
        .doc-header { text-align: center; }
        .bulletin-title { background: #f4f4f4; padding: 10px; border: 1px solid #333; text-align: center; margin: 20px 0; }
        .bulletin-title h2 { margin: 0; color: #0054A5; text-transform: uppercase; }
        .info-table { width: 100%; border: 1px solid #333; border-collapse: collapse; }
        .info-table td { border: 1px solid #333; padding: 8px; }
        .bg-gray { background-color: #f9f9f9; font-weight: bold; width: 40%; }
        .signatures { margin-top: 40px; }
        .sig-box { width: 45%; float: left; text-align: center; height: 100px; border: 1px solid #eee; padding: 10px; }
    </style>
</head>
<body>
    <div class="header">
        @if($logo)<img src="{{ $logo }}" class="logo">@endif
        <div class="doc-header">
            <h3 style="margin:0; color: #0054A5;">R.D.C - MINISTÈRE DES MINES</h3>
            <h4 style="margin:5px; color: #ED1C24;">SAEMAPE / HAUT-LOMAMI</h4>
            <small>BUREAU TECHNIQUE DE TRAÇABILITÉ (ABT)</small>
        </div>
    </div>

    <div class="bulletin-title">
        <h2>Bulletin de Déclaration de Production</h2>
        <span>N° {{ str_pad($declaration->id, 5, '0', STR_PAD_LEFT) }} / SAEMAPE / HL</span>
    </div>

    <table class="info-table">
        <tr><td class="bg-gray">ENTITÉ MINIÈRE</td><td>{{ $association->raison_sociale }}</td></tr>
        <tr><td class="bg-gray">MATRICULE DÉLÉGUÉ</td><td>{{ $association->delegue->matricule }}</td></tr>
        <tr><td class="bg-gray">NATURE DU MINERAI</td><td style="font-weight: bold; color: #ED1C24;">{{ $declaration->qualite_minerai }}</td></tr>
        <tr><td class="bg-gray">QUANTITÉ (TONNES)</td><td>{{ number_format($declaration->quantite_produite, 2) }}</td></tr>
        <tr><td class="bg-gray">TENEUR (%)</td><td>{{ $declaration->tennaire }} %</td></tr>
        <tr><td class="bg-gray">LOCALITÉ DU CARRÉ</td><td>{{ $declaration->localite }}</td></tr>
        <tr><td class="bg-gray">DATE D'EXTRACTION</td><td>{{ $declaration->created_at->format('d/m/Y') }}</td></tr>
    </table>

    <div class="signatures">
        <div class="sig-box">
            Le Délégué de l'Association<br><br><br><strong>{{ $association->delegue->name }}</strong>
        </div>
        <div class="sig-box" style="float: right;">
            Pour le SAEMAPE (ABT)<br><br><br>Sceau & Signature
        </div>
    </div>
</body>
</html>