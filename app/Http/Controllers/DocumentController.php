<?php

namespace App\Http\Controllers;

use App\Models\{Association, Declaration};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    private function getLogoBase64() {
        $path = public_path('images/saemape.png');
        return file_exists($path) ? 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($path)) : null;
    }

    public function identification(Association $association) {
        $this->authorizeAccess($association);
        $logo = $this->getLogoBase64();
        return Pdf::loadView('docs.identification', compact('association', 'logo'))->setPaper('a4', 'portrait')->stream();
    }

    public function declaration(Declaration $declaration) {
        $this->authorizeAccess($declaration->association);
        $logo = $this->getLogoBase64();
        $association = $declaration->association;
        return Pdf::loadView('docs.declaration', compact('declaration', 'association', 'logo'))->stream();
    }

    public function receipt(Declaration $declaration) {
        $this->authorizeAccess($declaration->association);
        $logo = $this->getLogoBase64();
        $association = $declaration->association;
        return Pdf::loadView('docs.receipt', compact('declaration', 'association', 'logo'))->setPaper('a5', 'landscape')->stream();
    }

    public function paymentReport() {
        $payments = Declaration::where('statut', 'payé')->with('association')->latest()->get();
        $total = $payments->sum('montant_cotisation');
        $logo = $this->getLogoBase64();
        return Pdf::loadView('docs.payment-report', compact('payments', 'total', 'logo'))->stream();
    }

    public function strategicReport() {
        $logo = $this->getLogoBase64();
        $totalAssoc = Association::where('statut', 'valide')->count();
        $totalProd = Declaration::where('statut', 'payé')->sum('quantite_produite');
        $totalRecettes = Declaration::where('statut', 'payé')->sum('montant_cotisation');
        $minerals = Declaration::where('statut', 'payé')->select('qualite_minerai', DB::raw('sum(quantite_produite) as total_qty'), DB::raw('sum(montant_cotisation) as total_val'))->groupBy('qualite_minerai')->get();
        return Pdf::loadView('docs.strategic-report', compact('logo', 'totalAssoc', 'totalProd', 'totalRecettes', 'minerals'))->stream();
    }

    private function authorizeAccess(Association $association) {
        $user = auth()->user();
        if (!($user->role === 'admin' || $user->role === 'agent' || $user->role === 'dipro' || ($user->role === 'delegue' && $user->id === $association->user_id))) abort(403);
    }
}