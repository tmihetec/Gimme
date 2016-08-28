@extends('layouts.app')

@section('content')

<div class="container">

    @include('layouts.errnmsgs')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Analytics home</div>

                <div class="panel-body">

                    <pre>

        odabrati partnera/pos/user za tablice:

        analitika partnera: 


                        nakon kaj je odabran partner:
                            graf sa week sales, linije su useri (ak je odabran pos), posevi ak je odabran  - jedna average?
                            top POS W/M/Q/C (QTY, PTS)
                            top sellers W/M/Q/C (QTY, PTS)
                            top items W/M/Q/C (QTY, PTS)

            analitika posa:
                        prodaja po artiklima (top lista artikla) W/M/Q/C (qty, pts)
                        prodaja po tjednima (qty, pts)

                    kad se klikne na neki qty ili pts daje 2 tablice za taj period (W, M, Q ili C)
                        -  1) svi korisnici za taj POS sa tim W/M/Q/C
                        -  2) svi artikli za taj POS sa tim W/M/Q/C 

            analitika sellera:
                        prodaja po tjednima (qty, pts)
                        prodaja po artiklima (top lista artikla) W/M/Q/C (qty, pts)

                    kad se klikne na neki qty ili pts daje 2 tablice za taj period (W, M, Q ili C)
                        -  1) svi artikli za taj POS sa tim W/M/Q/C 

            analitika itema:
                    - vrijednost koju je kroz vrijeme + prodaja (qty)
                    - prodaja po posu? useru?

                    </pre>


                    <pre>
                    analitika po brandu, kategoriji, artiklu po tjednima (graf, količina, bodovi - tjedni)
                    </pre>

                </div>
            </div>
        </div>
    </div>

</div> <!--container -->
@endsection
