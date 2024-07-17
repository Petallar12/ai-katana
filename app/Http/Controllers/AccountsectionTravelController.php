<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Accountsection_Travel;

class AccountsectionTravelController extends Controller
{
    
    public function index()
    {
        $search_insurer = request()->get('search_insurer');
        $search_start_date = request()->get('search_start_date');
        $query = Accountsection_travel::query();
        
        if ($search_insurer) {
            $query->where('insurer', $search_insurer);
        }
        
        if ($search_start_date) {
            $query->where('start_date', $search_start_date);
        }
    
        $accountsection_travel = $query->get();
    
        return view('travel.accountsection.index', ['accountsection_travel' => $accountsection_travel]);
    }
    
    public function create()
    {
        if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
            abort(404, 'Cannot Access');
        }
        return view('travel.accountsection.create');
    }

    public function store(Request $request)
            {
                if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
                    abort(404, 'Cannot Access');
                }
                $input = $request->all();
                Accountsection_travel::create($input);
                return redirect('travel/accountsection/index')->with('flash_message', 'Client Addedd!');  
            }
    


            
    public function show($id)
            {
                // if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
                //     abort(404, 'Cannot Access');
                // }
                $accountsection_travel = Accountsection_travel::find($id);
                return view('travel.accountsection.show')->with('accountsection_travel', $accountsection_travel);
            }

    public function edit($id)
            {
                if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
                    abort(404, 'Cannot Access');
                }
        
                $accountsection_travel = Accountsection_travel::find($id);
                return view('travel.accountsection.edit')->with('accountsection_travel', $accountsection_travel);
            }
          
    public function update(Request $request, $id)
            {
                if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
                    abort(404, 'Cannot Access');
                }
                $accountsection_travel = Accountsection_travel::find($id);
                $input = $request->all();
                $accountsection_travel->update($input);
                return redirect('travel/accountsection/index')->with('flash_message', 'Client Updated!');  
            }
          
    public function destroy($id)
            {
                if(!(auth()->user()->role == '1' || auth()->user()->role == '3' )) {
                    abort(404, 'Cannot Access');
                }
                Accountsection_travel::destroy($id);
                return redirect('travel/accountsection/index')->with('flash_message', 'Client deleted!');  
            }
   
}

// Create.blade.php   dont work   http://localhost:8000/2023/accountsection%20/index