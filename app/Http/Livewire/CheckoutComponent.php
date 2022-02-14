<?php

namespace App\Http\Livewire;

use App\Mail\orderMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Cart;
use Stripe;
class CheckoutComponent extends Component
{
    public $shipp_to_different;

    public $firstname;
    public $lastname;
    public $email;
    public $mobile;
    public $line1;
    public $line2;
    public $city;
    public $country;
    public $address;
    public $zipcode;
    public $province;

    public $s_firstname;
    public $s_lastname;
    public $s_email;
    public $s_mobile;
    public $s_line1;
    public $s_line2;
    public $s_city;
    public $s_country;
    public $s_address;
    public $s_zipcode;
    public $s_province;

    public $paymentmode;
    public $thankyou;

    public $card_no;
    public $exp_month;
    public $exp_year;
    public $cvc;

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'required | email',
            'mobile'=>'required | numeric',
            'line1'=>'required',
            'city'=>'required',
            'country'=>'required',
            'address' =>'required',
            'zipcode'=>'required',
            'province'=>'required',
            'paymentmode' => 'required',

        ]);

        if($this->shipp_to_different) {
            $this->validateOnly($fields,[
                's_firstname' => 'required',
                's_lastname' => 'required',
                's_email' => 'required | email',
                's_mobile' => 'required | numeric',
                's_line1' => 'required',
                's_city' => 'required',
                's_country' => 'required',
                's_address' =>'required',
                's_zipcode' => 'required',
                's_province' => 'required',
            ]);
        }

        if ($this->paymentmode == 'card')
        {
            $this->validateOnly($fields,[
                'card_no' => 'required | numeric',
                'exp_month' => 'required | numeric',
                'exp_year' => 'required | numeric',
                'cvc' => 'required | numeric',
            ]);
        }
    }

    public function placeOrder()
    {
        $this->validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'required | email',
            'mobile'=>'required | numeric',
            'line1'=>'required',
            'city'=>'required',
            'country'=>'required',
            'address' =>'required',
            'zipcode'=>'required',
            'province'=>'required',
            'paymentmode' => 'required',
        ]);

        if ($this->paymentmode == 'card')
        {
            $this->validate([
                'card_no' => 'required | numeric',
                'exp_month' => 'required | numeric',
                'exp_year' => 'required | numeric',
                'cvc' => 'required | numeric',
            ]);
        }

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->subtotal = session()->get('checkout')['subtotal'];
        $order->discount = session()->get('checkout')['discount'];
        $order->tax = session()->get('checkout')['tax'];
        $order->total = session()->get('checkout')['total'];

        $order->firstname = $this->firstname;
        $order->lastname =  $this->lastname;
        $order->email = $this->email;
        $order->mobile = $this->mobile;
        $order->line1 = $this->line1;
        $order->line2 = $this->line2;
        $order->city = $this->city;
        $order->country = $this->country;
        $order->zipcode = $this->zipcode;
        $order->province = $this->province;
        $order->status = 'ordered';
        $order->is_shipping_different = $this->shipp_to_different ? 1 : 0;

        $order->Save();

        foreach (Cart::instance('cart')->content() as $item)
        {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;

            $orderItem->save();
        }

        if($this->shipp_to_different)
        {
            $this->validate([
                's_firstname'=>'required',
                's_lastname'=>'required',
                's_email'=>'required | email',
                's_mobile'=>'required | numeric',
                's_line1'=>'required',
                's_city'=>'required',
                's_country'=>'required',
                's_address'=>'required',
                's_zipcode'=>'required',
                's_province'=>'required',
            ]);

            $shpping = new Shipping();
            $shpping->order_id = $order->id;
            $shpping->firstname = $this->s_firstname;
            $shpping->lastname =  $this->s_lastname;
            $shpping->email = $this->s_email;
            $shpping->mobile = $this->s_mobile;
            $shpping->line1 = $this->s_line1;
            $shpping->line2 = $this->s_line2;
            $shpping->city = $this->s_city;
            $shpping->country = $this->s_country;
            $shpping->zipcode = $this->s_zipcode;
            $shpping->province = $this->s_province;

            $shpping->save();
        }

        if($this->paymentmode == 'cod')
        {
            $this->makeTransaction($order->id , 'pending');
            $this->resetCart();
        }
        elseif ($this->paymentmode == 'card')
        {
            $stripe = Stripe::make(env('STRIPE_KEY'));
            try{
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number' => $this->card_no ,
                        'exp_month' => $this->exp_month ,
                        'exp_year' => $this->exp_year ,
                        'cvc' => $this->cvc
                    ]
                ]);

                if(!isset($token['id']))
                {
                    session()->flash('stripe_error' , 'The Stripe Token Was Not Generated Correctly');
                    $this->thankyou = 0;
                }

                $customer = $stripe->customers()->create([
                   'name' => $this->firstname.' '.$this->lastname ,
                    'email' => $this->email ,
                    'phone' => $this->mobile ,
                    'address' => [
                        'line1' => $this->line1 ,
                        'postal_code' => $this->zipcode ,
                        'city' => $this->city ,
                        'state' => $this->province ,
                        'country' => $this->country ,
                    ] ,
                    'shipping' => [
                        'name' => $this->firstname.' '.$this->lastname ,
                        'address' => [
                            'line1' => $this->line1 ,
                            'postal_code' => $this->zipcode ,
                            'city' => $this->city ,
                            'state' => $this->province ,
                            'country' => $this->country ,
                        ] ,
                    ] ,
                    'source' => $token['id']
                ]);

                $charge = $stripe->charges()->create([
                    'customer' => $customer['id'] ,
                    'currency' => 'USD' ,
                    'amount' => session()->get('checkout')['total'],
                    'description' => 'payment for order no '.$order->id
                ]);

                if ($charge['status'] == 'succeeded')
                {
                    $this->makeTransaction($order->id , 'approved');
                    $this->resetCart();
                }
                else
                {
                    session()->flash('stripe_error' , 'Error In Transaction');
                    $this->thankyou = 0;
                }
            }catch (\Exception $e){
                session()->flash('stripe_error' , $e->getMessage());
                $this->thankyou = 0;
            }

        }
        $this->sendOrderConfirmationMail($order);


    }

    public function resetCart()
    {
        $this->thankyou = 1;
        Cart::instance('cart')->destroy();
        session()->forget('checkout');
    }

    public function makeTransaction($order_id , $status)
    {
        $transaction = new Transaction();

        $transaction->user_id = Auth::user()->id;
        $transaction->order_id =$order_id;
        $transaction->mode = $this->paymentmode;
        $transaction->status = $status;

        $transaction->save();

    }

    public function sendOrderConfirmationMail($order)
    {
        Mail::to($order->email)->send(new orderMail($order));

    }

    public function verifyForCheckout()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }
        elseif($this->thankyou)
        {
            return redirect()->route('thankyou');
        }
        elseif(!session()->get('checkout'))
        {
            return redirect()->route('product.cart');
        }
    }


    public function render()
    {
        $this->verifyForCheckout();
        return view('livewire.checkout-component')->layout('layouts.base');
    }
}
