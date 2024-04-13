<div class="card-header-tab card-header">
    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
        <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i> {{ __('Register') }}
    </div>
</div>
<div class="main-card mb-3 card">
<div class="card-body m-b-50">

@if ($errors->any())
    <div class="alert alert-danger col-sm-12 msgAlrts">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
<div class="row">


<div class="position-relative form-group col-md-6">
<label for="exampleEmail" class>{{ __('First name') }}</label>
<input type="text" name="firstname" id="firstname" placeholder=""  class="form-control" value="{{ old('firstname') }}" required>
</div>

<div class="position-relative form-group col-md-6">
<label for="exampleEmail" class>{{ __('Last name') }}</label>
<input type="text" name="lastname" id="lastname" placeholder=""  class="form-control" value="{{ old('lastname') }}">
</div>

<div class="position-relative form-group col-md-6">
<label for="exampleEmail" class>{{ __('Email') }}</label>
<input type="email" name="email" id="email" placeholder=""  class="form-control" value="{{ old('email') }}" required>
</div>

<div class="position-relative form-group col-md-6">
<label for="exampleEmail" class>{{ __('Password') }}</label>
<input type="password" name="password" id="password" placeholder=""  class="form-control" value="" required>
<i class="fa fa-eye-slash" aria-hidden="true" id="RgstrPsswrdIcon"></i>
</div>

<div class="position-relative form-group col-md-6">
<label for="exampleEmail" class>{{ __('Confirm Password') }}</label>
<input type="password" name="password_confirmation" id="confirm" placeholder=""  class="form-control" value="" required><i class="fa fa-eye-slash" aria-hidden="true" id="RgstrCnfrmPsswrdIcon"></i>
</div>

<div class="col-md-12 form-group" style="text-align: center;">
 <button type="submit" class="mt-1 btn btn-primary col-md-8">{{ __('Register') }}</button>
</div>

</form>
</div>
</div>