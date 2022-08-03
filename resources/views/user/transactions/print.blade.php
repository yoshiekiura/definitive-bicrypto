@extends('layouts.fullLayoutMaster')
@php
    $pageConfigs = ['pageHeader' => false];
@endphp
@section('page-style')
<link rel="stylesheet" href="{{asset(mix('css/base/pages/app-invoice-print.css'))}}">
@endsection

@section('content')
<div class="invoice-print p-3">
    <div class="row invoice-preview">
        <!-- Invoice -->
        <div class="col-xl-9 col-md-8 col-12">
          <div class="card invoice-preview-card">
            <div class="card-body invoice-padding pb-0">
              <!-- Header starts -->
              <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                <div>
                <div class="brand-text mb-1"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="{{ __('locale.image')}}"></div>
                  {{-- <p class="card-text mb-25">Office 149, 450 South Brand Brooklyn</p>
                  <p class="card-text mb-25">San Diego County, CA 91905, USA</p>
                  <p class="card-text mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p> --}}
                </div>
                <div class="mt-md-0 mt-2">
                  <h4 class="invoice-title">
                    Transaction:
                    <span class="invoice-number">{{ $wal->trx }}</span>
                  </h4>
                  <div class="invoice-date-wrapper">
                    <p class="invoice-date-title">Date Issued:</p>
                    <p class="invoice-date">{{ $wal->created_at }}</p>
                  </div>
                  {{-- <div class="invoice-date-wrapper">
                    <p class="invoice-date-title">Due Date:</p>
                    <p class="invoice-date">29/08/2020</p>
                  </div> --}}
                </div>
              </div>
              <!-- Header ends -->
            </div>

            <hr class="invoice-spacing" />

            <!-- Address and Contact starts -->
            <div class="card-body invoice-padding pt-0">
              <div class="row invoice-spacing">
                <div class="col-xl-6 p-0">
                  <h6 class="mb-2">Invoice To:</h6>
                  <h6 class="mb-25">{{ $user->name }}</h6>
                  <p class="card-text mb-25">{{ $user->address }}</p>
                  <p class="card-text mb-25">{{ $user->town }}, {{ $user->city }}, {{ $user->zip }}, {{ $user->country }}</p>
                  <p class="card-text mb-25">{{ $user->mobile }}</p>
                  <p class="card-text mb-0">{{ $user->email }}</p>
                </div>
                <div class="col-xl-6 p-0 mt-xl-0 mt-2">
                  <h6 class="mb-2">Payment Details:</h6>
                  <table>
                    <tbody>
                      <tr>
                        <td class="pe-1">Amount Sent:</td>
                        <td><span class="fw-bold">{{ getAmount($wal->amount) }} {{ $wallet->symbol }}</span></td>
                      </tr>
                      <tr>
                        <td class="pe-1">Charge Fee:</td>
                        <td>{{ getAmount($wal->amount) * $fee }} {{ $wallet->symbol }}</td>
                      </tr>
                      <tr>
                        <td class="pe-1">Reciever Wallet:</td>
                        <td>{{ $wal->to }}</td>
                      </tr>
                      <tr>
                        <td class="pe-1">Reciever Wallet Type:</td>
                        <td>{{ $wal_to->symbol }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- Address and Contact ends -->

            <!-- Invoice Description starts -->
            {{-- <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="py-1">Task description</th>
                    <th class="py-1">Rate</th>
                    <th class="py-1">Hours</th>
                    <th class="py-1">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="py-1">
                      <p class="card-text fw-bold mb-25">Native App Development</p>
                      <p class="card-text text-nowrap">
                        Developed a full stack native app using React Native, Bootstrap & Python
                      </p>
                    </td>
                    <td class="py-1">
                      <span class="fw-bold">$60.00</span>
                    </td>
                    <td class="py-1">
                      <span class="fw-bold">30</span>
                    </td>
                    <td class="py-1">
                      <span class="fw-bold">$1,800.00</span>
                    </td>
                  </tr>
                  <tr class="border-bottom">
                    <td class="py-1">
                      <p class="card-text fw-bold mb-25">Ui Kit Design</p>
                      <p class="card-text text-nowrap">Designed a UI kit for native app using Sketch, Figma & Adobe XD</p>
                    </td>
                    <td class="py-1">
                      <span class="fw-bold">$60.00</span>
                    </td>
                    <td class="py-1">
                      <span class="fw-bold">20</span>
                    </td>
                    <td class="py-1">
                      <span class="fw-bold">$1200.00</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="card-body invoice-padding pb-0">
              <div class="row invoice-sales-total-wrapper">
                <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                  <p class="card-text mb-0">
                    <span class="fw-bold">Salesperson:</span> <span class="ms-75">Alfie Solomons</span>
                  </p>
                </div>
                <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                  <div class="invoice-total-wrapper">
                    <div class="invoice-total-item">
                      <p class="invoice-total-title">Subtotal:</p>
                      <p class="invoice-total-amount">$1800</p>
                    </div>
                    <div class="invoice-total-item">
                      <p class="invoice-total-title">Discount:</p>
                      <p class="invoice-total-amount">$28</p>
                    </div>
                    <div class="invoice-total-item">
                      <p class="invoice-total-title">Tax:</p>
                      <p class="invoice-total-amount">21%</p>
                    </div>
                    <hr class="my-50" />
                    <div class="invoice-total-item">
                      <p class="invoice-total-title">Total:</p>
                      <p class="invoice-total-amount">$1690</p>
                    </div>
                  </div>
                </div>
              </div>
            </div> --}}
            <!-- Invoice Description ends -->

            <hr class="invoice-spacing" />

            <!-- Invoice Note starts -->
            <div class="card-body invoice-padding pt-0">
              <div class="row">
                <div class="col-12">
                  <span class="fw-bold">Note:</span>
                  <span
                    >{{ $wal->details }}</span
                  >
                </div>
              </div>
            </div>
            <!-- Invoice Note ends -->
          </div>
        </div>
</div></div>
@endsection

@section('page-script')
<script src="{{asset('js/scripts/pages/app-invoice-print.js')}}"></script>
@endsection
