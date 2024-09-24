@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
<h1 class="page-title">
    <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }} &nbsp;

    <!--@can('edit', $dataTypeContent)-->
    <!--<a href="{{ route('voyager.'.$dataType->slug.'.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">transaction_data -->
    <!--    <i class="glyphicon glyphicon-pencil"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.edit') }}</span>-->
    <!--</a>-->
    <!--@endcan-->
    @can('delete', $dataTypeContent)
    <!--@if($isSoftDeleted)-->
    <!--<a href="{{ route('voyager.'.$dataType->slug.'.restore', $dataTypeContent->getKey()) }}" title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore" data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">-->
    <!--    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>-->
    <!--</a>-->
    <!--@else-->
    <!--<a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete" data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">-->
    <!--    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>-->
    <!--</a>-->
    <!--@endif-->
    @endcan
    @can('browse', $dataTypeContent)
    <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
        <i class="glyphicon glyphicon-list"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.return_to_list') }}</span>
    </a>
    @endcan
</h1>
@include('voyager::multilingual.language-selector')
@stop

@section('content')

@php
                $transaction_data = DB::table('order_payments')->where('order_no',$dataTypeContent->order_no)->first();

                $payObj = $transaction_data == null ? '' : json_decode(json_decode($transaction_data->payment_obj,true),true);
   
                @endphp
                

<div class="page-content read container-fluid">
    <div class="row">
        <div class="col-md-9">


            <div class="panel panel-primary panel-bordered">

                <style>
                    .cus_label {
                        font-size: 14px;
                    }

                    .general-detail {
                        list-style: none;
                        padding: 0px;
                    }

                    .general-detail li {
                        margin-bottom: 15px;
                    }

                    .contact-d {
                        font-size: 14px;
                        margin-bottom: 0px;
                    }

                    .shipping-detail {
                        list-style: none;
                        padding: 0px;
                    }

                    .shipping-detail li {
                        margin-bottom: 15px;
                    }

                    .shipping-detail li p {
                        margin: 0px;
                    }

                    .me-4 {
                        margin-right: 1rem !important;
                    }

                    .text-reset {
                        --bs-text-opacity: 1;
                        color: inherit !important;
                    }

                    .sa-table {
                        width: 100%;
                        font-size: 80%;
                    }

                    .sa-table tbody tr>* {
                        border-top: 1px solid #2125291a;
                    }

                    .text-end {
                        text-align: right !important;
                    }




                    [dir=ltr] .sa-table td:first-child,
                    [dir=ltr] .sa-table th:first-child {
                        padding-left: 1.5rem;
                    }

                    .sa-table tbody tr>* {
                        border-top: 1px solid #2125291a;
                    }

                    .sa-table td,
                    .sa-table th {
                        padding: .75rem .5rem;
                    }



                    .sa-table td,
                    .sa-table th {
                        padding: .75rem .5rem;
                    }

                    .fs-exact-13 {
                        font-size: 0.8125rem !important;
                    }

                    .text-muted {
                        --bs-text-opacity: 1;
                        color: #6c757d !important;
                    }


                    .sa-table td,
                    .sa-table th {
                        padding: .75rem .5rem;
                    }
                    
                    .text-warning-fg {
}
.bg-warning {
    --bb-bg-opacity: 1;
    background-color:rgb(255 110 14)  !important;
}

.gap-1 {
    gap: 0.25rem !important;
}

.d-flex {
    display: flex !important;
}

.badge {
align-items: center;
    justify-content: center;
    letter-spacing: .04em;
    min-width: 1.35714285em;
    overflow: hidden;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    vertical-align: bottom;
    height: fit-content;
    align-self: center;
    padding:6px 12px 6px 12px;
}

.bg-info {
    background-color: rgb(58 149 223) !important;
}

.bg-success {
    background-color: #4CAF50 !important;
}


                </style>
                <div class="panel-body">
                    <div style="display:flex;  justify-content: space-between; width: 100%; ">
                        
                  
                    <div>   
                    <h4 style="color:black; margin-bottom:2px;">Order information  #{{$dataTypeContent->order_no}} 
                        </h4>
                            <p style="color:black; margin:0px">{{ $transaction_data == null ? 'No Payment Made' : " Payment via  pay with your card using " . $transaction_data->payment_method}}. </p>
                    </div>
                    @if($dataTypeContent->status == 'Completed')
                    <span class="badge  bg-info text-warning-fg d-flex align-items-center gap-1">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                          <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                          <path d="M17 17h-11v-14h-2"></path>
                          <path d="M6 5l14 1l-1 7h-13"></path>
                        </svg> Completed</span>
                    @else
                    <span class="badge bg-warningtext-info-fg d-flex align-items-center gap-1">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                          <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                          <path d="M17 17h-11v-14h-2"></path>
                          <path d="M6 5l14 1l-1 7h-13"></path>
                        </svg> Uncompleted </span>
                    @endif
                    
                    


                </div>
  </div>
                <div class="panel-body">
 
                    <input type="hidden" name="order_no" id="orderID" value="{{$dataTypeContent->order_no}}">
                  

                    <form class="row" style="">

                        <div class="col-md-4">
                            <p> <b> General </b></p>

                            <ul class="general-detail">

                                <li>
                                    <label class="cus_label" for="date">Date created:</label>
                                    <input class="form-control" type="text" id="date" name="date" value="{{$dataTypeContent->created_at}}">
                                </li>
                                <li>
                                    <label class="cus_label" for="Status">Status:</label>
                                    <select class="form-control" id="order_status_Data" name="order_status_Data">

                                    </select>
                                </li>

                            </ul>

                        </div>
                        @php $shippingData = DB::table('order_shippings')->where('order_no',$dataTypeContent->order_no)->first(); @endphp
                        <div class="col-md-4">
                            <div style="display:flex; justify-content: space-between;">
                                <p> <b> Shipping </b></p>
                                <a href="#">Edit</a>
                            </div>

                            <ul class="shipping-detail">

                                <li>
                                    <p>{{$shippingData->first_name}} {{$shippingData->last_name}}</p>
                                    <p>{{$shippingData->company_name}} </p>
                                    <p>{{$shippingData->address}} </p>
                                    <p>{{$shippingData->city}} </p>
                                    <p>{{$shippingData->state}} {{$shippingData->country}} {{$shippingData->postal_code}} </p>
                                </li>
                            </ul>

                            <p> <b> Email Address </b></p>
                            <p class="contact-d" for="date"> <a href="mailto:{{$shippingData->email}}">{{$shippingData->email}}</a> </p>

                            <p style="margin-top: 10px;"> <b> Phone Address </b></p>
                            <p style="margin: 0px;" class="contact-d" for="date">{{$shippingData->phone}}</p>


                        </div>


                        @php $billingData = DB::table('order_billings')->where('order_no',$dataTypeContent->order_no)->first(); @endphp
                        <div class="col-md-4">
                            <div style="display:flex; justify-content: space-between;">
                                <p> <b> Billing </b></p>
                                <a href="#">Edit</a>
                            </div>

                            <ul class="shipping-detail">

                                <li>
                                    <p>{{$billingData->first_name}} {{$billingData->last_name}} </p>
                                    <p>{{$billingData->company_name}} </p>
                                    <p>{{$billingData->address}} </p>
                                    <p>{{$billingData->city}} </p>
                                    <p>{{$billingData->state}} {{$billingData->country}} {{$billingData->postal_code}} /
                                    <p>
                                </li>
                            </ul>

                            <p> <b> Email Address </b></p>
                            <p class="contact-d" for="date"> <a href="mailto:{{$billingData->email}}">{{$billingData->email}}</a> </p>
  <input type="hidden" name="EmailID" id="EmailID" value="{{$billingData->email}}">
                            <p style="margin-top: 10px;"> <b> Phone Address </b></p>
                            <p style="margin: 0px;" class="contact-d" for="date">{{$billingData->phone}}</p>



                        </div>

                        <div class="col-md-12">
                            <label class="cus_label" for="ordernote">Customer provided note:</label>

                            <textarea class="form-control" name="ordernote" id="ordernote" cols="30" rows="5"> {{$billingData->order_note}}</textarea>
                        </div>
                    </form>

                </div>
            </div>
            <div class="panel panel-primary panel-bordered">



                <div class="panel-body">

                    <h4 style="color:black">Items<h4>

                            @php
                            $products = json_decode($dataTypeContent->product, true);
                           
                            $total_subTotal = [];
                            @endphp
                            <table class="sa-table ">

                                <tbody>
                                    @foreach($products as $key => $product)
                                    @php

                                    $productsubTotal = $product['regular_price'] * $product['quantity'];

                                    $productsubTotal = number_format((float)$productsubTotal, 2, '.', '');
                                    $images = $product['images'];

                                    $total_subTotal[$key] = $productsubTotal;

                                    @endphp
                                    <tr>
                                        <td class="min-w-20x">
                                            <div style="align-items: center; display: flex">
                                                <img src="{{$images}}" class="me-4" width="40" height="40" alt="">
                                                <a href="/admin/products/{{$product['id']}}" target="new" class="text-reset">{{$product['name']}} {{$product['SKU']}}</a>
                                            </div>
                                            
                                            <div style="margin-top:10px">
                                            <h5>@if(isset($product['addOnsPrice']) && $product['addOnsPrice'] > 0 || isset($product['addOns3dPrice']) && $product['addOns3dPrice'] > 0)
   
       
         @if(isset($product['addOnsPrice']) && $product['addOnsPrice'] > 0)
            <span>Add-Ons Price: ${{ number_format($product['addOnsPrice'], 2) }}</span>
        @endif
        
        @if(isset($product['addOns3dPrice']) && $product['addOns3dPrice'] > 0)
            <span> 3D Add-Ons Price: ${{ number_format($product['addOns3dPrice'], 2) }}</span>
        @endif

@endif</h5>
                                           <ul style="font-size:12px">
    @if(isset($product['color']) && isset($product['color']['name']))
        <li><span>{{ $product['color']['name'] }} : $${{ number_format($product['color']['price'], 2) }}</span></li>
    @endif
    @if(isset($product['premiumColor']) && isset($product['premiumColor']['name']))
        <li><span>{{ $product['premiumColor']['name'] }} : $${{ number_format($product['premiumColor']['price'], 2) }}</span></li>
    @endif
    @if(isset($product['size']) && isset($product['size']['price']))
        <li><span>Size : $${{ number_format($product['size']['price'], 2) }}</span></li>
    @endif
    @if(isset($product['seater']) && isset($product['seater']['name']))
        <li><span>{{ $product['seater']['name'] }} : $${{ number_format($product['seater']['price'], 2) }}</span></li>
    @endif
    @if(isset($product['fabric']) && isset($product['fabric']['name']))
        <li><span>{{ $product['fabric']['name'] }} : $${{ number_format($product['fabric']['price'], 2) }}</span></li>
    @endif
    @if(isset($product['warrenty']))
        <li><span>{{ isset($product['warrenty']['name']) ? $product['warrenty']['name'] : 'Warrenty' }} : $${{ number_format($product['warrenty']['price'], 2) }}</span></li>
    @endif
</ul>


                                            </div>
                                        </td>
                                        <td class="text-end">${{number_format((float)$product['regular_price'], 2, '.', '')}} </td>
                                        <td class="text-end">x{{$product['quantity']}}</td>
                                        <td class="text-end">${{ $productsubTotal}}</td>
                                    </tr>
                                    @endforeach



                                </tbody>


                                <tbody class="sa-table__group">
                                    <tr>
                                        <td colspan="3">Subtotal</td>
                                        <td class="text-end">

                                            @php $total_subTotalRaw = array_sum($total_subTotal);

                                            $total_subTotal = number_format((float)$total_subTotalRaw, 2, '.', '');
                                            $shippingRates = 0;

                                            $finalTotal = $total_subTotalRaw + $shippingRates;

                                            @endphp

                                            ${{$total_subTotal}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3">
                                            Shipping
                                            <div class="text-muted fs-exact-13">via {{ ucfirst($dataTypeContent->shipping_method)}}</div>
                                        </td>
                                        <td class="text-end">
                                            <div class="sa-price"> {{number_format((float)$shippingRates, 2, '.', '')}} </div>
                                        </td>
                                    </tr>
                                </tbody>


                                <tbody>
                                    <tr>
                                        <td colspan="3">Total</td>
                                        <td class="text-end">
                                            <div class="sa-price"><span class="sa-price__symbol">$</span><span class="sa-price__integer">{{$finalTotal}}</span><span class="sa-price__decimal">.00</span></div>
                                        </td>
                                    </tr>
                                </tbody>


                            </table>
                </div>
            </div>

            <div class="panel panel-primary panel-bordered">


                <Style>
                    .transaction-detail {
                        list-style: none;
                        padding: 0px;
                        margin-top: 20px;
                    }

                    .transaction-detail li {
                        display: flex;
                        justify-content: space-between;
                        font-size: 100%;
                        margin-bottom: 5px;
                    }
                </Style>
                 
                 
                <div class="panel-body">


<div style="display:flex;  justify-content: space-between; width: 100%; ">
                        
                  
                    <div>   
                   <h4 style="color:black">Transaction #{{ $transaction_data == null ? '' : $payObj['id']}} </h4>
                    </div>
                    
                    @if($transaction_data == null)
                    <span class="badge bg-warning text-warning-fg d-flex align-items-center gap-1">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                          <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                          <path d="M17 17h-11v-14h-2"></path>
                          <path d="M6 5l14 1l-1 7h-13"></path>
                        </svg> Unpaid</span>
                    @else
                    <span class="badge bg-success text-info-fg d-flex align-items-center gap-1">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                          <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                          <path d="M17 17h-11v-14h-2"></path>
                          <path d="M6 5l14 1l-1 7h-13"></path>
                        </svg> Paid </span>
                    @endif
                    

                </div>


                  @if($transaction_data != null)
                               
                            <ul class="transaction-detail">
                               
                                <li>
                                    <span>Method</span>
                                      <span> {{ $transaction_data == null ? '' : $transaction_data->payment_method}} </span>
                                </li>
                                
                                 @if($transaction_data != null &&  $transaction_data->payment_method != "Afterpay")
                                <li>
                                    
                                    <span>Payment Email</span>
                                    <span> {{ $transaction_data == null ? '' : $payObj['billing_details']['name']}} </span>
                                </li>
                                <li>
                                    
                                    <span>ID</span>
                                    <span> {{ $transaction_data == null ? '' : $payObj['id']}} </span>
                                </li>
                                <li>
                                    <span>Amount</span>
                                    <span> ${{$transaction_data == null ? '' : number_format((float)$payObj['amount'], 2, '.', '')}} </span>
                                </li>
                                  @endif
                                  
                                  @if($transaction_data != null && $transaction_data->payment_method == "Afterpay")
                                <li>
                                    
                                    <span>Consumer Email</span>
                                    <span> {{ $transaction_data == null ? '' : $payObj['orderDetails']['consumer']['email']}} </span>
                                </li>
                                <li>
                                    
                                    <span>ID</span>
                                    <span> {{ $transaction_data == null ? '' : $payObj['id']}} </span>
                                </li>
                                <li>
                                    <span>Amount</span>
                                    <span> ${{$transaction_data == null ? '' : number_format((float)$payObj['originalAmount']['amount'], 2, '.', '')}} </span>
                                </li>
                                  @endif
                                <li>
                                    <span> Status</span>
                                    <span> {{ $transaction_data == null ? '' : $payObj['status']}} </span>
                                </li>
                                
                              
                            </ul>
                            @else
                            <p style="text-align:center">No Transaction Data<p>
                            @endif

                </div>
            </div>


        </div>
        <div class="col-md-3">


            <div class="panel ">

                <div class="panel-heading">
                    <h5 style="color:black ;font-size: 16px;" class="panel-title ">Action </h5>

                </div>

                <div class="panel-body">

                    <!-- <button class="btn btn-danger " style="margin: 0px;"> Delete </button> -->
                    <button class="btn btn-primary " id="update-order" style="margin: 0px; width:100%"> Update </button>

                </div><!-- .panel-body -->
            </div>
           

            <div class="panel ">

                <div class="panel-heading">
                    <h5 style="color:black ;font-size: 16px;" class="panel-title ">Invoice</h5>
                    <!--<div class="panel-actions">-->
                    <!--    Edit-->
                    <!--</div>-->
                </div>

                <div class="panel-body">

                    <!--<ul class="general-detail">-->
                    <!--    <li>-->
                    <!--        <p class="contact-d" for="date">Asher Anjum</p>-->
                    <!--        <p class="contact-d" for="date"> <a href="mailto:asheranjum50@gmail.com">asheranjum50@gmail.com</a> </p>-->
                    <!--        <p class="contact-d" for="date">+92 123 1234567</p>-->
                    <!--    </li>-->


                    <!--</ul>-->
                    
                <div class="my-3" style="">
                    {{-- <a class="btn btn-primary " type="button" href="#" target="_blank" style="width:100%">
                        <svg style="width: 20px;height: 20px; vertical-align: text-bottom;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path>
                          <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                          <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path>
                        </svg>   Print invoice </a> --}}
                    <a class="btn btn-primary"  href="/api/v1/order-invoice/{{$dataTypeContent->order_no}}" target="_blank" style="width:100%">
                        <i class="voyager-download"><i></i></i> Download invoice </a>
                </div>

                </div>
            </div>

            <div class="panel ">

                <div class="panel-heading">
                    <h5 style="color:black ;font-size: 16px;" class="panel-title ">Customer</h5>
                    <div class="panel-actions">
                        Edit
                    </div>
                </div>

                <div class="panel-body">

                    <ul class="general-detail">
                        <li>
                            <p class="contact-d" for="date">{{$shippingData->first_name}} {{$shippingData->last_name}}</p>
                            <p class="contact-d" for="date"> <a href="mailto:asheranjum50@gmail.com">{{$shippingData->email}}</a> </p>
                            <p class="contact-d" for="date">{{$shippingData->phone}}</p>
                        </li>


                    </ul>

                </div><!-- .panel-body -->
            </div>

        </div>
    </div>
</div>

{{-- Single delete modal --}}
<div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
            </div>
            <div class="modal-footer">
                <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}">
                </form>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop

@section('javascript')
@if ($isModelTranslatable)
<script>
    $(document).ready(function() {
        $('.side-body').multilingual();
    });
</script>
@endif
<script>
    var deleteFormAction;
    $('.delete').on('click', function(e) {
        var form = $('#delete_form')[0];

        if (!deleteFormAction) {
            // Save form action initial value
            deleteFormAction = form.action;
        }

        form.action = deleteFormAction.match(/\/[0-9]+$/) ?
            deleteFormAction.replace(/([0-9]+$)/, $(this).data('id')) :
            deleteFormAction + '/' + $(this).data('id');

        $('#delete_modal').modal('show');
    });




    $(document).ready(function() {

                var selectedOptionId = '{{$dataTypeContent->status}}';

                $.ajax({
                    type: "get",
                    url: "/api/v1/get-order-status",
                    dataType: "json",
                    success: function(result, status, xhr) {

                        let ajaxResponse = result.response.detail;
                        console.log(result.response.detail);
                        // var table = $("<table><tr><th>Weather Description</th></tr>");

                        ajaxResponse.forEach(function(data) {
                            // Create an option element
                            var option = document.createElement("option");

                            // Set the value and text of the option using the properties from the response
                            option.value = data.name;
                            option.text = data.name;

                            // Check if the current option should be selected
                            if (data.name === selectedOptionId) {
                                option.selected = true; // Set the selected attribute
                            }


                            // Append the option to the select element
                            $("#order_status_Data").append(option);
                        });


                        // $("#order_status_Data").append(table);
                    },
                    error: function(xhr, status, error) {
                        alert("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
                    }
                });



                // var orderID = $("#orderID").val();
                // // var OrderStaus = $("#order_status_Data").attr('selected','selected');
                // var OrderStaus = $('select[name="order_status_Data"]').val();

                $("#update-order").click(function() {

                var orderID = $("#orderID").val();
                var OrderStaus = $('select[name="order_status_Data"]').val();
                var Email =  $("#EmailID").val();
              $(this).text('Loading...').prop('disabled', true);
                    $.ajax({
                        type: 'POST',
                        url: '/api/v1/update-order',
                        data: {
                            orderId: orderID,
                            status: OrderStaus,
                            email: Email,
                        },
                        success: function(response) {

                            // console.log('data', response)
                            //  $("#update-order").text('Update').prop('disabled', false);
                            location.reload();

                        }
                    });

                });

            });
</script>
@stop