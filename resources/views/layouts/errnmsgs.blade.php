
    <div class="row" >

        <!-- will be used to show any messages -->
        <div class="col-md-12" id="messages">

            @if (Session::has('message'))
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {!! Session::pull('message') !!}
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span> 
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>

    </div>

