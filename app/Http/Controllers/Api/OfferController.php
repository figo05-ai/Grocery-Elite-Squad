<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offer\ValidateOfferRequest;
use App\Services\OfferManager;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function __construct(
        private OfferManager $manager
    ) {}

    public function index(Request $request)
    {
        return $this->manager->index($request);
    }

    public function featured()
    {
        return $this->manager->featured();
    }

    public function showByCode(string $code)
    {
        return $this->manager->showByCode($code);
    }

    public function validateOffer(ValidateOfferRequest $request)
    {
        return $this->manager->validateOffer($request);
    }
}
