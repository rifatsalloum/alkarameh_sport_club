<?php

namespace App\Http\Controllers;

use App\Http\Requests\sendMailRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    use GeneralTrait;
    public function login(UserLoginRequest $request){
        try{
        $user = User::where("email",$request->email)->first();

        if(!Hash::check($request->password,$user->password))
          return $this->unAuthorizeResponse();

        return $this->apiResponse(message($user->createToken("token")->plainTextToken));
    }catch(\Exception $e)
    {
        return $this->requiredField(message(null,5));
    }
    }
    public function logout(){
        try{
            $id = auth("sanctum")->user()->tokens()->delete();
            if($id)
             return $this->apiResponse(message(null,6));
            return $this->requiredField(message(null,7));
        }
        catch(\Exception $e){
            return $this->requiredField(message(null,7));
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(sendMailRequest $request){

        try{

        $email = $request->email;
        $name = $request->name;
        $number = $request->number;
        $message = $request->message;

        Mail::raw("You Have Message From: $email\nWith Phone Number: $number\nHe\She Saies:\n$message",function($message) use ($name) {
            $message->to("beastthe588@gmail.com")->from("sinowhitefine@gmail.com")->subject("$name");
        });
        return $this->apiResponse("تم ارسال البريد");
    }catch(\Exception $e){
        return $this->requiredField(message("لم يتم ارسال البريد"));
    }
        
    }
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
