<?php

namespace App\Http\Controllers\Web\Monitor;

use App\Models\Advertiser;
// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Pagination\Paginator;

/**
 * Class AdvertiserDetailController
 * @package App\Http\Controllers\Web\Monitor
 * Controller's name.
 * Controller shows details of compagn.
 * Shows advertising blocks of compagn and filter them.
 */
class AdvertiserDetailController extends Controller
{
    /**
     * @param int $id Обязательный параметр
     *      $id gets argument int number > 0 and is in id field, advertisers table in database 
     *      if element doesn't exist and user doesn't fit advertiser campagn then it calls exeption  NotFoundHttpException
     */
    public function index($id, $page = 1)
    {
        // Setting of current page for pagination
        Paginator::currentPageResolver(function() use($page) {
            return $page;
        });

        // Getting format data of advertising campagn
        $advertiser = Advertiser::getAdvertiserData([
            'advertiser_id' => $id,
            'client_id'     => Auth::user()->client->id,
        ]);

        // Getting format data of advertising campagn with pagination
        $advertiser_details = Advertiser::getAdvertiserDataDetails([
            'advertiser_id' => $id,
            'client_id'     => Auth::user()->client->id,
        ]);

        return view("inventory.advertiser-detail.index", [
            'advertiser'         => $advertiser,
            'advertiser_details' => $advertiser_details,
        ]);
    }

   
    public function filter($id, $status, $page = 1)
    {
        // Setting of current page for pagination
        Paginator::currentPageResolver(function() use($page) {
            return $page;
        });

        // Getting format data of advertising campagn
        $advertiser = Advertiser::getAdvertiserData([
            'advertiser_id' => $id,
            'client_id' => Auth::user()->client->id,
        ]);

        // Getting format details of advertising campagn with pagination and data
        $data = Advertiser::getAdvertiserFilterDataDetails([
            'advertiser_id' => $id,
            'status' => $status,
        ]);

        $title = $data['title'];
        $advertiser_details = $data['advertiser_details'];

        return view('inventory.advertiser-detail.filter', [
            'title'              => $title,
            'status'             => $status,
            'advertiser'         => $advertiser,
            'advertiser_details' => $advertiser_details,
        ]);
    }
}
