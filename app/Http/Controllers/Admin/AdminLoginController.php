<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminLoginService;
use App\Http\Requests\Admin\AdminLoginValidation;
class AdminLoginController extends Controller
{
    protected $loginService;
    public function __construct(AdminLoginService $loginService)
    {
        $this->loginService= $loginService;
    }

    public function index()
    {
        return $this->loginService->index();
    }

    public function doLogin(AdminLoginValidation $request)
    {
        return $this->loginService->doLogin($request);
    }

    public function logout()
    {
        return $this->loginService->logout();
    }
}
