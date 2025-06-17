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
        $banks = config('banks');
        return view('author.bank_account.index', compact('accounts','banks'));
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
            'is_default' => $request->has('is_default'),
        ]);
        return redirect()->route('vendor.bank_accounts.index')->with('success', 'Bank account saved.');
    }

    public function edit($id)
    {
        $account = UserBankAccount::where('user_id', auth()->id())->findOrFail($id);
        $banks = config('banks');
        return view('author.bank_account.edit', compact('account', 'banks'));
    }

    public function update(Request $request, $id)
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

        $account = UserBankAccount::where('user_id', auth()->id())->findOrFail($id);
        $account->update([
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
            'method' => $request->method,
            'is_default' => $request->has('is_default'),
        ]);

        return redirect()->route('vendor.bank_accounts.index')->with('success', 'Bank account updated.');
    }

    public function destroy($id)
    {
        $account = UserBankAccount::where('user_id', auth()->id())->findOrFail($id);
        $account->delete();
        return redirect()->route('vendor.bank_accounts.index')->with('success', 'Bank account deleted.');
    }
}
