<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $search = request('search');

    // Create the base query
    $query = Employee::query();

    // Apply search if a search term exists
    $query->when($search, function ($query) use ($search) {

        $query->where(function ($q) use ($search) {

            $q->where('first_name', 'like', "%$search%")
              ->orWhere('last_name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('phone_number', 'like', "%$search%")
              ->orWhere('department', 'like', "%$search%")
              ->orWhere('gender', '=', $search);

        });

    });

    // Statistics based on the search results
    $totalEmployees = (clone $query)->count();

    $maleEmployees = (clone $query)
        ->where('gender', 'Male')
        ->count();

    $femaleEmployees = (clone $query)
        ->where('gender', 'Female')
        ->count();

    $averageSalary = (clone $query)->avg('salary');

    $totalPayroll = (clone $query)->sum('salary');

    $departments = (clone $query)
        ->distinct('department')
        ->count('department');

    // Employee results
    $employees = $query
        ->paginate(10)
        ->withQueryString();

    return view('employees.index', compact(
        'employees',
        'totalEmployees',
        'maleEmployees',
        'femaleEmployees',
        'averageSalary',
        'totalPayroll',
        'departments'
    ));

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
