<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shopify Orders</title>

    <!-- Fonts -->
    <link
        rel="stylesheet"
        href="https://unpkg.com/@shopify/polaris@5.1.0/dist/styles.css"
    />
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        <table class="Polaris-DataTable__Table">
            <thead>
            <tr>
                <th data-polaris-header-cell="true"
                    class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn Polaris-DataTable__Cell--header"
                    scope="col">Order
                </th>
                <th data-polaris-header-cell="true"
                    class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric"
                    scope="col">Total Price
                </th>
                <th data-polaris-header-cell="true"
                    class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric"
                    scope="col">Order Created
                </th>
                <th data-polaris-header-cell="true"
                    class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric"
                    scope="col">Order Updated
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr class="Polaris-DataTable__TableRow">
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn"
                        scope="row">{{$order->name}}
                    </th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric"
                        scope="row">${{$order->total_price}}
                    </th>
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop">
                        {{$order->order_created}}
                    </td>
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop">
                        {{$order->order_updated}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
