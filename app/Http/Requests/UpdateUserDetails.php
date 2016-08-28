<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateUserDetails extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return false; 
        $userId = $this->route('user'); //Route::put('affiliate/{user}'...
        return (\Auth::user()->can('CRUDusers') || \Auth::user()->id == $userId->id);
        //return \App\Models\User::where('id', $commentId)
        //          ->where('user_id', Auth::id())->exists();

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => 'required|min:3',
            'oldpass'  => 'required_if:changepass,1',
            'newpass'  => 'required_if:changepass,1|min:6',
            'newpassconfirm'  => 'same:newpass',

        ];
    }

    public function messages()
    {
        return [
        'nickname.required' => 'Nickname cannot be empty! Pls name yourself with at least 3 characters.',
        'nickname.min' => 'Nickname too short! Please name yourself with at least 3 characters.',
        'oldpass.required_if' => 'Please enter old password!',
        'newpass.required_if' => 'Please enter new password and confirmation!',
        'newpass.min' => 'New password too short. Please enter at least 6 characters!',
        'newpassconfirm.same' => 'New password and its confirm are not the same!',
        ];
    }

}
