<?php

namespace App\Http\Controllers\API;

use App\File;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Submission;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Config;
use Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\FileEntry;
use Carbon\Carbon;

class FileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;

        if ($user_id) {

            $user = User::find($user_id);

            if ($user) {
                return $user->files;
            }
        }

        return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'submission_id' => ['required', 'integer'],
            'file' => ['required', 'mimes:pdf,gif,png,jpg','max:30000'],
        ]);

        $generatedFileName = $request->file('file')->hashName();

        $data['filename'] = $generatedFileName;
        $data['mime'] = $request->file('file')->getClientMimeType();
        $data['extension'] = $request->file('file')->extension();
        $data['original_filename'] = $request->file('file')->getClientOriginalName();
        $data['size'] = $request->file('file')->getSize();

        $path = $request->file('file')->storeAs('uploads', $generatedFileName, 's3');
        $data['path'] = $path;

        if ($path) {
            $id = File::create($data);
        }

        if ($id) {
            $this->uploadXMLFile($request, $generatedFileName);
            return response()->json($data, 200);
        }
        else {
            return response()->json($data, 500);
        }
    }

    //client requires an xml file created for every upload
    private function uploadXMLFile($request, $generatedFileName)
    {
        //get xml template
        $xmlTemplate = Config::get('field_values.xml_upload_template');

        //get submission user email
        $userEmail = Submission::with('user')->findOrFail($request->input('submission_id'))->user->email;

        //replace email and date tokens
        $xmlTemplate = str_replace('##email##', $userEmail, $xmlTemplate);
        $xmlTemplate = str_replace('##date##', Carbon::now()->format("Y-m-d"), $xmlTemplate);

        //make filename same as uploaded file, change extension to .xml
        $xmlFilename = $generatedFileName;
        $xmlFilename = str_replace('.'.$request->file('file')->extension(), ".xml", $xmlFilename);

        //save file to aws
        Storage::disk('s3')->put('uploads/'.$xmlFilename, $xmlTemplate);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $File
     * @return \Illuminate\Http\Response
     */
    public function show(File $File)
    {
        return new FileResource($File);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $File
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $File)
    {
        $file = $request->file('file');

        $data = $request->validate([
            'submission_id' => ['integer'],
        ]);

        $data['submission_id'] = $request->submission_id;
        $data['filename'] = $file->hashName();
        $data['path'] = $file->store('uploads');
        $data['extension'] = $file->extension();
        $data['mime'] = $file->getMimeType();
        $data['size'] = $file->getSize();
        $data['original_filename'] = $file->getClientOriginalName();

        $File->update($data);
        return new FileResource($File);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $File
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $File)
    {
        $File->delete();
        return response(null, 204);
    }
}
