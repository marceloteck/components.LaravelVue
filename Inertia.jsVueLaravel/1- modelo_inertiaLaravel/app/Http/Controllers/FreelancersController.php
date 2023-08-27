<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FreelancersController extends Controller
{
    public function index()
    {
        $freelancers = ['John', 'Janne', 'Dev'];

        return Inertia::render('pages/home', compact('freelancers'));
    }
    public function menu1()
    {
        $freelancers = ['John', 'Janne', 'Dev'];

        return Inertia::render('pages/menu1', compact('freelancers'));
    }
    public function pagina01()
    {
        $freelancers = ['John', 'Janne', 'Dev'];

        return Inertia::render('pages/pagina01', compact('freelancers'));
    }
}
