@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__("Payout Requests")}}</h1>
        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between ">
            <div class="col-left">
                @if(!empty($rows))
                    <form method="post" action="{{route('flight.admin.partner.payoutBulkEdit')}}" class="filter-form filter-form-left d-flex justify-content-start">
                        {{csrf_field()}}
                        <select name="action" class="form-control">
                            <option value="">{{__(" Bulk Actions ")}}</option>
                            <option value="processing">{{__(" Mark Processing ")}}</option>
                            <option value="completed">{{__(" Mark Completed (Paid) ")}}</option>
                            <option value="rejected">{{__(" Reject ")}}</option>
                        </select>
                        <button data-confirm="{{__("Are you sure?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                    </form>
                @endif
            </div>
            <div class="col-left">
                <form method="get" action="{{route('flight.admin.partner.payouts')}} " class="filter-form filter-form-right d-flex justify-content-end flex-column flex-sm-row" role="search">
                    <select name="status" class="form-control">
                        <option value="">{{__("-- Filter by Status --")}}</option>
                        <option value="requested" {{ request()->query('status') == 'requested' ? 'selected' : '' }}>Requested</option>
                        <option value="processing" {{ request()->query('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ request()->query('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button class="btn-info btn btn-icon btn_search" type="submit">{{__('Search')}}</button>
                </form>
            </div>
        </div>
        <div class="text-right">
            <p><i>{{__('Found :total items',['total'=>$rows->total()])}}</i></p>
        </div>
        <div class="panel">
            <div class="panel-body">
                <form action="" class="bravo-form-item">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th width="60px"><input type="checkbox" class="check-all"></th>
                                <th>{{__("Partner")}}</th>
                                <th>{{__("Amount")}}</th>
                                <th>{{__("Status")}}</th>
                                <th>{{__("Requested At")}}</th>
                                <th>{{__("Processed At")}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($rows->total() > 0)
                                @foreach($rows as $row)
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" class="check-item" value="{{$row->id}}"></td>
                                        <td class="title"> {{ $row->partner->name ?? 'Deleted Partner' }} <br><small>{{ $row->partner->email ?? '' }}</small></td>
                                        <td><strong>₹{{ number_format($row->amount, 2) }}</strong></td>
                                        <td>
                                            <span class="badge badge-{{ $row->status == 'completed' ? 'success' : ($row->status == 'requested' ? 'warning' : 'info') }}">{{ $row->status }}</span>
                                        </td>
                                        <td>{{ display_datetime($row->requested_at)}}</td>
                                        <td>{{ $row->processed_at ? display_datetime($row->processed_at) : '-'}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">{{__("No payout requests found")}}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </form>
                {{$rows->appends(request()->query())->links()}}
            </div>
        </div>
    </div>
@endsection
