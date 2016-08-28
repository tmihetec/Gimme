@extends('layouts.app')

@section('content')

<div class="container">

@include('layouts.errnmsgs')


@if($editOrCreateUser) {{-- EDIT --}}
    <!-- edit user -->
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-warning">
                @if($createnew) 
                  <div class="panel-heading">Create new user </div>
                  <div class="panel-body">
                  <form class="form-horizontal" method="post" role="form" action="{{URL::to('users')}}" >
              @else 
                  <div class="panel-heading">Edit user {{$editOrCreateUser->display_name}}</div>
                  <div class="panel-body">
                  <form class="form-horizontal" method="post" role="form" action="{{URL::to('users/'.$editOrCreateUser->id)}}" autocomplete="off">
                  {{method_field('PUT')}}
              @endif

                    {{csrf_field()}}
  


                      <div class="col-md-6"> 
  
                        <div class="form-group">
                          <label class="col-md-3 control-label">First name:</label>
                          <div class="col-md-9">
                            <input class="form-control" name="firstname" value="{{$editOrCreateUser->firstname}}" type="text" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Last name:</label>
                          <div class="col-md-9">
                            <input class="form-control" name="lastname" value="{{$editOrCreateUser->lastname}}" type="text" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Nick name:</label>
                          <div class="col-md-9">
                            <input class="form-control" name="nickname" value="{{$editOrCreateUser->name}}" type="text" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Roles:</label>
                          <div class="col-md-9">

                            <select name="userroles[]" class="form-control makethemselect2" size="1" multiple="multiple" >
                                @foreach($rolelist as $roleid=>$rolename)
                                    <option
                                        value="{{$roleid}}"
                                        @if ( in_array($roleid, $currentuserroles) )
                                            selected="selected" 
                                        @endif
                                    >{{$rolename}}</option>
                                @endforeach
                            </select>

                          </div>
                        </div>
                      </div>




  
                      <div class="col-md-6"> <!-- desna kolona start -->
                        <div class="form-group">
                          <label class="col-lg-3 control-label">POS:</label>
                          <div class="col-lg-9">

                            <select name="pos" class="form-control makethemselect2" >
                                <option ></option>
                                @foreach($poslist as $posid=>$posname)                                    
                                    <option
                                        value="{{$posid}}"
                                        @if ($posid == $editOrCreateUser->pos_id) )
                                            selected="selected" 
                                        @endif
                                    >{{$posname}}</option>
                                @endforeach
                            </select>

                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-3 control-label">Email (login):</label>
                          <div class="col-lg-9">
                            <input class="form-control" name="email" value="{{$editOrCreateUser->email}}" type="text" autocomplete="off"/>     
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-3 control-label">Set new pass:</label>
                          <div class="col-lg-9">
                            <input class="form-control" name="newpass"  type="password" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" autocapitalize="off" autocomplete="new-password"/>     
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-3 control-label">Active:</label>
                          <div class="col-lg-3">
                            <select name="activeuser" class="form-control">
                                <option value="0">NO</option>
                                <option value="1" 
                                    @if($editOrCreateUser->affiliateActive)
                                        selected="selected"  
                                    @endif
                                >YES</option>
                            </select>
                          </div>
                          <label class="col-lg-3 control-label">Deleted:</label>
                          <div class="col-lg-3">
                            <select name="deleteduser" class="form-control">
                                <option value="0">NO</option>
                                <option value="1"
                                    @if($editOrCreateUser->trashed())
                                        selected="selected"  
                                    @endif
                                >YES</option>
                            </select>
                          </div>
                        </div>
                       </div> <!-- desna kolona end -->



                  </form>

                </div> <!-- panel-body -->
            </div> <!-- panel -->

        </div> <!-- col -->
    </div> <!-- row -->
@endif


    <!-- list users --> {{-- INDEX --}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Users list 
                <div class="pull-right">
                <a href="{{URL::to('users/create')}}" ><i class="fa fa-plus-circle"  title="Add new user"></i> Add new user </a>&nbsp;
                {{--<a href="{{URL::to('recalculateAllResults')}}" > <i class="fa fa-plus-circle"  title="Add new user"></i>  Recalculate results <span> </span></a> --}}
                </div>
                </div>

                <div class="panel-body">
                   
                   <!-- table-striped table-bordered table-hover dt-responsive -->
                <table class="table display responsive usersTable" width="100%">
                    <thead>
                        <tr>
                            <th>Nick</th>
                            <th class="desktop">First name</th>
                            <th class="desktop">Last name</th>
                            <th class="desktop">Role</th>
                            <th class="desktop">Active</th>
                            <th class="desktop">Email</th>
                            <th class="desktop">Partner</th>
                            <th >POS</th>
                            <th >M</th>
                            <th >Q</th>
                            <th class="desktop">C</th>
                            <th></th>
                        </tr>
                    </thead>
                         <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align:right">Sum:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                         </tfoot>
                    <tbody>
                    @foreach($users as $user)
                        <tr 
                        @if($user->trashed())
                            class="strikeout"
                        @endif
                        >
                            <td>{{$user->name}}</td>
                            <td>{{$user->firstname}}</td>
                            <td>{{$user->lastname}}</td>
                            <td>
                                @if($user->roles->first())  
                                    {{ implode(", ",array_pluck($user->roles->toArray(), 'name')) }}  
                                @endif
                            </td>
                            <td>
                                @if($user->affiliateActive)
                                    <span class="text-success"><i class="fa fa-plus-square"  title="active"></i></span> YES
                                @else 
                                    <span class="text-danger"><i class="fa fa-minus-square"  title="inactive"></i></span> NO
                                @endif
                            </td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if( $user->pos()->exists() && $user->pos->partner()->exists() )
                                    {{$user->pos->partner()->first()->name}}
                                @else
                                    <i class="fa fa-times-circle" aria-hidden="true"></i> NONE
                                @endif
                            </td>
                            <td>
                                @if(count($user->pos))
                                    {{$user->pos->name}}
                                @else
                                    <i class="fa fa-times-circle" aria-hidden="true"></i> NONE
                                @endif
                            </td>
                            <td>
                              @if($user->resultm > 0) 
                                <a href="{{URL::to('realisationUserPeriod/'.$user->id.'/m')}}">{{$user->resultm}}</a>
                              @else
                                0
                              @endif
                            </td>
                            <td>
                              @if($user->resultq > 0) 
                                <a href="{{URL::to('realisationUserPeriod/'.$user->id.'/q')}}">{{$user->resultq}}</a>
                              @else
                                0
                              @endif
                            </td>
                            <td>
                              @if($user->resultc > 0) 
                                <a href="{{URL::to('realisationUserPeriod/'.$user->id.'/c')}}">{{$user->resultc}}</a>
                              @else
                                0
                              @endif
                            </td>
                            <td class="tools"><a class="btn btn-xs btn-primary" href="{{URL::to('users/'.$user->id.'/edit')}}"><i aria-hidden="true" class="fa fa-pencil-square"></i></a>
                        </tr>
                    @endforeach
                       </tbody>
                   </table>

                </div>

            </div>
        </div>
    </div>

</div>
@endsection
