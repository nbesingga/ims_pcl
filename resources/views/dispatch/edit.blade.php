@extends('layouts.master')
@section('title')
    Dispatch
@endsection
@section('css')
    <!--datatable css-->
    <link href="{{ URL::asset('assets/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <!--datatable responsive css-->
    <link href="{{ URL::asset('assets/css/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Outbound
        @endslot
        @slot('title')
        Dispatch
        @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-xxl-11">
            <div class="card" id="tasksList">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1"><?=$dispatch->dispatch_no?></h5>
                        <div class="col-md-2 text-center">
                            <span class="badge  fs-16 <?=$dispatch->status?> text-uppercase"><?=$dispatch->status?></span>
                        </div>
                        <div class="col-md-6 text-end">
                            <button data-status="open" class="submit-open btn btn-success btn-label rounded-pill"><i
                                class="ri-check-double-line label-icon align-middle rounded-pill fs-16 me-2"></i>
                            Save</button>
                            <button data-status="posted" class="submit-posted  btn btn-info btn-label rounded-pill"><i
                                class="ri-lock-line label-icon align-middle rounded-pill fs-16 me-2"></i> Post</button>
                            <a href="{{ URL::to('dispatch') }}" class="btn btn-primary btn-label rounded-pill"><i
                                    class="ri-arrow-go-back-line label-icon align-middle rounded-pill fs-16 me-2"></i>
                                Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    <form name="submit-dispatch" id="submit-dispatch">
        <div class="row justify-content-center">
            <div class="col-xxl-11">
                <div class="card" id="demo">
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row ms-3 mt-3 mx-3">

                                <div class="col-lg-6 col-md-6">
                                    <div class="row">
                                        <label for="colFormLabel" class="col-lg-4  col-form-label">Dispactch Date <span
                                                class="text-danger">*</span></label>

                                        <div class="col-lg-8">
                                            <input type="date" class="form-control" id="dispatch_date"
                                                name="dispatch_date" placeholder="Dispactch Date" value="{{ $dispatch->dispatch_date }}">
                                            <span class="text-danger error-msg dispatch_date_error"></span>
                                            <input type="hidden" name="dispatch_no"  value="{{$dispatch->dispatch_no}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="row">
                                        <label for="colFormLabel" class="col-lg-4 col-form-label">Created By</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="created_by" name="created_by" disabled
                                                value="<?=$dispatch->name?>" placeholder="Created By">
                                            <span class="text-danger error-msg created_by_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xxl-11">
                <div class="card" id="demo">
                    <div class="row ">
                        <div class=" col-lg-12">
                            <div class="card-header card-title mb-0 flex-grow-1">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title mb-0 flex-grow-1">Withdrawal</h5>
                                    <div class="d-flex flex-wrap gap-2 mb-3 mb-lg-0">
                                        <button type="button" id="find-withdrawal" class="btn btn-warning btn-label rounded-pill"><i
                                                class="ri-book-read-line label-icon align-middle rounded-pill fs-16 me-2"></i>
                                            Find Withdrawal</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-nowrap" id="withdrawal-list">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" style="width: 10px;">#</th>
                                                <th scope="col">WD #</th>
                                                <th scope="col">Client</th>
                                                <th scope="col">Deliver To</th>
                                                <th scope="col">No. of Package</th>
                                                <th scope="col">Order No.</th>
                                                <th scope="col">Order Date</th>
                                                <th scope="col">DR Number</th>
                                                <th scope="col">PO Number</th>
                                                <th scope="col">Sales Invoice</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="newlink">
                                            <?
                                            $rowCount = count($dispatch->items);
                                            $x=1;
                                            $total = 0;
                                             ?>
                                            @if(isset($dispatch->items))
                                                @foreach($dispatch->items as $item)
                                                @php
                                                    $total += $item->qty;
                                                @endphp
                                                <tr id="wd_{{$item->wd_no}}">
                                                    <td class="text-start">
                                                        <input type="hidden" name="wd_no[]"  value="{{$item->wd_no}}" />
                                                        <input type="hidden" name="wd_qty[]" value="{{$item->qty}}" />
                                                    {{$x++}} </td>
                                                    <td class="text-start fs-14">
                                                        {{$item->wd_no}}
                                                    </td>
                                                    <td class="text-start fs-14">
                                                        {{$item->client_name}}
                                                    </td>
                                                    <td class="text-start fs-14">
                                                        {{$item->deliver_to}}
                                                    </td>
                                                    <td class="ps-1 text-center">
                                                        {{ number_format($item->qty,2) }}
                                                    </td>
                                                    <td class="text-start fs-14">
                                                        {{$item->order_no}}
                                                    </td>
                                                    <td class="text-start fs-14">
                                                        {{ date('M d, Y', strtotime($item->order_date)) }}
                                                    </td>
                                                    <td class="text-start fs-14">
                                                        {{$item->dr_no}}
                                                    </td>
                                                    <td class="text-start fs-14">
                                                        {{$item->po_num}}
                                                    </td>
                                                    <td class="text-start fs-14">
                                                        {{$item->sales_invoice}}
                                                    </td>
                                                    <td>
                                                        <div class="text-center text-align-justify">
                                                            <button type="button" class="btn btn-danger mx-2 btn-icon waves-effect waves-light remove-withdrawal" data-id="{{$x}}"><i class="ri-delete-bin-5-fill"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr class="">
                                                    <td colspan="9" class="text-danger text-center">No Record Found!</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end">Total</td>
                                                <td class="text-center" id="total"><?=number_format($total,2)?></td>
                                                <td colspan="6"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <!--end table-->
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-xxl-11">
                <div class="card" id="demo">
                    <div class="row ">
                        <div class=" col-lg-12">
                            <div class="card-header card-title mb-0 flex-grow-1">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title mb-0 flex-grow-1">Vehicle</h5>
                                    <div class="d-flex flex-wrap gap-2 mb-3 mb-lg-0">
                                        <button type="button" id="add-row" class="btn btn-info btn-label rounded-pill"><i
                                                class="ri-add-line label-icon align-middle rounded-pill fs-16 me-2"></i>
                                            Add Truck</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-nowrap" id="truck-list">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col">Truck Type</th>
                                                <th scope="col">No. of Package</th>
                                                <th scope="col">Plate No.</th>
                                                <th scope="col">Driver</th>
                                                <th scope="col">Contact</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="newlink">
                                            <?
                                            $rowCount = count($dispatch->truck);
                                            $x=1;
                                            $total = 0;
                                             ?>
                                            @if(isset($dispatch->truck))
                                                @foreach($dispatch->truck as $truck)
                                                <tr>
                                                    <td>
                                                        <select class="form-select select2 truck_type" required="required" id="truck_type" name="truck_type[]" >
                                                            <option value="">Select Truck Type</option>
                                                            <? foreach($truck_type_list as $tr) : ?>
                                                                <option value="<?=$tr->vehicle_code?>" <?=($tr->vehicle_code == $truck->truck_type) ? 'selected' : ''?>><?="(".$tr->vehicle_code.") ".$tr->vehicle_desc?></option>
                                                            <? endforeach;?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control numeric" id="no_of_package" 
                                                            name="no_of_package[]" placeholder="Enter Quantity" value="{{ $truck->no_of_package }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="plate_no" 
                                                            name="plate_no[]" placeholder="Enter Plate No." value="{{ $truck->plate_no }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="driver" 
                                                            name="driver[]" placeholder="Enter Driver" value="{{ $truck->driver }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="contact" 
                                                            name="contact[]" placeholder="Enter Contact" value="{{ $truck->contact }}">
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <button type="button" class="remove-row btn btn-icon btn-danger remove-truck mx-2 waves-effect waves-light">
                                                                <i class="ri-delete-bin-5-fill"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach 
                                            @else
                                                <tr class="">
                                                    <td colspan="5" class="text-danger text-center">No Record Found!</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <!--end table-->
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end card-->
            </div>
        </div>
    </form>


    <!-- show charges Modal -->
    <div class="modal" id="show-withdrawal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Withdrawal List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <h6 class="text-muted text-uppercase fw-semibold">Keyword</h6>
                            <p class="fw-medium" id="billing-name">
                                <input type="text" class="form-control" id="keyword" name="keyword" value="" placeholder="Wd No,Order No, PO, Sales Invoice, DR No">
                            </p>
                        </div>
                        <div class="col-2">
                            <h6 class="text-muted text-uppercase fw-semibold">&nbsp;</h6>
                            <p class="fw-medium" id="billing-name">
                                <button data-status="open" id="search-withdrawal" class="btn btn-warning btn-label rounded-pill"><i class="ri-search-line label-icon align-middle rounded-pill fs-16 me-2"></i> Search </button>
                            </p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle" width="100%" style="font-size: 12px;" id="show-withdrawal-list">
                            <thead class="table-light">
                                <tr>
                                    <th>&nbsp;</th>
                                    <th scope="col">WD #</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Deliver To</th>
                                    <th scope="col">No. of Package</th>
                                    <th scope="col">Order No.</th>
                                    <th scope="col">Order Date</th>
                                    <th scope="col">DR Number</th>
                                    <th scope="col">PO Number</th>
                                    <th scope="col">Sales Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-success" id="add-withdrawal"><i
                                class="ri-add-line label-icon align-middle rounded-pill fs-16 me-2"></i> Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/cleave.js/cleave.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/masks/jquery.mask.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>

    <script src="{{ URL::asset('assets/js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datatables/dataTables.responsive.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/dispatch/dispatch.js') }}"></script>
@endsection