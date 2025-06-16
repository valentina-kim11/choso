<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{Wallet,WalletTransaction,UserAdditionalInfo,WalletTransactionBankAccount,UserBankAccount};
use App\Models\Admin\Setting;
use App\Services\{WalletService, AdminActionLogService};
use Illuminate\Support\Facades\DB;




class WalletController extends Controller
{
    private WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $Obj = new WalletTransaction();
        $data['data'] =  $Obj->filter()->orderBy('id','DESC')->paginate(10);
        $data['total_amount'] = $Obj->sum('amount');
        $data['searchable'] =  [];


        $Obj = new Wallet();
        $data['data'] =  $Obj->filter()->orderBy('id','DESC')->paginate(10);
        $data['total_amount'] = $Obj->sum('balance');

        $Obj = new WalletTransaction();
        $data['data'] =  $Obj->with('wallet.getUser')->filter()->orderBy('id','DESC')->paginate(10);

        $data['searchable'] =  Wallet::$searchable;

        return view('admin.wallet.index',$data);
    }

    /**
     * Display a listing of the resource.
     */
    public function withdraw_request()
    {
        $data['data'] = WalletTransaction::with('wallet.getUser')
            ->filter()
            ->where('source', 'WITHDRAW')
            ->where('type', 'debit')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $data['searchable'] = Wallet::$searchable;

        return view('admin.wallet.withdraw_request',$data);
    }

     /**
     * Display a listing of the resource.
     */
    public function withdraw_setting()
    {
        $data['data'] = (object)Setting::pluck('short_value','key')->toArray();
        return view('admin.wallet.withdraw_setting',$data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $data = WalletTransaction::find($id);

        $data = WalletTransaction::with('wallet.getUser')->find($id);

        if(empty($data)){
            return redirect()->route('admin.wallet.index');
        }
        return view('admin.wallet.show',compact('data'));
    }


    /**
     * Display the specified resource.
     */
    public function  edit_request(string $id)
    {

        $data = WalletTransaction::find($id);

        $data = WalletTransaction::with('wallet.getUser')->find($id);

        if(empty($data)){
            return redirect()->route('admin.wallet.withdraw-request');
        }
        $data['user_details'] = (object) UserAdditionalInfo::where('user_id',$data->wallet->user_id)->pluck('value','key')->toArray();
        $map = WalletTransactionBankAccount::where('wallet_transaction_id',$id)->first();
        $data['bank_account'] = $map ? UserBankAccount::find($map->bank_account_id) : null;
        $data['data'] = $data;

        return view('admin.wallet.edit_request',$data);
    }

    public function  update_request(Request $request)
    {
        $data = WalletTransaction::with('wallet')->find($request->id);
        if(empty($data)){
            return redirect()->route('admin.wallet.withdraw-request');
        }

        DB::transaction(function () use ($data, $request) {
            if ((int) $request->status === 2 && $data->status != 2) {
                $this->walletService->credit(
                    $data->wallet->user_id,
                    $data->amount,
                    'WITHDRAW_REJECT',
                    'Withdraw rejected'
                );
                AdminActionLogService::log(
                    auth()->id(),
                    'withdraw_reject',
                    $data,
                    ['note' => $request->note]
                );
            }

            if ((int) $request->status === 1 && $data->status != 1) {
                AdminActionLogService::log(
                    auth()->id(),
                    'withdraw_approve',
                    $data,
                    ['note' => $request->note]
                );
            }

            $data->status = $request->status;
            $data->description = $request->note;
            $data->save();
        });

        return response()->json([
            'status' => true,
            'msg' => "Withdraw request updated successfully.",
            'url' => route('admin.wallet.withdraw-request')
        ], 200);

    }
   

}
