<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Courier', monospace; font-size: 14px; padding: 20px; border: 2px dashed #000; height: 380px; }
        .logo-recu { position: absolute; right: 20px; top: 20px; width: 60px; opacity: 0.5; }
        .header { text-align: left; border-bottom: 1px solid #000; padding-bottom: 10px; }
        .amount { border: 3px double #000; padding: 15px; font-size: 24px; font-weight: bold; text-align: center; margin: 20px 0; }
        .body-text { line-height: 1.8; }
        .stamp-area { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    @if($logo)<img src="{{ $logo }}" class="logo-recu">@endif
    
    <div class="header">
        <strong>SAEMAPE HAUT-LOMAMI</strong><br>
        SERVICE DE LA CAISSE (CEDAF)<br>
        BUREAU DE KAMINA
    </div>

    <div style="text-align: center; margin: 15px 0;">
        <span style="font-size: 18px; font-weight: bold; text-decoration: underline;">REÇU DE CAISSE N° {{ $declaration->id }}</span>
    </div>

    <div class="amount">
        $ {{ number_format($declaration->montant_cotisation, 2) }} USD
    </div>

    <div class="body-text">
        Reçu de l'Association : <strong>{{ $association->raison_sociale }}</strong><br>
        Somme pour : Cotisation minière / Production {{ $declaration->qualite_minerai }}<br>
        Référence de production : #DEC-{{ $declaration->id }} / {{ $declaration->localite }}<br>
        Date : {{ date('d/m/Y') }}
    </div>

    <div class="stamp-area">
        L'Agent de Caisse (CEDAF)<br><br>
        ..........................
    </div>
</body>
</html>