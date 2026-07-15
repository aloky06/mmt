<div class="login-forms-wrapper">
    <!-- OTP Login Form -->
    <form class="bravo-form-login-otp otp-login-form" method="POST" action="{{ route('auth.login.verify_otp') }}">
        <input type="hidden" name="redirect" value="{{ request()->query('redirect') ?? session('redirect') ?? session()->get('url.intended') }}">
        @csrf
        
        <div class="text-center mb-4">
            <h3 style="font-size: 24px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Welcome / Sign Up</h3>
            <p style="color: #64748b; font-size: 14px;">Enter your email to receive a secure One-Time Password.</p>
        </div>

        <div class="form-group otp-email-group" style="position: relative;">
            <label style="font-weight: 600; color: #334155; margin-bottom: 8px; display: block;">{{__('Email address')}}</label>
            <div class="input-group-modern" style="position: relative;">
                <i class="input-icon icofont-mail" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 18px; z-index: 2;"></i>
                <input type="email" class="form-control otp-email-input" name="email" autocomplete="off" placeholder="{{__('e.g. name@example.com')}}" style="padding: 12px 16px 12px 45px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 15px; width: 100%; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            </div>
            <span class="invalid-feedback error error-email" style="display: none; color: #ef4444; font-size: 13px; margin-top: 5px;"></span>
            
            <button type="button" class="btn btn-primary btn-block mt-4 btn-send-otp" style="padding: 12px; font-weight: 600; font-size: 16px; border-radius: 8px; background-color: #d4441c; border-color: #d4441c; width: 100%; transition: all 0.2s; color: white;">
                {{ __('Continue with Email') }}
                <span class="spinner-grow spinner-grow-sm icon-loading" role="status" aria-hidden="true" style="display:none; margin-left: 5px;"></span>
            </button>
        </div>

        <div class="form-group otp-code-group" style="display: none;">
            <div class="text-center mb-4">
                <div style="display: inline-block; padding: 12px; background: #f1f5f9; border-radius: 50%; margin-bottom: 12px;">
                    <i class="icofont-envelope" style="font-size: 24px; color: #3b82f6;"></i>
                </div>
                <h4 style="font-size: 18px; font-weight: 600; color: #1e293b;">Check your email</h4>
                <p style="color: #64748b; font-size: 14px; margin-top: 5px;">We've sent a 6-digit verification code to<br><strong class="display-email-target" style="color: #0f172a;"></strong></p>
            </div>

            <label style="font-weight: 600; color: #334155; margin-bottom: 8px; display: block; text-align: center;">{{__('Enter Verification Code')}}</label>
            <input type="text" class="form-control text-center" name="otp_code" autocomplete="off" placeholder="••••••" maxlength="6" style="padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 24px; letter-spacing: 12px; font-weight: bold; width: 100%; transition: all 0.2s;">
            <span class="invalid-feedback error error-otp_code" style="display: none; color: #ef4444; font-size: 13px; margin-top: 5px; text-align: center;"></span>
            
            <button class="btn btn-primary btn-block form-submit mt-4" type="submit" style="padding: 12px; font-weight: 600; font-size: 16px; border-radius: 8px; background-color: #d4441c; border-color: #d4441c; width: 100%; transition: all 0.2s; color: white;">
                {{ __('Verify & Login') }}
                <span class="spinner-grow spinner-grow-sm icon-loading" role="status" aria-hidden="true" style="display:none; margin-left: 5px;"></span>
            </button>
            <div class="text-center mt-4">
                <a href="javascript:void(0)" class="btn-resend-view" style="color: #3b82f6; font-size: 14px; font-weight: 500; text-decoration: none;" onclick="$(this).closest('.otp-login-form').find('.otp-email-group').fadeIn(); $(this).closest('.otp-login-form').find('.otp-code-group').hide(); $('.display-email-target').text('');">
                    <i class="icofont-arrow-left"></i> {{__('Change Email')}}
                </a>
            </div>
        </div>

        <div class="error message-error invalid-feedback" style="display: none; text-align: center; margin-top: 15px; font-size: 14px;"></div>
        <div class="alert alert-success message-success mt-3" style="display: none; border-radius: 8px; font-size: 14px;"></div>
        
        <div class="text-center mt-4 pt-3" style="border-top: 1px solid #e2e8f0;">
            <p style="font-size: 12px; color: #94a3b8; margin: 0;">By continuing, you agree to our <a href="#" style="color: #64748b; text-decoration: underline;">Terms of Service</a> & <a href="#" style="color: #64748b; text-decoration: underline;">Privacy Policy</a>.</p>
        </div>
    </form>
</div>

<script>
    (function() {
        var initOTPLogin = function() {
            if (typeof window.jQuery === 'undefined') {
                setTimeout(initOTPLogin, 100);
                return;
            }
            var $ = window.jQuery;
            
            $(document).off('click', '.btn-send-otp').on('click', '.btn-send-otp', function() {
                var btn = $(this);
                var form = btn.closest('.otp-login-form');
                var email = form.find('.otp-email-input').val();
                
                form.find('.error').hide().text('');
                form.find('.message-error').hide().text('');
                form.find('.message-success').hide().text('');
                
                if(!email) {
                    form.find('.error-email').show().text('{{__('Email is required')}}');
                    return;
                }

                btn.find('.icon-loading').show();
                btn.prop('disabled', true);
                
                $.ajax({
                    url: '{{ route('auth.login.send_otp') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email
                    },
                    success: function(res) {
                        btn.find('.icon-loading').hide();
                        btn.prop('disabled', false);
                        if(res.error) {
                            if(res.messages) {
                                for(var k in res.messages) {
                                    form.find('.error-'+k).show().text(res.messages[k][0]);
                                }
                            }
                            if(res.message_error) {
                                form.find('.message-error').show().text(res.message_error);
                            }
                        } else {
                            form.find('.display-email-target').text(email);
                            form.find('.otp-email-group').hide();
                            form.find('.otp-code-group').fadeIn();
                        }
                    },
                    error: function(err) {
                        btn.find('.icon-loading').hide();
                        btn.prop('disabled', false);
                        form.find('.message-error').show().text('{{__('Something went wrong. Please try again later.')}}');
                    }
                });
            });

            $(document).off('submit', '.otp-login-form').on('submit', '.otp-login-form', function(e) {
                e.preventDefault();
                var form = $(this);
                var btn = form.find('.form-submit');
                
                form.find('.error').hide().text('');
                form.find('.message-error').hide().text('');
                form.find('.message-success').hide().text('');
                
                btn.find('.icon-loading').show();
                btn.prop('disabled', true);
                
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(res) {
                        btn.find('.icon-loading').hide();
                        btn.prop('disabled', false);
                        if(res.error) {
                            if(res.messages) {
                                for(var k in res.messages) {
                                    form.find('.error-'+k).show().text(res.messages[k][0]);
                                }
                            }
                            if(res.messages && res.messages.message_error) {
                                form.find('.message-error').show().text(res.messages.message_error[0]);
                            }
                        } else {
                            if(res.redirect) {
                                window.location.href = res.redirect;
                            } else {
                                window.location.reload();
                            }
                        }
                    },
                    error: function(err) {
                        btn.find('.icon-loading').hide();
                        btn.prop('disabled', false);
                        form.find('.message-error').show().text('{{__('Something went wrong. Please try again later.')}}');
                    }
                });
            });
        };
        initOTPLogin();
    })();
</script>
