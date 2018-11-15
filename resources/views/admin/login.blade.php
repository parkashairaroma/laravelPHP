{{-- Header --}}
@include('admin.includes.header')

<section class="container">
    <section class="login">
        <h1>Site Control</h1>
        <form method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="form-group has-feedback">
                        <input type="text" name="login" class="form-control" placeholder="Account">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-7">
                        <span class="error">
                        @if($errors->has())
                            @foreach ($errors->all() as $error)
                                {{ $error }}       
                            @endforeach
                        @endif
                        </span>
                    </div>
                    <div class="col-xs-5">
                        <button type="submit" class="btn btn-success">Sign In</button>
                    </div>
                </div>
        </form>
    </section>
</section>

{{-- Footer --}}
@include('admin.includes.footer')