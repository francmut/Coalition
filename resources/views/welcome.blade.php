<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Coalition Demo</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <form id="form" method="post">
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input class="form-control" id="productName" placeholder="Product Name" name="product_name" required>
                        </div>
                        <div class="form-group">
                            <label for="productQuantity">Quantity in Stock</label>
                            <input class="form-control" type="number" min="0" step="1" id="productQuantity" placeholder="Quantity in Stock" name="product_quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Price per Item</label>
                            <input class="form-control" type="number" min="0" step="0.01" id="productPrice" placeholder="Price per Item" name="product_price" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark btn-block">Add Product</button>
                        </div>
                    </form>
                </div>

                <div class="col-6">
                    <div id="data"><center>No Data</center></div>
                </div>
            </div>

        </div>

        <script tyle="javascript">
            $(function () {
                $('#form').on('submit', function (event) {
                    event.preventDefault();
                    $.ajax({
                        url: '/products',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'product_name': $('#productName').val(),
                            'product_quantity': $('#productQuantity').val(),
                            'product_price': $('#productPrice').val(),
                        },
                        success: function (response) {
                            if (response) {
                                var response = response.data;
                                html = '<table class="table"><thead><tr><th>Product Name</th><th>Quantity in Stock</th><th>Price Per Item</th><th>Date Time</th><th>Total Value Number</th></tr></thead>';
                                html += '<tbody>';
                                for (var i = 0; i < response.length; i++) {
                                    var product = response[i];
                                    html += '<tr>' + 
                                                '<td>' + product.product_name + '</td>' +
                                                '<td>' + product.product_quantity + '</td>' +
                                                '<td>' + product.product_price + '</td>' +
                                                '<td>' + product.date_time + '</td>' +
                                                '<td>' + product.price_total + '</td>' +
                                            '<tr>';
                                }
                                html += '</tbody></table>';
                                $('#data').html(html);
                            }
                        }
                    });
                });

                // Load initial products
                $.ajax({
                    url: '/products',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response) {
                            var response = response.data;
                            html = '<table class="table"><thead><tr><th>Product Name</th><th>Quantity in Stock</th><th>Price Per Item</th><th>Date Time</th><th>Total Value Number</th></tr></thead>';
                            html += '<tbody>';
                            for (var i = 0; i < response.length; i++) {
                                var product = response[i];
                                html += '<tr>' + 
                                            '<td>' + product.product_name + '</td>' +
                                            '<td>' + product.product_quantity + '</td>' +
                                            '<td>' + product.product_price + '</td>' +
                                            '<td>' + product.date_time + '</td>' +
                                            '<td>' + product.price_total + '</td>' +
                                        '<tr>';
                            }
                            html += '</tbody></table>';
                            $('#data').html(html);
                        }
                    }
                });
                
            });
        </script>
    </body>
</html>
