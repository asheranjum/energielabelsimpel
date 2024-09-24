<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            margin: 0px auto;
        }
        .header {
            text-align: center;
            padding: 0px 0px;
        }
        .header img {
            max-width: 200px;
        }
        .top-header {
            height:200px;
            margin-bottom: 20px;
        }
        .top-header .company-info {
            float:left;
            text-align: left;
             width:50%;
        }
        .top-header .invoice-info {
             float:right;
            text-align: right;
               width:50%;
        }
        .details-table, .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size:90%;
        }
        .details-table td, .products-table th, .products-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .details-table td {
            width: 50%;
        }

         .details-table td  strong
        {
            font-size: 16px;
            padding: 0px 0px 0px 0px;
            display: block;
        }
        .products-table th {
            background-color: #f2f2f2;
        }
        .total-row th, .total-row td {
            font-weight: bold;
            text-align: right;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #666;
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
    /* min-width: 20px; */
    overflow: hidden;
    -webkit-user-select: w;
    -moz-user-select: none;
    width: fit-content;
    border-radius: 5px;
    float: right;
    user-select: none;
    vertical-align: bottom;
    height: fit-content;
    color: white;
    align-self: center;
    padding: 6px 12px 6px 16px;
}

.bg-info {
    background-color: rgb(58 149 223) !important;
}

.bg-success {
    background-color: #4CAF50 !important;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="top-header">
            <div class="company-info">
                
                <img src="{{ url('storage/settings/April2024/5YZLCd8FW2x7Sxmfx0oI.png') }}" width="120" alt="Company Logo">

                <p>Radio Nostalgie<br>
                LOUIS STREET<br>
                DOVETON, Victoria, 3177<br>
                Australia<br>
                0397540901<br>
                54 658 208 087</p>
            </div>
            <div class="invoice-info">
                <h2>Invoice</h2>
                <p>Invoice Date: 07-10-2023<br>
                Invoice No.: 4236<br>
                Order No.: 4236<br>
                Order Date: 07-10-2023<br>
                </p>

                                    @if(isset($details['payment_info']) && !empty($details['payment_info']['transaction_id']))
                   <span class="badge bg-success text-info-fg d-flex align-items-center gap-1">
                        Paid </span>
                    @else
                   

                          <span class="badge bg-warning text-warning-fg d-flex align-items-center gap-1">
                        Unpaid</span>
                    @endif
            </div>
        </div>

        <table class="details-table" style="margin:0px;">
            <tr>
                <td style='border: none;'><strong>Billing Information:</strong><br>
                    Name: {{ $details['billing_info']['delivery_name'] }}<br>
                    Company: {{ $details['billing_info']['company_name'] }}<br>
                    Address: {{ $details['billing_info']['address'] }}<br>
                    City: {{ $details['billing_info']['city'] }}<br>
                    State: {{ $details['billing_info']['state'] }}<br>
                    Postal Code: {{ $details['billing_info']['postal'] }}<br>
                    Country: {{ $details['billing_info']['country'] }}<br>
                    Contact No: {{ $details['billing_info']['contact_no'] }}<br>
                    Email: {{ $details['billing_info']['email'] }}
                </td>
                <td  style='border: none;'><strong>Shipping Information:</strong><br>
                    Name: {{ $details['shipping_info']['delivery_name'] }}<br>
                    Company: {{ $details['shipping_info']['delivery_company'] }}<br>
                    Address: {{ $details['shipping_info']['delivery_address_1'] }}<br>
                    City: {{ $details['shipping_info']['city'] }}<br>
                    State: {{ $details['shipping_info']['state'] }}<br>
                    Postal Code: {{ $details['shipping_info']['postal'] }}<br>
                    Country: {{ $details['shipping_info']['country'] }}<br>
                    Contact No: {{ $details['shipping_info']['delivery_contact_no'] }}<br>
                    Email: {{ $details['shipping_info']['delivery_email'] }}<br>
                    Expected Delivery: {{ $details['shipping_info']['expected_delivery'] }}
                </td>
            </tr>
        </table>

        <table class="products-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Adds On</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details['products'] as $product)
                <tr>
                    <td>{{ $product->name }} 
                    
                    <ul style="font-size:14px">
    @if(isset($product->color) && isset($product->color->name))
        <li><span>{{ $product->color->name }} : ${{ number_format($product->color->price, 2) }}</span></li>
    @endif
    @if(isset($product->premiumColor) && isset($product->premiumColor->name))
        <li><span>{{ $product->premiumColor->name }} : ${{ number_format($product->premiumColor->price, 2) }}</span></li>
    @endif
    @if(isset($product->size) && isset($product->size->price))
        <li><span>Size : ${{ number_format($product->size->price, 2) }}</span></li>
    @endif
    @if(isset($product->seater) && isset($product->seater->name))
        <li><span>{{ $product->seater->name }} : ${{ number_format($product->seater->price, 2) }}</span></li>
    @endif
    @if(isset($product->fabric) && isset($product->fabric->name))
        <li><span>{{ $product->fabric->name }} : ${{ number_format($product->fabric->price, 2) }}</span></li>
    @endif
    @if(isset($product->warrenty))
        <li><span>{{ isset($product->warrenty->name) ? $product->warrenty->name : 'Warrenty' }} : ${{ number_format($product->warrenty->price, 2) }}</span></li>
    @endif
</ul>
                     <br> 

                    </td>
                    <td>{{ $product->SKU }} </td>
                    <td>@if(isset($product->addOnsPrice) && $product->addOnsPrice > 0 || isset($product->addOns3dPrice) && $product->addOns3dPrice > 0)
   
                    @if(isset($product->addOnsPrice) && $product->addOnsPrice > 0)
                        <span>${{ number_format($product->addOnsPrice, 2) }}</span>
                    @endif
                    
                    @if(isset($product->addOns3dPrice) && $product->addOns3dPrice > 0)
                        <span> ${{ number_format($product->addOns3dPrice, 2) }}</span>
                    @endif @endif</td>
                    <td>${{ number_format($product->regular_price, 2) }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>${{ number_format($product->regular_price * $product->quantity, 2) }}</td>
                </tr>
                @endforeach
         
    
            
            <tr class="total-row">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Tax:</td>
                <td>${{ $details['payment_info']['tax'] }}</td>
            </tr>
            <tr class="total-row">
              <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total:</td>
                <td>${{ $details['payment_info']['total'] }}</td>
            </tr>
               </tbody>
        </table>

        @if(isset($details['payment_info']) && !empty($details['payment_info']['transaction_id']))
        <table  class="products-table">
           

               <thead>
                <tr>
                    <th colspan="2">Transaction Details  </th>
                </tr>
            </thead>
            <tr>
                <td>Transaction Date:</td>
                <td>{{ $details['payment_info']['transaction_date'] }}</td>
            </tr>
            <tr>
                <td>Gateway:</td>
                <td>{{ $details['payment_info']['payment_method'] }}</td>
            </tr>
            <tr>
                <td>Shipping:</td>
                <td>{{ $details['payment_info']['shipping_method'] }}</td>
            </tr>
            <tr>
                <td>Transaction ID:</td>
                <td>{{ $details['payment_info']['transaction_id'] }}</td>
            </tr>
            <tr>
                <td>Amount:</td>
                <td>${{ $details['payment_info']['total'] }}</td>
            </tr>
        </table>
    @else
        <p>No Related Transactions Found</p>
    @endif

        <div class="footer">
           Thank you For Shopping 
        </div>
    </div>
</body>
</html>
