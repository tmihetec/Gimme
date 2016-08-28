<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MessagesController extends Controller
{
    //

	public function index()
	{

		$msgs = \App\Models\Message::with('author','recipients')->get();

		$sendData=[
			'msgs'=>$msgs
		];
		return view('messages.index')->with($sendData);
	}


	public function create()
	{

		$partnerlist = \App\Models\Partner::lists('name','id');

		$sendData=[
			'partnerlist' => $partnerlist,
		];
		return view('messages.create')->with($sendData);
	}


	public function store(Request $request)
	{

		$rules=[
			'title' => 'required',
			'body' => 'required'
		];
		$messages=[
		];
        $this->validate($request, $rules, $messages);


        $msg=new \App\Models\Message;
        $msg->title = $request->input('title');
        $msg->body = $request->input('body');
        $msg->user_id = \Auth::user()->id;
        $msg->class = $request->class;


        dd($request);

        // recipients array
        $recipients = [
        	1 => ['seendatetime' => null]
        ];
        // attach recipients
        $msg->recipients()->attach($recipients);

        $msg->save();

		$statusmsg="Message sent!";




		return redirect('messages')->with('message',$statusmsg);
	}

}
