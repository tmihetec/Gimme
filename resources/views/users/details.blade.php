@extends('layouts.app')

@section('content')

<div class="container">

    @include('layouts.errnmsgs')



    <div class="row" >



        <div class="col-md-12">
            <div class="panel panel-default panel-black">
                <div class="panel-heading"><i class="fa fa-user" aria-hidden="true"></i> User {{$user->display_name}} details</a></div>
                <div class="panel-body">

					{{--<h1 class="page-header">Edit Profile</h1>--}}

					<div class="row">
					    <!-- left column -->
					    <div class="col-md-4 col-sm-6 col-xs-12">
					      <div class="text-center">
					        <img src="{{asset('images/icon-user-default.png')}}" class="avatar img-circle img-thumbnail img-responsive" width="300" alt="avatar">
					        {{-- <h6>Upload a different photo...</h6>
					        <input type="file" class="text-center center-block well well-sm">--}}
					      </div>
					      <!-- affiliate status label -->
					      @if($user->affiliateActive)
						      <div class="label label-primary">AFFILIATE ACTIVE</div>
					      @else
						      <div class="label label-danger">AFFILIATE INACTIVE</div>
					      @endif

					      <!-- affiliate pos -->
					      @if($user->pos_id)
						      <div class="label label-info">{{$user->pos->name}}</div>
					      @else
						      <div class="label label-danger">COMPANY NOT DEFINED</div>
					      @endif

					      <!-- achievements -->

					    </div>

					    <!-- edit form column -->
					    <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
					    {{-- 
					      <div class="alert alert-info alert-dismissable">
					        <a class="panel-close close" data-dismiss="alert">×</a> 
					        <i class="fa fa-coffee"></i>
					        This is an <strong>.alert</strong>. Use this to show important messages to the user.
					      </div>
					    --}}
					      <h3>Personal info</h3>
					      <form class="form-horizontal" method="post" role="form" action="{{URL::to('affiliate/'.$user->id)}}">
					      {{csrf_field()}}
					      {{method_field('PUT')}}

					        <div class="form-group">
					          <label class="col-lg-3 control-label">First name:</label>
					          <div class="col-lg-8">
					            <input class="form-control" name="firstname" value="{{$user->firstname}}" type="text">
					          </div>
					        </div>
					        <div class="form-group">
					          <label class="col-lg-3 control-label">Last name:</label>
					          <div class="col-lg-8">
					            <input class="form-control" name="lastname" value="{{$user->lastname}}" type="text">
					          </div>
					        </div>
					        <div class="form-group">
					          <label class="col-md-3 control-label">Nickname:</label>
					          <div class="col-md-8">
					            <input class="form-control" name="nickname" value="{{$user->name}}" type="text">
					          </div>
					        </div>
					        <div class="form-group">
					          <label class="col-lg-3 control-label">Company:</label>
					          <div class="col-lg-8">
					            <input class="form-control" value="{{$user->pos_display_name}}" type="text" disabled="disabled">
					          </div>
					        </div>
					        <div class="form-group">
					          <label class="col-lg-3 control-label">Email (login):</label>
					          <div class="col-lg-8">
					            <input class="form-control" name="email" value="{{$user->email}}" type="text" readonly="readonly"/>     
					            </div>
					        </div>


							<div class="mywell col-sm-10 col-sm-offset-1">
						        <div class="form-group">
						          <label class="col-lg-3 control-label">Reset password:</label>
						          <div class="col-lg-1">
						          	<input type="checkbox" class="form-control" value="1" id="changepass" name="changepass" />
						          </div>
						          <label class="col-lg-3 control-label">Old password:</label>
						          <div class="col-lg-5">
						            <input class="form-control" id="oldpass" type="password" name="oldpass" disabled="disabled"/>
								  </div>
								</div>
								
						        <div class="form-group">
						          <label class="col-lg-3 control-label">New password:</label>
							          <div class="col-lg-9">
							            <input class="form-control" id="newpass" name="newpass" type="password" disabled="disabled"/>
							          </div>
					          	</div>
						        
						        <div class="form-group">
						          <label class="col-lg-3 control-label">Confirm new:</label>
							          <div class="col-lg-9">
							            <input class="form-control" id="newpassconfirm" name="newpassconfirm" type="password" disabled="disabled"/>
							          </div>
								</div>
							</div>


					        <div class="form-group">
					          <label class="col-md-3 control-label"></label>
					          <div class="col-md-8">
					            <input class="btn btn-primary" value="Save Changes" type="submit">
					            <span></span>
					            <input class="btn btn-default" value="Cancel" type="reset">
					            @can('CRUDusers')
						            <span></span>
						            <a class="btn btn-warning" href="{{URL::to('users/'.$user->id.'/edit')}}">Edit user</a>
					            @endcan

					          </div>
					        </div>
					      </form>
					    </div>
					  </div><!-- row u panelu -->

                </div>
            </div>
        </div>
	</div>


</div>
@endsection