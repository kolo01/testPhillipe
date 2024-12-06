<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthOtpController;
use App\Http\Controllers\CommercialController;
use App\Http\Controllers\MarchandController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\OperateurController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\CheckIsAdmin;
use App\Http\Middleware\CheckIsCommercial;
use App\Http\Middleware\CheckIsSuperAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/paiement', [PaiementController::class, 'index'])->name('paiement.index');

Route::get('/test', [PaiementController::class, 'test'])->name('paiement.test');

Route::get('/login', [LoginController::class, 'login'])->name('otp.login');
Route::post('/otp/generate', [LoginController::class, 'generate'])->name('otp.generate');
Route::get('/otp/verification/{code}', [LoginController::class, 'verification'])->name('otp.verification');
Route::post('/otp/login', [LoginController::class, 'loginWithOtp'])->name('otp.getlogin');
Route::post('/logout-user', [LoginController::class, 'logout'])->name('logout.user');

// Route::get('/otp/login',[ AuthOtpController::class => 'login'])->name('otp.login');
// Route::post('/otp/generate', [AuthOtpController::class =>'generate'])->name('otp.generate');
// Route::get('/otp/verification/{user_id}', [AuthOtpController::class =>'verification'])->name('otp.verification');
// Route::post('/otp/login', [AuthOtpController::class => 'loginWithOtp'])->name('otp.getlogin');
// Route::post('/logout-user', [AuthOtpController::class, 'logout'])->name('otp.logout');

//Route::get('/faire-un-paiement/{id}', [PaiementController::class, 'paymentURL'])->name('paymentURL');

Route::get('/faire-un-paiement/{id}', [PaiementController::class,'openLink'])->name('faire-un-paiement');
Route::get('/success_url/{id}', [PaiementController::class, 'successURL'])->name('successURL');
Route::get('/failed_url/{id}', [PaiementController::class, 'failedURL'])->name('failedURL');
Route::get('/notif_url/{id}', [PaiementController::class, 'notifiedURL'])->name('notifiedURL');

Route::get('/check-the-transaction', [CompteController::class, 'checkTheTransaction']); //check-the-transaction

Route::middleware('auth','web')->group(function () {
    // Routes that require authentication
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware(CheckIsSuperAdmin::class);
    Route::post('users/store', [UserController::class, 'store'])->name('users.store')->middleware(CheckIsSuperAdmin::class);
    Route::get('users/create', [UserController::class, 'create'])->name('users.create')->middleware(CheckIsSuperAdmin::class);
    Route::get('users/show/{id}', [UserController::class, 'show'])->name('users.show')->middleware(CheckIsSuperAdmin::class);
    Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit')->middleware(CheckIsSuperAdmin::class);
    Route::post('users/update', [UserController::class, 'update'])->name('users.update')->middleware(CheckIsSuperAdmin::class);
    Route::get('users/delete/{id}', [UserController::class, 'delete'])->name('users.delete')->middleware(CheckIsSuperAdmin::class);

    Route::get('/liste-des-marchands', [MarchandController::class, 'index'])->name('marchand.index')->middleware(CheckIsSuperAdmin::class);
    Route::get('/ajouter-un-marchand', [MarchandController::class, 'create'])->name('marchand.ajouter')->middleware(CheckIsSuperAdmin::class);
    Route::post('/enregistrer-marchand', [MarchandController::class, 'store'])->name('marchand.enregistrer')->middleware(CheckIsSuperAdmin::class);
    Route::get('/modifier-un-marchand/{id}', [MarchandController::class, 'edit'])->name('marchand.modifier')->middleware(CheckIsSuperAdmin::class);
    Route::post('/mise-ajour-marchand', [MarchandController::class, 'update'])->name('marchand.mise-ajour')->middleware(CheckIsSuperAdmin::class);
    Route::get('/supprimer-un-marchand/{sup}', [MarchandController::class, 'delete'])->name('marchand.supprimer')->middleware(CheckIsSuperAdmin::class);
    Route::get('/active-marchand/{active}', [MarchandController::class, 'active'])->name('marchand.active')->middleware(CheckIsSuperAdmin::class);
    //-----fond-----money
    Route::get('depot',[MarchandController::class, 'depot'])->name('view.depot')->middleware('checktest')->middleware(CheckIsAdmin::class);
    Route::get('validate-depot-money/{id}',[MarchandController::class, 'ValidDepotMoney'])->name('marchand.validatedepot')->middleware(CheckIsAdmin::class);
    Route::get('cancel-depot-money/{id}',[MarchandController::class, 'CancelDepotMoney'])->name('marchand.canceldepot')->middleware(CheckIsAdmin::class);
    Route::post('depot-money',[MarchandController::class, 'storeDepot'])->name('marchand.storedepot')->middleware(CheckIsAdmin::class);
    //--------------------------
    Route::get('transfert-money/{id}',[MarchandController::class, 'TransfertMoney'])->name('marchand.transfert')->middleware(CheckIsAdmin::class);
    Route::get('cancel-transfert-money/{id}',[MarchandController::class, 'CancelTransfertMoney'])->name('marchand.canceltransfert')->middleware(CheckIsAdmin::class);
    //----26/10/2023
    Route::post('demande-retrait',[MarchandController::class, 'DemandeRetrait'])->name('marchand.demanderetrait')->middleware(CheckIsAdmin::class);
    Route::get('solde-marchand-transaction',[MarchandController::class, 'ManageTransactionMarchand'])->name('view.transaction.manager')->middleware('checktest')->middleware(CheckIsAdmin::class);

    Route::get('/mon-compte', [CompteController::class, 'profil'])->name('profil.info');
    Route::post('/updateImage', [CompteController::class, 'UpdateProfilsPic'])->name('profil.update');
    Route::get('/sms', [CompteController::class, 'sms'])->name('get.sms');
    Route::get('/liste-des-operateurs', [OperateurController::class, 'operateur'])->name('liste.operateur')->middleware(CheckIsAdmin::class);
    Route::get('/suvi-des-transactions', [TransactionController::class, 'transactions'])->name('liste.transactions')->middleware(CheckIsAdmin::class);
    Route::get('/statistique', [TransactionController::class, 'statistique'])->name('liste.statistique')->middleware(CheckIsAdmin::class);
    Route::post('/search-statistique', [TransactionController::class, 'statistiqueSearch'])->name('liste.statistiqueSearch')->middleware(CheckIsAdmin::class);
    //----26/10/2023
    Route::get('/detail-transactions/{id}', [TransactionController::class, 'detailtransaction'])->name('detail.transaction')->middleware(CheckIsAdmin::class);
    Route::post('/export-excel',  [TransactionController::class, 'exportExcel'])->name('export.excel')->middleware(CheckIsAdmin::class);
    Route::post('/search-transactions',  [TransactionController::class, 'SearchTransactions'])->name('search.transactions')->middleware(CheckIsAdmin::class);


    // commerciaux interface
    Route::get('/suivi-affilier', [CommercialController::class, 'index'])->name('commercial.dashboard')->middleware(CheckIsCommercial::class);
    //Route pour modifier rib dans le profil
    Route::post('/modifier-rib', [CompteController::class, 'updateRib'])->name('profil.updateRib')->middleware(CheckIsAdmin::class);
    Route::get('/retrait-rib', [CompteController::class, 'indexRIB'])->name('marchand.ribindex')->middleware(CheckIsAdmin::class);
    Route::post('/save-retrait', [CompteController::class, 'saveRetrait'])->name('marchand.ribRetraitSave')->middleware(CheckIsAdmin::class);
    Route::get('/confirm-retrait-rib/{id}', [CompteController::class, 'acceptPaiement'])->name('transfert.rib')->middleware(CheckIsSuperAdmin::class);
    Route::get('/cancel-retrait-rib/{id}', [CompteController::class, 'cancelPaiement'])->name('transfert.ribcancel')->middleware(CheckIsSuperAdmin::class);
    Route::get('/afficher-un-marchand/{id}', [MarchandController::class, 'show'])->name('marchand.details')->middleware(CheckIsCommercial::class);
    Route::get('generate-recap_marchand/{id}', [MarchandController::class, 'generatePDF'])->name('commercial.pdf')->middleware(CheckIsCommercial::class);
    Route::get('commercial-stats', [TransactionController::class, 'statistiqueForCommercial'])->name('commercial.statistic')->middleware(CheckIsCommercial::class);


});

Route::post('/logout', [LoginController::class, 'logout'])->name('user.logout');

Route::get('Api/v1/test-api/', function(){
    return view('formualaire');
});




//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
