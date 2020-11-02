 <!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
      table {
        border-collapse: collapse;
        width: 100%;
      }
      td, th {
        border: solid 2px;
        padding: 10px 5px;
      }
      tr {
        text-align: center;
      }
      .container {
        width: 100%;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="container">
        <div><h2>List of hired employees from {{$searchingVals['from']}} to {{$searchingVals['to']}}</h2></div>
       <table id="example2" role="grid">
            <thead>
              <tr role="row">
                <th width="20%">Customer Name</th>
                <th width="20%">Terminal ID</th>
                <th width="10%">Atm Name</th>
                <th width="15%">Product</th>
                <th width="15%">Brand</th>
                <th width="10%">Supplier</th>
                <th width="10%">Unit Price</th>
                  <th width="10%">Tax</th>
                  <th width="10%">Qty</th>
                <th width="10%">Note</th>
                <th width="10%">CE Name</th>
                <th width="10%">Customer Address</th>
                <th width="10%">Sale Date</th>
                <th width="10%">Total Price</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($sales as $sales)
                <tr role="row" class="odd">
                  <td>{{ $sales['customer_name'] }}</td>
                  <td>{{ $sales['terminal_id'] }}</td>
                  <td>{{ $sales['atm_name'] }}</td>
                  <td>{{ $sales['product_name'] }}</td>
                  <td>{{ $sales['brand_name'] }}</td>
                  <td>{{ $sales['supplier_name'] }}</td>
                  <td> &#x20a6 {{ $sales['unit_price'] }}</td>
                  <td> &#x20a6 {{ $sales['tax'] }}</td>
                  <td>{{ $sales['quantity'] }}</td>
                  <td>{{ $sales['note'] }}</td>
                  <td>{{ $sales['ce_name'] }}</td>
                  <td>{{ $sales['customer_address'] }}</td>
                  <td> &#x20a6 {{ $sales['total_price'] }}</td>
                  <td>{{ $sales['sale_date'] }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
    </div>
  </body>
</html>