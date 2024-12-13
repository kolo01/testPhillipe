<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Marchand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\fondManager;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class TransactionController extends Controller
{
  use fondManager;

  public function transactions()
  {
    ini_set('max_execution_time', '600');
    // Récupérer les paramètres de recherche depuis la requête
    $periodeDebut = request()->input('periode_debut');
    $periodeFin = request()->input('periode_fin');
    $modepaiement = request()->input('modepaiement');
    $idpaie = request()->input('id_paie');
    $statut = request()->input('status');
    $type = request()->input('type');
    $marchand_choice = request()->input('marchand');
    $marchand =  Marchand::find(auth()->user()->marchand_id);
    $marchands =  Marchand::orderby('created_at', 'desc')->get();
    $nom_marchand = $marchand->nom;
    $marchand_id = $marchand->id;
    $service_status = $marchand->service_status;

    if ($service_status == 1) {
      $transactions = DB::connection('mysql2')->table('transactions')->where('marchand_id', auth()->user()->marchand_id)->whereDate('created_at', Carbon::today());
      $all_transactions = DB::connection('mysql2')->table('transactions');
      $infotransaction = DB::connection('mysql2')->table('info_transactions');
    } else {
      $transactions = DB::table('view_transactions')->where('marchand_id', auth()->user()->marchand_id)->whereDate('created_at', Carbon::today());
      $all_transactions = DB::table('view_transactions')->whereDate('created_at', Carbon::today());
      // $all_transactions = DB::table('view_transactions');
      $infotransaction = DB::table('info_transactions');
    }

    $query = auth()->user()->role == 'superAdmin' ?  $all_transactions : $transactions;
    // Effectuer la recherche
    $trQuery = $query
      ->when($periodeDebut, function ($query) use ($periodeDebut) {
        return $query->whereDate("created_at", '>=', $periodeDebut);
      })
      ->when($periodeFin, function ($query) use ($periodeFin) {
        return $query->whereDate("created_at", '<=', $periodeFin);
      })
      ->when($modepaiement, function ($query) use ($modepaiement) {
        return $query->where('modepaiement', $modepaiement);
      })
      ->when($statut, function ($query) use ($statut) {
        return $query->where('statut', $statut);
      })
      ->when($idpaie, function ($query) use ($idpaie) {
        return $query->where('merchant_transaction_id', $idpaie);
      })
      ->when($type, function ($query) use ($type) {
        return $query->where('type', $type);
      })
      ->when($marchand_choice, function ($query) use ($marchand_choice) {
        return $query->where('marchand_id', $marchand_choice);
      });

    $totalTransactions = $trQuery->count();
    // Get the paginated transactions
    $transactions_excel = $trQuery->orderby('created_at', 'desc')->paginate(10);
    session(['transactions' => $transactions_excel]);
    $transactions = $trQuery->orderby('created_at', 'desc')->paginate(10);
    $html = view('transaction.suivi', compact('transactions', 'totalTransactions'))->render();

    if (request()->ajax()) {
      return response()->json($html);
    }
    // dd($transactions);


    return view('transaction.suivi', compact('transactions', 'nom_marchand', 'marchand_id', 'totalTransactions', 'html', 'marchands'));
  }


  public function SearchTransactions(Request $request)
  {
    ini_set('max_execution_time', '1200');
    // Récupérer les paramètres de recherche depuis la requête
    $periodeDebut = request()->input('periode_debut');
    $periodeFin = request()->input('periode_fin');
    $modepaiement = request()->input('modepaiement');
    $idpaie = request()->input('id_paie');
    $statut = request()->input('status');
    $type = request()->input('type');
    $marchand_choice = request()->input('marchand');
    $marchand =  Marchand::find(auth()->user()->marchand_id);
    $marchands =  Marchand::orderby('created_at', 'desc')->get();
    $nom_marchand = $marchand->nom;
    $marchand_id = $marchand->id;
    $service_status = $marchand->service_status;

    $returnedTable = [
      "_token" => request()->input("_token"),
      "id_paie" => request()->input('id_paie'),
      "status" => request()->input('status'),
      "modepaiement" => request()->input('modepaiement'),
      "type" => request()->input('type'),
      "periode_debut" => request()->input('periode_debut'),
      "periode_fin" => request()->input('periode_fin')

    ];




    if ($service_status == 1) {
      $transactions = DB::connection('mysql2')->table('transactions')->where('marchand_id', auth()->user()->marchand_id);
      $all_transactions = DB::connection('mysql2')->table('transactions');
      $infotransaction = DB::connection('mysql2')->table('info_transactions');
    } else {
      $transactions = DB::table('view_transactions')->where('marchand_id', auth()->user()->marchand_id);
      $all_transactions = DB::table('view_transactions');
      $infotransaction = DB::table('info_transactions');
    }

    $query =   auth()->user()->role == 'superAdmin' ?  $all_transactions : $transactions;
    // Effectuer la recherche
    $trQuery = $query
      ->when($periodeDebut, function ($query) use ($periodeDebut) {
        return $query->whereDate("created_at", '>=', $periodeDebut);
      })
      ->when($periodeFin, function ($query) use ($periodeFin) {
        return $query->whereDate("created_at", '<=', $periodeFin);
      })
      ->when($modepaiement, function ($query) use ($modepaiement) {
        return $query->where('modepaiement', $modepaiement);
      })
      ->when($statut, function ($query) use ($statut) {
        return $query->where('statut', $statut);
      })
      ->when($idpaie, function ($query) use ($idpaie) {
        return $query->where('merchant_transaction_id', $idpaie);
      })
      ->when($type, function ($query) use ($type) {
        return $query->where('type', $type);
      })
      ->when($marchand_choice, function ($query) use ($marchand_choice) {
        return $query->where('marchand_id', $marchand_choice);
      });

    // $totalTransactions = $trQuery->count();

    // $transactions_excel = $trQuery->orderby('created_at', 'desc')->get();
    // session(['transactions' => $transactions_excel]);
    // $transactions = $trQuery->orderby('created_at', 'desc')->get();
    // $html = view('transaction.data', compact('transactions', 'totalTransactions'))->render();

    // return response()->json($html);
    // // return view('transaction.suivi', compact('transactions','nom_marchand','marchand_id','totalTransactions'));
    $totalTransactions = $trQuery->count();
    // Get the paginated transactions
    $transactions_excel = $trQuery->orderby('created_at', 'desc')->paginate(10);
    session(['transactions' => $transactions_excel]);
    $transactions = $trQuery->orderby('created_at', 'desc')->paginate(10);
    $html = view('transaction.suivi', compact('transactions', 'totalTransactions'))->render();

    if (request()->ajax()) {
      return response()->json($html);
    }
    // dd($transactions);

    $transactions->appends($returnedTable);

    return view('transaction.suivi', compact('transactions', 'nom_marchand', 'marchand_id', 'totalTransactions', 'html', 'marchands'));
  }


  public function exportExcel(Request $request)
  {
    ini_set('max_execution_time', '1200'); //20 Min
    // Récupérer les transactions à partir des données JSON envoyées dans la requête
    $transactions = json_decode($request->input('results'), true);
    $transactions_excel = session('transactions');
    //dd($transactions_excel);
    // Définir le nom du fichier avec l'extension CSV
    $filename = "export_transaction_" . date('Y-m-d_H-i-s') . ".xls";
    // Générer le contenu CSV
    $transactions = $transactions_excel;

    //$csvContent = View::make('transaction.export', compact('transactions'))->render();
    header("Content-transitaire: application/vnd.ms-excel; charset=iso-8859-1");
    header("Content-disposition: attachment; filename=$filename");
    return view('transaction.export', compact('transactions'));
  }

  public function detailtransaction($id)
  {
    $id = base64_decode($id);
    $marchand =  Marchand::find(auth()->user()->marchand_id);
    $nom_marchand = $marchand->nom;
    $marchand_id = $marchand->id;
    $service_status = $marchand->service_status;

    if ($service_status == 1) {

      $info = DB::connection('mysql2')->table('info_transactions');
      $transactions = DB::connection('mysql2')->table('transactions');
    } else {
      $info = DB::table('info_transactions');
      $transactions = DB::table('transactions');
    }

    $lesinfos = $info->where('transaction_order_id', $id)->first();
    $infotransaction = $transactions->where('merchant_transaction_id', $id)->first();
    $infotransaction->montantmarchand = $this->calculFrais($infotransaction->transacmontant, $infotransaction->fraistransaction, $infotransaction->type);
    if ($lesinfos && !empty($lesinfos)) {
      $JsonDecodeprovider = json_decode($lesinfos->provider);
      $provider = json_decode($JsonDecodeprovider);
      $other = json_decode($lesinfos->other_info);
      $lesinfos->nomprenoms = $other[0] ?? "";
      $lesinfos->email = $other[1] ?? "";
      $lesinfos->motif = $other[2] ?? "";
      $lesinfos->nom = $provider->receiver->firstname ?? "";
      $lesinfos->prenoms = $provider->receiver->lastname ?? "";
      $lesinfos->phoneNumber = $provider->receiver->phoneNumber ?? "";
      $lesinfos->parcelUID = $provider->parcelUID ?? "";
      $lesinfos->amount = (isset($provider->amount) && !empty($provider->amount)) ? $this->calculFrais($provider->amount, $infotransaction->fraistransaction, $infotransaction->type) : "";
    }

    $autresinfo = $lesinfos;

    return view('transaction.detail', compact('infotransaction', 'autresinfo', 'nom_marchand', 'marchand_id'));
  }


  public function statistique()
  {
    $marchandFounded = null;
    $allMarchand = DB::table("marchands")->get();
    $periodeDebut = date('Y-m-d');
    $periodeFin = date('Y-m-d');
    $marchand = Marchand::find(auth()->user()->marchand_id);
    $nom_marchand = $marchand->nom;
    $marchand_id = $marchand->id;
    $service_status = $marchand->service_status;
    $trans_pending = 0;
    $sum_pending = 0;
    if ($service_status == 1) {
      return back();
    }
    if (auth()->user()->role == 'superAdmin') {
      $trans_pending = DB::table("transactions")->where('statut', "INITIATED")->where("created_at", Carbon::today())->get()->count();
      $sum_pending = Transaction::where('statut', 'INITIATED')->where("created_at", Carbon::today())->sum('transacmontant');
      $nb_t = DB::table('succeed_daily_transactions')->get()->count();
      $sum_t = DB::table('succeed_daily_transactions')->where('type', 'depot')->sum('transacmontant');
      $sum_paye = $this->calculFrais($sum_t, $marchand->tranche_transac, "depot");
      $sum_r = DB::table('succeed_daily_transactions')->where('type', 'retrait')->sum('transacmontant');
      $sum_retire = $this->calculFrais($sum_r, $marchand->tranche_retrait, "retrait");
      $solde = $sum_paye - $sum_retire;
      $f_p = $this->getMtFees($sum_t, $marchand->tranche_transac);
      $f_r = $this->getMtFees($sum_r, $marchand->tranche_retrait);
      //$feesAmount = $f_p + $f_r;
      $feesAmount = DB::table('view_montantfrais_total_jour')->first()->montant_total_frais;
    } else {
      $nb_t = DB::table('succeed_daily_transactions')->where('marchand_id', auth()->user()->marchand_id)->get()->count();
      $sum_t = DB::table('succeed_daily_transactions')->where('marchand_id', auth()->user()->marchand_id)->where('type', 'depot')->sum('transacmontant');
      $sum_paye = $this->calculFrais($sum_t, $marchand->tranche_transac, "depot");
      $sum_r = DB::table('succeed_daily_transactions')->where('marchand_id', auth()->user()->marchand_id)->where('type', 'retrait')->sum('transacmontant');
      $sum_retire = $this->calculFrais($sum_r, $marchand->tranche_retrait, "retrait");
      $solde = $sum_paye - $sum_retire;
      $f_p = $this->getMtFees($sum_t, $marchand->tranche_transac);
      $f_r = $this->getMtFees($sum_r, $marchand->tranche_retrait);
      //$feesAmount = $f_p + $f_r;
      $sum_pending = Transaction::where('marchand_id', auth()->user()->marchand_id)->where('statut', 'INITIATED')->where("created_at", Carbon::today())->sum('transacmontant');
      $trans_pending = Transaction::where('statut', "INITIATED")->where('marchand_id', auth()->user()->marchand_id)->where("created_at", Carbon::today())->get()->count();
      $feesAmount = DB::table('view_transactions')->where('statut', 'SUCCESS')->where('marchand_id', auth()->user()->marchand_id)->sum('montantfrais');
    }
    //dd("=====nb_t======>", $nb_t, "=====solde======>", $solde, "=====paye======>", $sum_paye,"=====retrait======>", $sum_retire);
    // dd($trans_pending);
    $mapData = [1,2,3,4,5,6,7,8,9,10];
    return view('transaction.state', compact('mapData', 'nb_t', 'solde', 'sum_paye', 'sum_retire', 'periodeDebut', 'periodeFin', 'feesAmount', "allMarchand", 'marchandFounded', 'trans_pending', 'sum_pending'));
  }


  public function statistiqueSearch(Request $request)
  {

    $trans_pending = 0;
    $sum_pending = 0;


    $allMarchand = DB::table("marchands")->get();
    $periodeDebut = request()->input('periode_debut');
    $periodeFin = request()->input('periode_fin');
    $marchandToFind = request()->input('marchand_selected');
    $marchandFounded = Marchand::find($marchandToFind);
    $marchand = Marchand::find(auth()->user()->marchand_id);
    $nom_marchand = $marchand->nom;
    $marchand_id = $marchand->id;
    $service_status = $marchand->service_status;
    if ($service_status == 1) {
      return back();
    }
    if ((request()->input('periode_debut') == null && request()->input('periode_fin') == null) || (request()->input('periode_debut') > request()->input('periode_fin'))) {
      if (request()->input('marchand_selected') == null) {
        return redirect()->route('liste.statistique');
      } else {
        if (auth()->user()->role = "superAdmin") {
          $sum_pending = Transaction::where('statut', 'INITIATED')->where('marchand_id', $marchandToFind)->sum('transacmontant');
          $trans_pending = Transaction::where('statut', "INITIATED")->where('marchand_id', $marchandToFind)->get()->count();
        } else {
          $sum_pending =  Transaction::where('marchand_id', auth()->user()->marchand_id)->where('statut', 'INITIATED')->sum('transacmontant');
          $trans_pending = Transaction::where('statut', "INITIATED")->where('marchand_id', auth()->user()->marchand_id)->get()->count();
        }


        $nb_t = DB::table('transactions')->where('marchand_id', $marchandToFind)->where('statut', 'SUCCESS')->get()->count();
        $sum_t = DB::table('transactions')->where('statut', 'SUCCESS')->where('marchand_id', $marchandToFind)->where('type', 'depot')->sum('transacmontant');



        $sum_paye = $this->calculFrais($sum_t, $marchandFounded->tranche_transac, "depot");
        $sum_r = DB::table('transactions')->where('statut', 'SUCCESS')->where('marchand_id', $marchandToFind)->where('type', 'retrait')->sum('transacmontant');
        $sum_retire = $this->calculFrais($sum_r, $marchandFounded->tranche_retrait, "retrait");
        $solde = $sum_paye - $sum_retire;
        $solde = "";

        $feesAmount = DB::table('view_transactions')->where('statut', 'SUCCESS')->where('marchand_id', $marchandToFind)->sum('montantfrais');
        $periodeDebut = "";
        $periodeFin = "";

        return view('transaction.state', compact('nb_t', 'solde', 'sum_paye', 'sum_retire', 'periodeDebut', 'periodeFin', 'feesAmount', 'allMarchand', 'marchandFounded', 'sum_pending', 'trans_pending'));
      }
    }

    if (request()->input('marchand_selected') == null) {
      if (auth()->user()->role == 'superAdmin') {

        $sum_pending = Transaction::where('statut', 'INITIATED')->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->sum('transacmontant');

        $trans_pending = Transaction::where('statut', "INITIATED")->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->get()->count();


        $nb_t = DB::table('transactions')->where('statut', 'SUCCESS')->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->get()->count();

        $sum_t = DB::table('transactions')->where('statut', 'SUCCESS')->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->where('type', 'depot')->sum('transacmontant');

        $sum_paye = $this->calculFrais($sum_t, $marchand->tranche_transac, "depot");

        $sum_r = DB::table('transactions')->where('statut', 'SUCCESS')->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->where('type', 'retrait')->sum('transacmontant');
        $sum_retire = $this->calculFrais($sum_r, $marchand->tranche_retrait, "retrait");
        $solde = $sum_paye - $sum_retire;
        $solde = "";

        $feesAmount = DB::table('view_transactions')->where('statut', 'SUCCESS')->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->sum('montantfrais');
      } else {




        $sum_pending =  Transaction::where('marchand_id', auth()->user()->marchand_id)->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->where('marchand_id', auth()->user()->marchand_id)->where('statut', 'INITIATED')->sum('transacmontant');

        $trans_pending = Transaction::where('statut', "INITIATED")->where('marchand_id', auth()->user()->marchand_id)->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->where('marchand_id', auth()->user()->marchand_id)->get()->count();



        $nb_t = DB::table('transactions')->where('statut', 'SUCCESS')->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->where('marchand_id', auth()->user()->marchand_id)->get()->count();

        $sum_t = DB::table('transactions')->where('statut', 'SUCCESS')->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->where('marchand_id', auth()->user()->marchand_id)->where('type', 'depot')->sum('transacmontant');

        $sum_paye = $this->calculFrais($sum_t, $marchand->tranche_transac, "depot");
        $sum_r = DB::table('transactions')->where('statut', 'SUCCESS')->where('marchand_id', auth()->user()->marchand_id)->where('type', 'retrait')->sum('transacmontant');
        $sum_retire = $this->calculFrais($sum_r, $marchand->tranche_retrait, "retrait");
        $solde = "";

        $feesAmount = DB::table('view_transactions')->where('marchand_id', auth()->user()->marchand_id)->where('statut', 'SUCCESS')
          ->when($periodeDebut, function ($query) use ($periodeDebut) {
            return $query->whereDate('created_at', '>=', $periodeDebut);
          })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->sum('montantfrais');
      }
      //dd("=====nb_t======>", $nb_t, "=====solde======>", $solde, "=====paye======>", $sum_paye,"=====retrait======>", $sum_retire);
      return view('transaction.state', compact('nb_t', 'solde', 'sum_paye', 'sum_retire', 'periodeDebut', 'periodeFin', 'feesAmount', 'allMarchand', 'marchandFounded', 'sum_pending', 'trans_pending'));
    } else {
      if (auth()->user()->role == 'superAdmin') {

        $sum_pending = Transaction::where('statut', 'INITIATED')->where('marchand_id', $marchandToFind)->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->sum('transacmontant');

        $trans_pending = Transaction::where('statut', "INITIATED")->where('marchand_id', $marchandToFind)->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->get()->count();


        $nb_t = DB::table('transactions')->where('statut', 'SUCCESS')->where('marchand_id', $marchandToFind)->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->get()->count();

        $sum_t = DB::table('transactions')->where('statut', 'SUCCESS')->where('marchand_id', $marchandToFind)->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->where('type', 'depot')->sum('transacmontant');

        $sum_paye = $this->calculFrais($sum_t, $marchandFounded->tranche_transac, "depot");

        $sum_r = DB::table('transactions')->where('statut', 'SUCCESS')->where('marchand_id', $marchandToFind)->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->where('type', 'retrait')->sum('transacmontant');
        $sum_retire = $this->calculFrais($sum_r, $marchandFounded->tranche_retrait, "retrait");
        $solde = $sum_paye - $sum_retire;
        $solde = "";

        $feesAmount = DB::table('view_transactions')->where('statut', 'SUCCESS')->where('marchand_id', $marchandToFind)->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->sum('montantfrais');
      } else {

        $sum_pending =  Transaction::where('marchand_id', auth()->user()->marchand_id)->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->where('marchand_id', auth()->user()->marchand_id)->where('statut', 'INITIATED')->sum('transacmontant');

        $trans_pending = Transaction::where('statut', "INITIATED")->where('marchand_id', auth()->user()->marchand_id)->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->where('marchand_id', auth()->user()->marchand_id)->get()->count();


        $nb_t = DB::table('transactions')->where('statut', 'SUCCESS')->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->where('marchand_id', auth()->user()->marchand_id)->get()->count();

        $sum_t = DB::table('transactions')->where('statut', 'SUCCESS')->when($periodeDebut, function ($query) use ($periodeDebut) {
          return $query->whereDate('created_at', '>=', $periodeDebut);
        })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->where('marchand_id', auth()->user()->marchand_id)->where('type', 'depot')->sum('transacmontant');

        $sum_paye = $this->calculFrais($sum_t, $marchand->tranche_transac, "depot");
        $sum_r = DB::table('transactions')->where('statut', 'SUCCESS')->where('marchand_id', auth()->user()->marchand_id)->where('type', 'retrait')->sum('transacmontant');
        $sum_retire = $this->calculFrais($sum_r, $marchand->tranche_retrait, "retrait");
        $solde = "";

        $feesAmount = DB::table('view_transactions')->where('marchand_id', auth()->user()->marchand_id)->where('statut', 'SUCCESS')
          ->when($periodeDebut, function ($query) use ($periodeDebut) {
            return $query->whereDate('created_at', '>=', $periodeDebut);
          })
          ->when($periodeFin, function ($query) use ($periodeFin) {
            return $query->whereDate('created_at', '<=', $periodeFin);
          })->sum('montantfrais');
      }


      $start = Carbon::parse(User::min("created_at"));
      $end = Carbon::now();
      $period = CarbonPeriod::create($start, "1 month", $end);

      $usersPerMonth = collect($period)->map(function ($date) {
          $endDate = $date->copy()->endOfMonth();

          return [
              "count" => User::where("created_at", "<=", $endDate)->count(),
              "month" => $endDate->format("Y-m-d")
          ];
      });

      $data = $usersPerMonth->pluck("count")->toArray();
      $labels = $usersPerMonth->pluck("month")->toArray();

      $chart = Chartjs::build()
          ->name("UserRegistrationsChart")
          ->type("line")
          ->size(["width" => 400, "height" => 200])
          ->labels($labels)
          ->datasets([
              [
                  "label" => "User Registrations",
                  "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                  "borderColor" => "rgba(38, 185, 154, 0.7)",
                  "data" => $data
              ]
          ])
          ->options([
              'scales' => [
                  'x' => [
                      'type' => 'time',
                      'time' => [
                          'unit' => 'month'
                      ],
                      'min' => $start->format("Y-m-d"),
                  ]
              ],
              'plugins' => [
                  'title' => [
                      'display' => true,
                      'text' => 'Monthly User Registrations'
                  ]
              ]
          ]);

      //dd("=====nb_t======>", $nb_t, "=====solde======>", $solde, "=====paye======>", $sum_paye,"=====retrait======>", $sum_retire);
      return view('transaction.state', compact('nb_t', 'solde', 'sum_paye', 'sum_retire', 'periodeDebut', 'periodeFin', 'feesAmount', 'allMarchand', 'marchandFounded', 'sum_pending', 'trans_pending','chart'));
    }








  }


  public function calculFrais($mt, $ft, $tp)
  {
    // Check and log types of the variables
    Log::info('Type of $mt: ' . gettype($mt));
    Log::info('Type of $ft: ' . gettype($ft));
    Log::info('Type of $tp: ' . gettype($tp));
    $mt_retrait = ceil($mt + (($ft / 100) * $mt));
    $mt_depot = ceil($mt - (($ft / 100) * $mt));
    $mt_recu = $tp == 'retrait' ? $mt_retrait : $mt_depot;
    return $mt_recu;
  }



  public function getMtFees($mt, $ft)
  {
    // Check and log types of the variables
    Log::info('Type of $mt: ' . gettype($mt));
    Log::info('Type of $ft: ' . gettype($ft));
    $fees = ceil(($ft / 100) * $mt);
    return $fees;
  }




  public function statistiqueForCommercial()
  {
    $nb_t = 0;
    $sum_t = 0;
    $sum_paye = 0;
    $sum_r = 0;
    $sum_retire = 0;
    $nb_total = DB::table('marchands')->where('commercial_id', auth()->user()->id)->get();
    // dd($nb_t);
    foreach ($nb_total as $key => $value) {
      //  dd($value->tranche_retrait);
      $nb_t = DB::table('succeed_daily_transactions')->where('marchand_id', $value->id)->get()->count() + $nb_t;
      $sum_t = DB::table('succeed_daily_transactions')->where('marchand_id', $value->id)->where('type', 'depot')->sum('transacmontant') + $sum_t;
      $sum_paye = $this->calculFrais($sum_t, $value->tranche_transac, "depot") + $sum_paye;
      $sum_r = DB::table('succeed_daily_transactions')->where('marchand_id', $value->id)->where('type', 'retrait')->sum('transacmontant') + $sum_r;
      $sum_retire = $this->calculFrais($sum_r, $value->tranche_retrait, "retrait") + $sum_retire;
      $solde = $sum_paye - $sum_retire;
      $f_p = $this->getMtFees($sum_t, $value->tranche_transac);
      $f_r = $this->getMtFees($sum_r, $value->tranche_retrait);
      //$feesAmount = $f_p + $f_r;
      $feesAmount = DB::table('view_transactions')->where('statut', 'SUCCESS')->where('marchand_id', $value->id)->sum('montantfrais');
    }

    return view('transaction.state', compact('nb_t', 'solde', 'sum_paye', 'sum_retire', 'feesAmount'));
  }
}
