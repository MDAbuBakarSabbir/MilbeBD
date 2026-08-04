@extends('layouts.backend.masterLay')
@section('title','Incomplete Orders')
@section('content')
<div class="row">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">Filter</div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <label for="">Filter by date range</label>
                        <input type="date" name="" id="" class="form-control">
                    </div>
                    <div class="col">
                        <label for="">Filter by status</label>
                        <select name="" id="" class="form-control">
                            <option value="">Select Status</option>
                            <option value="">Pending</option>
                            <option value="">Processing</option>
                            <option value="">Completed</option>
                            <option value="">Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    Incomplete Orders
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Product Name</td>
                                    <td>100</td>
                                    <td>1</td>
                                    <td>100</td>
                                    <td>Pending</td>
                                    <td>
                                        <button class="btn btn-primary">Edit</button>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection