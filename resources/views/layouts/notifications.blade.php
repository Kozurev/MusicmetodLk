@if (($disableNotifications ?? false) !== true)
    @if (isset($errors) && !empty($errors))
        @php
            if (is_object($errors)) {
                $errors = $errors->all();
            }
        @endphp
        @foreach((array)$errors as $errorMsg)
            <div class="alert alert-danger fade show" role="alert">
                <div class="alert-icon">
                    <i class="flaticon-warning"></i>
                </div>
                <div class="alert-text">
                    {{ $errorMsg }}
                </div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-close"></i></span>
                    </button>
                </div>
            </div>
        @endforeach
    @endif

    @if (isset($success) && is_array($success))
        @foreach($success as $successMsg)
            <div class="alert alert-success fade show" role="alert">
                <div class="alert-icon">
                    <i class="flaticon-questions-circular-button"></i>
                </div>
                <div class="alert-text">
                    {{ $successMsg }}
                </div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-close"></i></span>
                    </button>
                </div>
            </div>
        @endforeach
    @endif
@endif