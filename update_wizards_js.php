<?php
$files = [
    'c:\booking-core.2.3.0\modules\Car\Views\frontend\listing\wizard.blade.php',
    'c:\booking-core.2.3.0\modules\Hotel\Views\frontend\listing\wizard.blade.php'
];

$jsOld = <<<'HTML'
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

$jsNew = <<<'HTML'
function showInlineMsg(stepId, msg, isError) {
    let container = document.getElementById(stepId);
    let msgDiv = container.querySelector('.wiz-inline-msg');
    if (!msgDiv) {
        msgDiv = document.createElement('div');
        msgDiv.className = 'wiz-inline-msg';
        msgDiv.style.padding = '10px 15px';
        msgDiv.style.marginBottom = '15px';
        msgDiv.style.borderRadius = '4px';
        msgDiv.style.fontWeight = '500';
        msgDiv.style.fontSize = '13px';
        // insert after step header
        let header = container.querySelector('.wiz-step-header');
        header.insertAdjacentElement('afterend', msgDiv);
    }
    msgDiv.style.backgroundColor = isError ? '#f8d7da' : '#d4edda';
    msgDiv.style.color = isError ? '#721c24' : '#155724';
    msgDiv.innerHTML = msg;
    msgDiv.style.display = 'block';
}

function sendOtpWiz() {
    let btn = document.getElementById('btnSendOtp');
    let email = document.getElementById('reg_email').value;
    let fname = document.getElementById('reg_first_name').value;
    let phone = document.getElementById('reg_phone').value;
    if(!email) { showInlineMsg('step0', "Email is required", true); return; }
    if(!fname) { showInlineMsg('step0', "Full Name is required", true); return; }
    if(!phone) { showInlineMsg('step0', "Mobile Number is required", true); return; }
    
    btn.innerHTML = 'Sending...';
    btn.disabled = true;
    
    let token = document.querySelector('input[name="_token"]').value;

    fetch('/login/send-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ email: email, first_name: fname, phone: phone })
    })
    .then(res => res.json())
    .then(data => {
        btn.innerHTML = 'Send OTP';
        btn.disabled = false;
        if(data.error) {
            showInlineMsg('step0', data.messages?.message_error || 'Error sending OTP', true);
        } else {
            showInlineMsg('step05', 'OTP sent successfully to your email!', false);
            goToStep(0.5);
        }
    }).catch(err => {
        btn.innerHTML = 'Send OTP';
        btn.disabled = false;
        showInlineMsg('step0', 'Server error. Please try again.', true);
    });
}

function verifyOtpWiz() {
    let btn = document.getElementById('btnVerifyOtp');
    let email = document.getElementById('reg_email').value;
    let otp = document.getElementById('reg_otp').value;
    if(!otp) { showInlineMsg('step05', "OTP is required", true); return; }
    
    btn.innerHTML = 'Verifying...';
    btn.disabled = true;

    let token = document.querySelector('input[name="_token"]').value;

    fetch('/login/verify-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ email: email, otp_code: otp })
    })
    .then(res => res.json())
    .then(data => {
        btn.innerHTML = 'Verify & Continue';
        btn.disabled = false;
        if(data.error) {
            showInlineMsg('step05', data.messages?.message_error || 'Invalid OTP', true);
        } else {
            // Update CSRF tokens so subsequent form submissions work without reload!
            if(data.csrf_token) {
                document.querySelectorAll('input[name="_token"]').forEach(el => el.value = data.csrf_token);
                let metaCsrf = document.querySelector('meta[name="csrf-token"]');
                if(metaCsrf) metaCsrf.setAttribute('content', data.csrf_token);
            }
            
            // Smoothly move to step 1
            showInlineMsg('step05', 'Verified Successfully! Let\'s go.', false);
            setTimeout(() => {
                goToStep(1);
            }, 800);
        }
    }).catch(err => {
        btn.innerHTML = 'Verify & Continue';
        btn.disabled = false;
        showInlineMsg('step05', 'Server error. Please try again.', true);
    });
}
HTML;

foreach ($files as $file) {
    if(!file_exists($file)) continue;
    $content = file_get_contents($file);

    // Replace JS
    $content = str_replace($jsOld, $jsNew, $content);
    
    file_put_contents($file, $content);
    echo "Updated $file\n";
}
