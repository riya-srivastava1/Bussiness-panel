@extends('layouts.app')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN breadcrumb -->
        <ol class="breadcrumb float-xl-end">
            <li class="breadcrumb-item">Home</li>
        </ol>
        <!-- END breadcrumb -->
        <h3 class=" page-header">Dashboard</h3>
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-3 -->
            <div class="col-xl-3 col-md-6">
                <div class="widget widget-stats bg-orange">
                    <div class="stats-icon"><i class="fa fa-users"></i></div>
                    <div class="stats-info">
                        <h4>Candiate Appear for Interview</h4>
                        <p>100</p>
                    </div>
                    <div class="stats-link">
                        <a href="javascript:,">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- END col-3 -->
            <!-- BEGIN col-3 -->
            <div class="col-xl-3 col-md-6">
                <div class="widget widget-stats bg-blue">
                    <div class="stats-icon"><i class="fa fa-users"></i></div>
                    <div class="stats-info">
                        <h4>Selected Candidate</h4>
                        <p>200</p>
                    </div>
                    <div class="stats-link">
                        <a href="javascript:,">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- END col-3 -->
            <!-- BEGIN col-3 -->
            <div class="col-xl-3 col-md-6">
                <div class="widget widget-stats bg-info">
                    <div class="stats-icon"><i class="fa fa-users"></i></div>
                    <div class="stats-info">
                        <h4> Employee</h4>
                        <p>500</p>
                    </div>
                    <div class="stats-link">
                        <a href="javascript:,">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- END col-3 -->

            <!-- BEGIN col-3 -->
            <div class="col-xl-3 col-md-6">
                <div class="widget widget-stats bg-red">
                    <div class="stats-icon"><i class="fa fa-users"></i></i></div>
                    <div class="stats-info">
                        <h4>InActive Employee</h4>
                        <p>1500</p>
                    </div>
                    <div class="stats-link">
                        <a href="javascript:,">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- END col-3 -->
        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->
@endsection
