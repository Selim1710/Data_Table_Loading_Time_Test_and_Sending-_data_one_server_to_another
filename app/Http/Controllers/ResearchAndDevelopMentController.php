<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use App\DataTables\UsersDataTable;
use App\Models\UserLoginLog;

class ResearchAndDevelopMentController extends Controller
{
    public function dataTable(UsersDataTable $dataTable)
    {
        return $dataTable->render('data_table');
    }

    public function paginateCheck(Request $request)
    {
        $datas = User::orderBy('id', 'desc')
            ->paginate(50);

        return view('paginate_check', compact('datas'));
    }

    public function log()
    {
        // there showing main server data
        $client = new \GuzzleHttp\Client();
        $get_response = $client->request('GET', 'https://rmghealthcarebd.com/MainServer/user/log/view');
        $datas = json_decode($get_response->getBody(), true);

        return view('user_log', compact('datas'));
    }

    public function logCreate(Request $request)
    {
        // $data = $request->all();
        // return $data;
        UserLoginLog::create([
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'user' => 'guest',
        ]);
    }
    public function logView()
    {
        $data = UserLoginLog::all();
        return $data;
    }

    public function refreshLog()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://rmghealthcarebd.com/MainServer/user/log/create/www.acquaintbd.net');

        return back();

        // let, Refresh-button is child server login button,
        // when user click on login button then data will sent into main server 
    }

    public function writingInTextFile()
    {
        $file_location = 'testing_file.text';

        // Open a file named - $file_location - in write mode
        $data = fopen($file_location, "w");

        // writing content to a file using fwrite() function
        echo fwrite($data, "hello");

        // closing the file
        fclose($data);
    }
}
