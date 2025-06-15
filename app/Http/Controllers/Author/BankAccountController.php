<?php
namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\UserBankAccount;
use Illuminate\Http\Request;
use Validator;

class BankAccountController extends Controller
{
    public function index()
    {
        $accounts = UserBankAccount::where('user_id', auth()->id())->paginate(10);
        return view('author.bank_account.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        $rules = [
            'bank_name' => 'required',
            'account_number' => 'required',
            'account_holder' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        UserBankAccount::create([
            'user_id' => auth()->id(),
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
            'method' => $request->method,
            'is_default' => $request->is_default ? true : false,
        ]);
        return redirect()->route('vendor.bank_accounts.index')->with('success', 'Bank account saved.');
    }

    public function destroy($id)
    {
        $account = UserBankAccount::where('user_id', auth()->id())->findOrFail($id);
        $account->delete();
        return redirect()->route('vendor.bank_accounts.index')->with('success', 'Bank account deleted.');
    }
}
