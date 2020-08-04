<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;
use Veritrans_Config;
use Veritrans_Snap;
use Veritrans_Notification;
use App\Jobs\ProcessHandlePayment;
use stdClass;
use Illuminate\Support\Collection;
use App\User;

class PaymentController extends Controller
{
    protected $request;

    /**
     * Class constructor.
     *
     * @param \Illuminate\Http\Request $request User Request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        // Set midtrans configuration
        Veritrans_Config::$serverKey = config('services.midtrans.serverKey');
        Veritrans_Config::$isProduction = config('services.midtrans.isProduction');
        Veritrans_Config::$isSanitized = config('services.midtrans.isSanitized');
        Veritrans_Config::$is3ds = config('services.midtrans.is3ds');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getPaymentReport($from,$to){
        // -- Semua pembayaran beserta yang bayar beberapa kali untuk satu aktivasi jadi keitung
        // $results = Payment::with(['user.profile.province','user.profile.city','user.profile.district'])
        // ->where('status','success')
        // ->where('value',35000)
        // ->whereBetween('updated_at',[date($from),date($to)])
        // ->get();
        // -------------------------------------------------------------------------------------

        // -- Hitung yang melakukan aktivasi saja
        $users = User::with(['payments'=>function($query)use($from,$to){
            $query
            ->where('status','success')
            ->where('value',35000)
            ->whereBetween('updated_at',[date($from),date($to)]);
        },'payments.user'])
        ->whereHas('payments',function($query)use($from,$to){
            $query
            ->where('status','success')
            ->where('value',35000)
            ->whereBetween('updated_at',[date($from),date($to)]);
        })
        ->get();
        // --------------------------------------

        $results = collect([]);
        foreach ($users as $u => $user) {
            # code...
            $results->add($user->payments[0]);
        }
        return response()->json($results);
    }

    public function getPaymentReportByProvince($from,$to,$provinceId){
        // $results = Payment::with(['user.profile.province','user.profile.city','user.profile.district'])
        // ->where('status','success')
        // ->where('value',35000)
        // ->whereBetween('updated_at',[date($from),date($to)])
        // ->whereHas('user.profile.province',function($query)use($provinceId){
        //     $query->where('id',$provinceId);
        // })
        // ->get();

        // -- Hitung yang melakukan aktivasi saja
        $users = User::with(['payments'=>function($query)use($from,$to){
            $query
            ->where('status','success')
            ->where('value',35000)
            ->whereBetween('updated_at',[date($from),date($to)]);
        },'payments.user'])
        ->whereHas('payments',function($query)use($from,$to){
            $query
            ->where('status','success')
            ->where('value',35000)
            ->whereBetween('updated_at',[date($from),date($to)]);
        })
        ->whereHas('profile.province',function($query)use($provinceId){
            $query
            ->where('id',$provinceId);
        })
        ->get();
        // --------------------------------------

        $results = collect([]);
        foreach ($users as $u => $user) {
            # code...
            $results->add($user->payments[0]);
        }

        return response()->json($results);
    }

    public function getPaymentReportByCity($from,$to,$cityId){
        // $results = Payment::with(['user.profile.province','user.profile.city','user.profile.district'])
        // ->where('status','success')
        // ->where('value',35000)
        // ->whereBetween('updated_at',[date($from),date($to)])
        // ->whereHas('user.profile.city',function($query)use($cityId){
        //     $query->where('id',$cityId);
        // })
        // ->get();
        // -- Hitung yang melakukan aktivasi saja
        $users = User::with(['payments'=>function($query)use($from,$to){
            $query
            ->where('status','success')
            ->where('value',35000)
            ->whereBetween('updated_at',[date($from),date($to)]);
        },'payments.user'])
        ->whereHas('payments',function($query)use($from,$to){
            $query
            ->where('status','success')
            ->where('value',35000)
            ->whereBetween('updated_at',[date($from),date($to)]);
        })
        ->whereHas('profile.city',function($query)use($cityId){
            $query->where('id',$cityId);
        })
        ->get();
        // --------------------------------------

        $results = collect([]);
        foreach ($users as $u => $user) {
            # code...
            $results->add($user->payments[0]);
        }
        return response()->json($results);
    }

    public function getPaymentReportForArdata(){
        // $payments = Payment::with('user')
        // ->where('status','success')
        // ->where('value',35000)
        // ->get();

        // $results = collect([]);
        // foreach ($payments as $p => $payment) {
        //     # code...
        //     // isi tanggal
        //     $date = date('F Y',strtotime($payment->updated_at));
        //     $object = new stdClass();
        //     $object->date = $date;
        //     $object->total = 0;
        //     $object->toPaid = 0;
        //     $object->toReceive = 0;
        //     $object->rest = 0;
        //     $object->payments = collect([]);
        //     $results->add($object);
        //     $results = $results->unique();
        // }

        // foreach ($payments as $p => $payment) {
        //     # code...
        //     // menjumlahkan yang harus dibayar dan mengisi pembayaran apa saja didalamnya
        //     $date = date('F Y',strtotime($payment->updated_at));
        //     $results->map(function($result)use($date,$payment){
        //         if($result->date == $date){
        //             // -- tambah 20000 jika  pembayarannya 35000, tambah 30000 jika pembayarannya 65000
        //             // $result->toPaid += $payment->value == 35000 ? 20000 : 30000;
        //             // $result->toReceive += $payment->value == 35000 ? 10000 : 30000;
        //             //---------------------------------------------------------------------------------

        //             // -- sementara untuk hanya 35000
        //             $result->toPaid += 20000;
        //             $result->toReceive += 10000;
        //             $result->rest += 5000;
        //             //--------------------------------
        //             $result->total += $payment->value;
        //             $result->payments->add($payment);
        //             return $result;
        //         }
        //     });
        // }

        // -- Hitung yang melakukan aktivasi saja
        $users = User::with(['payments'=>function($query){
            $query
            ->where('status','success')
            ->where('value',35000);
        },'payments.user'])
        ->whereHas('payments',function($query){
            $query
            ->where('status','success')
            ->where('value',35000);
        })
        ->get();
        // --------------------------------------

        $results = collect([]);
        foreach ($users as $u => $user) {
            # code...
            // isi tanggal
            $date = date('F Y',strtotime($user->payments[0]->updated_at));
            $object = new stdClass();
            $object->date = $date;
            $object->total = 0;
            $object->toPaid = 0;
            $object->toReceive = 0;
            $object->rest = 0;
            $object->payments = collect([]);
            $results->add($object);
            $results = $results->unique();
        }

        foreach ($users as $u => $user) {
            # code...
            // menjumlahkan yang harus dibayar dan mengisi pembayaran apa saja didalamnya
            $date = date('F Y',strtotime($user->payments[0]->updated_at));
            $results->map(function($result)use($date,$user){
                if($result->date == $date){
                    // -- tambah 20000 jika  pembayarannya 35000, tambah 30000 jika pembayarannya 65000
                    // $result->toPaid += $payment->value == 35000 ? 20000 : 30000;
                    // $result->toReceive += $payment->value == 35000 ? 10000 : 30000;
                    //---------------------------------------------------------------------------------

                    // -- sementara untuk hanya 35000
                    $result->toPaid += 20000;
                    $result->toReceive += 10000;
                    $result->rest += 5000;
                    //--------------------------------
                    $result->total += $user->payments[0]->value;
                    $result->payments->add($user->payments[0]);
                    return $result;
                }
            });
        }

        return response()->json($results);
    }

    public function getPaymentReportForDpp(){
        // $payments = Payment::with('user')
        // ->where('status','success')
        // ->where('value',35000)
        // ->get();

        // -- Hitung yang melakukan aktivasi saja
        $users = User::with(['payments'=>function($query){
            $query
            ->where('status','success')
            ->where('value',35000);
        },'payments.user'])
        ->whereHas('payments',function($query){
            $query
            ->where('status','success')
            ->where('value',35000);
        })
        ->get();
        // --------------------------------------

        $results = collect([]);
        foreach ($users as $u => $user) {
            # code...
            // isi tanggal
            $date = date('F Y',strtotime($user->payments[0]->updated_at));
            $object = new stdClass();
            $object->date = $date;
            $object->toPaid = 0;
            $object->payments = collect([]);
            $results->add($object);
            $results = $results->unique();
        }

        foreach ($users as $u => $user) {
            # code...
            // menjumlahkan yang harus dibayar dan mengisi pembayaran apa saja didalamnya
            $date = date('F Y',strtotime($user->payments[0]->updated_at));
            $results->map(function($result)use($date,$user){
                if($result->date == $date){
                    // -- tambah 20000 jika  pembayarannya 35000, tambah 30000 jika pembayarannya 65000
                    // $result->toPaid += $payment->value == 35000 ? 4000 : 8000;
                    //---------------------------------------------------------------------------------

                    // -- sementara untuk hanya 35000
                    $result->toPaid += 4000;
                    //-------------------------------
                    $result->payments->add($user->payments[0]);
                    return $result;
                }
            });
        }

        return response()->json($results);
    }

    public function getPaymentReportForProvince($provinceId){
        // $payments = Payment::with('user')
        // ->where('status','success')
        // ->where('value',35000)
        // ->whereHas('user.profile.province',function($query)use($provinceId){
        //     $query->where('id',$provinceId);
        // })
        // ->get();

        // $results = collect([]);
        // foreach ($payments as $p => $payment) {
        //     # code...
        //     // isi tanggal
        //     $date = date('F Y',strtotime($payment->updated_at));
        //     $object = new stdClass();
        //     $object->date = $date;
        //     $object->toPaid = 0;
        //     $object->payments = collect([]);
        //     $results->add($object);
        //     $results = $results->unique();
        // }

        // foreach ($payments as $p => $payment) {
        //     # code...
        //     // menjumlahkan yang harus dibayar dan mengisi pembayaran apa saja didalamnya
        //     $date = date('F Y',strtotime($payment->updated_at));
        //     $results->map(function($result)use($date,$payment){
        //         if($result->date == $date){
        //             // -- tambah 20000 jika  pembayarannya 35000, tambah 30000 jika pembayarannya 65000
        //             // $result->toPaid += $payment->value == 35000 ? 4000 : 8000;
        //             //---------------------------------------------------------------------------------

        //             // -- sementara untuk hanya 35000
        //             $result->toPaid += 6000;
        //             //-------------------------------
        //             $result->payments->add($payment);
        //             return $result;
        //         }
        //     });
        // }

        // -- Hitung yang melakukan aktivasi saja
        $users = User::with(['payments'=>function($query){
            $query
            ->where('status','success')
            ->where('value',35000);
        },'payments.user'])
        ->whereHas('payments',function($query){
            $query
            ->where('status','success')
            ->where('value',35000);
        })
        ->whereHas('profile.province',function($query)use($provinceId){
            $query->where('id',$provinceId);
        })
        ->get();
        // --------------------------------------

        $results = collect([]);
        foreach ($users as $u => $user) {
            # code...
            // isi tanggal
            $date = date('F Y',strtotime($user->payments[0]->updated_at));
            $object = new stdClass();
            $object->date = $date;
            $object->toPaid = 0;
            $object->payments = collect([]);
            $results->add($object);
            $results = $results->unique();
        }

        foreach ($users as $u => $user) {
            # code...
            // menjumlahkan yang harus dibayar dan mengisi pembayaran apa saja didalamnya
            $date = date('F Y',strtotime($user->payments[0]->updated_at));
            $results->map(function($result)use($date,$user){
                if($result->date == $date){
                    // -- tambah 20000 jika  pembayarannya 35000, tambah 30000 jika pembayarannya 65000
                    // $result->toPaid += $payment->value == 35000 ? 4000 : 8000;
                    //---------------------------------------------------------------------------------

                    // -- sementara untuk hanya 35000
                    $result->toPaid += 6000;
                    //-------------------------------
                    $result->payments->add($user->payments[0]);
                    return $result;
                }
            });
        }

        return response()->json($results);
    }

    public function getPaymentReportForCity($cityId){
        // $payments = Payment::with('user')
        // ->where('status','success')
        // ->where('value',35000)
        // ->whereHas('user.profile.city',function($query)use($cityId){
        //     $query->where('id',$cityId);
        // })
        // ->get();

        // -- Hitung yang melakukan aktivasi saja
        $users = User::with(['payments'=>function($query){
            $query
            ->where('status','success')
            ->where('value',35000);
        },'payments.user'])
        ->whereHas('payments',function($query){
            $query
            ->where('status','success')
            ->where('value',35000);
        })
        ->whereHas('profile.city',function($query)use($cityId){
            $query->where('id',$cityId);
        })
        ->get();
        // --------------------------------------

        $results = collect([]);
        foreach ($users as $u => $user) {
            # code...
            // isi tanggal
            $date = date('F Y',strtotime($user->payments[0]->updated_at));
            $object = new stdClass();
            $object->date = $date;
            $object->toPaid = 0;
            $object->payments = collect([]);
            $results->add($object);
            $results = $results->unique();
        }

        foreach ($users as $u => $user) {
            # code...
            // menjumlahkan yang harus dibayar dan mengisi pembayaran apa saja didalamnya
            $date = date('F Y',strtotime($user->payments[0]->updated_at));
            $results->map(function($result)use($date,$user){
                if($result->date == $date){
                    // -- tambah 20000 jika  pembayarannya 35000, tambah 30000 jika pembayarannya 65000
                    // $result->toPaid += $payment->value == 35000 ? 4000 : 8000;
                    //---------------------------------------------------------------------------------

                    // -- sementara untuk hanya 35000
                    $result->toPaid += 10000;
                    //-------------------------------
                    $result->payments->add($user->payments[0]);
                    return $result;
                }
            });
        }

        return response()->json($results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (strtotime($request->user()->created_at) < strtotime('-6 months')) {
        //     // jika umur akunnya lebih dari 6 bulan akan dikenakan biaya perpanjangan
        //     $payment_value = setting('admin.extend_member_period');
        //     $payment_text = "Pembayaran Iuran Anggota Selama 6 Bulan";
        // } else {
        //     // bula kurang dari 6 bulan akan dikenakan biaya daftar baru
        //     $payment_value = setting('admin.member_price');
        //     $payment_text = "Pembayaran Member KTA";
        // }

        if($request->user()->user_activated_at == null){
            $payment_value = setting('admin.member_price');
            $payment_text = "Pembayaran Member KTA";
        } else{
            $payment_value = setting('admin.extend_member_period');
            $payment_text = "Pembayaran Iuran Anggota Selama 6 Bulan";
        }

        $data = new Payment(['value' => $payment_value]);
        $uniqueId = 1;
        try {
            $payment = $request->user()->payment()->save($data);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                while (Payment::where('id', $uniqueId)->exists()) {
                    $uniqueId++;
                }
                $newdata = new Payment(['id' => $uniqueId, 'value' => $payment_value]);
                $payment = $request->user()->payment()->save($newdata);
            }
        }
        $data->id = $payment->id;
        $data->update();

        $payload = [
            'transaction_details' => [
                'order_id'      => $data->id,
                'gross_amount'  => $payment->value,
            ],
            'customer_details' => [
                'first_name'    => $request->user()->name,
                'email'         => $request->user()->email
            ],
            'item_details' => [
                [
                    'id'       => $payment->id,
                    'price'    => $payment->value,
                    'quantity' => 1,
                    'name'     => ucwords(str_replace('_', ' ', $payment_text))
                ]
            ]
        ];

        do {
            try {
                $tryAgain = false;
                $snapToken = Veritrans_Snap::getSnapToken($payload);
                // $paymentUrl = Veritrans_Snap::createTransaction($payload)->redirect_url;
            } catch (\Exception $e) {
                $tryAgain = true;
                // dd($e->getCode());
                if ($e->getCode() == '400') {
                    $uniqueId++;
                    $data->id = $uniqueId;
                    $data->update();
                    $payload['transaction_details']['order_id'] = $data->id;
                    $snapToken = Veritrans_Snap::getSnapToken($payload);
                    // $paymentUrl = Veritrans_Snap::createTransaction($payload)->redirect_url;
                } else{
                    break;
                }
            }
        } while ($tryAgain);

        $payment->snap_token = $snapToken;
        $payment->update();

        // Beri response snap token
        $this->response['snap_token'] = $snapToken;
        // $this->response['payment_url'] = $paymentUrl;

        return response()->json($this->response);
    }

    public function paymentUrl(Request $request)
    {
        if($request->user()->user_activated_at == null){
            $payment_value = setting('admin.member_price');
            $payment_text = "Pembayaran Member KTA";
        } else{
            $payment_value = setting('admin.extend_member_period');
            $payment_text = "Pembayaran Iuran Anggota Selama 6 Bulan";
        }

        $data = new Payment(['value' => $payment_value]);
        $uniqueId = 1;
        try {
            $payment = $request->user()->payment()->save($data);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                while (Payment::where('id', $uniqueId)->exists()) {
                    $uniqueId++;
                }
                $newdata = new Payment(['id' => $uniqueId, 'value' => $payment_value]);
                $payment = $request->user()->payment()->save($newdata);
            }
        }
        $data->id = $payment->id;
        $data->update();

        $payload = [
            'transaction_details' => [
                'order_id'      => $data->id,
                'gross_amount'  => $payment->value,
            ],
            'customer_details' => [
                'first_name'    => $request->user()->name,
                'email'         => $request->user()->email
            ],
        ];
        // dd(Veritrans_Snap::createTransaction($payload)->redirect_url);
        do {
            try {
                $tryAgain = false;
                $paymentUrl = Veritrans_Snap::createTransaction($payload)->redirect_url;
            } catch (\Exception $e) {
                $tryAgain = true;
                // dd($e->getCode());
                if ($e->getCode() == '400') {
                    $uniqueId++;
                    $data->id = $uniqueId;
                    $data->update();
                    $payload['transaction_details']['order_id'] = $data->id;
                    $paymentUrl = Veritrans_Snap::createTransaction($payload)->redirect_url;
                }else {
                    break;
                }
            }
        } while ($tryAgain);

        $payment->update();

        $this->response['payment_url'] = $paymentUrl;

        return response()->json($this->response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function test($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->setSuccess();

        return response()->json($payment);
    }

    public function notificationHandler(Request $request)
    {
        $notif = new Veritrans_Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;
        $payment = Payment::findOrFail($orderId);

        if ($transaction == 'capture') {

            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {

                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    // $payment->addUpdate("Transaction order_id: " . $orderId ." is challenged by FDS");
                    $payment->setPending();
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    // $payment->addUpdate("Transaction order_id: " . $orderId ." successfully captured using " . $type);
                    $payment->setSuccess();
                }
            }
        } elseif ($transaction == 'settlement') {

            // TODO set payment status in merchant's database to 'Settlement'
            // $payment->addUpdate("Transaction order_id: " . $orderId ." successfully transfered using " . $type);
            $payment->setSuccess();
        } elseif ($transaction == 'pending') {

            // TODO set payment status in merchant's database to 'Pending'
            // $payment->addUpdate("Waiting customer to finish transaction order_id: " . $orderId . " using " . $type);
            $payment->setPending();
        } elseif ($transaction == 'deny') {

            // TODO set payment status in merchant's database to 'Failed'
            // $payment->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is Failed.");
            $payment->setFailed();
        } elseif ($transaction == 'expire') {

            // TODO set payment status in merchant's database to 'expire'
            // $payment->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is expired.");
            $payment->setExpired();
        } elseif ($transaction == 'cancel') {

            // TODO set payment status in merchant's database to 'Failed'
            // $payment->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is canceled.");
            $payment->setFailed();
        }
        return;
    }

    public function notificationQueueHandler(Request $request){
        ProcessHandlePayment::dispatch();
        return;
    }
}
