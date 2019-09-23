<?php

namespace App\Http\Controllers\Api\v1\Mail;

use App\Services\MailService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    protected $mailService;
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }


    public function personasInteresadas(Request $request){
        return response()->json($this->mailService->reportePersonasInteresadas($request));
    }

    public function enviarMailInformativo(Request $request){
        return response()->json($this->mailService->enviarEmailInformativo(collect($request->all())));
    }

    public function enviarMailPersonalizado(Request $request){
        return response()->json($this->mailService->enviarMailPersonalizado($request->get("mail")));
    }
}
