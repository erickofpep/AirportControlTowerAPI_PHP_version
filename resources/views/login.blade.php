<div class="card-header-tab card-header">
    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
        <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i> Login
    </div>
</div>


<div class="main-card mb-3 card">
<div class="card-body m-b-50">

@if ($message = Session::get('error'))
    <div class="alert alert-danger col-sm-12 msgAlrts">
        <p>{{ $message }}</p>
    </div>
 @endif

 @if ($errors->any())
    <div class="alert alert-danger msgAlrts">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row">
                        <div class="position-relative form-group col-md-6">
<label for="exampleEmail" class>Email</label>
<input type="email" name="email" id="email" placeholder=""  class="form-control" value="" required>
</div>

<div class="position-relative form-group col-md-6">
<label for="exampleEmail" class>Password</label>
<input type="password" name="password" id="password" placeholder=""  class="form-control" value="" required>
<i class="fa fa-eye-slash" aria-hidden="true" id="RgstrPsswrdIcon"></i>
</div>
</div>
                        
                        <div class="form-group row mb-0">
                        <div class="col-md-12 form-group" style="text-align: center;">
 <button type="submit" class="mt-1 btn btn-primary col-md-8">{{ __('Login') }}</button>
</div>
                            <div class="col-md-12 offset-md-4">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
</div>
</div>