@extends('library.layout.app')

{{-- HTML Title --}}
@section('html-title')

@endsection


{{-- Css --}}
@section('css')

@endsection

{{-- Page Title --}}
@section('page-title')
Dashboard
@endsection

{{-- Page Title Sub --}}
@section('page-title-sub')

@endsection


{{-- Main Content --}}
@section('main-content')
<!-- Content Row -->
          <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <a href="/library/books">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Books</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count['books'] }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                  </div>
                  </a>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <a href="/library/borrow/registered">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Registered Borrower</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count['borrow2'] }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                  </div>
                  </a>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <a href="/library/borrow/pre/">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      	<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pre-registered Borrower</div>
                     	<div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count['borrow1'] }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-minus fa-2x text-gray-300"></i>
                    </div>
                  </div>
                  </a>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <a href="/library/reservation/status/pending">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count['pending'] }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-stream fa-2x text-gray-300"></i>
                    </div>
                  </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
@endsection


{{-- Js Script --}}
@section('js')

@endsection