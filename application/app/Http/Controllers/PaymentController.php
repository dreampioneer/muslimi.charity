<?php

namespace App\Http\Controllers;

use App\Models\DonateDetail;
use App\Models\DonateHistory;
use Exception;
use Illuminate\Http\Request;
use Stripe\Exception\CardException;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Square\Models\Builders\CreatePaymentRequestBuilder;
use Square\Models\Builders\MoneyBuilder;
use Square\Models\Builders\SearchCustomersRequestBuilder;
use Square\Models\Builders\CustomerQueryBuilder;
use Square\Models\Builders\CustomerFilterBuilder;
use Square\Models\Builders\CustomerTextFilterBuilder;
use Square\Models\Builders\CreateCustomerRequestBuilder;
use Square\Models\Builders\UpsertCatalogObjectRequestBuilder;
use Square\Models\Builders\CatalogObjectBuilder;
use Square\Models\CatalogObjectType;
use Square\Models\SubscriptionCadence;
use Square\Models\SubscriptionPricingType;
use Square\Models\Builders\CatalogSubscriptionPlanBuilder;
use Square\Models\Builders\SubscriptionPhaseBuilder;
use Square\Models\Builders\CreateSubscriptionRequestBuilder;
use Square\Models\Builders\SubscriptionPricingBuilder;
use Square\Models\Builders\CreateOrderRequestBuilder;
use Square\Models\Builders\OrderBuilder;
use Square\Models\Builders\CatalogSubscriptionPlanVariationBuilder;
use Square\Models\Builders\OrderLineItemBuilder;
use Square\Models\Builders\PhaseBuilder;
use Square\Models\Builders\CreateCustomerCardRequestBuilder;
use Square\Models\Currency;
use Square\Models\OrderLineItemItemType;
use Square\Models\OrderState;
use Square\SquareClient;
use Ramsey\Uuid\Uuid;
use Square\Models\CatalogObject;
use Square\Models\UpsertCatalogObjectRequest;

class PaymentController extends Controller
{
    public function index()
    {
        return view('stripe.index');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'stripeToken' => ['required'],
            'card_number' => ['required'],
            'cvc' => ['required', 'numeric'],
            'expirey_date' => ['required'],
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'donates' => ['required', 'array', 'min:1'],
            'dedicate_this_donation' => ['max:40000'],
            // 'is_zakat' => ['boolean'],
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }

        try {
            $email = $request->email;
            $stripe = new StripeClient(env('STRIPE_SECRET'));

            $customers = $stripe->customers->all([
                "limit" => 100,
                "email" => $email,
            ]);

            foreach ($customers->autoPagingIterator() as $customer) {
                if ($customer->name == $request->first_name . " " . $request->last_name) {
                    $customerId = $customer->id;
                    break;
                }
            }

            if (isset($customerId)) {
                $customer = $stripe->customers->retrieve($customerId);
            } else {
                $customer = $stripe->customers->create(
                    [
                        "email" => $request->email,
                        "name" => $request->first_name . " " . $request->last_name,
                        "source" => $request->stripeToken
                    ]
                );
            }

            $total = 0;

            foreach ($request->donates as $donate) {
                $subtotal = intval($donate['donate_count']) * floatval($donate['donate_amount']);
                $total += $subtotal;
            }

            if ($request->is_monthly == 'true') {
                $items = [];
                foreach ($request->donates as $donate) {
                    array_push($items, [
                        'price' => $donate['donate_price_id'],
                        'quantity' => intval($donate['donate_count'])
                    ]);
                }

                $result = $stripe->subscriptions->create([
                    'customer' => $customer->id,
                    'items' => $items,
                    'payment_behavior' => 'default_incomplete',
                    'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
                    'expand' => ['latest_invoice.payment_intent'],
                    "description" => $request->dedicate_this_donation ? "Double-Time Donate - " . $request->dedicate_this_donation : "Double-Time Donate",
                ]);

                $invoice = $stripe->invoices->pay($result->latest_invoice->id, [
                    "source" => $customer->default_source
                ]);
            } else {

                $result = $stripe->charges->create([
                    "amount" => $total * 100,
                    "currency" => "usd",
                    "customer" => $customer->id,
                    "description" => $request->dedicate_this_donation ? "One-Time Donate - " . $request->dedicate_this_donation : "One-Time Donate",
                ]);
            }

            $donateHistory = DonateHistory::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'customer_id' => $customer->id,
                'phone' => $request->phone_number,
                'dedicate_this_donation' => $request->dedicate_this_donation,
                'is_zakat' => $request->is_zakat == 'true' ? 1 : 0,
                'is_monthly' => $request->is_monthly == 'true' ? 1 : 0,
                'price' => $total,
                'transaction_id' => $result->id,
            ]);

            foreach ($request->donates as $donate) {
                DonateDetail::create([
                    'donate_history_id' => $donateHistory->id,
                    'donate_name' => $donate["donate_name"],
                    'donate_amount' => $donate["donate_amount"],
                    'donate_count' => $donate["donate_count"],
                ]);
            }

            $data = [
                'status' => 'success',
                'msg' => '',
                'return_url' => route('home.thanks', $donateHistory->id)
            ];

            $request->session()->flash('success', 'You have donated successfully!');
            return response()->json($data);
        } catch (CardException $th) {
            return response()->json(['status' => 'error', 'msg' => $th->getMessage()]);
        }
    }

    public function squarePayment(Request $request){
        $validate = Validator::make($request->all(), [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'donates' => ['required', 'array', 'min:1'],
            'dedicate_this_donation' => ['max:40000'],
            'locationId' => ['required'],
            'sourceId' => ['required'],
            'idempotencyKey' => ['required'],
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }

        $sourceId = $request->sourceId;
        $idempotencyKey = Uuid::uuid4(); // $request->idempotencyKey;

        $email = $request->email;
        $firstName = $request->first_name;
        $lastName = $request->last_name;

        $squareClient = new SquareClient([
            'accessToken' => env('SQUARE_ACCESS_TOKEN'),
            'environment' => env('SQUARE_ENVIRONMENT'),
        ]);

        $customersApi = $squareClient->getCustomersApi();

        $searchBody = SearchCustomersRequestBuilder::init()
            ->limit(1)
            ->query(
                CustomerQueryBuilder::init()
                    ->filter(
                        CustomerFilterBuilder::init()
                            ->emailAddress(
                                CustomerTextFilterBuilder::init()
                                    ->fuzzy($email)
                                    ->build()
                            )
                            ->build()
                    )
                    ->build()
            )
            ->build();

        $apiResponse = $customersApi->searchCustomers($searchBody);

        $customerId = '';

        if ($apiResponse->isSuccess()) {
            $searchCustomersResponse = $apiResponse->getResult();
            $customers = $searchCustomersResponse->getCustomers();
            if(!is_null($customers) && count($customers)){
                $customerId = $customers[0]->getId();
            }else{
                $createCustomerBody = CreateCustomerRequestBuilder::init()
                    ->givenName($firstName)
                    ->familyName($lastName)
                    ->emailAddress($email)
                    ->phoneNumber($request->phone_number)
                    ->build();

                $apiResponse = $customersApi->createCustomer($createCustomerBody);

                if ($apiResponse->isSuccess()) {
                    $createCustomerResponse = $apiResponse->getResult();
                    $customer = $createCustomerResponse->getCustomer();
                    $customerId = $customer->getId();
                } else {
                    $errors = $apiResponse->getErrors();
                    $msg = $this->getErrorMsg($errors);
                    return response()->json(['status' => 'error', 'msg' => $msg]);
                }
            }
        } else {
            $errors = $apiResponse->getErrors();
            $msg = $this->getErrorMsg($errors);
            return response()->json(['status' => 'error', 'msg' => $msg]);
        }

        $total = 0;
        $lineItems = [];
        foreach ($request->donates as $donate) {
            $subtotal = intval($donate['donate_count']) * floatval($donate['donate_amount']);
            $total += $subtotal;
            array_push($lineItems,
                OrderLineItemBuilder::init($donate['donate_count'])
                ->catalogObjectId($donate['donate_id'])
                ->itemType(OrderLineItemItemType::ITEM)
                ->build()
            );
        }

        $ordersApi = $squareClient->getOrdersApi();
        if ($request->is_monthly == 'true') {
            $orderState = OrderState::DRAFT;
        }else{
            $orderState = OrderState::OPEN;
        }
        $body = CreateOrderRequestBuilder::init()
            ->order(
                OrderBuilder::init(
                    env('SQUARE_LOCATION_ID')
                )
                ->lineItems($lineItems)
                ->state($orderState)
                ->build()
            )
            ->idempotencyKey($idempotencyKey)
            ->build();
        $apiResponse = $ordersApi->createOrder($body);

        if ($apiResponse->isSuccess()) {
            $createOrderResponse = $apiResponse->getResult();
            $orderId = $createOrderResponse->getOrder()->getId();
            $totalAmount = $createOrderResponse->getOrder()->getTotalMoney();
        } else {
            $errors = $apiResponse->getErrors();
            $msg = $this->getErrorMsg($errors);
            return response()->json(['status' => 'error', 'msg' => $msg]);
        }

        if ($request->is_monthly == 'true') {
            $body = CreateCustomerCardRequestBuilder::init(
                    $sourceId
                )
                ->cardholderName($firstName . ' ' . $lastName)
                ->build();

            $apiResponse = $customersApi->createCustomerCard(
                $customerId,
                $body
            );

            if ($apiResponse->isSuccess()) {
                $createCustomerCardResponse = $apiResponse->getResult();
                $card = $createCustomerCardResponse->getCard();
            } else {
                $errors = $apiResponse->getErrors();
                $msg = $this->getErrorMsg($errors);
                return response()->json(['status' => 'error', 'msg' => $msg]);
            }

            $catalogApi = $squareClient->getCatalogApi();
            $time = time();
            $body = UpsertCatalogObjectRequestBuilder::init(
                        $idempotencyKey,
                        CatalogObjectBuilder::init(
                            CatalogObjectType::SUBSCRIPTION_PLAN,
                            "#" . $time
                        )
                            ->subscriptionPlanData(
                                CatalogSubscriptionPlanBuilder::init('SPlan - ' . $time)
                                    ->phases([
                                        SubscriptionPhaseBuilder::init(SubscriptionCadence::MONTHLY)
                                            ->pricing(
                                                SubscriptionPricingBuilder::init()
                                                ->type(SubscriptionPricingType::STATIC_)
                                                ->build()
                                            )->build()
                                ])->build()
                        )->build()
                    )->build();

            $apiResponse = $catalogApi->upsertCatalogObject($body);

            if ($apiResponse->isSuccess()) {
                $upsertCatalogObjectResponse = $apiResponse->getResult();
                $subscriptionPlanId = $upsertCatalogObjectResponse->getCatalogObject()->getId();
            } else {
                $errors = $apiResponse->getErrors();
                $msg = $this->getErrorMsg($errors);
                return response()->json(['status' => 'error', 'msg' => $msg]);
            }

            $idempotencyKey = Uuid::uuid4();

            $body = UpsertCatalogObjectRequestBuilder::init(
                        $idempotencyKey,
                        CatalogObjectBuilder::init(
                            CatalogObjectType::SUBSCRIPTION_PLAN_VARIATION,
                            "#" . $time
                        )
                            ->subscriptionPlanVariationData(
                                CatalogSubscriptionPlanVariationBuilder::init('SPlan Variation - ' . $time, [
                                        SubscriptionPhaseBuilder::init(SubscriptionCadence::MONTHLY)
                                            ->pricing(
                                                SubscriptionPricingBuilder::init()
                                                ->type(SubscriptionPricingType::RELATIVE)
                                                ->build()
                                            )
                                            ->build()
                                    ])
                                    ->subscriptionPlanId($subscriptionPlanId)
                                    ->build()
                            )->build()
                    )->build();

            $apiResponse = $catalogApi->upsertCatalogObject($body);

            if ($apiResponse->isSuccess()) {
                $upsertCatalogObjectResponse = $apiResponse->getResult();
                $subscriptionPlanVariationId = $upsertCatalogObjectResponse->getCatalogObject()->getId();
            } else {
                $errors = $apiResponse->getErrors();
                $msg = $this->getErrorMsg($errors);
                return response()->json(['status' => 'error', 'msg' => $msg]);
            }

            $subscriptionsApi = $squareClient->getSubscriptionsApi();

            $body = CreateSubscriptionRequestBuilder::init(
                env('SQUARE_LOCATION_ID'),
                $customerId
            )
                ->idempotencyKey($idempotencyKey)
                ->planVariationId($subscriptionPlanVariationId)
                ->cardId($card->getId())
                ->phases(
                    [
                        PhaseBuilder::init()
                            ->ordinal(0)
                            ->orderTemplateId($orderId)
                            ->build()
                    ]
                )
                ->build();

            $apiResponse = $subscriptionsApi->createSubscription($body);

            if ($apiResponse->isSuccess()) {
                $createSubscriptionResponse = $apiResponse->getResult();
                $paymentId = $createSubscriptionResponse->getSubscription()->getId();
            } else {
                $errors = $apiResponse->getErrors();
                $msg = $this->getErrorMsg($errors);
                return response()->json(['status' => 'error', 'msg' => $msg]);
            }
        }else{
            $paymentsApi = $squareClient->getPaymentsApi();

            $body = CreatePaymentRequestBuilder::init(
                    $sourceId,
                    $idempotencyKey
                )
                ->amountMoney(
                    MoneyBuilder::init()
                        ->amount($totalAmount->getAmount())
                        ->currency(Currency::USD)
                        ->build()
                )
                ->orderId($orderId)
                ->autocomplete(true)
                ->customerId($customerId)
                ->locationId(env('SQUARE_LOCATION_ID'))
                ->note($request->dedicate_this_donation ? "One-Time Donate - " . $request->dedicate_this_donation : "One-Time Donate")
                ->build();

            $apiResponse = $paymentsApi->createPayment($body);

            if ($apiResponse->isSuccess()) {
                $createPaymentResponse = $apiResponse->getResult();
                $paymentId = $createPaymentResponse->getPayment()->getId();
            } else {
                $errors = $apiResponse->getErrors();
                $msg = $this->getErrorMsg($errors);
                return response()->json(['status' => 'error', 'msg' => $msg]);
            }
        }

        $donateHistory = DonateHistory::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'customer_id' => $customerId,
            'phone' => $request->phone_number,
            'dedicate_this_donation' => $request->dedicate_this_donation,
            'is_zakat' => $request->is_zakat == 'true' ? 1 : 0,
            'is_monthly' => $request->is_monthly == 'true' ? 1 : 0,
            'price' => $total,
            'transaction_id' => $paymentId,
        ]);

        foreach ($request->donates as $donate) {
            DonateDetail::create([
                'donate_history_id' => $donateHistory->id,
                'donate_name' => $donate["donate_name"],
                'donate_amount' => $donate["donate_amount"],
                'donate_count' => $donate["donate_count"],
            ]);
        }

        $data = [
            'status' => 'success',
            'msg' => '',
            'return_url' => route('home.thanks', $donateHistory->id)
        ];

        $request->session()->flash('success', 'You have donated successfully!');
        return response()->json($data);
    }

    function getErrorMsg($errors){
        $msg = [];
        foreach ($errors as $error) {
            $errorDetail = $error->getDetail();
            $errorDetail = str_replace('_', ' ', $errorDetail);
            $errorCategory = $error->getCategory();
            $errorCategory = str_replace('_', ' ', $errorCategory);
            array_push($msg, "Error Type: $errorCategory, Detail: $errorDetail");
            return $msg;
        }
    }

    // public function squareTest(){
    //     $idempotencyKey = Uuid::uuid4();

    //     $squareClient = new SquareClient([
    //         'accessToken' => env('SQUARE_ACCESS_TOKEN'),
    //         'environment' => env('SQUARE_ENVIRONMENT'),
    //     ]);

    //     $catalogApi = $squareClient->getCatalogApi();
    //     $time = time();
    //     $body = UpsertCatalogObjectRequestBuilder::init(
    //                 $idempotencyKey,
    //                 CatalogObjectBuilder::init(
    //                     CatalogObjectType::SUBSCRIPTION_PLAN,
    //                     "#" . $time
    //                 )
    //                     ->subscriptionPlanData(
    //                         CatalogSubscriptionPlanBuilder::init('SPlan - ' . $time)
    //                             ->phases([
    //                                 SubscriptionPhaseBuilder::init(SubscriptionCadence::MONTHLY)
    //                                     ->pricing(
    //                                         SubscriptionPricingBuilder::init()
    //                                         ->type(SubscriptionPricingType::STATIC_)
    //                                         ->build()
    //                                     )->build()
    //                         ])->build()
    //                 )->build()
    //             )->build();

    //     $apiResponse = $catalogApi->upsertCatalogObject($body);

    //     if ($apiResponse->isSuccess()) {
    //         $upsertCatalogObjectResponse = $apiResponse->getResult();
    //         $subscriptionPlanId = $upsertCatalogObjectResponse->getCatalogObject()->getId();
    //     } else {
    //         $errors = $apiResponse->getErrors();
    //     }

    //     $idempotencyKey = Uuid::uuid4();

    //     $body = UpsertCatalogObjectRequestBuilder::init(
    //                 $idempotencyKey,
    //                 CatalogObjectBuilder::init(
    //                     CatalogObjectType::SUBSCRIPTION_PLAN_VARIATION,
    //                     "#" . $time
    //                 )
    //                     ->subscriptionPlanVariationData(
    //                         CatalogSubscriptionPlanVariationBuilder::init('SPlan Variation - ' . $time, [
    //                                 SubscriptionPhaseBuilder::init(SubscriptionCadence::MONTHLY)
    //                                     ->pricing(
    //                                         SubscriptionPricingBuilder::init()
    //                                         ->type(SubscriptionPricingType::RELATIVE)
    //                                         ->build()
    //                                     )
    //                                     ->build()
    //                             ])
    //                             ->subscriptionPlanId($subscriptionPlanId)
    //                             ->build()
    //                     )->build()
    //             )->build();

    //     $apiResponse = $catalogApi->upsertCatalogObject($body);

    //     if ($apiResponse->isSuccess()) {
    //         $upsertCatalogObjectResponse = $apiResponse->getResult();
    //         $subscriptionPlanVariationId = $upsertCatalogObjectResponse->getCatalogObject()->getId();
    //     } else {
    //         $errors = $apiResponse->getErrors();
    //     }

    //     echo json_encode($subscriptionPlanVariationId);

    //     $subscriptionsApi = $squareClient->getSubscriptionsApi();

    //     $body = CreateSubscriptionRequestBuilder::init(
    //         env('SQUARE_LOCATION_ID'),
    //         'CHFGVKYY8RSV93M5KCYTG4PN0G'
    //     )
    //         ->idempotencyKey($idempotencyKey)
    //         ->planVariationId('6JHXF3B2CW3YKHDV4XEM674H')
    //         ->cardId('ccof:qy5x8hHGYsgLrp4Q4GB')
    //         ->phases(
    //             [
    //                 PhaseBuilder::init()
    //                     ->ordinal(0)
    //                     ->orderTemplateId($subscriptionPlanVariationId)
    //                     ->build()
    //             ]
    //         )
    //         ->build();

    //     $apiResponse = $subscriptionsApi->createSubscription($body);

    //     if ($apiResponse->isSuccess()) {
    //         $createSubscriptionResponse = $apiResponse->getResult();
    //     } else {
    //         $errors = $apiResponse->getErrors();
    //     }

    //     // echo json_encode();

    //     // $planVariationId = $upsertCatalogObjectResponse->getId();

    //     // $body = CreateSubscriptionRequestBuilder::init(
    //     //     env('SQUARE_LOCATION_ID'),
    //     //     'KPNX3NEX3BS18JF52VK7HX4T8R'
    //     // )
    //     //     ->idempotencyKey($idempotencyKey)
    //     //     ->planVariationId($planVariationId)
    //     //     ->cardId('ccof:qy5x8hHGYsgLrp4Q4GB')
    //     //     ->timezone('America/Los_Angeles')
    //     //     ->build();

    //     // $apiResponse = $subscriptionsApi->createSubscription($body);

    //     // if ($apiResponse->isSuccess()) {
    //     //     $createSubscriptionResponse = $apiResponse->getResult();
    //     // } else {
    //     //     $errors = $apiResponse->getErrors();
    //     // }

    //     // // Getting more response information
    //     // var_dump($apiResponse->getStatusCode());
    //     // var_dump($apiResponse->getHeaders());
    // }
}
