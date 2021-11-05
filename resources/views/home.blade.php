@extends('layouts.app2')

@section('tittlebar','Home Email System')



@section('css')
    
@endsection
            
@section('content')
                            <div class="btn-controls">
                                <div class="btn-box-row row-fluid">
                                    <a href="#" class="btn-box big span4"><i class="icon-ok-sign"></i><b id="sent"></b>
                                        <p class="text-muted">
                                            Sent</p>
                                    </a><a href="#" class="btn-box big span4"><i class="icon-remove"></i><b id="failed"></b>
                                        <p class="text-muted">
                                            Failed</p>
                                    </a><a href="#" class="btn-box big span4"><i class="icon-envelope"></i><b id="mail"></b>
                                        <p class="text-muted">
                                            Email Account</p>
                                    </a>
                                </div>
                            </div>
                            <!--/#btn-controls-->
@endsection

@section('js')
<script>
    setInterval(() => {
        valueDash();
    }, 1000);
    valueDash();
    function valueDash(){
        $.ajax({
            url: "{{ route('getdata.dashboard') }}",
            type: "GET",
            success: function(respon){                
                $('#sent').replaceWith($('#sent').html(respon.sent));
                $('#failed').replaceWith($('#failed').html(respon.fail));
                $('#mail').replaceWith($('#mail').html(respon.mail));
            }
        });        
    }
</script>

@endsection