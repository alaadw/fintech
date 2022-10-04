@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><b>{{ __('List of Transactions') }}</b> <span style="margin-left: 40px;">Balance:
                            {{ auth()->user()->balance }} Euro \ {{ auth()->user()->balance * $CHF }} CHF \
                            {{ auth()->user()->balance * $USD }} USD</span></div>

                    <div class="card-body">
                        <form method="get" action="{{ env('APP_URL') }}">
                            @csrf

                            <table cellspacing="" cellpadding="" class="table table-hover table-bordered display bg-white"
                                id="PostTable">
                                <div class="mb-2">

                                    <form action="/">
                                        @csrf
                                        <input type="date" name="from_date" required>
                                        <input type="date" name="to_date" required>
                                        <input type="submit" name="q" value="Search" class="btn btn-success" />
                                    </form>

                                </div>
                                <thead>
                                    <tr class="">
                                        <th>{{ __('Id') }}</th>
                                        <th>{{ __('Value') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Date') }}</th>
                                    </tr>
                                </thead>

                                @foreach ($transactions as $transaction)
                                    <tr class="">
                                        <td>{{ $transaction->tid }}</td>
                                        <td class="alert {{ $transaction->id == 2 ? 'alert-danger' : 'alert-success' }}">
                                            {{ $transaction->netvalue }}</td>
                                        <td>{{ $transaction->name }} </td>
                                        <td>{{ $transaction->cret }} </td>
                                    </tr>
                                @endforeach
                            </table>
                            <div class="row mb-3">

                                {{ $transactions->appends(Request::all())->links() }}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
