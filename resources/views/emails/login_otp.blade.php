@extends('Email::layout')
@section('content')
    <div class="b-container">
        <div class="b-panel" style="padding: 30px; text-align: center;">
            <h2 style="color: #1e293b; font-size: 24px; font-weight: bold; margin-bottom: 20px;">Your Login Verification Code</h2>
            <p style="color: #64748b; font-size: 16px; margin-bottom: 30px;">
                Hello,<br><br>
                You requested a One-Time Password (OTP) to log in to your account or complete a booking. Please use the verification code below:
            </p>
            <div style="background-color: #f1f5f9; border-radius: 12px; padding: 20px; display: inline-block; margin-bottom: 30px;">
                <h1 style="color: #d4441c; font-size: 36px; font-weight: bold; letter-spacing: 12px; margin: 0;">{{ $otpCode }}</h1>
            </div>
            <p style="color: #64748b; font-size: 14px;">
                This code will expire in <strong>10 minutes</strong>. Do not share this code with anyone.
            </p>
            <p style="color: #94a3b8; font-size: 12px; margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                If you did not request this OTP, please ignore this email or contact support if you have concerns.
            </p>
        </div>
    </div>
@endsection
