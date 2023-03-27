<?php

namespace App\Http\Controllers;

use App\Actions\GetAuctionAction;
use App\Actions\GetAuctionsPaginatedAction;
use App\Actions\ParseAuctionsAction;
use App\Http\Resources\AuctionWithDataResource;
use App\Http\Responses\SuccessResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuctionsController extends Controller
{
    public function get(Request $request): AuctionWithDataResource|AnonymousResourceCollection
    {
        if ($request->has('number'))
        {
            $number = $request->get('number');
            $action = new GetAuctionAction();
            return new AuctionWithDataResource($action->execute($number));
        }

        $pageCount = (int)($request->get('page_count', 0));
        $action = new GetAuctionsPaginatedAction();
        return AuctionWithDataResource::collection($action->execute($pageCount));
    }

    public function parse(Request $request, ParseAuctionsAction $action): SuccessResponse
    {
        $page = (int)($request->get('page', 1));
        $action->execute($page);
        return new SuccessResponse();
    }
}
