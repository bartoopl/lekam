<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\QuizAttempt;
use App\Models\Certificate;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get user's enrolled courses
        $enrolledCourses = Course::whereHas('userProgress', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['userProgress' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get();

        // Calculate statistics
        $completedCourses = 0;
        $totalPoints = 0;
        
        foreach ($enrolledCourses as $course) {
            $totalLessons = $course->lessons()->count();
            $completedLessons = $course->lessons()
                ->whereHas('userProgress', function($query) use ($user) {
                    $query->where('user_id', $user->id)->where('is_completed', true);
                })->count();
            
            if ($totalLessons > 0 && $completedLessons == $totalLessons) {
                $completedCourses++;
                // Add points based on user type
                if ($user->user_type === 'farmaceuta') {
                    $totalPoints += $course->pharmacist_points ?? 0;
                } else {
                    $totalPoints += $course->technician_points ?? 0;
                }
            }
        }

        // Count certificates (assuming we have a certificates table)
        $certificatesCount = Certificate::where('user_id', $user->id)->count();

        return view('dashboard', compact(
            'user', 
            'enrolledCourses', 
            'completedCourses', 
            'certificatesCount', 
            'totalPoints'
        ));
    }
}