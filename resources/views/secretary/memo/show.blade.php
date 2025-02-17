@extends('dashboards.index')
@section('content')
<style>
    /* Add your letterhead styles here */
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 20px;
    }
    .header {
        text-align: center;
        margin-bottom: 40px;
    }
    /* .footer {
        position: fixed;
        bottom: 0;
        text-align: center;
        width: 100%;
    } */
</style>
<div class="letter mt-5">
    <div class="header">
        <h1>Your Company Name</h1>
        <p>Your Company Address</p>
        <p>Contact Information</p>
    </div>
    
    <p><strong>To:</strong> Recipient</p>
    <p>Address</p>
    
    <h2>{{ $memo->title }}</h2>
    
    <p>{{ $memo->content }}</p>
    
    <div class="footer">
        <p>Your Company Footer Information</p>
    </div>
</div>
@endsection