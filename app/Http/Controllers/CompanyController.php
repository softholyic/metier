<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Http\Resources\CompanyResource;

class CompanyController extends Controller
{
    /**
     * Return a filtered list of companies
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'website_url' => 'required',
        ]);


        $company = Company::create([
            "name" => $request->name,
            "email" => $request->email,
            "owner_id" => \Auth::user()->id,
            "address" => $request->address,
            "website_url" => $request->website_url
        ]);

        $company->owner_id = \Auth::user()->id;
        $company->save();

        if($request->photo){
            $company->saveProfilePhoto($request->photo);
        }

        return ["status" => "success", "company_id" => $company->id];

    }

    /**
     * Return a filtered list of companies
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function fetch_datatable(Request $request){
        $_companies = Company::all();
        $companies = [];
        foreach($_companies as $company){
            $company->hiring_application_count = $company->applications()->count();
            array_push($companies,$company);
        }
        return ["data"=>$companies];
    }

    /**
     * Return a filtered list of companies
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function fetch(Request $request){
        return new CompanyResource(Company::findOrFail($request->company_id));
    }

    /**
     * Return openings
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function fetch_openings(Request $request){
        $company = Company::find($request->company_id);
        return ['openings'=>$company->openings()->orderBy('openings.created_at','desc')->get()->load('company')->load('programmingLanguages')->load('technologies')];
    }

    /**
     * Return hiring applications
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\JsonResource
     */
    public function fetchHiringApplications(Request $request){
        return Company::find($request->company_id)->applications->load('opening','opening.hiringProcedure','opening.hiringProcedure.hiring_steps','user','hiringStepResults');
    }
}
