<?php

$files = [
    'c:\booking-core.2.3.0\modules\Car\Views\frontend\listing\wizard.blade.php',
    'c:\booking-core.2.3.0\modules\Hotel\Views\frontend\listing\wizard.blade.php'
];

$step0Html = <<<'HTML'

        @if(!Auth::check())
        <!-- ===== STEP 0: Account Registration ===== -->
        <div class="wiz-step active" id="step0">
            <div class="wiz-step-header">
                <h2>Create Your Partner Account</h2>
                <p>Please enter your details to create an account and continue.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-row">
                    <div class="wiz-col-6">
                        <label class="wiz-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" id="reg_first_name" class="wiz-input" placeholder="Your Name" required>
                    </div>
                    <div class="wiz-col-6">
                        <label class="wiz-label">Mobile Number <span class="text-danger">*</span></label>
                        <input type="text" id="reg_phone" class="wiz-input" placeholder="Mobile Number" required>
                    </div>
                </div>
                <div class="wiz-row" style="margin-top: 15px;">
                    <div class="wiz-col-12">
                        <label class="wiz-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" id="reg_email" class="wiz-input" placeholder="Email Address" required>
                    </div>
                </div>
            </div>
            <div class="wiz-nav">
                <div></div>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="sendOtpWiz()" id="btnSendOtp">Send OTP</button>
            </div>
        </div>

        <!-- ===== STEP 0.5: Verify OTP ===== -->
        <div class="wiz-step" id="step05">
            <div class="wiz-step-header">
                <h2>Verify OTP</h2>
                <p>We sent a 6-digit code to your email.</p>
            </div>
            <div class="wiz-card">
                <div class="wiz-row">
                    <div class="wiz-col-12">
                        <label class="wiz-label">Enter OTP <span class="text-danger">*</span></label>
                        <input type="text" id="reg_otp" class="wiz-input" placeholder="123456" required>
                    </div>
                </div>
            </div>
            <div class="wiz-nav">
                <button type="button" class="wiz-btn wiz-btn-back" onclick="goToStep(0)">Back</button>
                <button type="button" class="wiz-btn wiz-btn-next" onclick="verifyOtpWiz()" id="btnVerifyOtp">Verify & Continue</button>
            </div>
        </div>
        @endif

HTML;

$jsHtml = <<<'HTML'

function sendOtpWiz() {
    let btn = document.getElementById('btnSendOtp');
    let email = document.getElementById('reg_email').value;
    let fname = document.getElementById('reg_first_name').value;
    let phone = document.getElementById('reg_phone').value;
    if(!email) { alert("Email is required"); return; }
    
    btn.innerHTML = 'Sending...';
    btn.disabled = true;

    fetch('/login/send-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ email: email, first_name: fname, phone: phone })
    })
    .then(res => res.json())
    .then(data => {
        btn.innerHTML = 'Send OTP';
        btn.disabled = false;
        if(data.error) {
            alert(data.messages?.message_error || 'Error sending OTP');
        } else {
            alert('OTP sent successfully!');
            goToStep(0.5);
        }
    }).catch(err => {
        btn.innerHTML = 'Send OTP';
        btn.disabled = false;
        alert('Server error');
    });
}

function verifyOtpWiz() {
    let btn = document.getElementById('btnVerifyOtp');
    let email = document.getElementById('reg_email').value;
    let otp = document.getElementById('reg_otp').value;
    if(!otp) { alert("OTP is required"); return; }
    
    btn.innerHTML = 'Verifying...';
    btn.disabled = true;

    fetch('/login/verify-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ email: email, otp_code: otp })
    })
    .then(res => res.json())
    .then(data => {
        if(data.error) {
            btn.innerHTML = 'Verify & Continue';
            btn.disabled = false;
            alert(data.messages?.message_error || 'Invalid OTP');
        } else {
            alert('Verified Successfully!');
            window.location.reload(); // Reload to initialize authenticated state
        }
    }).catch(err => {
        btn.innerHTML = 'Verify & Continue';
        btn.disabled = false;
        alert('Server error');
    });
}
HTML;

foreach ($files as $file) {
    if(!file_exists($file)) {
        echo "File not found: $file\n";
        continue;
    }
    $content = file_get_contents($file);

    // Insert Step 0 and 0.5 before Step 1
    if (strpos($content, '<!-- ===== STEP 0: Account Registration ===== -->') === false) {
        $content = preg_replace('/(<!-- ===== STEP 1:[^>]+>)/', $step0Html . "\n        $1", $content);
    }
    
    // Change Step 1 active class conditionally
    $content = str_replace('<div class="wiz-step active" id="step1">', '<div class="wiz-step @if(Auth::check()) active @endif" id="step1">', $content);

    // Insert JS logic
    if (strpos($content, 'function sendOtpWiz') === false) {
        $content = str_replace('function goToStep(n) {', $jsHtml . "\n\nfunction goToStep(n) {", $content);
    }

    // Fix goToStep to handle step 0 and 0.5
    if (strpos($content, "if(n === 0.5)") === false) {
        $goToStepFix = <<<'HTML'
    if(n === 0) {
        document.querySelectorAll('.wiz-step').forEach(e => e.classList.remove('active'));
        document.getElementById('step0').classList.add('active');
        return;
    }
    if(n === 0.5) {
        document.querySelectorAll('.wiz-step').forEach(e => e.classList.remove('active'));
        document.getElementById('step05').classList.add('active');
        return;
    }
HTML;
        $content = preg_replace('/(function goToStep\(n\) \{)/', "$1\n" . $goToStepFix, $content);
    }
    
    file_put_contents($file, $content);
    echo "Updated $file\n";
}
