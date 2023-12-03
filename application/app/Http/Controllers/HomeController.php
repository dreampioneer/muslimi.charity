<?php

namespace App\Http\Controllers;

use App\Models\DonateHistory;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;
use Ramsey\Uuid\Uuid;
use Square\SquareClient;
use Square\Models\CatalogObjectType;
class HomeController extends Controller
{
    public function index(){
        SEOTools::setTitle('Home - MUSLIMI');
        SEOTools::setDescription(config('constants.home_content'));
        SEOTools::opengraph()->setUrl(route("home.index"));
        SEOTools::setCanonical(route("home.index"));
        SEOTools::opengraph()->addProperty('type', 'home');
        SEOTools::jsonLd()->addImage([asset('assets/img/home.png'), asset('assets/video/What_are_the_Rules_of_War_thumbnail.jpg')]);
        return view('home');
    }

    public function donate(){
        SEOTools::setTitle('Donate - MUSLIMI');
        SEOTools::setDescription(config('constants.home_content'));
        SEOTools::opengraph()->setUrl(route("home.donate"));
        SEOTools::setCanonical(route("home.donate"));
        SEOTools::opengraph()->addProperty('type', 'donate');
        SEOTools::jsonLd()->addImage(asset('assets/img/home.png'));
        $donates = DonateHistory::orderBy('created_at', 'desc')->limit(5)->get();
        $squareClient = new SquareClient([
            'accessToken' => env('SQUARE_ACCESS_TOKEN'),
            'environment' => env('SQUARE_ENVIRONMENT'),
        ]);
        $catalogApi = $squareClient->getCatalogApi();
        $apiResponse = $catalogApi->listCatalog();
        $item = [];
        if ($apiResponse->isSuccess()) {
            $listCatalogResponse = $apiResponse->getResult();
            $items = $listCatalogResponse->getObjects();
        } else {
            $errors = $apiResponse->getErrors();
        }
        $categories = [];
        foreach($items as $item){
            if($item->getType() === CatalogObjectType::CATEGORY){
                $categories[$item->getId()] = $item->getCategoryData()->getName();
            }
        }
        $donateFoods = [];
        $donateMedicalSupplies = [];
        $donateShelter = [];
        $donateAidCombo = [];
        foreach($items as $item){
            if($item->getType() === CatalogObjectType::ITEM){
                $jsonItem = $item->jsonSerialize();
                $data = [
                    'donate_id' => $jsonItem['id'],
                    'donate_name' => $jsonItem['item_data']->getName(),
                    'amount' => $jsonItem['item_data']->getVariations()[0]->getItemVariationData()->getPriceMoney()->getAmount() / 100
                ];
                if($categories[$jsonItem['item_data']->getCategoryId()] == 'Food'){
                    array_push($donateFoods, $data);
                }
                if($categories[$jsonItem['item_data']->getCategoryId()] == 'Medical Supply'){
                    array_push($donateMedicalSupplies, $data);
                }
                if($categories[$jsonItem['item_data']->getCategoryId()] == 'Shelter'){
                    array_push($donateShelter, $data);
                }
                if($categories[$jsonItem['item_data']->getCategoryId()] == 'Aid Combo'){
                    array_push($donateAidCombo, $data);
                }
            }
        }
        usort($donateFoods, function($a, $b) {
            return $a['amount'] > $b['amount'];
        });
        $idempotencyKey = Uuid::uuid4();
        return view('donate', [
            'donates' => $donates,
            'idempotencyKey' => $idempotencyKey,
            'donateFoods' => $donateFoods,
            'donateMedicalSupplies' => $donateMedicalSupplies,
            'donateShelter' => $donateShelter,
            'donateAidCombo' => $donateAidCombo,
        ]);
    }

    public function thanks($donate_history_id){
        SEOTools::setTitle('Thanks - MUSLIMI');
        $donate = DonateHistory::with('detail')->find($donate_history_id);
        return view('thanks', ['donate' => $donate]);
    }
}
