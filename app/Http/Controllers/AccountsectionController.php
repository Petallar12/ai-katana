<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accountsection;





class AccountsectionController extends Controller

{

    // public function index()
    // {
    //     $search = request()->get('search');

    //     if ($search) {
    //         $accountsection = Accountsection::where('full', 'like', '%'.$search.'%')
    //             ->orWhere('membership', 'like', '%'.$search.'%')
    //             ->orWhere('insurer', 'like', '%'.$search.'%')
    //             ->orWhere('policy', 'like', '%'.$search.'%')
    //             ->get();
    //     } else {
    //         $accountsection = Accountsection::all();
    //     }

    //     return view('accountsection.index', ['accountsection' => $accountsection]);
    // }
    public function index()
    {

        $search_insurer = request()->get('search_insurer');
        $search_status = request()->get('search_status');
        $search_start_date = request()->get('search_start_date');
        $query = Accountsection::query();
        if ($search_insurer) {
            $query->where('insurer', $search_insurer);
        }
        if ($search_status) {
            $query->where('status', $search_status);
        }
        if ($search_start_date) {
            $query->where('start_date', $search_start_date);
        }


        $insurers = Accountsection::select('insurer')->distinct()->get();
        $status = Accountsection::select('status')->distinct()->get();

        $accountsection = $query->get();

        return view('accountsection.index', ['accountsection' => $accountsection, 'insurers' => $insurers, 'status' => $status]);
    }



    public function create()
    {
        if (!(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')) {
            abort(404, 'Cannot Access');
        }
        return view('accountsection.create');
    }

    public function store(Request $request)
    {

        if (!(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')) {
            abort(404, 'Cannot Access');
        }
        $input = $request->all();
        Accountsection::create($input);
        return redirect('accountsection/index')->with('flash_message', 'Client Addedd!');
    }

    public function show($id)
    {

        $accountsection = Accountsection::find($id);
        return view('accountsection.show')->with('accountsection', $accountsection);
    }

    public function edit($id)
    {
        if (!(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')) {
            abort(404, 'Cannot Access');
        }

        $accountsection = Accountsection::find($id);
        return view('accountsection.edit')->with('accountsection', $accountsection);
    }

    public function update(Request $request, $id)
    {
        if (!(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')) {
            abort(404, 'Cannot Access');
        }
        $accountsection = Accountsection::find($id);
        $input = $request->all();
        $accountsection->update($input);
        return redirect('accountsection/index')->with('flash_message', 'Client Updated!');
    }

    public function destroy($id)
    {
        if (!(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')) {
            abort(404, 'Cannot Access');
        }
        Accountsection::destroy($id);
        return redirect('accountsection/index')->with('flash_message', 'Client deleted!');
    }
}
