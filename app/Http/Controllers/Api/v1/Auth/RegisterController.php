<?php
/**
 * Copyright © 2018 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

namespace App\Http\Controllers\Api\v1\Auth;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\common\Auth\RegisterController as BaseRegisterController;

class RegisterController extends BaseRegisterController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());//$this->validator($request->all())->validate();
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            event(new Registered($user = $this->create($request->all())));

            $this->guard()->login($user);

            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function registered(Request $request, $user)
    {
        $user->generateToken();

        return response()->json(['data' => $user->toArray()], 201);
    }
}
