<?php

namespace App\Http\Controllers;


use App\Http\Requests\ResponseRequest;
use App\Models\AssistentChat;
use App\Models\AttachmentRequest;
use App\Models\AssistenceRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AssistentChatController extends Controller
{
    
    public function sendResponse($_, array $args)
    {
        $data = $args['input'];

        $validator = Validator::make($data, (new ResponseRequest())->rules());

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => $validator->errors()->first(),
                'code' => 422
            ];
        }

        DB::beginTransaction();

        try {

            // Recupera il ticket esistente
            $ticket = AssistenceRequest::findOrFail($data['assistence_request_id']);

            // Recupera l'utente dall'email
            $user = User::where('email', $ticket->email)->firstOrFail();
            

            $filesAllegati = $data['attachments'] ?? []; 

            if (count($filesAllegati) > 0) {
                foreach ($filesAllegati as $file) {
                    $pathRelativo = $file->store('private'); // salva in storage/app/private

                    AttachmentRequest::create([
                        'assistence_request_id' => $ticket->id,
                        'file_name'  => $file->getClientOriginalName(),
                        'path'       => $pathRelativo,
                        'type'       => $file->getMimeType(),
                    ]);
                }
            }

        
           
            AssistentChat::create([
                'assistence_request_id'  => $ticket->id,
                'user_id'                => $user->id,
                'message'                => null,
                'response'               => $data['response'],
                'attachment_request_id'  => $attachmentIds[0] ?? null, // usa il primo allegato se presente
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Risposta inviata con successo',
                'code' => 201
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'code' => 500
            ];
        }
    }

    public function sendMessage($_, array $args)
    {
        $data = $args['input'];

        $validator = Validator::make($data, (new ResponseRequest())->rules());

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => $validator->errors()->first(),
                'code' => 422
            ];
        }

        DB::beginTransaction();

        try {

            // Recupera il ticket esistente
            $ticket = AssistenceRequest::findOrFail($data['assistence_request_id']);

            // Recupera l'utente dall'email
            $user = User::where('email', $ticket->email)->firstOrFail();


            $filesAllegati = $data['attachments'] ?? [];

            if (count($filesAllegati) > 0) {
                foreach ($filesAllegati as $file) {
                    $pathRelativo = $file->store('private'); // salva in storage/app/private

                    AttachmentRequest::create([
                        'assistence_request_id' => $ticket->id,
                        'file_name'  => $file->getClientOriginalName(),
                        'path'       => $pathRelativo,
                        'type'       => $file->getMimeType(),
                    ]);
                }
            }



            AssistentChat::create([
                'assistence_request_id'  => $ticket->id,
                'user_id'                => $user->id,
                'message'                => $data['message'],
                'response'               => null,
                'attachment_request_id'  => $attachmentIds[0] ?? null, // usa il primo allegato se presente
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Messaggio inviato con successo',
                'code' => 201
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'code' => 500
            ];
        }
    }
}
