<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendEmailJob;

class AdminEmailController extends Controller
{
    public function showEmailForm()
    {
        return view('admin.admin_email');
    }

    public function sendEmail(Request $request,$id)
    {
        $validatedData = $request->validate([
            'message' => 'required',
        ], [
            'message.required' => 'メッセージを入力してください。',
        ]);

        $Contact = ShopEmail

        $message = $validatedData['message'];

        SendEmailJob::dispatch($message);

        return redirect()->back()->with('success', 'メールが送信されました。');
    }
}
