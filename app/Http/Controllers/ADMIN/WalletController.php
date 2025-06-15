<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{Wallet,WalletTransaction,Setting,UserAdditionalInfo};
use App\Services\WalletService;
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
        $Obj = new WalletTransaction();

        $data['data'] =  $Obj->filter()->where('source','WITHDRAW')->orderBy('id','DESC')->paginate(10);
        $data['searchable'] =  [];

        $data['data'] =  $Obj->with('wallet.getUser')->filter()->where('type','debit')->orderBy('id','DESC')->paginate(10);
        $data['searchable'] =  Wallet::$searchable;

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
