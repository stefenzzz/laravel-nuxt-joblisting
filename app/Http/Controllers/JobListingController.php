<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobListingRequest;
use App\Models\JobListing;
use Illuminate\Http\Request;

class JobListingController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $active = $request->input('active', null); 
        $search = $request->input('search', null); 
        $user = $request->input('user', null); 
        $query = JobListing::join('users','users.id','job_listings.created_by')
        ->selectRaw('
            job_listings.id as id,
            title,
            description,
            company_name,
            job_listings.status as status,
            number_impression,
            number_applies,
            number_views,
            job_listings.created_at as posted,
            users.name as created_by,
            users.id as user_id
        ');
        
        // check if parameters are set
        if($user){
            $query->where('job_listings.created_by', $user);
        }
        if($active){
            $query->where('job_listings.status', 'active');
        }
        if($search){
            $query->where(function($query) use($search){
                $query->where('job_listings.title', 'like', "%{$search}%")
                ->orWhere('job_listings.company_name', 'like', "%{$search}%");
            });
        }


        $jobs = $query->orderByDesc('job_listings.created_at')
        ->paginate(9);
        
        return $jobs;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobListingRequest $request)
    {
        $fields = $request->validated();
        $fields['created_by'] = $request->user()->id;
        JobListing::create($fields);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
      return JobListing::query()->where('id',$id)->first();
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      return JobListing::query()->where('id',$id)->first();
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobListingRequest $request, string $id)
    {
        $fields = $request->validated();
        $jobListing = JobListing::query()->where('id',$id)->first();
        $request->user()->load('role');

        if( $jobListing->created_by !== $request->user()->id && $request->user()->role->code !== 'admin' ){
            return response()->json([
                'message' => 'you dont have permission to access this route'
            ], 401);
        }
        $jobListing->title = $fields['title'];
        $jobListing->company_name = $fields['company_name'];
        $jobListing->description = $fields['description'];
        $jobListing->email = $fields['email'];
        $jobListing->status = $fields['status'];

        $jobListing->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {   

        $jobListing = JobListing::query()->where('id',$id)->first();
        if( $jobListing->created_by !== $request->user()->id && $request->user()->role->code !== 'admin' ){
            return response()->json([
                'message' => 'you dont have permission to access this route'
            ], 401);
        }
        $jobListing->delete();
    }

    public function updateViews(string $id)
    {
        
        $jobListing = JobListing::query()->where('id',$id)->first();
        $jobListing->number_views =  (int) $jobListing->number_views + 1;
        $jobListing->save();
    }

    public function updateImpressions(string $id)
    {
        
        $jobListing = JobListing::query()->where('id',$id)->first();
        $jobListing->number_impression =  (int) $jobListing->number_impression + 1;
        $jobListing->save();
    }

    public function submitApplication(Request $request, string $id)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'contact' => 'required|numeric',
            'email' => 'required|email',
        ]);
        $jobListing = JobListing::query()->where('id',$id)->first();
        $jobListing->number_applies =  (int) $jobListing->number_applies + 1;
        $jobListing->save();

        // send email 
    }
}
