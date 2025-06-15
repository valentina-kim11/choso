<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{Wallet, WalletTransaction};



use App\Services\WalletService;
use Validator;

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
        $user = auth()->user();

        $wallet = Wallet::where('user_id', $user->id)->first();

        $transactions = WalletTransaction::query();
        if ($wallet) {
            $transactions->where('wallet_id', $wallet->id);
        }

        $data['data'] = $transactions->filter()->orderBy('id', 'DESC')->paginate(10);

        $data['total_amount'] = $wallet->balance ?? 0;
        $data['withdraw_amount'] = WalletTransaction::where('wallet_id', $wallet->id ?? '')
            ->where('type', 'debit')
            ->where('status', 1)
            ->sum('amount');


        $Obj = new WalletTransaction();
        $data['data'] =  $Obj->with('wallet')->filter()->whereHas('wallet', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->orderBy('id','DESC')->paginate(10);

        $data['total_amount'] = $this->walletService->getBalance($user->id);


        $wallet = Wallet::where('user_id',$user->id)->first();
        $data['withdraw_amount'] = 0;
        if ($wallet) {
            $data['withdraw_amount'] = $wallet->transactions()
                ->where('type', 'debit')
                ->where('source', 'WITHDRAW')
                ->where('status', 1)
                ->sum('amount');
        }

        $data['withdraw_amount'] = WalletTransaction::whereHas('wallet', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('type', 'debit')->sum('amount');

    
        $data['searchable'] =  Wallet::$searchable;

        return view('author.wallet.index',$data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $data = WalletTransaction::find($id);

        $data = WalletTransaction::with('wallet')->find($id);

        if(empty($data)){
            return redirect()->route('vendor.wallet.index');
        }

        $data['data'] = $data;
        return view('author.wallet.show',$data);
    }

      /**
     * Store a withdraw request.
     */

    public function store(request $request){
        $rules['amount'] = 'required|numeric';
        $userId =  auth()->id();

        $total_amount = $this->walletService->getBalance($userId);
        if($request->amount > $total_amount){
            return response()->json(['status' => false,'msg' => trans('msg.insufficient_balance') ], 400);
        }

        if($request->amount < (int) getSetting()->min_withdraw){
            return response()->json(['status' => false,'msg' => trans('msg.greater_min_withdrawal') ], 400);
        }
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);  

        try {
            $this->walletService->debit(
                $userId,
                $request->amount,
                'WITHDRAW'
            );
        } catch (\Exception $e) {
            return response()->json(['status' => false,'msg' => $e->getMessage() ], 400);
        }

            return response()->json(['status' => true,'msg' => trans('msg.withdraw_req_suc')], 200);
    }
}
