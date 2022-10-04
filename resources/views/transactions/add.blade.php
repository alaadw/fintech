@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div id="whole-cart-container"></div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Add Transaction') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ env('APP_URL') }}/store">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Value To Add or Withdraw from Balance in Euro') }}</label>

                                <div class="col-md-6">
                                    <input id="netvalue" type="text" class="form-control" name="netvalue"
                                        value="{{ old('netvalue') }}" required autofocus>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Type of Transaction') }}</label>

                                <div class="col-md-6">
                                    <select name="transaction_id" id="transaction_id" onchange="get_transaction()" required>
                                        <option value="">
                                            {{ __('Please Select One') }}</option>
                                        @foreach ($transactions as $transaction)
                                            <option value="{{ $transaction->id }}">{{ $transaction->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div id="paypal-button-container" style="display:none"></div>
                                <input type="submit" id="send" name="sub" value="Send"
                                    class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sample PayPal credentials (client-id) are included -->
    <script src="https://www.paypal.com/sdk/js?client-id=test&currency=EUR&intent=capture&enable-funding=venmo"
        data_source="integrationbuilder"></script>
    <script>
        function get_transaction() {
            var tid = document.getElementById("transaction_id").value;
            if (tid == 1) {

                document.getElementById("paypal-button-container").style.display = "block";
                document.getElementById("send").
                style.display = "none";
            } else {
                document.getElementById("paypal-button-container").
                style.display = "none";
                document.getElementById("send").
                style.display = "block";
            }
        }
        const paypalButtonsComponent = paypal.Buttons({
            // optional styling for buttons
            // https://developer.paypal.com/docs/checkout/standard/customize/buttons-style-guide/
            style: {
                color: "gold",
                shape: "rect",
                layout: "vertical"
            },

            // set up the transaction
            createOrder: (data, actions) => {
                // pass in any options from the v2 orders create call:
                // https://developer.paypal.com/api/orders/v2/#orders-create-request-body
                const v = document.getElementById("netvalue").value;
                console.log(v);
                const createOrderPayload = {
                    purchase_units: [{
                        amount: {
                            value: v
                        }
                    }]
                };

                return actions.order.create(createOrderPayload);
            },

            // finalize the transaction
            onApprove: (data, actions) => {
                const captureOrderHandler = (details) => {
                    const payerName = details.payer.name.given_name;
                    console.log(details);
                    //save all to database and make cart empty
                    if (details.status == 'COMPLETED') {

                        console.log(details);
                        var xhr = new XMLHttpRequest();

                        var params = "id=" + details.id + "&time=" + details.update_time + '&email=' +
                            details.payer.email_address + '&payer_id=' + details.payer.payer_id + '&v=' +
                            document.getElementById("netvalue").value;
                        xhr.onreadystatechange = function() {
                            console.log(params);
                            if (xhr.readyState === 4 && xhr.status === 200) { //no error
                                console.log(xhr.response);
                                document.getElementById("whole-cart-container").innerHTML =
                                    '<div class="alert alert-success" role="alert">Deposit Added Successfully</div>';


                            }
                        };
                        xhr.open('POST', "{{ env('APP_URL') }}/withpaypal");
                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhr.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector(
                            "[name=csrf-token]").content);
                        xhr.send(params);
                    }
                };

                return actions.order.capture().then(captureOrderHandler);
            },

            // handle unrecoverable errors
            onError: (err) => {
                console.error('An error prevented the buyer from checking out with PayPal');
            }
        });

        paypalButtonsComponent
            .render("#paypal-button-container")
            .catch((err) => {
                console.error('PayPal Buttons failed to render');
            });
    </script>
@endsection
