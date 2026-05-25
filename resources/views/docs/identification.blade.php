<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #1a1a1a; padding: 20px; }
        .border-frame { border: 5px double #0054A5; padding: 30px; height: 90%; }
        .header { text-align: center; position: relative; margin-bottom: 40px; border-bottom: 2px solid #ED1C24; padding-bottom: 20px; }
        .logo-img { position: absolute; left: 0; top: 0; width: 90px; }
        .republique { color: #0054A5; font-weight: bold; font-size: 16px; margin: 0; }
        .ministere { color: #ED1C24; font-weight: bold; font-size: 14px; margin: 5px 0; }
        .title { text-align: center; margin: 40px 0; font-size: 26px; font-weight: bold; color: #0054A5; text-decoration: underline; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .data-table td { padding: 15px; border-bottom: 1px solid #eee; font-size: 14px; }
        .label { font-weight: bold; color: #555; width: 35%; text-transform: uppercase; }
        .stamp { margin-top: 80px; float: right; text-align: center; width: 250px; font-size: 13px; }
        .footer { position: fixed; bottom: 30px; width: 100%; text-align: center; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="border-frame">
        <div class="header">
            @if($logo)<img src="{{ $logo }}" class="logo-img">@endif
            <div style="margin-left: 100px;">
                <p class="republique">RÉPUBLIQUE DÉMOCRATIQUE DU CONGO</p>
                <p class="ministere">MINISTÈRE DES MINES</p>
                <p style="margin:0; font-weight: bold;">SAEMAPE - HAUT LOMAMI</p>
            </div>
        </div>

        <div class="title">CERTIFICAT D'IDENTIFICATION</div>

        <table class="data-table">
            <tr><td class="label">Numéro RCCM :</td><td style="font-family: monospace; font-weight: bold; font-size: 18px;">{{ $association->num_rccm }}</td></tr>
            <tr><td class="label">Dénomination :</td><td style="font-weight: bold;">{{ $association->raison_sociale }}</td></tr>
            <tr><td class="label">Date de Création :</td><td>{{ $association->date_creation->format('d/m/Y') }}</td></tr>
            <tr><td class="label">Localité :</td><td>{{ $association->localite }}</td></tr>
            <tr><td class="label">Délégué Responsable :</td><td>{{ $association->delegue->name }}</td></tr>
            <tr><td class="label">Matricule Délégué :</td><td>{{ $association->delegue->matricule }}</td></tr>
        </table>

        <div class="stamp">
            Fait à Kamina, le {{ date('d/m/Y') }}<br>
            <strong>L'Agent de l'Administration,</strong><br><br><br><br>
            ................................................
        </div>

        <div class="footer">
            SAEMAPE HL - Système de Gestion Digitalisé v1.0 - ID Unique #{{ $association->id }}
        </div>
    </div>
</body>
</html>