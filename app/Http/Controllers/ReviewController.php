<?php

namespace App\Http\Controllers;

use App\Models\Jobseeker;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Jobseeker $jobseeker)
    {
        $user = Auth::user();
        $employer = $user->user;

        $existingReview = Review::where('jobseeker_id', $jobseeker->id)->where('employer_id', $employer->id)->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this jobseeker.');
        }

        return view('reviews.create', compact('jobseeker'));
    }
    public function store(Request $request, Jobseeker $jobseeker)
    {
        $request->validate([
            'rating_star' => ['required', 'integer', 'min:1', 'max:5'],
            'review_description' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = Auth::user();
        $employer = $user->user;

        $existingReview = Review::where('jobseeker_id', $jobseeker->id)->where('employer_id', $employer->id)->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this jobseeker.');
        }

        Review::create([
            'jobseeker_id' => $jobseeker->id,
            'employer_id' => $employer->id,
            'rating_star' => $request->rating_star,
            'review_description' => $request->review_description,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
    public function show(Jobseeker $jobseeker)
    {
        $reviews = $jobseeker->reviews()->with('employer.authParent')->latest()->get();
        
        return view('reviews.show', compact('jobseeker', 'reviews'));
    }
}
