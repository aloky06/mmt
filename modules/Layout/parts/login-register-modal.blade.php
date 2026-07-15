<div class="modal fade login" id="login" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 420px;">
        <div class="modal-content relative" style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
            <div style="position: absolute; top: 16px; right: 16px; z-index: 10;">
                <span class="c-pointer" data-dismiss="modal" aria-label="Close" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: rgba(241, 245, 249, 0.8); border-radius: 50%; transition: all 0.2s;">
                    <i class="icofont-close" style="font-size: 16px; color: #64748b;"></i>
                </span>
            </div>
            <div class="modal-body relative" style="padding: 40px 32px 32px 32px;">
                @include('Layout::auth/login-form')
            </div>
        </div>
    </div>
</div>
<div class="modal fade login" id="register" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 420px;">
        <div class="modal-content relative" style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
            <div style="position: absolute; top: 16px; right: 16px; z-index: 10;">
                <span class="c-pointer" data-dismiss="modal" aria-label="Close" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: rgba(241, 245, 249, 0.8); border-radius: 50%; transition: all 0.2s;">
                    <i class="icofont-close" style="font-size: 16px; color: #64748b;"></i>
                </span>
            </div>
            <div class="modal-body relative" style="padding: 40px 32px 32px 32px;">
                @include('Layout::auth/login-form')
            </div>
        </div>
    </div>
</div>