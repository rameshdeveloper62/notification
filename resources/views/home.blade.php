@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="alert alert-success hide">
                        Message was sent successfully.
                    </div>
                    
                    <div class="alert alert-danger hide">
                        Message was not sent successfully.
                    </div>

                    <form id="form">
                        <input type="hidden" name="from_user" value="{{auth()->id()}}"/>
                      <div class="form-group">
                        <label for="to_user">Select User:</label>
                        <select id="to_user" name="to_user" class="form-control">
                            <option value="">Select User</option>
                            @if(isset($users) && count($users))
                            @foreach($users as $user_id=>$user)
                                <option value="{{$user_id}}">{{$user}}</option>
                            @endforeach
                            @endif
                        </select>

                      </div>
                      <div class="form-group">
                        <label for="pwd">Message:</label>
                        <textarea class="form-control" id="message" name="message"></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
<script type="text/javascript">
    $(function(){
        $( "#form" ).validate({
            'errorClass':'text-danger',
            rules: {
                to_user: {
                  required: true,
                },
                message: {
                  required: true,
                }
            },
            messages:{
                to_user:{
                    required:'Please select user.'
                },
                message:{
                    required:'Message field is required.'
                }
            },
            submitHandler:function(form){
                 sendMessage(form);
            }
        });
        sendMessage=function(form)
        {
            $.ajax({
                url: '{{action('HomeController@store')}}',
                type: 'post',
                dataType: 'json',
                data: $(form).serialize(),
            })
            .done(function() {
                $(form)[0].reset();
                $('.alert-success').removeClass('hide');
                $('.alert-success').fadeIn().fadeIn(1000);
                console.log("success");
            })
            .fail(function() {
                console.log("error");
                $('.alert-danger').removeClass('hide');
                $('.alert-danger').fadeIn().fadeOut(1000);
            });
        }
    })
</script>
@endpush
@endsection
